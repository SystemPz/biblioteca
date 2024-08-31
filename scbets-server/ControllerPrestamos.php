<?php
session_start();
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
//date_default_timezone_set("UTC");
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());

    switch (base64_decode($_POST['scbets_action'])) {
        case 'Insert':
            /**-----------------------------------------INSERT--------------------------------- */
            $folios = !empty($_POST['folio'])  ? ($_POST['folio']) : "";
            $matriculas = trim($_POST['scbets_matricula']);
            $devolucion = trim($_POST['scbets_devolucion']);
            list($a, $b) = explode('-', $matriculas);
            if (!empty($folios) && !empty($matriculas) && !empty($devolucion)) {
                if (!empty($a)) {
                    $array = array();
                    $bookId = array();
                    foreach ($folios as $key) {
                        $book = $db->setSelect("libros", "*", "lib_id='$key'");

                        if ($db->setNumRows($book) > 0) {
                            foreach ($db->setFetchArray($book) as $row) {
                                $bookId[] = array('bookId' => $row->lib_id);
                                $array[] = array('id' => $row->lib_id, 'folio' => $row->lib_cod, 'titulo' => htmlspecialchars($row->lib_tit, ENT_QUOTES), 'autor' => ($row->lib_aut));
                            }
                        }
                    }

                    $consulta = $db->setSelect("consultor", "*", "con_mat='$a'");
                    //$consultor = $db->setSelect("consultor", "*", "lib_cod='$folio'");
                    $consltor = array();
                    $consultorId = null;
                    if ($db->setNumRows($consulta) > 0) {
                        foreach ($db->setFetchArray($consulta) as $row) {
                            $consultorId = $row->con_id;
                            $consltor[] = array('id' => $row->con_id, 'matricula' => $row->con_mat, 'consultor' => ($row->con_nom) . ' ' . ($row->con_ape), 'email' => $row->con_ema);
                        }
                    }
                    $cons = $db->setSelect("prestamos", "*", "consultor_id='$consultorId' AND (estatus='PRESTADO' OR estatus='EN PROCESO')");
                    if ($db->setNumRows($cons) == 0) {
                    

                    if (sizeof($array) > 0 && sizeof($consltor) > 0 && !empty($bookId) && !empty($consultorId)) {
                        $codexpres = uniqid();
                        $consultor = json_encode($consltor);
                        $libro = json_encode($array);
                        $idsLib = json_encode($bookId);

                        if ($db->setInsert("prestamos", "codepres, tipo_prestamo, coleccion_id, coleccion, consultor_id, consultor, status, fecha_prestamo, fecha_devolucion, estatus", "'$codexpres', 'LIB', '$idsLib', '$libro', '$consultorId', '$consultor', 2, NOW(), '$devolucion', 'EN PROCESO' ")) {
                            foreach (json_decode($libro) as $row) {
                                if ($db->setUpdate("libros", "lib_pro=2", "lib_id='$row->id'")) {
                                }
                            }
                            //if ($db->setUpdate("libros", "lib_pro=2", "lib_id='$id'"))
                            $validator['success'] = true;
                            $validator['messages'] = ' Éxito en la Operación.';
                            //$validator['messages'] = '=> ' . $codexpres . ' ' . json_encode($bookId) . '--' . json_encode($array) . '--' . $consultorId . json_encode($consltor) . ' ' . $DateAndTime = date('m-d-Y h:i:s a', time());
                        } else {
                            $validator['success'] = false;
                            $validator['messages'] = ' No se pudo ejecutar la operación.';
                        }
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Algumos datos requeridos no estan completos.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = 'El consultor tiene un proceso activo.';
                }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' Algumos datos requeridos no estan completos.';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Algumos datos requeridos no estan completos.';
            }


            print_r(json_encode($validator));
            /**-----------------------------------------INSERT--------------------------------- */
            break;

        case 'DeleteListPrestamo':
            /**-----------------------------------------INSERT--------------------------------- */
            $token = trim($_POST['txt_codex']);
            if (!empty($token)) {
                $id = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("libros", "*", "lib_id='$id'");
                if ($db->setNumRows($consulta) > 0) {
                    if ($db->setUpdate("libros", "lib_pro=0", "lib_id='$id'")) {
                        $validator['success'] = true;
                        $validator['messages'] = ' Éxito en la Operación.';
                    } else {
                        $validator['success'] = false;
                        $validator['messages'] = ' Ocurrio un error.';
                    }
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' La Operación ya se ejecuto. <b>'  . '</b>';
                }
            } else {
                $validator['success'] = false;
                $validator['messages'] = ' Algumos datos requeridos no estan completos.';
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
            } else if (!empty($_POST['status_codex'])) {
                $status_codex = $_POST['status_codex'];
                $consulta = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_pro = '$status_codex' ORDER BY lib_tit ASC");
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
                        '_presx' => base64_encode($row->lib_pro),
                        '_links' => basename($filename),
                    );
                }
            }
            print_r(json_encode($json));
            /**-----------------------------------------JSON----------------------------------- */
            break;
        case 'ListConsultorMatricula':
            # code...

            $consulta = $db->setSelect("consultor", "*", "con_sta=1 ORDER BY con_mat DESC");

            $json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {

                    $json['data'][] = array(
                        '_aresx' => base64_encode($row->con_id),
                        '_bresx' => base64_encode($row->con_mat),
                        '_cresx' => base64_encode(utf8_decode($row->con_nom)),
                        '_dresx' => base64_encode(utf8_decode($row->con_ape)),
                        '_eresx' => base64_encode(($row->con_ema)),
                    );
                }
            }
            print_r(json_encode($json));
            break;
        case 'ListHtml':
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
            //$json = array();
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
                    $filename = $PNG_TEMP_DIR . 'test' . md5($row->lib_cod . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

                    QRcode::png($row->lib_cod, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

                    echo '<tr class="search-items">';

                    echo '<td>
                            <div class="d-flex align-items-center">
                                <span class="round rounded-circle text-white d-inline-block text-center bg-info">EA</span>
                                <div class="ms-3">
                                    <div class="user-meta-info">
                                        <h6 class="user-name mb-0 font-weight-medium" data-name="Emma Adams">
                                            ' . (utf8_decode($row->lib_tit)) . '
                                        </h6>
                                        <small class="user-work text-muted" data-occupation="Web Developer">Web Developer</small>
                                    </div>
                                </div>
                            </div>
                        </td>';
                    echo '<td>
                            <span class="usr-email-addr" data-email="adams@mail.com">adams@mail.com</span>
                        </td>';

                    echo '<td>

                            <div class="action-btn">
                            ';
                    $found = false;

                    if (isset($_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $c) {
                            if ($c["product_id"] == $row->lib_id) {
                                $found = true;
                                break;
                            }
                        }
                    }

                    if ($found) {
                        echo '<a href="javascript:void(0)" class="text-dark delete ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 feather-sm fill-white"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </a>';
                    } else {
                        /*echo '<form id="addItem" class="form-inline" method="post">
                                <input type="hidden" name="product_id" value="' . $row->lib_id . '">
                                <div class="form-group">
                                    <input type="number" name="q" value="1" style="width:100px;" min="1" class="form-control" placeholder="Cantidad">
                                </div>
                                <button type="button" onclick="prestamo('.$row->lib_id.')" class="btn btn-info rounded-pill px-4 waves-effect waves-light">
                                Agregar al carrito</button>
                                </form>';

                        echo '---->' . $found;*/
                        echo '<a href="javascript:void(0)" class="text-info edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" onclick="prestamo(' . $row->lib_id . ')" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye feather-sm fill-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                                <a href="javascript:void(0)" class="text-dark delete ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 feather-sm fill-white"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </div>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            }

            break;
        case 'addProceso':
            if (!empty($_POST['txt_process']) && !empty($_POST['txt_codex'])) {
                $process = $_POST['txt_process'];
                $id = base64_decode($_POST['txt_codex']);
                if ($db->setUpdate("libros", "lib_pro='$process'", "lib_id='$id'")) {
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
            break;

        case 'ListAutorization':
            $consulta = $db->setSelect("prestamos", "*", "estatus = 'EN PROCESO' ORDER BY create_at DESC");

            $json = array();
            $book = null;
            $student = null;
            if ($db->setNumRows($consulta) > 0) {
                foreach ($db->setFetchArray($consulta) as $row) {
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
                    );
                }
            } else {
                $json['data'][] = array();
            }
            print_r(json_encode($json));
            break;

        case 'DataBooks':
            $list = array();
            if (isset($_POST['txt_codex'])) {
                $id = base64_decode($_POST['txt_codex']);

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
                                    'id' => $i->lib_id,
                                    'folio' => $i->lib_cod,
                                    'titulo' => base64_encode(utf8_decode($i->lib_tit)),
                                    'autor' => base64_encode(utf8_decode($i->lib_aut)),
                                );
                            }
                        }
                    }
                }
            }
            print_r(json_encode($book));
            break;

        case 'AprobatePrestamo':
            if (isset($_POST['txt_codex'])) {
                $prestamoId = base64_decode($_POST['txt_codex']);

                if (!empty($prestamoId)) {
                    if ($db->setUpdate("prestamos", "estatus='PRESTADO'", "prestamo_id='$prestamoId'")) {
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
            break;
        case 'CancelPrestamoBook':
            if (isset($_POST['txt_codex'])) {
                $id = base64_decode($_POST['txt_codex']);
                $consulta = $db->setSelect("prestamos", "*", "prestamo_id = '$id' ORDER BY create_at DESC");
                $list = array();
                if ($db->setNumRows($consulta) > 0) {
                    foreach ($db->setFetchArray($consulta) as $row) {
                        $list = array($row->coleccion_id);
                    }
                }

                if ($db->setUpdate("prestamos", "status = 0, fecha_real = NOW(), estatus = 'CANCELADO'", "prestamo_id='$id'")) {
                    foreach ((($list)) as $key => $value) {
                        $id = 0;
                        foreach (json_decode($value) as $x => $y) {
                            $id = intval($y->bookId);
                            if ($db->setUpdate("libros", "lib_pro = 0", "lib_id = '$id'")) {
                            }
                        }
                    }
                    $validator['success'] = true;
                    $validator['messages'] = ' Éxito en la Operación.';
                } else {
                    $validator['success'] = false;
                    $validator['messages'] = ' No se pudo ejecutar la operación.';
                }
            }
            print_r(json_encode($validator));
            break;
        default:
    }
} else {
    header("Location: ../index.php");
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
