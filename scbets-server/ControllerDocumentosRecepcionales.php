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
            $ciclo = trim($_POST['txt_periodo']);
            $paginas = trim($_POST['txt_NumPagina']);
            $permiso = trim($_POST['txt_permiso']);
            $ubicacion = trim($_POST['txt_ubicacion']);
            $modalidad = trim($_POST['txt_categoria']);
            $status = trim($_POST['txt_status']);

            if (!empty($folio) && !empty($titulo) && !empty($autor) && !empty($ciclo) && !empty($paginas) && !empty($permiso) && !empty($ubicacion) && !empty($modalidad) && !empty($status)) {

                $aux = $db->setSelect("doc_recepcional", "*", "doc_id='$folio'");
                if ($db->setNumRows($aux) == 0) {
                    $folio = htmlspecialchars(trim($_POST['txt_folio']), ENT_QUOTES);
                    $titulo = htmlspecialchars(trim($_POST['txt_titulo']), ENT_QUOTES);
                    $autor = htmlspecialchars(trim($_POST['txt_autor']), ENT_QUOTES);
                    $ciclo = htmlspecialchars(trim($_POST['txt_periodo']), ENT_QUOTES);
                    $paginas = htmlspecialchars(trim($_POST['txt_NumPagina']), ENT_QUOTES);
                    $permiso = htmlspecialchars(trim($_POST['txt_permiso']), ENT_QUOTES);
                    $ubicacion = htmlspecialchars(trim($_POST['txt_ubicacion']), ENT_QUOTES);
                    $modalidad = htmlspecialchars(trim($_POST['txt_categoria']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);

                    if ($db->setInsert("doc_recepcional", "doc_fec, doc_cod, doc_tit, doc_aut, doc_cic, doc_pag, doc_per, doc_mod, doc_ubi, doc_sta ", "NOW(), '$folio', '$titulo', '$autor', '$ciclo', '$paginas', '$permiso','$modalidad', '$ubicacion', '$status'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Esta registro ya exíste. <b>' . $matricula . '</b>';
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
            $ciclo = trim($_POST['upd_periodo']);
            $paginas = trim($_POST['upd_NumPagina']);
            $permiso = trim($_POST['upd_permiso']);
            $ubicacion = trim($_POST['upd_ubicacion']);
            $modalidad = trim($_POST['upd_categoria']);
            $status = trim($_POST['upd_status']);
            $documentoId = trim($_POST['upd_codex']);

            if (!empty($folio) && !empty($titulo) && !empty($autor) && !empty($ciclo) && !empty($paginas) && !empty($permiso) && !empty($ubicacion) && !empty($modalidad) && !empty($status) && !empty($documentoId)) {

                $documentoId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("doc_recepcional", "*", "doc_id='$documentoId'");
                if ($db->setNumRows($aux) == 1) {
                    $folio = htmlspecialchars(trim($_POST['upd_folio']), ENT_QUOTES);
                    $titulo = htmlspecialchars(trim($_POST['upd_titulo']), ENT_QUOTES);
                    $autor = htmlspecialchars(trim($_POST['upd_autor']), ENT_QUOTES);
                    $ciclo = htmlspecialchars(trim($_POST['upd_periodo']), ENT_QUOTES);
                    $paginas = htmlspecialchars(trim($_POST['upd_NumPagina']), ENT_QUOTES);
                    $permiso = htmlspecialchars(trim($_POST['upd_permiso']), ENT_QUOTES);
                    $ubicacion = htmlspecialchars(trim($_POST['upd_ubicacion']), ENT_QUOTES);
                    $modalidad = htmlspecialchars(trim($_POST['upd_categoria']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);

                    if ($db->setUpdate("doc_recepcional", "doc_cod = '$folio', doc_tit = '$titulo', doc_aut = '$autor', doc_cic = '$ciclo', doc_pag = '$paginas', doc_per = '$permiso', doc_mod = '$modalidad', doc_ubi = '$ubicacion', doc_sta = '$status'", "doc_id='$documentoId'")) {
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
                $documentoId = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("doc_recepcional", "doc_id = '$documentoId'")) {
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
                $consulta = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_id='$libroId' AND doc_sta != 0 ORDER BY doc_tit ASC");
            } else {
                $consulta = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_sta != 0 ORDER BY doc_tit ASC");
            }
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->doc_id),
                        '_bresx' => base64_encode($row->doc_fec),
                        '_cresx' => base64_encode($row->doc_cod),
                        '_dresx' => base64_encode(utf8_decode($row->doc_tit)),
                        '_eresx' => base64_encode(utf8_decode($row->doc_aut)),
                        '_fresx' => base64_encode($row->doc_cic),
                        '_gresx' => base64_encode($row->doc_pag),
                        '_hresx' => base64_encode($row->doc_per),
                        '_iresx' => base64_encode($row->doc_mod),
                        '_jresx' => base64_encode(utf8_decode($row->cat_tip)),
                        '_kresx' => base64_encode($row->doc_ubi),
                        '_lresx' => base64_encode(utf8_decode($row->ubi_nom)),
                        '_mresx' => base64_encode($row->doc_ref),
                        '_nresx' => base64_encode($row->doc_sta),
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'Status':
            /**-----------------------------------------Status--------------------------------- */
            if (isset($_POST['txt_codex'])) {
                $documentoId = base64_decode($_POST['txt_codex']);
                $buscar = $db->setSelect("doc_recepcional", "*", "doc_id='$documentoId'");
                $row = $db->setFetchArray($buscar);
                if ($row[0]['doc_sta'] == 1) {
                    $sta = 2;
                } else if ($row[0]['doc_sta'] == 2) {
                    $sta = 1;
                } else if ($row[0]['doc_sta'] == 3) {
                    $sta = 1;
                }

                if (!empty($sta)) {
                    if ($db->setUpdate("doc_recepcional", "doc_sta='$sta'", "doc_id='$documentoId'")) {
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
