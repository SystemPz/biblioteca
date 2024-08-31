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
            $variedad = trim($_POST['txt_variedad']);
            $paginas = trim($_POST['txt_NumPagina']);
            $permiso = 2;//trim($_POST['txt_permiso']);
            $ubicacion = trim($_POST['txt_ubicacion']);
            $categoria = trim($_POST['txt_categoria']);
            $status = trim($_POST['txt_status']);

            if (!empty($folio) && !empty($titulo) && !empty($autor) && !empty($variedad) && !empty($paginas) && !empty($permiso) && !empty($ubicacion) && !empty($categoria) && !empty($status)) {

                $aux = $db->setSelect("variaciones", "*", "var_cod='$folio'");
                if ($db->setNumRows($aux) == 0) {
                    $folio = htmlspecialchars(trim($_POST['txt_folio']), ENT_QUOTES);
                    $titulo = htmlspecialchars(trim($_POST['txt_titulo']), ENT_QUOTES);
                    $autor = htmlspecialchars(trim($_POST['txt_autor']), ENT_QUOTES);
                    $variedad = htmlspecialchars(trim($_POST['txt_variedad']), ENT_QUOTES);
                    $paginas = htmlspecialchars(trim($_POST['txt_NumPagina']), ENT_QUOTES);
                    $permiso = 2;//htmlspecialchars(trim($_POST['txt_permiso']), ENT_QUOTES);
                    $ubicacion = htmlspecialchars(trim($_POST['txt_ubicacion']), ENT_QUOTES);
                    $categoria = htmlspecialchars(trim($_POST['txt_categoria']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);
                    //echo $folio.'<br>'.$titulo.'<br>'.$autor.'<br>'.$variedad.'<br>'.$paginas.'<br>'.$permiso.'<br>'.$ubicacion.'<br>'.$categoria.'<br>'.$status.'<br>';
                    if ($db->setInsert("variaciones", "var_fec, var_mat, var_cod, var_tit, var_aut, var_typ, var_pag, var_per, var_ubi, var_sta", "NOW(), '$variedad', '$folio',  '$titulo', '$autor', '$categoria',  '$paginas', '$permiso','$ubicacion', '$status'")) {
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
            //$variedad = 'ENC';//trim($_POST['upd_variedad']);
            $paginas = trim($_POST['upd_NumPagina']);
            $permiso = 2;//trim($_POST['upd_permiso']);
            $ubicacion = trim($_POST['upd_ubicacion']);
            $categoria = trim($_POST['upd_categoria']);
            $status = trim($_POST['upd_status']);
            $variedadId = trim($_POST['upd_codex']);

            if (!empty($folio) && !empty($titulo) && !empty($autor) && !empty($paginas) && !empty($permiso) && !empty($ubicacion) && !empty($categoria) && !empty($status) && !empty($variedadId)) {

                $variedadId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("variaciones", "*", "var_id='$variedadId'");
                if ($db->setNumRows($aux) == 1) {
                    $folio = htmlspecialchars(trim($_POST['upd_folio']), ENT_QUOTES);
                    $titulo = htmlspecialchars(trim($_POST['upd_titulo']), ENT_QUOTES);
                    $autor = htmlspecialchars(trim($_POST['upd_autor']), ENT_QUOTES);
                    //$variedad = htmlspecialchars(trim($_POST['upd_variedad']), ENT_QUOTES);
                    $paginas = htmlspecialchars(trim($_POST['upd_NumPagina']), ENT_QUOTES);
                    $permiso = 2;//htmlspecialchars(trim($_POST['upd_permiso']), ENT_QUOTES);
                    $ubicacion = htmlspecialchars(trim($_POST['upd_ubicacion']), ENT_QUOTES);
                    $categoria = htmlspecialchars(trim($_POST['upd_categoria']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);

                    if ($db->setUpdate("variaciones", "var_cod = '$folio', var_tit = '$titulo', var_aut = '$autor', var_typ = '$categoria', var_pag = '$paginas', var_per = '$permiso', var_ubi = '$ubicacion', var_sta = '$status'", "var_id='$variedadId'")) {
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
            /**-----------------------------------------DELETE--------------------------------- */
            $variedadId = trim($_POST['txt_codex']);
            if (!empty($variedadId)) {
                # code...
                $variedadId = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("variaciones", "var_id = '$variedadId'")) {
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
            /**-----------------------------------------DELETE--------------------------------- */
            break;

        case 'Json':
            /**-----------------------------------------JSON----------------------------------- */
            //$consulta = $db->setSelect("usuarios", "*", "user_sta != 0 ORDER BY user_use ASC");

            if (!empty($_POST['txt_codex'])) {
                $variedadId = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_id='$variedadId' AND var_sta != 0 ORDER BY var_tit ASC");
            } else if (!empty($_POST['txt_variedad'])) {
                $variedad = base64_decode($_POST['txt_variedad']);
                $consulta = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = '$variedad' AND var_sta != 0 ORDER BY var_tit ASC");
            } else {
                $consulta = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_sta != 0 ORDER BY var_tit ASC");
            }
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->var_id),
                        '_bresx' => base64_encode($row->var_fec),
                        '_cresx' => base64_encode($row->var_mat),
                        '_dresx' => base64_encode($row->var_cod),
                        '_eresx' => base64_encode(utf8_decode($row->var_tit)),
                        '_fresx' => base64_encode(utf8_decode($row->var_aut)),
                        '_gresx' => base64_encode($row->var_typ),
                        '_hresx' => base64_encode(utf8_decode($row->cat_tip)),
                        '_iresx' => base64_encode($row->var_pag),
                        '_jresx' => base64_encode($row->var_per),
                        '_kresx' => base64_encode($row->var_ubi),
                        '_lresx' => base64_encode(utf8_decode($row->ubi_nom)),
                        '_mresx' => base64_encode($row->var_ref),
                        '_nresx' => base64_encode($row->var_sta),
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
