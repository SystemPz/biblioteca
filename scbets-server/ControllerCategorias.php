<?php
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());

    switch (base64_decode($_POST['scbets_action'])) {
        case 'Insert':
            /**-----------------------------------------INSERT--------------------------------- */
            
            $tipo = trim($_POST['txt_tipo']);
            $status = trim($_POST['txt_status']);

            if (!empty($tipo) && !empty($status)) {

                $aux = $db->setSelect("categoria", "*", "cat_tip='$tipo'");
                if ($db->setNumRows($aux) == 0) {
                   
                    $tipo = htmlspecialchars(trim($_POST['txt_tipo']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);
                   
                    if ($db->setInsert("categoria", "cat_fec, cat_tip, cat_sta", "NOW(), '$tipo', '$status'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Esta registro ya exíste. <b>' . $tipo . '</b>';
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
            $tipo = trim($_POST['upd_tipo']);
            $status = trim($_POST['upd_status']);
            $categoriaId = trim($_POST['upd_codex']);

            if (!empty($tipo) && !empty($status)) {

                $categoriaId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("categoria", "*", "cat_id='$categoriaId'");
                if ($db->setNumRows($aux) == 1) {

                    $tipo = htmlspecialchars(trim($_POST['upd_tipo']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);

                    if ($db->setUpdate("categoria", "cat_tip = '$tipo', cat_sta = '$status'", "cat_id='$categoriaId'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Este registro ya exíste. <b>' . $tipo . '</b>';
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
            $categoriaId = trim($_POST['txt_codex']);
            if (!empty($categoriaId)) {
                # code...
                $categoriaId = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("categoria", "cat_id='$categoriaId'")) {
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
                $categoriaId = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("categoria", "*", "cat_id='$categoriaId' AND cat_sta != 0 ORDER BY cat_tip ASC");
            } else {
                $consulta = $db->setSelect("categoria", "*", "cat_sta != 0 ORDER BY cat_tip ASC");
            }
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->cat_id),
                        '_bresx' => base64_encode($row->cat_fec),
                        '_cresx' => base64_encode(utf8_decode($row->cat_tip)),
                        '_dresx' => base64_encode($row->cat_sta)
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'Status':
            /**-----------------------------------------Status--------------------------------- */
            if (isset($_POST['txt_codex'])) {
                $categoriaId = base64_decode($_POST['txt_codex']);
                $buscar = $db->setSelect("categoria", "*", "cat_id = '$categoriaId'");
                $row = $db->setFetchArray($buscar);
                if ($row[0]['cat_sta'] == 1) {
                    $sta = 2;
                } else if ($row[0]['cat_sta'] == 2) {
                    $sta = 1;
                } else if ($row[0]['cat_sta'] == 3) {
                    $sta = 1;
                }

                if (!empty($sta)) {
                    if ($db->setUpdate("categoria", "cat_sta = '$sta'", "cat_id = '$categoriaId'")) {
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
