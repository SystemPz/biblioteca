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
        case 'DownloadDetailBook':

            if (isset($_POST['txt_codex'])) {
                $id = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_id = '$id'");

                $json = array();
                $fecha = $db->setSelect("NOW() as fecha", "");

                if ($db->setNumRows($consulta) > 0) {
                    foreach ($db->setFetchArray($consulta) as $row) {

                        $json[] = array(
                            '_aresx' => base64_encode($row->lib_id),
                            '_bresx' => base64_encode($row->lib_fec),
                            'folio' => ($row->lib_cod),
                            'titulo' => (($row->lib_tit)),
                            'autor' => (($row->lib_aut)),
                            'editorial' => (($row->lib_edi)),
                            'lugarEdicion' => (($row->lib_l_f)),
                            'paginas' => ($row->lib_pag),
                            'permiso' => ($row->lib_per),
                            '_jresx' => base64_encode($row->lib_ubi),
                            'ubicacion' => (($row->ubi_nom)),
                            '_lresx' => base64_encode($row->lib_cat),
                            'categoria' => (($row->cat_tip)),
                            '_nresx' => base64_encode($row->lib_ref),
                            'status' => ($row->lib_sta),
                            'fecha' => $fecha,
                        );
                    }
                }
                $pdf = new Cezpdf('LETTER', 'portrait');
                ContentPdf2($pdf, $json);
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
                # code...
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

function ContentPdf($pdf, $data)
{
    $pdf->addJpegFromFile('./resource/image/MarcaLogoETS.jpg', 200.5, 470, 211, 205);

    $pdf->addJpegFromFile('./resource/image/HeaderLogo.jpg', 40, 732, 532, 33.5);

    $yb1 = 725;
    $pdf->ezSetCmMargins(0, 0, 0, 0);

    $opc = "Educación Presencial";
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');
    $pdf->addText(40, $yb1 - 14, 12, (str_replace(" ", " ", '<b>BIBLIOTECA ESCOLAR DE LA ESCUELA DE TRABAJO SOCIAL, ZACATECAS.</b>')), 532, 'center');

    $yb1 = 718;
    date_default_timezone_set('America/Mexico_City');

    $fechaActual = date('d-m-Y h:i:s');
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->addText(307, $yb1 - 24, 9, $fechaActual, 265, 'center');


    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb1 - 26, 572, $yb1 - 26);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb1 - 34, 7, 'Fecha', 265, 'center');

    $pdf->setStrokeColor(0.847, 0.780, 0.65);
    $pdf->setColor(0.835, 0.749, 0.619);
    $pdf->filledRectangle(40, $yb1 - 49.6, 532, 10);
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(70, $yb1 - 48, 10, 'Datos del Libro', 472, 'center');


    $folio = $data[0]['folio'];
    $pdf->addText(40, $yb1 - 62, 9, $folio, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 64, 300, $yb1 - 64);
    

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 72, 7, 'Folio', 265, 'center');
    

    $titulo = $data[0]['titulo'];
    $pdf->addText(40, $yb1 - 86, 9, $titulo, 532, 'center');
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 88, 572, $yb1 - 88);
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 96, 7, 'Título', 532, 'center');

    $autor = $data[0]['autor'];
    $pdf->addText(40, $yb1 - 110, 9, $autor, 532, 'center');
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 112, 572, $yb1 - 112);
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 120, 7, 'Autor', 532, 'center');


    $editorial = $data[0]['editorial'];
    $lugarEdicion = $data[0]['lugarEdicion'];
    $pdf->addText(40, $yb1 - 134, 9, $editorial, 265, 'center');
    $pdf->addText(307, $yb1 - 134, 9, $lugarEdicion, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 136, 300, $yb1 - 136);
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb1 - 136, 572, $yb1 - 136);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 144, 7, 'Editorial', 265, 'center');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb1 - 144, 7, 'Lugar y fecha de edición', 265, 'center');


    $paginas = $data[0]['paginas'];
    $status = "*******";
    if ($data[0]['status'] == 1) {
        $status = "Activo";
    } else if ($data[0]['status'] == 2) {
        $status = "Suspedido";
    } else {
        $status = "Baja";
    }
    $pdf->addText(40, $yb1 - 158, 9, $paginas, 265, 'center');
    $pdf->addText(307, $yb1 - 158, 9, $status, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 160, 300, $yb1 - 160);
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb1 - 160, 572, $yb1 - 160);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 168, 7, 'Páginas', 265, 'center');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb1 - 168, 7, 'Estatus', 265, 'center');

    $categoria = $data[0]['categoria'];
    $ubicacion = $data[0]['ubicacion'];
    $pdf->addText(40, $yb1 - 182, 9, $categoria, 265, 'center');
    $pdf->addText(307, $yb1 - 182, 9, $ubicacion, 265, 'center');

    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(40, $yb1 - 184, 300, $yb1 - 184);
    $pdf->setStrokeColor(0.756, 0.752, 0.745);
    $pdf->setLineStyle(0.5, "round");
    $pdf->line(312, $yb1 - 184, 572, $yb1 - 184);

    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 192, 7, 'Categoría', 265, 'center');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(307, $yb1 - 192, 7, 'Ubicación', 265, 'center');

    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');
    $pdf->setColor(0, 0, 0);
    $pdf->addText(40, $yb1 - 200, 7, 'INFORMACIÖN', 532, 'center');

    $pdf->ezSetY($yb1 - 200);
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $stamp  = array(
        array('stamp' => "El ejemplar " . $titulo . " con folio " . $folio . ", es una collecion resguardad en la biblioteca escolar de la Escuela de Trabajo Social de Zacatecas. "),
    );
    $pdf->ezTable($stamp, '', '', array(
        'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 0, 'width' => 552,
        'xPos' => 40, 'xOrientation' => 'right', 'fontSize' => 8, 'cols' =>
        array(
            'stamp' => array('width' => 532, 'justification' => 'full'),
        )
    ));

}


function ContentPdf2($pdf, $data)
{
    $pdf->addJpegFromFile('./resource/image/PlantillaBook.jpg', 0, 0, 612, 792);

    $yb1 = 725;
    $pdf->ezSetCmMargins(0, 0, 0, 0);

    $opc = "Educación Presencial";
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Bold.afm');

    $yb1 = 718;
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
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $pdf->addText(425, $yb1 - 42, 9, $dateString, 150, 'center');

    $folio = $data[0]['folio'];
    $pdf->addText(40, $yb1 - 79, 9, $folio, 150, 'center');

    $titulo = $data[0]['titulo'];
    $pdf->addText(39.612, $yb1 - 101, 9, $titulo, 532.618, 'center');

    $autor = $data[0]['autor'];
    $pdf->addText(39.612, $yb1 - 124, 9, $autor, 532.618, 'center');

    $editorial = $data[0]['editorial'];
    $lugarEdicion = $data[0]['lugarEdicion'];

    $pdf->addText(39.612, $yb1 - 147, 9, $editorial, 255.118, 'center');
    $pdf->addText(317.268, $yb1 - 147, 9, $lugarEdicion, 255.118, 'center');

    $paginas = $data[0]['paginas'];
    $status = "*******";
    if ($data[0]['status'] == 1) {
        $status = "Activo";
    } else if ($data[0]['status'] == 2) {
        $status = "Suspedido";
    } else {
        $status = "Baja";
    }

    if ($data[0]['permiso'] == 1) {
        $permiso = "Para Prestamo";
    } else if ($data[0]['permiso'] == 2) {
        $permiso = "Para Reserva";
    }

    $pdf->addText(39.612, $yb1 - 170, 9, $paginas, 166.325, 'center');
    $pdf->addText(220.961, $yb1 - 170, 9, $permiso, 166.325, 'center');
    $pdf->addText(406.063, $yb1 - 170, 9, $status, 166.325, 'center');


    $categoria = $data[0]['categoria'];
    $ubicacion = $data[0]['ubicacion'];
    $pdf->addText(39.609, $yb1 - 192, 9, $categoria, 166.325, 'center');
    $pdf->addText(220.961, $yb1 - 192, 9, $ubicacion, 166.325, 'center');

    $StringSpam = "|BIBLIOTECA ESCOLAR ETS|" . $folio . "|" . $titulo . "|" . $autor . "|" . $editorial . "|" . $lugarEdicion . "|" . $paginas . "|" . $permiso . "|" . $status . "|" . $categoria . "|" . $ubicacion . "|";
    generateQr($StringSpam, $folio);

    $pdf->addPngFromFile('./temp/scbets_lib' . $folio . '.png', 36, $yb1 - 295, 60, 60);

    $pdf->ezSetY($yb1 - 232);
    $pdf->selectFont('./lib/ezpdf/fonts/Montserrat-Regular.afm');
    $stamp  = array(
        array('stamp' => "El ejemplar " . $titulo . " con folio " . $folio . ", es una collecion resguardada en la biblioteca escolar de la Escuela de Trabajo Social de Zacatecas. "),
        array('stamp' => base64_encode($StringSpam)),
    );
    $pdf->ezTable($stamp, '', '', array(
        'rowGap' => 1, 'colGap' => 1, 'showLines' => 0, 'showHeadings' => 0, 'shaded' => 0, 'width' => 400,
        'xPos' => 98, 'xOrientation' => 'right', 'fontSize' => 8, 'cols' =>
        array(
            'stamp' => array('width' => 480, 'justification' => 'full'),
        )
    ));
}

function generateQr($StringSpam, $matricula)
{
    $_REQUEST['data'] = '' . ($StringSpam);
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . './temp' . DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = './temp';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
    if (isset($_REQUEST['data'])) {
        $filename = $PNG_TEMP_DIR . 'scbets_lib' . $matricula . '.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}
