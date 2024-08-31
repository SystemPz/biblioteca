<?php
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());

    switch (base64_decode($_POST['scbets_action'])) {
        case 'Insert':
            /**-----------------------------------------INSERT--------------------------------- */

            $name = trim($_POST['txt_name']);
            $status = trim($_POST['txt_status']);

            if (!empty($name) && !empty($status)) {

                $aux = $db->setSelect("ubicacion", "*", "ubi_nom='$name'");
                if ($db->setNumRows($aux) == 0) {

                    $name = htmlspecialchars(trim($_POST['txt_name']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);

                    if ($db->setInsert("ubicacion", "ubi_fec, ubi_nom, ubi_sta", "NOW(), '$name', '$status'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Este registro ya exíste. <b>' . $name . '</b>';
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
            $name = trim($_POST['upd_name']);
            $status = trim($_POST['upd_status']);
            $ubicacionId = trim($_POST['upd_codex']);

            if (!empty($name) && !empty($status) && !empty($ubicacionId)) {

                $ubicacionId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("ubicacion", "*", "ubi_id='$ubicacionId'");
                if ($db->setNumRows($aux) == 1) {

                    $name = htmlspecialchars(trim($_POST['upd_name']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);

                    if ($db->setUpdate("ubicacion", "ubi_nom = '$name', ubi_sta = '$status'", "ubi_id='$ubicacionId'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Este registro ya exíste. <b>' . $name . '</b>';
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
            $ubicacionId = trim($_POST['txt_codex']);
            if (!empty($ubicacionId)) {
                # code...
                $ubicacionId = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("ubicacion", "ubi_id='$ubicacionId'")) {
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
                $ubicacionId = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("ubicacion", "*", "ubi_id='$ubicacionId' AND ubi_sta != 0 ORDER BY ubi_nom ASC");
            } else {
                $consulta = $db->setSelect("ubicacion", "*", "ubi_sta != 0 ORDER BY ubi_nom ASC");
            }
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->ubi_id),
                        '_bresx' => base64_encode($row->ubi_fec),
                        '_cresx' => base64_encode(utf8_decode($row->ubi_nom)),
                        '_dresx' => base64_encode($row->ubi_sta)
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'Status':
            /**-----------------------------------------Status--------------------------------- */
            if (isset($_POST['txt_codex'])) {
                $ubicacionId = base64_decode($_POST['txt_codex']);
                $buscar = $db->setSelect("ubicacion", "*", "ubi_id = '$ubicacionId'");
                $row = $db->setFetchArray($buscar);
                if ($row[0]['ubi_sta'] == 1) {
                    $sta = 2;
                } else if ($row[0]['ubi_sta'] == 2) {
                    $sta = 1;
                } else if ($row[0]['ubi_sta'] == 3) {
                    $sta = 1;
                }

                if (!empty($sta)) {
                    if ($db->setUpdate("ubicacion", "ubi_sta = '$sta'", "ubi_id = '$ubicacionId'")) {
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