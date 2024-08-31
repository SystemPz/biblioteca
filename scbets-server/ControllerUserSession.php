<?php
session_start();
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array(), 'data' => array());

    switch (base64_decode($_POST['stmt_action'])) {

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
                                $_SESSION["user_session"] = $row->user_id;
                                $_SESSION["type_user"] = 'ADMIN';
                                //$_SESSION['data'] = array('user' == $row->user_use, 'email' => $row->user_ema);
                                $validator['success'] = true;
                                //$validator['messages'] = array('url' => '/home/view', 'user' => $row->user_use);
                                $validator['data'] = array('codex' => base64_encode($row->user_id), 'type_user' => base64_encode('ADMIN'),  'user' => $row->user_use, 'email' => $row->user_ema, 'name' => $row->user_nom, 'firtsName' => $row->user_ape);
                            } else {
                                $validator['success'] = false;
                                $validator['messages'] = 'Credenciales invalidos.';
                            }
                        } else {
                            $validator['success'] = false;
                            $validator['messages'] = 'Credencial caducadas.';
                        }
                } else {
                    $sign = $db->setSelect("consultor", "*", "con_ema='$email'");
                    $sign = $db->setFetchArray($sign);

                    if ($db->setCoutRows($sign) == 1) {
                        foreach ($sign as $row)
                            if ($row->con_sta == 1) {
                                if ($row->con_pas == MD5($password)) {
                                    $_SESSION['user_session'] = $row->con_id;
                                    $_SESSION['type_user'] = 'CONSULT';
                                    $validator['success'] = true;
                                    $validator['messages'] = array('url' => '/home/view');
                                    $validator['data'] = array('codex' => base64_encode($row->con_id), 'type_user' => base64_encode('CONSULT'), 'user' => $row->con_mat, 'email' => $row->con_ema, 'name' => $row->con_nom, 'firtsName' => $row->con_ape);
                                } else {
                                    $validator['success'] = false;
                                    $validator['messages'] = 'Credenciales invalidos.';
                                }
                            } else {
                                $validator['success'] = false;
                                $validator['messages'] = 'Credencial caducadas.';
                            }
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = 'Usuario/Contraseña incorrecta';
                    }
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = 'Los campos son importantes';
            }
            print_r(json_encode($validator));

            break;

        case 'SessionDataSet':
            $json = array();
            if (isset($_POST['txt_codex']) && base64_decode($_POST["type_user"]) == "ADMIN") {
                $codex = base64_decode($_POST['txt_codex']);
                $sign = $db->setSelect("usuarios", "*", "user_id='$codex'");
                $sign = $db->setFetchArray($sign);
                if ($db->setCoutRows($sign) == 1) {
                    foreach ($sign as $row) {
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
            }
            if (isset($_POST['txt_codex']) && base64_decode($_POST["type_user"]) == "CONSULT") {
                $id = base64_decode($_POST['txt_codex']);

                $sign = $db->setSelect("consultor", "*", "con_id='$id'");
                $sign = $db->setFetchArray($sign);
                if ($db->setCoutRows($sign) == 1) {
                    foreach ($sign as $row) {
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
            }
            print_r(json_encode($json));

            break;

        default:
    }
} else {
    header("Location: ../index.php");
}
