<?php
set_include_path('./ezpdf/' . PATH_SEPARATOR . get_include_path());
date_default_timezone_set('UTC');
define("UTF_8", 1);
define("ASCII", 2);
define("ISO_8859_1", 3);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('display_errors', 0);
require_once './ezpdf/Cezpdf2.php';
require_once './phpqrcode/qrlib.php';

session_start();
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
$validator = array('success' => false, 'messages' => array());

if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

    switch (base64_decode($_POST['scbets_action'])) {
        case 'ListAutorization':
            $consulta = $db->setSelect("prestamos", "*", "estatus = 'PRESTADO' ORDER BY create_at DESC");

            $json = array();
            $book = null;
            $student = null;
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $book = getBook($row->prestamo_id, $db);
                    $student = getStudent($row->consultor_id, $db);
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->prestamo_id),
                        '_bresx' => base64_encode($row->create_at),
                        '_cresx' => base64_encode(($row->codepres)),
                        '_dresx' => base64_encode(($row->tipo_prestamo)),
                        '_eresx' => base64_encode(($row->coleccion_id)),
                        'collection' => $book,
                        '_gresx' => base64_encode(($row->consultor_id)),
                        'consult' => $student,
                        '_iresx' => base64_encode(($row->status)),
                        '_jresx' => base64_encode(($row->fecha_prestamo)),
                        '_kresx' => base64_encode(($row->fecha_devolucion)),
                        '_lresx' => base64_encode(($row->fecha_real)),
                        '_mresx' => base64_encode(($row->estatus)),
                    );
                }
            }
            print_r(json_encode($json));
            break;
        case 'DevolutionBook':
            if (isset($_POST['txt_codex'])) {
                $prestamoId = base64_decode($_POST['txt_codex']);

                if (!empty($prestamoId)) {
                    if ($db->setUpdate("prestamos", "status=0, estatus='DEVUELTO', fecha_real=NOW()", "prestamo_id='$prestamoId'")) {
                        /*$validator['success'] = true;
                        $validator['messages'] = ' Éxito acompletado.';*/
                        $consulta = $db->setSelect("prestamos", "*", "prestamo_id = '$prestamoId' ORDER BY create_at DESC");
                        if ($db->setNumRows($consulta) > 0) {
                            foreach ($db->setFetchArray($consulta) as $row) {
                                if (devolutionBook($row->prestamo_id, $db)) {
                                    $validator['success'] = true;
                                    $validator['messages'] = ' Éxito acompletado.';
                                } else {
                                    $validator['success'] = false;
                                    $validator['messages'] = ' Ocurrio un error con la operación..';
                                }
                            }
                        }
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error con la operación.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Error técnico.';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Error técnico.';
            }
            print_r(json_encode($validator));

            break;
        case 'BookReturn':
            if (isset($_POST['txt_codex'])) {
                $id = base64_decode($_POST['txt_codex']);
            }
            break;
        case 'DownloadPdf':

            if (isset($_POST['txt_codex'])) {
                $id = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("prestamos", "*", "prestamo_id = '$id' ORDER BY create_at DESC");

                $json = array();
                $book = null;
                $student = null;
                if ($db->setNumRows($consulta) > 0) {
                    foreach ($db->setFetchArray($consulta) as $row) {
                        $book = getBookPdf($row->prestamo_id, $db);
                        $student = getStudent($row->consultor_id, $db);
                        $json[] = array(
                            'dateReport' => ($row->create_at),
                            'folioReport' => (($row->codepres)),
                            'name' => base64_decode($student[0]['name']),
                            'matricula' => base64_decode($student[0]['matricula']),
                            'email' => base64_decode($student[0]['email']),
                            'book' => $book,
                            'dateExpedition' => (($row->fecha_prestamo)),
                            'dateReturn' => (($row->fecha_devolucion)),
                            'estatus' => (($row->estatus)),
                            'dateReal' => $row->fecha_real,
                        );
                    }
                }

                $bookRead = array();
                foreach (($json[0]['book']) as $key => $value) {
                    $bookRead = array('type' => '+', 'folio' => $value['folio'], 'titulo' => ($value['titulo']),  'autor' => ($value['autor']));
                }

                $pdf = new Cezpdf('LETTER', 'portrait');
                getPdf($pdf, $json, $bookRead);
                $stream_options = array('Content-Disposition' => 'pdf.pdf', 'download' => 1);
                $pdf->ezStream($stream_options);
            }
            break;
        default:
    }
}

function getBook($id_pres, $db)
{
    $list = array();
    if (!empty($id_pres)) {
        $id = $id_pres;

        $consulta = $db->setSelect("prestamos", "*", "prestamo_id = '$id' ORDER BY create_at DESC");
        $list = array();
        if ($db->setNumRows($consulta) > 0) {
            foreach ($db->setFetchArray($consulta) as $row) {
                $list = array($row->coleccion_id);
            }
        }
    }
    $book = array();
    if (sizeof($list) > 0) {
        foreach ((($list)) as $key => $value) {
            $id = 0;
            foreach (json_decode($value) as $x => $y) {
                $id = intval($y->bookId);

                $libro = $db->setSelect("libros", "*", "lib_id='$id'");
                if ($db->setNumRows($libro) > 0) {
                    foreach ($db->setFetchArray($libro) as $i) {
                        $book[] = array(
                            'type' => '+',
                            'folio' => $i->lib_cod,
                            'titulo' => base64_encode(utf8_decode($i->lib_tit)),
                            'autor' => base64_encode(utf8_decode($i->lib_aut)),
                        );
                    }
                }
            }
        }
    }
    return ($book);
}


function devolutionBook($id_pres, $db)
{
    $valorado = false;
    $list = array();
    if (!empty($id_pres)) {
        $id = $id_pres;

        $consulta = $db->setSelect("prestamos", "*", "prestamo_id = '$id' ORDER BY create_at DESC");
        $list = array();
        if ($db->setNumRows($consulta) > 0) {
            foreach ($db->setFetchArray($consulta) as $row) {
                $list = array($row->coleccion_id);
            }
        }
    }
    $book = array();
    if (sizeof($list) > 0) {
        foreach ((($list)) as $key => $value) {
            $id = 0;
            foreach (json_decode($value) as $x => $y) {
                $id = intval($y->bookId);
                if ($db->setUpdate("libros", "lib_pro=0", "lib_id='$id'")) {
                    $valorado = true;
                } else {
                    $valorado = false;
                }
            }
        }
    }
    return ($valorado);
}

function getStudent($id_student, $db)
{
    if (!empty($id_student)) {
        $consultorId = $id_student;
        $consulta = $db->setSelect("consultor", "*", "con_id='$consultorId' ORDER BY con_mat ASC");
    }
    $json = array();
    if ($db->setNumRows($consulta) > 0) {
        foreach ($db->setFetchArray($consulta) as $row) {
            $json[] = array(
                'codex' => base64_encode($row->con_id),
                'fecha' => base64_encode($row->con_f_i),
                '_cresx' => base64_encode($row->con_f_u),
                'matricula' => base64_encode($row->con_mat),
                'name' => base64_encode(utf8_decode($row->con_nom) . ' ' . utf8_decode($row->con_ape)),
                'email' => base64_encode(utf8_decode($row->con_ema)),
                'status' => base64_encode($row->con_sta)
            );
        }
    }
    return $json;
}


function getBookPdf($id_pres, $db)
{
    $list = array();
    if (!empty($id_pres)) {
        $id = $id_pres;

        $consulta = $db->setSelect("prestamos", "*", "prestamo_id = '$id' ORDER BY create_at DESC");
        $list = array();
        if ($db->setNumRows($consulta) > 0) {
            foreach ($db->setFetchArray($consulta) as $row) {
                $list = array($row->coleccion_id);
            }
        }
    }
    $book = array();
    if (sizeof($list) > 0) {
        foreach ((($list)) as $key => $value) {
            $id = 0;
            foreach (json_decode($value) as $x => $y) {
                $id = intval($y->bookId);

                $libro = $db->setSelect("libros", "*", "lib_id='$id'");
                if ($db->setNumRows($libro) > 0) {
                    foreach ($db->setFetchArray($libro) as $i) {
                        $book[] = array(
                            'type' => '+',
                            'folio' => $i->lib_cod,
                            'titulo' => (($i->lib_tit)),
                            'autor' => (($i->lib_aut)),
                        );
                    }
                }
            }
        }
    }
    return ($book);
}


function ContentPdf($pdf, $data, $bookRead)
{
    $pdf->addJpegFromFile('./resource/image/MarcaLogoETS.jpg', 200.5, 470, 211, 205);

    $pdf->addJpegFromFile('./resource/image/HeaderLogo.jpg', 40, 732, 532, 33.5);

    $yb1 = 725;
    $pdf->ezSetCmMargins(0, 0, 0, 0);

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');
    $pdf->addText(40, $yb1 - 14, 12, (str_replace(" ", " ", '<b>BIBLIOTECA ESCOLAR DE LA ESCUELA DE TRABAJO SOCIAL, ZACATECAS.</b>')), 532, 'center');

    $yb1 = 718;

    $pdf->setStrokeColor(0.847, 0.780, 0.65);
    $pdf->setColor(0.835, 0.749, 0.619);
    $pdf->filledRectangle(40, $yb1 - 32, 532, 10);
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(70, $yb1 - 32, 10, 'VALE DE PRESTAMO', 472, 'center');


    $folioReport = $data[0]['folioReport'];
    $dateReport = $data[0]['dateReport'];
    $pdf->addText(40, $yb1 - 46, 9, $folioReport, 265, 'center');
    $pdf->addText(307, $yb1 - 46, 9, $dateReport, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 48, 300, $yb1 - 48);
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb1 - 48, 572, $yb1 - 48);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 56, 7, 'Folio', 265, 'center');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb1 - 56, 7, 'Fecha', 265, 'center');



    $pdf->setStrokeColor(0.847, 0.780, 0.65);
    $pdf->setColor(0.835, 0.749, 0.619);
    $pdf->filledRectangle(40, $yb1 - 70, 532, 10);
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 70, 10, 'Datos del Consultor ', 532, 'center');


    $matriculaStudent = $data[0]['matricula'];
    $nameStudent = $data[0]['name'];
    $pdf->addText(40, $yb1 - 82, 9, $matriculaStudent, 265, 'center');
    $pdf->addText(307, $yb1 - 82, 9, $nameStudent, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 84, 300, $yb1 - 84);
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb1 - 84, 572, $yb1 - 84);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 92, 7, 'Matrícula', 265, 'center');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb1 - 92, 7, 'Nombre', 265, 'center');

    $emailStudent = $data[0]['email'];
    $pdf->addText(40, $yb1 - 104, 9, $emailStudent, 532, 'center');
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 106, 572, $yb1 - 106);
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 113, 7, 'Correo electrónico ', 532, 'center');


    $pdf->setStrokeColor(0.847, 0.780, 0.65);
    $pdf->setColor(0.835, 0.749, 0.619);
    $pdf->filledRectangle(40, $yb1 - 126, 532, 10);
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 126, 10, 'Datos del ejemplar ', 532, 'center');

    $yb3 = 593;

    $dateExpedition = $data[0]['dateExpedition'];
    $dateReturn = $data[0]['dateReturn'];
    $pdf->addText(40, $yb3 - 14, 9, $dateExpedition, 265, 'center');
    $pdf->addText(307, $yb3 - 14, 9, $dateReturn, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb3 - 16, 300, $yb3 - 16);
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb3 - 16, 572, $yb3 - 16);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb3 - 22, 7, 'fecha de expedición', 265, 'center');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb3 - 22, 7, 'Fecha de devolución', 265, 'center');


    $pdf->ezSetY($yb3 - 28);
    $header  = array(
        array('type' => '+', 'folio' => 'Folio', 'titulo' => 'Título',  'autor' => 'Autor'),
    );

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');
    $pdf->ezTable($header, '', '', array(
        'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 2, 'width' => 572,
        'xPos' => 40, 'xOrientation' => 'right', 'fontSize' => 9, 'cols' =>
        array(
            'type' => array('width' => 15, 'justification' => 'center'),
            'folio' => array('width' => 65, 'justification' => 'center'),
            'titulo' => array('width' => 250, 'justification' => 'full'),
            'autor' => array('width' => 202, 'justification' => 'full'),
        )
    ));
    $bookList  = $data[0]['book'];

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->ezTable($bookList, '', '', array(
        'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 2, 'width' => 572,
        'xPos' => 40, 'xOrientation' => 'right', 'fontSize' => 8, 'cols' =>
        array(
            'type' => array('width' => 15, 'justification' => 'center'),
            'folio' => array('width' => 65, 'justification' => 'center'),
            'titulo' => array('width' => 250, 'justification' => 'full'),
            'autor' => array('width' => 202, 'justification' => 'full'),
        )
    ));
    $StringSpam = "|BIBLIOTECA ESCOLAR ETS|" . $folioReport . "|" . $dateReport . "|" . $matriculaStudent . "|" . $nameStudent . "|" . $dateExpedition . "|" . $dateReturn . "|";
    generateQr($StringSpam, $matriculaStudent);

    $pdf->addPngFromFile('./resource/temp/scbets' . $matriculaStudent . '.png', 36, $yb3 - 155, 60, 60);

    $pdf->ezSetY($yb3 - 97);
    $stamp  = array(
        array('stamp' => "Qr proporcionado por el sistema de control bibliotecario de la escuela de trabajo social, exclusivamente de uso interno, para matener la integrigad y la segurirada del prestamo otorgada al usuario que lo expidio."),
        array('stamp' => base64_encode($StringSpam)),
    );

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->ezTable($stamp, '', '', array(
        'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 2, 'width' => 552,
        'xPos' => 96, 'xOrientation' => 'right', 'fontSize' => 8, 'cols' =>
        array(
            'stamp' => array('width' => 476, 'justification' => 'full'),
        )
    ));
}

function generateQr($StringSpam, $matricula)
{
    $_REQUEST['data'] = '' . ($StringSpam);
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . './resource/temp' . DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = './resource/temp';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
    if (isset($_REQUEST['data'])) {
        $filename = $PNG_TEMP_DIR . 'scbets' . $matricula . '.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}

function generateQrDev($StringSpam, $matricula)
{
    $_REQUEST['data'] = '' . ($StringSpam);
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . './resource/temp' . DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = './resource/temp';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
    if (isset($_REQUEST['data'])) {
        $filename = $PNG_TEMP_DIR . 'scbets_dev' . $matricula . '.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}


function ContentPdf2($pdf, $data, $bookRead)
{
    $pdf->addJpegFromFile('./resource/image/Prestamos.jpg', 0, 0, 612, 792);

    $yb1 = 725;
    $pdf->ezSetCmMargins(0, 0, 0, 0);

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');

    $yb1 = 718;
    date_default_timezone_set('America/Mexico_City');
    $fechaActual = date('Y-m-d H:i:s');
    $month = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4" => "Abr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Ago", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    list($i, $j, $k) = explode('-', $fechaActual . " " . $data[0]["fecha"]);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i . " / " . $hora;
    $dia = (intval($intNum) >= 10 ? $intNum : "0" . $intNum);
    $mes = $month[$monthInt];
    $anio = $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->addText(425, $yb1 - 36, 10, $dateString, 150, 'center');


    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $folioReport = $data[0]['folioReport'];
    $pdf->addText(20, $yb1 - 86, 10, $folioReport, 180, 'center');


    $dateReport = $data[0]['dateReport'];
    $month = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4" => "Abr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Ago", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    list($i, $j, $k) = explode('-', $dateReport);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $pdf->addText(436, $yb1 - 86, 10, $dateString . " / " . $hora, 200, 'left');

    $nameStudent = $data[0]['name'];
    $pdf->addText(40.139, $yb1 - 108, 10, $nameStudent, 255.118, 'center');

    $matriculaStudent = $data[0]['matricula'];
    $pdf->addText(317.793, $yb1 - 108, 10, $matriculaStudent, 255.118, 'center');

    $emailStudent = $data[0]['email'];
    $pdf->addText(39.616, $yb1 - 131, 10, $emailStudent, 532.769, 'center');

    $yb3 = 593;
    $dateExpedition = $data[0]['dateExpedition'];
    list($i, $j, $k) = explode('-', $dateExpedition);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $pdf->addText(38.260, $yb1 - 176, 10, $dateString . " / " . $hora, 166.325, 'center');


    $dateReturn = $data[0]['dateReturn'];
    list($i, $j, $k) = explode('-', $dateReturn);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $pdf->addText(221.486, $yb1 - 176, 10, $dateString . " / " . $hora, 170.079, 'center');

    $estatusPrestamo = $data[0]['estatus'];
    $pdf->addText(39.616, $yb1 - 200, 10, $estatusPrestamo, 532.769, 'center');

    if ($estatusPrestamo == "DEVUELTO") {

        $dateReal = $data[0]['dateReal'];
        list($i, $j, $k) = explode('-', $dateReal);
        $intNum = intval(substr($k, 0, 2));
        $monthInt = intval($j);
        $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
        list($x, $y) = explode(' ', $k);
        $hora = $y;
        $pdf->addText(409.515, $yb1 - 176, 10, $dateString . " / " . $hora, 164.225, 'center');
    } else {
        $pdf->addText(409.515, $yb1 - 176, 10, "00 / --- / 00 / 0000 / 00:00:00", 164.225, 'center');
    }

    $pdf->ezSetY($yb1 - 226);

    $bookList  = $data[0]['book'];
    $books = array();
    $lisBook = array();
    foreach ($bookList as $key => $value) {
        $books[] = array('folio' => $value['folio'], 'titulo' => $value['titulo'],  'autor' => $value['autor']);
        $lisBook[] = $value['folio'];
    }

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->ezTable($books, '', '', array(
        'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 0, 'width' => 555.287,
        'xPos' => 30, 'xOrientation' => 'right', 'fontSize' => 8, 'cols' =>
        array(
            'folio' => array('width' => 102, 'justification' => 'full'),
            'titulo' => array('width' => 214, 'justification' => 'full'),
            'autor' => array('width' => 220, 'justification' => 'full'),
        )
    ));

    if (($estatusPrestamo != "EN PROCESO" && $estatusPrestamo == "CANCELADO") || $estatusPrestamo == "DEVUELTO" || $estatusPrestamo == "PRESTADO") {
        $StringSpam = "|BIBLIOTECA ESCOLAR ETS|" . $folioReport . "|" . $dateReport . "|" . $matriculaStudent . "|" . $nameStudent . "|" . $dateExpedition . "|" . $dateReturn . "|PRESTADO|" . json_encode($lisBook) . "|";
        generateQr($StringSpam, $matriculaStudent);

        $pdf->addPngFromFile('./resource/temp/scbets' . $matriculaStudent . '.png', 30, $yb1 - 350, 60, 60);

        $pdf->ezSetY($yb1 - 290);
        $stamp  =  array(
            array('stamp' => "Qr proporcionado por el sistema de control bibliotecario de la escuela de trabajo social, exclusivamente de uso interno, para matener la integrigad y la segurirada del prestamo otorgada al usuario que lo expidio."),
            array('stamp' => base64_encode($StringSpam)),
        );
        $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
        $pdf->ezTable($stamp, '', '', array(
            'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 1, 'width' => 552,
            'xPos' => 90, 'xOrientation' => 'right', 'fontSize' => 5.2, 'cols' =>
            array(
                'stamp' => array('width' => 204, 'justification' => 'full'),
            )
        ));
    }

    if ($estatusPrestamo == "DEVUELTO") {

        $StringSpam = "|BIBLIOTECA ESCOLAR ETS|" . $folioReport . "|" . $dateReport . "|" . $matriculaStudent . "|" . $nameStudent . "|" . $dateExpedition . "|" . $dateReturn . "|" . $estatusPrestamo . "|" . json_encode($lisBook) . "|" . $data[0]['dateReal'] . "|";
        generateQrDev($StringSpam, $matriculaStudent);

        $pdf->addPngFromFile('./resource/temp/scbets_dev' . $matriculaStudent . '.png', 315, $yb1 - 350, 60, 60);

        $pdf->ezSetY($yb1 - 290);
        $stamp  =  array(
            array('stamp' => "Qr proporcionado por el sistema de control bibliotecario de la escuela de trabajo social, exclusivamente de uso interno, para matener la integrigad y la segurirada del prestamo otorgada al usuario que lo expidio."),
            array('stamp' => base64_encode($StringSpam)),
        );
        $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
        $pdf->ezTable($stamp, '', '', array(
            'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 1, 'width' => 552,
            'xPos' => 375, 'xOrientation' => 'right', 'fontSize' => 5.2, 'cols' =>
            array(
                'stamp' => array('width' => 205, 'justification' => 'full'),
            )
        ));
    }
}

function getPdf($pdf, $data, $bookRead)
{
    //$pdf->addJpegFromFile('./resource/image/HeaderLogo.jpg', 40, 732, 532, 33.5);
    $pdf->addJpegFromFile('./resource/image/header.jpg', 40, 705, 532, 50);

    $yb1 = 725;
    $pdf->ezSetCmMargins(0, 0, 0, 0);

    $yb1 = 718;

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');
    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(40, $yb1 - 28, 12, (str_replace(" ", " ", '<b>VALE DE PRESTAMO</b>')), 532, 'center');

    date_default_timezone_set('America/Mexico_City');

    $fechaActual = date('Y-m-d h:i:s');
    $month = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4" => "Abr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Ago", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    list($i, $j, $k) = explode('-', $fechaActual);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i . " / " . $hora;
    $dia = (intval($intNum) >= 10 ? $intNum : "0" . $intNum);
    $mes = $month[$monthInt];
    $anio = $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');
    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(40, $yb1 - 42, 9, 'INFORMACIÓN: ', 122, 'left');

    $pdf->addText(355, $yb1 - 42, 9, 'FECHA: ', 98, 'right');

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(450, $yb1 - 42, 9, $dateString, 122, 'center');

    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1, 'round', '', array(0, 2));
    $pdf->line(450, $yb1 - 44, 572, $yb1 - 44);


    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->filledRectangle(40, $yb1 - 64, 532, 14);

    $pdf->setColor(255, 255, 255);
    $pdf->addText(40, $yb1 - 60, 10, 'Datos del Consultor ', 532, 'center');


    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $folioReport = $data[0]['folioReport'];
    $pdf->setColor(0, 0, 0);
    $pdf->addText(70, $yb1 - 76, 9, $folioReport, 60, 'center');

    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(40, $yb1 - 76, 9, 'Folio: ', 80, 'left');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(63, $yb1 - 78, 143, $yb1 - 78);


    $dateReport = $data[0]['dateReport'];
    $month = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4" => "Abr", "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Ago", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    list($i, $j, $k) = explode('-', $dateReport);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;
    $pdf->setColor(0, 0, 0);
    $pdf->addText(450, $yb1 - 76, 9, $dateString . " / " . $hora, 122, 'center');
    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(355, $yb1 - 76, 9, 'Fecha de creación: ', 98, 'right');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(450, $yb1 - 78, 572, $yb1 - 78);


    $matriculaStudent = $data[0]['matricula'];
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 90, 9, $matriculaStudent, 260, 'center');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(40, $yb1 - 92, 300, $yb1 - 92);

    $nameStudent = $data[0]['name'];
    $pdf->setColor(0, 0, 0);
    $pdf->addText(312, $yb1 - 90, 9, $nameStudent, 260, 'center');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(312, $yb1 - 92, 572, $yb1 - 92);

    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(40, $yb1 - 98, 7, 'Matrícula', 260, 'center');
    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(312, $yb1 - 98, 7, 'Nombre', 260, 'center');


    $emailStudent = $data[0]['email'];
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 110, 9, $emailStudent, 532, 'center');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(40, $yb1 - 112, 572, $yb1 - 112);

    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(40, $yb1 - 118, 7, 'Correo electrónico ', 532, 'center');



    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->filledRectangle(40, $yb1 - 136, 532, 14);

    $pdf->setColor(255, 255, 255);
    $pdf->addText(40, $yb1 - 132, 10, '* * * * * * * Datos del Prestamo * * * * * * *', 532, 'center');


    $dateExpedition = $data[0]['dateExpedition'];
    list($i, $j, $k) = explode('-', $dateExpedition);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 148, 9, $dateString . " / " . $hora, 180, 'center');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(40, $yb1 - 150, 200, $yb1 - 150);
    $pdf->setColor(17/255, 44/255, 38/255);
    $pdf->addText(40, $yb1 - 158, 7, 'Fecha de expedición', 180, 'center');



    $dateReturn = $data[0]['dateReturn'];
    list($i, $j, $k) = explode('-', $dateReturn);
    $intNum = intval(substr($k, 0, 2));
    $monthInt = intval($j);
    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
    list($x, $y) = explode(' ', $k);
    $hora = $y;

    $pdf->setColor(0, 0, 0);
    $pdf->addText(216, $yb1 - 148, 9, $dateString . " / " . $hora, 180, 'center');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(216, $yb1 - 150, 396, $yb1 - 150);
    $pdf->setColor(17/255, 44/255, 38/255);
    $pdf->addText(216, $yb1 - 158, 7, 'Fecha de devolución', 180, 'center');


    $estatusPrestamo = $data[0]['estatus'];

    if ($estatusPrestamo == "DEVUELTO") {

        $dateReal = $data[0]['dateReal'];
        list($i, $j, $k) = explode('-', $dateReal);
        $intNum = intval(substr($k, 0, 2));
        $monthInt = intval($j);
        $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " / " . $month[$monthInt] . " / " . $i;
        list($x, $y) = explode(' ', $k);
        $hora = $y;
        $pdf->setColor(0, 0, 0);
        $pdf->addText(412, $yb1 - 148, 9, $dateString . " / " . $hora, 180, 'center');
    } else {
        $pdf->setColor(0, 0, 0);
        $pdf->addText(412, $yb1 - 148, 9, '*****************', 180, 'center');
    }

    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(412, $yb1 - 150, 572, $yb1 - 150);
    $pdf->setColor(17/255, 44/255, 38/255);
    $pdf->addText(412, $yb1 - 158, 7, 'Fecha de devolución real', 180, 'center');



    $estatusPrestamo = $data[0]['estatus'];
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 170, 9, $estatusPrestamo, 532, 'center');
    $pdf->setStrokeColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->setLineStyle(0.1);
    $pdf->line(40, $yb1 - 172, 572, $yb1 - 172);

    $pdf->setColor(17 / 255, 44 / 255, 38 / 255);
    $pdf->addText(40, $yb1 - 178, 7, 'Estatus de Prestamo', 532, 'center');

    $pdf->ezSetY($yb1 - 184);

    $bookList  = $data[0]['book'];
    $books = array();
    $lisBook = array();
    foreach ($bookList as $key => $value) {
        $books[] = array('folio' => $value['folio'], 'titulo' => $value['titulo'],  'autor' => $value['autor']);
        $lisBook[] = $value['folio'];
    }

    /*$data = array(
        array('type' => '*', 'folio' => 1, 'titulo' => 'gandalf', 'autor' => 'wizard'),
        array('type' => '*', 'folio' => 2, 'titulo' => 'bilbo', 'autor' => 'hobbit', 'url' => 'http://www.ros.co.nz/pdf/'),
        array('type' => '*', 'folio' => 3, 'titulo' => 'frodo', 'autor' => 'hobbit')
    );*/
    $bookList  = $data[0]['book'];

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->ezTable(
        $bookList,
        array('type' => '+', 'folio' => 'Folio', 'titulo' => 'Titulo', 'autor' => '<b>Autor</b>'),
        '',
        array(
            'width' => 532, 'xPos' => 40, 'xOrientation' => 'right', 'fontSize' => 8,
            /*'shadeHeadingCol'=>array(17/255,44/255,38/255),  */
            'cols' =>
            array(
                'type' => array('width' => 15, 'justification' => 'center'),
                'folio' => array('width' => 75, 'justification' => 'center'),
                'titulo' => array('width' => 240, 'justification' => 'full'),
                'autor' => array('width' => 202, 'justification' => 'full'),
            )
        ),

    );


    if (($estatusPrestamo != "EN PROCESO" && $estatusPrestamo == "CANCELADO") || $estatusPrestamo == "DEVUELTO" || $estatusPrestamo == "PRESTADO") {
        $StringSpam = "|BIBLIOTECA ESCOLAR ETS|" . $folioReport . "|" . $dateReport . "|" . $matriculaStudent . "|" . $nameStudent . "|" . $dateExpedition . "|" . $dateReturn . "|PRESTADO|" . json_encode($lisBook) . "|";
        generateQr($StringSpam, $matriculaStudent);

        $pdf->addPngFromFile('./resource/temp/scbets' . $matriculaStudent . '.png', 38, $yb1 - 340, 60, 60);

        $pdf->ezSetY($yb1 - 260);

        $stamp  =  array(
            array('stamp' => "Qr proporcionado por el sistema de control bibliotecario de la escuela de trabajo social, exclusivamente de uso interno, para matener la integrigad y la segurirada del prestamo otorgada al usuario que lo expidio."),
            array('stamp' => base64_encode($StringSpam)),
        );
        $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
        $pdf->ezTable($stamp, '', 'Prestamo Autorizado', array(
            'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 1, 'width' => 552,
            'xPos' => 98, 'xOrientation' => 'right', 'fontSize' => 5.2, 'cols' =>
            array(
                'stamp' => array('width' => 204, 'justification' => 'full'),
            )
        ));
    }

    if ($estatusPrestamo == "DEVUELTO") {

        $StringSpam = "|BIBLIOTECA ESCOLAR ETS|" . $folioReport . "|" . $dateReport . "|" . $matriculaStudent . "|" . $nameStudent . "|" . $dateExpedition . "|" . $dateReturn . "|" . $estatusPrestamo . "|" . json_encode($lisBook) . "|" . $data[0]['dateReal'] . "|";
        generateQrDev($StringSpam, $matriculaStudent);

        $pdf->addPngFromFile('./resource/temp/scbets_dev' . $matriculaStudent . '.png', 308, $yb1 - 340, 60, 60);

        $pdf->ezSetY($yb1 - 260);
        $stamp  =  array(
            array('stamp' => "Qr proporcionado por el sistema de control bibliotecario de la escuela de trabajo social, exclusivamente de uso interno, para matener la integrigad y la segurirada del prestamo otorgada al usuario que lo expidio."),
            array('stamp' => base64_encode($StringSpam)),
        );
        $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
        $pdf->ezTable($stamp, '', 'Devolución Autorizado', array(
            'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 1, 'width' => 552,
            'xPos' => 367, 'xOrientation' => 'right', 'fontSize' => 5.2, 'cols' =>
            array(
                'stamp' => array('width' => 205, 'justification' => 'full'),
            )
        ));
    }
}