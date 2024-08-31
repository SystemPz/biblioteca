<?php
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());

    switch (base64_decode($_POST['scbets_action'])) {
        case 'Insert':
            /**-----------------------------------------INSERT--------------------------------- */
            $name = trim($_POST['txt_name']);
            $firtsname = trim($_POST['txt_firtsname']);
            $email = trim($_POST['txt_email']);
            $password = trim($_POST['txt_password']);
            $status = trim($_POST['txt_status']);


            if (!empty($name) && !empty($firtsname) && !empty($email) && !empty($password) && !empty($status)) {

                $aux = $db->setSelect("usuarios", "*", "user_ema='$email'");
                if ($db->setNumRows($aux) == 0) {
                    $name = htmlspecialchars(trim($_POST['txt_name']), ENT_QUOTES);
                    $firtsname = htmlspecialchars(trim($_POST['txt_firtsname']), ENT_QUOTES);
                    $email = htmlspecialchars(trim($_POST['txt_email']), ENT_QUOTES);
                    $password = htmlspecialchars(trim($_POST['txt_password']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['txt_status']), ENT_QUOTES);
                    $password1 = md5($password);
                    $password2 = base64_encode($password);
                    $username = uniqid();

                    if ($db->setInsert("usuarios", "user_fec, user_use, user_ema, user_enc, user_pas, user_nom, user_ape, user_sta", "NOW(), '$username', '$email', '$password1', '$password2', '$name', '$firtsname', '$status'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Esta registro ya exíste. <b>' . $email . '</b>';
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
            $firtsname = trim($_POST['upd_firtsname']);
            $email = trim($_POST['upd_email']);
            $password = trim($_POST['upd_password']);
            $status = trim($_POST['upd_status']);
            $usuarioId =  trim($_POST['upd_codex']);

            if (!empty($name) && !empty($firtsname) && !empty($email) && !empty($password) && !empty($status) && !empty($usuarioId)) {

                $usuarioId = base64_decode($_POST['upd_codex']);

                $aux = $db->setSelect("usuarios", "*", "user_id='$usuarioId'");
                if ($db->setNumRows($aux) == 1) {
                    $name = htmlspecialchars(trim($_POST['upd_name']), ENT_QUOTES);
                    $firtsname = htmlspecialchars(trim($_POST['upd_firtsname']), ENT_QUOTES);
                    $email = htmlspecialchars(trim($_POST['upd_email']), ENT_QUOTES);
                    $password = htmlspecialchars(trim($_POST['upd_password']), ENT_QUOTES);
                    $status = htmlspecialchars(trim($_POST['upd_status']), ENT_QUOTES);
                    $decode = ($password);
                    //echo "[[ ".base64_decode($password)." ]]";
                    $password1 = md5($decode);
                    $password2 = base64_encode($decode);

                    if ($db->setUpdate("usuarios", " user_ema = '$email', user_enc = '$password1', user_pas = '$password2', user_nom = '$name', user_ape = '$firtsname', user_sta = '$status' ", "user_id='$usuarioId'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Este registro ya exíste. <b>' . $email . '</b>';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Algumos datos requeridos no estan completos.';
            }
            print_r(json_encode($validator));

            /**-----------------------------------------UPDATE--------------------------------- */
            break;
        case 'userDelete':
            /**-----------------------------------------INSERT--------------------------------- */
            $token = trim($_POST['txt_codex']);
            if (!empty($token)) {
                # code...
                $usuarioId = base64_decode($_POST['txt_codex']);
                if ($db->setDelete("usuarios", "user_id='$usuarioId'")) {
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
                $usuarioId = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("usuarios", "*", "user_id='$usuarioId' AND user_sta != 0 ORDER BY user_use ASC");
            } else {
                $consulta = $db->setSelect("usuarios", "*", "user_sta != 0 ORDER BY user_use ASC");
            }
            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->user_id),
                        '_bresx' => base64_encode($row->user_fec),
                        '_cresx' => base64_encode($row->user_use),
                        '_dresx' => base64_encode(utf8_decode($row->user_ema)),
                        '_eresx' => base64_encode($row->user_enc),
                        '_fresx' => ($row->user_pas),
                        '_gresx' => base64_encode(utf8_decode($row->user_nom)),
                        '_hresx' => base64_encode(utf8_decode($row->user_ape)),
                        '_iresx' => base64_encode($row->user_sta)
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'Status':
            /**-----------------------------------------Status--------------------------------- */
            if (isset($_POST['txt_codex'])) {
                $usuarioId = base64_decode($_POST['txt_codex']);
                $buscar = $db->setSelect("usuarios", "*", "user_id='$usuarioId'");
                $row = $db->setFetchArray($buscar);
                if ($row[0]['user_sta'] == 1) {
                    $sta = 2;
                } else if ($row[0]['user_sta'] == 2) {
                    $sta = 1;
                } else if ($row[0]['user_sta'] == 3) {
                    $sta = 1;
                }

                if (!empty($sta)) {
                    if ($db->setUpdate("usuarios", "user_sta='$sta'", "user_id='$usuarioId'")) {
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
        case 'session_input':
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            if (!empty($email) && !empty($password)) {
                $sign = $db->setSelect("usuarios", "*", "user_ema='$email'");
                $sign = $db->setFetchArray($sign);
                if ($db->setCoutRows($sign) == 1) {
                    foreach ($sign as $row)
                        if ($row->user_sta == 1) {
                            if ($row->user_enc == MD5($password)) {
                                //session_start();
                                $_SESSION['user_session'] = $row->user_id;
                                $_SESSION['type_user'] = 'ADMIN';
                                //$_SERVER['inic'] = $row['user_sta'];
                                $validator['success'] = true;
                                $validator['messages'] = array('url' => '/home/view');
                                //echo "->" . $row->user_sta;
                            } else {
                                $validator['success'] = true;
                                $validator['messages'] = 'invalid';
                            }
                        } else {
                            $validator['success'] = true;
                            $validator['messages'] = 'invalid';
                        }
                }
            }
            print_r(json_encode($validator));

            break;

        default:
    }
} else {
    header("Location: ../index.php");
}
