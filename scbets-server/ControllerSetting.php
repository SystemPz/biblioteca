<?php
require_once './ControllerModel.php/ControllerModel.php';
$db = new DataBase();
if (!empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
    $validator = array('success' => false, 'messages' => array());
    $option = 'TotalEjemplares';
    switch (base64_decode($_POST['scbets_action'])) {
        case 'TotalEjemplares':
            $eciclopedia = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = 'ENC' AND var_sta != 0 ORDER BY var_tit ASC");
            $totalEciclopedia = $db->setNumRows($eciclopedia) > 0 ? $db->setNumRows($eciclopedia) : 0;
            $engargolado = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = 'ENG' AND var_sta != 0 ORDER BY var_tit ASC");
            $totalEngargolados = $db->setNumRows($engargolado) > 0 ? $db->setNumRows($engargolado) : 0;
            $revista = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = 'REV' AND var_sta != 0 ORDER BY var_tit ASC");
            $totalRevistas = $db->setNumRows($revista) > 0 ? $db->setNumRows($revista) : 0;
            $otros = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = 'OTR' AND var_sta != 0 ORDER BY var_tit ASC");
            $totalOtros = $db->setNumRows($otros) > 0 ? $db->setNumRows($otros) : 0;
            $documentos = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_sta != 0 ORDER BY doc_tit ASC");
            $totalDocumentos = $db->setNumRows($documentos) > 0 ? $db->setNumRows($documentos) : 0;
            $libros = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_sta != 0 ORDER BY lib_tit ASC");
            $totalLibros = $db->setNumRows($libros) > 0 ? $db->setNumRows($libros) : 0;

            $arra = array('totalEnciclopedias' => $totalEciclopedia, 'totalEngargolados' => $totalEngargolados, 'totalRevistas' => $totalRevistas, 'totalOtros' => $totalOtros, 'totalDocumentos' => $totalDocumentos, 'totalLibros' => $totalLibros);
            print_r(json_encode($arra));
            break;
        case 'TotalUsers':
            $usuariosA = $db->setSelect("usuarios", "*", "user_sta = 1 ORDER BY user_nom ASC");
            $totalA = $db->setNumRows($usuariosA) > 0 ? $db->setNumRows($usuariosA) : 0;

            $usuariosS = $db->setSelect("usuarios", "*", "user_sta = 2 ORDER BY user_nom ASC");
            $totalS = $db->setNumRows($usuariosS) > 0 ? $db->setNumRows($usuariosS) : 0;

            $usuariosB = $db->setSelect("usuarios", "*", "user_sta = 3 ORDER BY user_nom ASC");
            $totalB = $db->setNumRows($usuariosB) > 0 ? $db->setNumRows($usuariosB) : 0;

            $sum = $totalA + $totalS + $totalB;

            $arra = array('totalA' => (($totalA * 100) / $sum), 'totalS' => (($totalS * 100) / $sum), 'totalB' => (($totalB * 100) / $sum));
            print_r(json_encode($arra));
            break;
        case 'TotalConsults':
            $consultA = $db->setSelect("consultor", "*", "con_sta = 1 ORDER BY con_nom ASC");
            $totalA = $db->setNumRows($consultA) > 0 ? $db->setNumRows($consultA) : 0;

            $consultS = $db->setSelect("consultor", "*", "con_sta = 2 ORDER BY con_nom ASC");
            $totalS = $db->setNumRows($consultS) > 0 ? $db->setNumRows($consultS) : 0;

            $consultB = $db->setSelect("consultor", "*", "con_sta = 3 ORDER BY con_nom ASC");
            $totalB = $db->setNumRows($consultB) > 0 ? $db->setNumRows($consultB) : 0;

            $sum = $totalA + $totalS + $totalB;

            $arra = array('totalA' => (($totalA * 100) / $sum), 'totalS' => (($totalS * 100) / $sum), 'totalB' => (($totalB * 100) / $sum));
            print_r(json_encode($arra));
            break;
        case 'PrecessReadStudents':
            $anio = date("Y");
            $array = array('Ene' => '01', 'Feb' => '02', 'Mar' => '03', 'Abr' => '04', 'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Ago' => '08', 'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dic' => '12',);
            $lista = array();
            foreach ($array as $key => $value) {
                $consulta = $db->setSelect("prestamos", "COUNT(*) as total", "YEAR(create_at) ='$anio' AND MONTH(create_at) = '$value'");
                if ($db->setNumRows($consulta) > 0) {
                    foreach ($db->setFetchArray($consulta) as $i) {
                        $lista['data'][] = ($i->total);
                    }
                }
            }
            print_r(json_encode($lista));
            break;
        case 'TotalEjemplarStatus':
            $array = [];

            $libros = $db->setSelect("libros", "COUNT(*) AS Total, lib_sta", "lib_sta GROUP BY lib_sta");
            if ($db->setNumRows($libros) > 0) {
                $active = 0;
                $suspend = 0;
                $baja = 0;
                foreach ($db->setFetchArray($libros) as $i) {
                    if ($i->lib_sta == 1) $active = $i->Total;
                    if ($i->lib_sta == 2) $suspend = $i->Total;
                    if ($i->lib_sta == 3) $baja = $i->Total;
                }
                $array[] = $listStatus = array('type' => 'LIB', 'Ejemplar' => "Libros", 'Activos' => $active, 'Suspendidos' => $suspend, 'Bajas' => $baja);
            }
            $documentos = $db->setSelect("doc_recepcional", "COUNT(*) AS Total, doc_sta", "doc_sta GROUP BY doc_sta");
            if ($db->setNumRows($documentos) > 0) {
                $active = 0;
                $suspend = 0;
                $baja = 0;
                foreach ($db->setFetchArray($documentos) as $i) {
                    if ($i->doc_sta == 1) $active = $i->Total;
                    if ($i->doc_sta == 2) $suspend = $i->Total;
                    if ($i->doc_sta == 3) $baja = $i->Total;
                }
                $array[] = $listStatus = array('type' => 'DOC', 'Ejemplar' => "Documentos recepcionales", 'Activos' => $active, 'Suspendidos' => $suspend, 'Bajas' => $baja);
            }
            $enciclopedia = $db->setSelect("variaciones", "COUNT(*) AS Total, var_sta", "var_mat = 'ENC' GROUP BY var_sta");
            if ($db->setNumRows($enciclopedia) > 0) {
                $active = 0;
                $suspend = 0;
                $baja = 0;
                foreach ($db->setFetchArray($enciclopedia) as $i) {
                    if ($i->var_sta == 1) $active = $i->Total;
                    if ($i->var_sta == 2) $suspend = $i->Total;
                    if ($i->var_sta == 3) $baja = $i->Total;
                }
                $array[] = $listStatus = array('type' => 'ENC', 'Ejemplar' => "Enciclopedias", 'Activos' => $active, 'Suspendidos' => $suspend, 'Bajas' => $baja);
            }
            $engargolado = $db->setSelect("variaciones", "COUNT(*) AS Total, var_sta", "var_mat = 'ENG' GROUP BY var_sta");
            if ($db->setNumRows($enciclopedia) > 0) {
                $active = 0;
                $suspend = 0;
                $baja = 0;
                foreach ($db->setFetchArray($engargolado) as $i) {
                    if ($i->var_sta == 1) $active = $i->Total;
                    if ($i->var_sta == 2) $suspend = $i->Total;
                    if ($i->var_sta == 3) $baja = $i->Total;
                }
                $array[] = $listStatus = array('type' => 'ENG', 'Ejemplar' => "Engargolados", 'Activos' => $active, 'Suspendidos' => $suspend, 'Bajas' => $baja);
            }
            $engargolado = $db->setSelect("variaciones", "COUNT(*) AS Total, var_sta", "var_mat = 'REV' GROUP BY var_sta");
            if ($db->setNumRows($enciclopedia) > 0) {
                $active = 0;
                $suspend = 0;
                $baja = 0;
                foreach ($db->setFetchArray($engargolado) as $i) {
                    if ($i->var_sta == 1) $active = $i->Total;
                    if ($i->var_sta == 2) $suspend = $i->Total;
                    if ($i->var_sta == 3) $baja = $i->Total;
                }
                $array[] = $listStatus = array('type' => 'REV', 'Ejemplar' => "Revistas", 'Activos' => $active, 'Suspendidos' => $suspend, 'Bajas' => $baja);
            }
            $engargolado = $db->setSelect("variaciones", "COUNT(*) AS Total, var_sta", "var_mat = 'OTR' GROUP BY var_sta");
            if ($db->setNumRows($enciclopedia) > 0) {
                $active = 0;
                $suspend = 0;
                $baja = 0;
                foreach ($db->setFetchArray($engargolado) as $i) {
                    if ($i->var_sta == 1) $active = $i->Total;
                    if ($i->var_sta == 2) $suspend = $i->Total;
                    if ($i->var_sta == 3) $baja = $i->Total;
                }
                $array[] = $listStatus = array('type' => 'OTR', 'Ejemplar' => "Otros", 'Activos' => $active, 'Suspendidos' => $suspend, 'Bajas' => $baja);
            }
            print_r(json_encode($array));
            break;
        case 'CategoriaTotalBook':

            if ($_POST['txt_report'] == 6) {
                $libros = $db->setSelect("libros, categoria", "libros.lib_cat, categoria.cat_tip, COUNT(*) AS Total", "libros.lib_cat=categoria.cat_id GROUP BY libros.lib_cat");
            } else if ($_POST['txt_report'] == 5) {
                $libros = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_sta = 3 ORDER BY lib_tit ASC");
            } else if ($_POST['txt_report'] == 4) {
                $libros = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_sta = 2 ORDER BY lib_tit ASC");
            } else if ($_POST['txt_report'] == 3) {
                $libros = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_sta = 1 ORDER BY lib_tit ASC");
            } else if ($_POST['txt_report'] == 2) {
                $libros = $db->setSelect("libros", "lib_sta, COUNT(*) AS Total", "lib_sta GROUP BY lib_sta");
            } else if ($_POST['txt_report'] == 1) {
                $libros = $db->setSelect("libros INNER JOIN categoria ON libros.lib_cat=categoria.cat_id INNER JOIN ubicacion ON libros.lib_ubi=ubicacion.ubi_id", "*", "lib_sta != 0 ORDER BY lib_tit ASC");
            }

            $lista = array();
            $isValid = ($_POST['txt_report']) == 6 || ($_POST['txt_report']) == 2 ? false : true;
            if ($isValid) {

                if ($db->setNumRows($libros) > 0) {
                    foreach ($db->setFetchArray($libros) as $row) {

                        $lista[] = array(
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
                        );
                    }
                }
            }

            if (($_POST['txt_report']) == 6) {
                if ($db->setNumRows($libros) > 0) {
                    foreach ($db->setFetchArray($libros) as $i) {
                        $lista[] = array('categoria' => $i->cat_tip, 'total' => $i->Total);
                    }
                }
            }

            if (($_POST['txt_report']) == 2) {
                if ($db->setNumRows($libros) > 0) {
                    foreach ($db->setFetchArray($libros) as $i) {
                        $lista[] = array('status' => $i->lib_sta, 'total' => $i->Total);
                    }
                }
            }

            print_r(json_encode($lista));
            break;

        case 'CategoriaTotalDocument':

            if ($_POST['txt_report'] == 6) {
                $consult = $db->setSelect("doc_recepcional, categoria", "doc_recepcional.doc_mod, categoria.cat_tip, COUNT(*) AS Total", "doc_recepcional.doc_mod=categoria.cat_id GROUP BY doc_recepcional.doc_mod");
            } else if ($_POST['txt_report'] == 5) {
                $consult = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_sta = 3 ORDER BY doc_tit ASC");
            } else if ($_POST['txt_report'] == 4) {
                $consult = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_sta = 2 ORDER BY doc_tit ASC");
            } else if ($_POST['txt_report'] == 3) {
                $consult = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_sta = 1 ORDER BY doc_tit ASC");
            } else if ($_POST['txt_report'] == 2) {
                $consult = $db->setSelect("doc_recepcional", "doc_sta, COUNT(*) AS Total", "doc_sta GROUP BY doc_sta ");
            } else if ($_POST['txt_report'] == 1) {
                $consult = $db->setSelect("doc_recepcional INNER JOIN categoria ON doc_recepcional.doc_mod=categoria.cat_id INNER JOIN ubicacion ON doc_recepcional.doc_ubi=ubicacion.ubi_id", "*", "doc_sta != 0 ORDER BY doc_tit ASC");
            }

            $lista = array();
            $isValid = ($_POST['txt_report']) == 6 || ($_POST['txt_report']) == 2 ? false : true;
            if ($isValid) {

                if ($db->setNumRows($consult) > 0) {
                    foreach ($db->setFetchArray($consult) as $row) {

                        $lista[] = array(
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
            }

            if (($_POST['txt_report']) == 6) {
                if ($db->setNumRows($consult) > 0) {
                    foreach ($db->setFetchArray($consult) as $i) {
                        $lista[] = array('categoria' => $i->cat_tip, 'total' => $i->Total);
                    }
                }
            }

            if (($_POST['txt_report']) == 2) {
                if ($db->setNumRows($consult) > 0) {
                    foreach ($db->setFetchArray($consult) as $i) {
                        $lista[] = array('status' => $i->doc_sta, 'total' => $i->Total);
                    }
                }
            }

            print_r(json_encode($lista));
            break;
            case 'CategoriaTotalEngargolados':
                $type = $_POST['txt_clas'];
                if ($_POST['txt_report'] == 6 && !empty($type)) {
                    $consult = $db->setSelect("variaciones, categoria", "variaciones.var_typ, categoria.cat_tip, COUNT(*) AS Total", "var_mat = '$type' AND variaciones.var_typ=categoria.cat_id GROUP BY variaciones.var_typ ASC");
                } else if ($_POST['txt_report'] == 5 && !empty($type)) {
                    $consult = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = '$type' AND var_sta = 3 ORDER BY var_tit ASC");
                } else if ($_POST['txt_report'] == 4 && !empty($type)) {
                    $consult = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = '$type' AND var_sta = 2 ORDER BY var_tit ASC");
                } else if ($_POST['txt_report'] == 3 && !empty($type)) {
                    $consult = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = '$type' AND var_sta = 1 ORDER BY var_tit ASC");
                } else if ($_POST['txt_report'] == 2 && !empty($type)) {
                    $consult = $db->setSelect("variaciones", "var_sta, COUNT(*) AS Total", "var_mat = '$type' GROUP BY var_sta ");
                } else if ($_POST['txt_report'] == 1) {
                    $consult = $db->setSelect("variaciones INNER JOIN categoria ON variaciones.var_typ=categoria.cat_id INNER JOIN ubicacion ON variaciones.var_ubi=ubicacion.ubi_id", "*", "var_mat = '$type' AND var_sta <> 0 ORDER BY var_tit ASC");
                }
    
                $lista = array();
                $isValid = ($_POST['txt_report']) == 6 || ($_POST['txt_report']) == 2 ? false : true;
                if ($isValid) {
    
                    if ($db->setNumRows($consult) > 0) {
                        foreach ($db->setFetchArray($consult) as $row) {
    
                            $lista[] = array(
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
                }
    
                if (($_POST['txt_report']) == 6) {
                    if ($db->setNumRows($consult) > 0) {
                        foreach ($db->setFetchArray($consult) as $i) {
                            $lista[] = array('categoria' => $i->cat_tip, 'total' => $i->Total);
                        }
                    }
                }
    
                if (($_POST['txt_report']) == 2) {
                    if ($db->setNumRows($consult) > 0) {
                        foreach ($db->setFetchArray($consult) as $i) {
                            $lista[] = array('status' => $i->var_sta, 'total' => $i->Total);
                        }
                    }
                }
    
                print_r(json_encode($lista));
                break;
        default:
    }
} else {
    header("Location: ../index.php");
}
