<?php

require_once './phpqrcode/qrlib.php';

session_start();
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
$validator = array('success' => false, 'messages' => array());

if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

    switch (base64_decode($_POST['scbets_action'])) {
        case 'HistoryDataUser':
            if (!empty($_POST['txt_codex'])) {
                $id = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("prestamos", "*", "consultor_id='$id' ORDER BY create_at DESC");
            } else {
                $consulta = $db->setSelect("prestamos", "*", "1 ORDER BY create_at DESC");
            }
            $json = array();
            $book = null;
            $student = null;
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $month = array("1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
                    $d = $row->create_at;
                    list($i, $j, $k) = explode('-', $d);
                    $intNum = intval(substr($k, 0, 2));

                    $monthInt = intval($j);

                    $dateString =  (intval($intNum) >= 10 ? $intNum : "0" . $intNum) . " de " . $month[$monthInt] . " de " . $i;

                    $book = getBook($row->prestamo_id, $db);
                    $student = getStudent($row->consultor_id, $db);
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->prestamo_id),
                        '_bresx' => base64_encode($row->create_at),
                        '_cresx' => base64_encode(($row->codepres)),
                        '_dresx' => base64_encode(($row->tipo_prestamo)),
                        '_eresx' => base64_encode(($row->coleccion_id)),
                        'collection' => $book, //base64_encode($row->coleccion),
                        '_gresx' => base64_encode(($row->consultor_id)),
                        'consult' => $student, //base64_encode(($row->consultor)),
                        '_iresx' => base64_encode(($row->status)),
                        '_jresx' => base64_encode(($row->fecha_prestamo)),
                        '_kresx' => base64_encode(($row->fecha_devolucion)),
                        '_lresx' => base64_encode(($row->fecha_real)),
                        '_mresx' => base64_encode(($row->estatus)),
                        'fechaString' => $dateString,
                    );
                }
            }
            print_r(json_encode($json));
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
