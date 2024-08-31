<?php
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());

    switch (base64_decode($_POST['scbets_action'])) {
        case 'Insert':
            /**-----------------------------------------INSERT--------------------------------- */
            $email = trim($_POST['txt_email']);
            $matricula = trim($_POST['txt_matricula']);
            $name = trim($_POST['txt_name']);
            $firtsname = trim($_POST['txt_firtsname']);
            $status = trim($_POST['txt_status']);


            if (!empty($email) && !empty($matricula) && !empty($name) && !empty($firtsname) && !empty($status)) {

                $aux = $db->setSelect("consultor", "*", "con_ema='$email'");
                if ($db->setNumRows($aux) == 0) {
                    $email = htmlspecialchars(trim($_POST['txt_email']), ENT_QUOTES);
                    $matricula = htmlspecialchars(trim($_POST['txt_matricula']), ENT_QUOTES);
                    $name = htmlspecialchars(trim($_POST['txt_name']), ENT_QUOTES);
                    $firtsname = htmlspecialchars(trim($_POST['txt_firtsname']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);
                    $password1 = md5($matricula);

                    if ($db->setInsert("consultor", "con_f_i, con_f_u, con_mat, con_pas, con_nom, con_ape, con_ema, con_sta", "NOW(), NOW(), '$matricula', '$password1', '$name', '$firtsname', '$email', '$status'")) {
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
            $email = trim($_POST['upd_email']);
            $matricula = trim($_POST['upd_matricula']);
            $name = trim($_POST['upd_name']);
            $firtsname = trim($_POST['upd_firtsname']);
            $status = trim($_POST['upd_status']);
            $consultorId =  trim($_POST['upd_codex']);

            if (!empty($email) && !empty($matricula) && !empty($name) && !empty($firtsname) && !empty($status) && !empty($consultorId)) {

                $consultorId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("consultor", "*", "con_id='$consultorId'");
                if ($db->setNumRows($aux) == 1) {
                    $email = htmlspecialchars(trim($_POST['upd_email']), ENT_QUOTES);
                    $matricula = htmlspecialchars(trim($_POST['upd_matricula']), ENT_QUOTES);
                    $name = htmlspecialchars(trim($_POST['upd_name']), ENT_QUOTES);
                    $firtsname = htmlspecialchars(trim($_POST['upd_firtsname']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);
                    $password1 = md5($matricula);

                    if ($db->setUpdate("consultor", " con_mat = '$matricula', con_pas = '$password1', con_nom = '$name', con_ape = '$firtsname', con_ema = '$email', con_sta = '$status' ", "con_id='$consultorId'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Este registro ya exíste. <b>' . $matricula . '</b>';
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
                $id = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("consultor", "con_id='$id'")) {
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
                $consultorId = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("consultor", "*", "con_id='$consultorId' AND con_sta != 0 ORDER BY con_mat ASC");
            } else {
                $consulta = $db->setSelect("consultor", "*", "con_sta != 0 ORDER BY con_mat ASC");
            }
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->con_id),
                        '_bresx' => base64_encode($row->con_f_i),
                        '_cresx' => base64_encode($row->con_f_u),
                        '_dresx' => base64_encode($row->con_mat),
                        '_eresx' => base64_encode($row->con_pas),
                        '_fresx' => base64_encode(utf8_decode($row->con_nom)),
                        '_gresx' => base64_encode(utf8_decode($row->con_ape)),
                        '_hresx' => base64_encode(utf8_decode($row->con_ema)),
                        '_iresx' => base64_encode($row->con_sta)
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'Status':
            /**-----------------------------------------Status--------------------------------- */
            if (isset($_POST['txt_codex'])) {
                $consultorId = base64_decode($_POST['txt_codex']);
                $buscar = $db->setSelect("consultor", "*", "con_id='$consultorId'");
                $row = $db->setFetchArray($buscar);
                if ($row[0]['con_sta'] == 1) {
                    $sta = 2;
                } else if ($row[0]['con_sta'] == 2) {
                    $sta = 1;
                } else if ($row[0]['con_sta'] == 3) {
                    $sta = 1;
                }

                if (!empty($sta)) {
                    if ($db->setUpdate("consultor", "con_sta='$sta'", "con_id='$consultorId'")) {
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
