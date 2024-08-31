<?php
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());

    switch (base64_decode($_POST['scbets_action'])) {
        case 'Insert':
            /**-----------------------------------------INSERT--------------------------------- */
            
            $folio = trim($_POST['txt_folio']);
            $titulo = trim($_POST['txt_titulo']);
            $autor = trim($_POST['txt_autor']);
            $editorial = trim($_POST['txt_editorial']);
            $edicion = trim($_POST['txt_lugarFechaEdicion']);
            $paginas = trim($_POST['txt_NumPagina']);
            $permiso = trim($_POST['txt_permiso']);
            $ubicacion = trim($_POST['txt_ubicacion']);
            $categoria = trim($_POST['txt_categoria']);
            $status = trim($_POST['txt_status']);

            if (!empty($folio) && !empty($titulo) && !empty($autor) && !empty($editorial) && !empty($edicion) && !empty($paginas) && !empty($permiso) && !empty($ubicacion) && !empty($categoria) && !empty($status)) {

                $aux = $db->setSelect("libros", "*", "lib_cod='$folio'");
                if ($db->setNumRows($aux) == 0) {
                    $folio = htmlspecialchars(trim($_POST['txt_folio']), ENT_QUOTES);
                    $titulo = htmlspecialchars(trim($_POST['txt_titulo']), ENT_QUOTES);
                    $autor = htmlspecialchars(trim($_POST['txt_autor']), ENT_QUOTES);
                    $editorial = htmlspecialchars(trim($_POST['txt_editorial']), ENT_QUOTES);
                    $edicion = htmlspecialchars(trim($_POST['txt_lugarFechaEdicion']), ENT_QUOTES);
                    $paginas = htmlspecialchars(trim($_POST['txt_NumPagina']), ENT_QUOTES);
                    $permiso = htmlspecialchars(trim($_POST['txt_permiso']), ENT_QUOTES);
                    $ubicacion = htmlspecialchars(trim($_POST['txt_ubicacion']), ENT_QUOTES);
                    $categoria = htmlspecialchars(trim($_POST['txt_categoria']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);

                    if ($db->setInsert("libros", "lib_fec, lib_cod, lib_tit, lib_aut, lib_edi, lib_l_f, lib_pag, lib_per, lib_ubi, lib_cat, lib_sta", "NOW(), '$folio', '$titulo', '$autor', '$editorial', '$edicion', '$paginas', '$permiso','$ubicacion', '$categoria', '$status'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Esta registro ya exíste. <b>' . $folio . '</b>';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Algumos datos requeridos no estan completos.';
            }
            print_r(json_encode($validator));
            /**-----------------------------------------INSERT--------------------------------- */
            break;
        case 'Update':
            /**-----------------------------------------UPDATE--------------------------------- */
            $folio = trim($_POST['upd_folio']);
            $titulo = trim($_POST['upd_titulo']);
            $autor = trim($_POST['upd_autor']);
            $editorial = trim($_POST['upd_editorial']);
            $edicion = trim($_POST['upd_lugarFechaEdicion']);
            $paginas = trim($_POST['upd_NumPagina']);
            $permiso = trim($_POST['upd_permiso']);
            $ubicacion = trim($_POST['upd_ubicacion']);
            $categoria = trim($_POST['upd_categoria']);
            $status = trim($_POST['upd_status']);
            $libroId = trim($_POST['upd_codex']);

            if (!empty($folio) && !empty($titulo) && !empty($autor) && !empty($editorial) && !empty($edicion) && !empty($paginas) && !empty($permiso) && !empty($ubicacion) && !empty($categoria) && !empty($status) && !empty($libroId)) {

                $libroId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("libros", "*", "lib_id='$libroId'");
                if ($db->setNumRows($aux) == 1) {
                    $folio = htmlspecialchars(trim($_POST['upd_folio']), ENT_QUOTES);
                    $titulo = htmlspecialchars(trim($_POST['upd_titulo']), ENT_QUOTES);
                    $autor = htmlspecialchars(trim($_POST['upd_autor']), ENT_QUOTES);
                    $editorial = htmlspecialchars(trim($_POST['upd_editorial']), ENT_QUOTES);
                    $edicion = htmlspecialchars(trim($_POST['upd_lugarFechaEdicion']), ENT_QUOTES);
                    $paginas = htmlspecialchars(trim($_POST['upd_NumPagina']), ENT_QUOTES);
                    $permiso = htmlspecialchars(trim($_POST['upd_permiso']), ENT_QUOTES);
                    $ubicacion = htmlspecialchars(trim($_POST['upd_ubicacion']), ENT_QUOTES);
                    $categoria = htmlspecialchars(trim($_POST['upd_categoria']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);

                    if ($db->setUpdate("libros", "lib_cod = '$folio', lib_tit = '$titulo', lib_aut = '$autor', lib_edi = '$editorial', lib_l_f = '$edicion', lib_pag = '$paginas', lib_per = '$permiso', lib_ubi = '$ubicacion', lib_cat = '$categoria', lib_sta = '$status'", "lib_id='$libroId'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Este registro ya exíste. <b>' . $folio . '</b>';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Algumos datos requeridos no estan completos.';
            }
            print_r(json_encode($validator));

            /**-----------------------------------------UPDATE--------------------------------- */
            break;
        case 'onDelete':
            /**-----------------------------------------INSERT--------------------------------- */
            $token = trim($_POST['txt_codex']);
            if (!empty($token)) {
                # code...
                $libroId = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("libros", "lib_id = '$libroId'")) {
                    $validator['success'] = true;
                    $validator['messages'] = ' Éxito en la Operación.';
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Ocurrio un error.';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Ocurrio un error con el identificador interno.';
            }
            print_r(json_encode($validator));
            /**-----------------------------------------INSERT--------------------------------- */
            break;

        case 'Json':
            /**-----------------------------------------JSON----------------------------------- */
            //$consulta = $db->setSelect("usuarios", "*", "user_sta != 0 ORDER BY user_use ASC");

            if (!empty($_POST['txt_codex'])) {
                $libroId = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_id='$libroId' AND lib_sta != 0 ORDER BY lib_tit ASC");
            } else {
                $consulta = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_sta != 0 ORDER BY lib_tit ASC");
            }
            $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

            //html PNG location prefix
            $PNG_WEB_DIR = 'temp/';

            include "./phpqrcode/qrlib.php";

            //ofcourse we need rights to create temp dir
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);

            $errorCorrectionLevel = 'Q';

            $matrixPointSize = 7;
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $filename = $PNG_TEMP_DIR . 'test' . md5($row->lib_cod . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

                    QRcode::png($row->lib_cod, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->lib_id),
                        '_bresx' => base64_encode($row->lib_fec),
                        '_cresx' => base64_encode($row->lib_cod),
                        '_dresx' => base64_encode(utf8_decode($row->lib_tit)),
                        '_eresx' => base64_encode(utf8_decode($row->lib_aut)),
                        '_fresx' => base64_encode(utf8_decode($row->lib_edi)),
                        '_gresx' => base64_encode(utf8_decode($row->lib_l_f)),
                        '_hresx' => base64_encode($row->lib_pag),
                        '_iresx' => base64_encode($row->lib_per),
                        '_jresx' => base64_encode($row->lib_ubi),
                        '_kresx' => base64_encode(utf8_decode($row->ubi_nom)),
                        '_lresx' => base64_encode($row->lib_cat),
                        '_mresx' => base64_encode(utf8_decode($row->cat_tip)),
                        '_nresx' => base64_encode($row->lib_ref),
                        '_oresx' => base64_encode($row->lib_sta),
                        '_links' => basename($filename),
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'Status':
            /**-----------------------------------------Status--------------------------------- */
            if (isset($_POST['txt_codex'])) {
                $libroId = base64_decode($_POST['txt_codex']);
                $buscar = $db->setSelect("libros", "*", "lib_id='$libroId'");
                $row = $db->setFetchArray($buscar);
                if ($row[0]['lib_sta'] == 1) {
                    $sta = 2;
                } else if ($row[0]['lib_sta'] == 2) {
                    $sta = 1;
                } else if ($row[0]['lib_sta'] == 3) {
                    $sta = 1;
                }

                if (!empty($sta)) {
                    if ($db->setUpdate("libros", "lib_sta='$sta'", "lib_id='$libroId'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito acompletado.';
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
            /**-----------------------------------------Status--------------------------------- */
            break;

        default:
    }
} else {
    header("Location: ../index.php");
}
