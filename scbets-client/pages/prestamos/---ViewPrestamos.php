<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Prestamos</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="?scbets-inicio=">Home</a>
            </li>
            <li class="breadcrumb-item active">Crear Prestamos</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">

    </div>
</div>

<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJQcmVzdGFtb3MucGhw",
        "loadingmessage": "Sending user info, please wait...",
        "ajaxint": "SW5zZXJ0",
        "ajaxupd": "VXBkYXRl",
        "ajaxjsn": "SnNvbg==",
        "ajaxfol": "Rm9saW8=",
        "ajaxSta": "U3RhdHVz",
        "ajaxQr": "UXI=",
        "ajaxSign": "c2Vzc2lvbl9pbnB1dA==",
        "ajaxList": "TGlzdEh0bWw=",
        "ajaxAdd": "YWRkSXRlbQ==",
        "ajaxProces": "YWRkUHJvY2Vzbw==",
        "ajaxAuth": "TGlzdEF1dG9yaXphdGlvbg==",
        "ajaxDownload": "RG93bmxvYWREZXRhaWxCb29r",
        "routeDownload": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJSZXBvcnREb3dubG9hZC5waHA=",
        "ajaxCancel": "Q2FuY2VsUHJlc3RhbW9Cb29r",
    };
    let arrays = [];

    function listBook(item) {
        $("#content-list").html("");
        $.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: ajax_auth_object.ajaxjsn
                },
            })
            .done(function(e) {
                console.log("success => " + e);
                $.each((e.data), function(indexInArray, valueOfElement) {
                    let isPrestamos = "" + atob(valueOfElement._presx) + '-' + atob(valueOfElement._oresx) + '-' + atob(valueOfElement._iresx);
                    let isDisponible = atob(valueOfElement._presx) == 0 ? '<i class="fa fa-circle text-success"></i> Disponible' : atob(valueOfElement._presx) == 1 ? '<i class="fa fa-circle text-dark"></i> Proceso' : '<i class="fa fa-circle text-warning"></i> Prestado';

                    if (atob(valueOfElement._presx) == 0 && atob(valueOfElement._oresx) == 1 && atob(valueOfElement._iresx) == 1) {
                        isPrestamos = '<a href="javascript:void(0)" class="badge font-weight-medium bg-light-success text-success me-2" data-a="' + (valueOfElement._aresx) + '" data-b="' + atob(valueOfElement._dresx) + '" data-c="' + atob(valueOfElement._eresx) + '" data-d="' + atob(valueOfElement._fresx) + '" data-e="' + atob(valueOfElement._gresx) + '" data-f="' + atob(valueOfElement._dresx) + '" data-g="' + atob(valueOfElement._dresx) + '" data-link="' + (valueOfElement._links) + '"  data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="ti-control-shuffle"></i> Expedir</a>';
                    } else if (atob(valueOfElement._presx) == 2 && atob(valueOfElement._oresx) == 1 && atob(valueOfElement._iresx) == 1) {
                        isPrestamos = '<span class="badge font-weight-medium bg-light-warning text-warnning me-2"><span class="ti-shift-right"></span> Prestado</span>';
                    } else if (atob(valueOfElement._presx) == 0 && atob(valueOfElement._oresx) == 2 && atob(valueOfElement._iresx) == 1) {
                        isPrestamos = '<span class="badge font-weight-medium bg-light-warning text-warning me-2"><span class=" fas fa-ban"></span> Reserva</span>';
                    } else if (atob(valueOfElement._presx) == 0 && atob(valueOfElement._oresx) == 1 && atob(valueOfElement._iresx) != 1) {
                        isPrestamos = '<span class="badge font-weight-medium bg-light-warning text-warning me-2"><span class=" fas fa-ban"></span> Reserva</span>';
                    } else if (atob(valueOfElement._presx) == 1 && atob(valueOfElement._oresx) == 1 && atob(valueOfElement._iresx) == 1) {
                        isPrestamos = '<span class="badge font-weight-medium bg-light-primary text-dark me-2"><span class=" fas fa-ban"></span> Proceso</span>';
                    } else if (atob(valueOfElement._presx) == 2 && atob(valueOfElement._oresx) == 2 && atob(valueOfElement._iresx) == 1) {
                        isPrestamos = '<span class="badge font-weight-medium bg-light-danger text-danger me-2"><span class=" fas fa-ban"></span> Reserva</span>';
                    }else if (atob(valueOfElement._presx) == 0 && atob(valueOfElement._oresx) == 3 && atob(valueOfElement._iresx) == 1) {
                        isPrestamos = '<span class="badge font-weight-medium bg-light-danger text-danger me-2"><span class=" fas fa-ban"></span> Baja</span>';
                        isDisponible = '<i class="fa fa-circle text-danger"></i> No Disponible';
                    }

                    $("#content-list").append('<div class="col-lg-6">' +
                        '<div class="card">' +
                        '<div class="card-body">' +
                        '<div class="d-flex flex-row comment-row mt-0">' +
                        '<div class="p-2">' +
                        '<img src="./scbets-server/temp/' + valueOfElement._links + '" alt="user" width="50" class="">' +
                        '</div>' +
                        '<div class="comment-text w-100">' +
                        '<h6 class="font-medium">' + atob(valueOfElement._dresx) + '</h6>' +
                        '<span class="mb-0 d-block">' + atob(valueOfElement._eresx) + '</span>' +
                        '<div class="mb-2 d-block text-muted">' + atob(valueOfElement._fresx) + ', ' + atob(valueOfElement._gresx) +
                        '</div>' +
                        '<div class="mb-2 d-block text-muted">' + atob(valueOfElement._cresx) + '</div>' +
                        '<div class="comment-footer">' +
                        '<span class="text-muted float-left"></span>' +
                        '<span class="label label-rounded label-primary">' + isDisponible + '</span>' +
                        '<span class="action-icons p-2">' + isPrestamos +
                        /*(atob(valueOfElement._presx) == 0 ?
                                                   '<a href="javascript:void(0)" data-a="' + (valueOfElement._aresx) +
                                                   '" data-b="' + atob(valueOfElement._dresx) +
                                                   '" data-c="' + atob(valueOfElement._eresx) +
                                                   '" data-d="' + atob(valueOfElement._fresx) +
                                                   '" data-e="' + atob(valueOfElement._gresx) +
                                                   '" data-f="' + atob(valueOfElement._dresx) +
                                                   '" data-g="' + atob(valueOfElement._dresx) +
                                                   '" data-link="' + (valueOfElement._links) + '"  data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="ti-control-shuffle"></i></a>' +
                                                   '<span> | </span>' : '') +*/
                        '<a href="javascript:void(0)" class="badge font-weight-medium bg-light-info text-info" data-a="' + atob(valueOfElement._cresx) +
                        '" data-b="' + atob(valueOfElement._dresx) +
                        '" data-c="' + atob(valueOfElement._eresx) +
                        '" data-d="' + atob(valueOfElement._fresx) +
                        '" data-e="' + atob(valueOfElement._gresx) +
                        '" data-f="' + atob(valueOfElement._dresx) +
                        '" data-g="' + atob(valueOfElement._dresx) +
                        '" data-codex="' + (valueOfElement._aresx) +
                        '" data-link="' + (valueOfElement._links) + '" data-bs-toggle="modal" data-bs-target="#book-modal"><i class=" ti-eye"></i> Información</a>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                });
            })
            .fail(function(e) {
                console.log("error => " + e);
            })
            .always(function(e) {
                console.log("complete =>" + e);
            });

    }

    function listBookSelect() {
        $(".listSelect").html("");
        $.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: ajax_auth_object.ajaxjsn,
                    status_codex: 1,
                },
            })
            .done(function(e) {
                console.log("success" + e);
                if (e.data != []) {
                    $.each(e.data, function(indexInArray, valueOfElement) {
                        $(".listSelect").append(' <tr class=item' + atob(valueOfElement._aresx) + '>' +
                            '<td><img src="./scbets-server/temp/' + valueOfElement._links + '" width="30" alt=""></td>' +
                            '<td><input type="text" name="folio[' + indexInArray + ']"  class="form-control" value=' + atob(valueOfElement._cresx) + ' disabled>' +
                            '<input type="hidden" id="folio" name="folio[]"  class="form-control" value=' + atob(valueOfElement._aresx) + '>' + '</td>' +
                            '<td>' + atob(valueOfElement._dresx) + '</td>' +
                            '<td><a href="#" onClick=deleteBookSelect(' + atob(valueOfElement._aresx) + ')><i class=" ti-close text-danger"></i></a></td>' +
                            '</tr>');
                    });
                } else {
                    $(".listSelect").html('<tr><td colspan="4" aling="center">Sin registro</td></tr>');
                }
            })
            .fail(function(e) {
                console.log("error" + e);
            })
            .always(function(e) {
                console.log("complete" + e);
            });
    }

    $(document).ready(function() {

        listBook(1);

        $("#input-search").on("keyup", function() {
            var rex = new RegExp($(this).val(), "i");
            $(".col-lg-6").hide();
            $(".col-lg-6").filter(function() {
                const acentos = {
                    'á': 'a',
                    'é': 'e',
                    'í': 'i',
                    'ó': 'o',
                    'ú': 'u',
                    'Á': 'A',
                    'É': 'E',
                    'Í': 'I',
                    'Ó': 'O',
                    'Ú': 'U'
                };
                return rex.test($(this).text().split('').map(letra => acentos[letra] || letra).join('').toString());
            }).show();
        });

        $("#book-modal").on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this)
            modal.find('.modal-body .txtFolio').html(button.data('a'));
            modal.find('.modal-body .txtTitulo').html(button.data('b'));
            modal.find('.modal-body .txtAutor').html(button.data('c'));
            modal.find('.modal-body .txtEdicion').html(button.data('d') + ', ' + button.data('e'));
            modal.find('.modal-body .txtIMG').html('<img src="./scbets-server/temp/' + button.data('link') + '" width="70" alt="">');
            modal.find('.modal-body .txt_btn').html('<a href="#" type="button" class="btn waves-light btn-rounded btn-xs btn-danger" onclick=onClickDownloadDetail(' + atob(button.data('codex')) + ',' + JSON.stringify({
                folio: button.data('a')
            }) + ')><i class="far fa-file-pdf"></i> Descarga</a>');

        });

        $('#btn-print').on('click', function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };

            $("div#print-data").printArea(options);
        });

        const listBookTable = function rowBook() {
            $.post(atob(ajax_auth_object.routeLink), {
                    scbets_action: ajax_auth_object.ajaxList
                },
                function(data, textStatus, jqXHR) {
                    //console.log(data)
                    //$("#listHtml").html(data);
                },
                "html"
            );
        }
        listBookTable();



        $("#staticBackdrop").on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this)
            console.log(button.data('a'))

            processUpdate(button.data('a'));
            /*modal.find('.modal-body .txtFolio').html(button.data('a'));
            modal.find('.modal-body .txtTitulo').html(button.data('b'));
            modal.find('.modal-body .txtAutor').html(button.data('c'));
            modal.find('.modal-body .txtEdicion').html(button.data('d') + ', ' + button.data('e'));
            modal.find('.modal-body .txtIMG').html('<img src="./scbets-server/temp/' + button.data('link') + '" width="70" alt="">');*/
            //modal.find('.modal-body .listSelect').append(button.data('a') + '--');
        });
        listBookSelect();

        let processUpdate = function updateBook(e) {
            console.log(e)
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'post',
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxProces + '&&txt_process=1&&txt_codex=' + e,
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + (xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('uccess: ' + (data));
                    if (data.success) {
                        setNotify('success', data.messages, 'right');
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }
                    listBook(2);
                    listBookSelect();
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + (xhr));
                }
            });

        }

        $("#addPrestamo").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'post',
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxint + '&&' + $(this).serialize(),
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('success: ' + JSON.stringify(data));
                    if (data.success) {
                        setNotify('success', data.messages, 'right');
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }
                    listBook(4);
                    listBookSelect();
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });
        });

        let listConsultores = function listConsult() {
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'post',
                dataType: 'json',
                data: 'scbets_action=' + btoa('ListConsultorMatricula') + '&&' + $(this).serialize(),
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + (xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('success: ' + (data));
                    if (data.data != []) {
                        //setNotify('success', data.messages, 'right');
                        let $consultor = $('.txt_consultor');
                        $consultor.html('<option></option>');
                        $.each((data.data), function(indexInArray, valueOfElement) {
                            //console.log('=>> '+atob(valueOfElement._aresx));
                            $consultor.append('<option value=' + atob(valueOfElement._bresx) + '-' + atob(valueOfElement._cresx) + ' ' + atob(valueOfElement._dresx) + '>' + atob(valueOfElement._bresx) + '-' + atob(valueOfElement._cresx) + ' ' + atob(valueOfElement._dresx) + '</option>');
                        });
                    } else {
                        //setNotify('warning', data.messages, 'right');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + (xhr));
                }
            });
        }
        listConsultores();

    });

    function deleteBookSelect(e) {
        console.log(e);
        //$("#item" + e).remove();
        $("#content-list").html("");
        jQuery.ajax({
            url: atob(ajax_auth_object.routeLink),
            type: 'post',
            dataType: 'json',
            data: 'scbets_action=' + btoa('DeleteListPrestamo') + '&&txt_codex=' + btoa(e),
            complete: function(xhr, textStatus) {
                //called when complete
                console.log('complete: ' + (xhr));
            },
            success: function(data, textStatus, xhr) {
                //called when successful
                console.log('uccess: ' + (data));

                if (data.success) {
                    setNotify('success', data.messages, 'right');
                    $(".item" + e).remove();
                } else {
                    setNotify('warning', data.messages, 'right');
                }

                listBook(3);
                listBookSelect();
            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                console.log('error: ' + (xhr));
            }
        });

    }



    function onClickDownloadDetail(a, b) {
        let fileName = b.folio;
        /*$.ajax({
                type: "POST",
                url: atob(ajax_auth_object.routeDownload),
                //dataType: 'blob',
                data: {
                    "scbets_action": ajax_auth_object.ajaxDownload,
                    txt_codex: btoa(a)
                },

            })
            .done(function(e) {
                console.log("success" +(e));
            })
            .fail(function(e) {
                console.log("error" + e);
            })
            .always(function(e) {
                console.log("complete" + e);
            });*/
        $.ajax({
            type: 'POST',
            url: atob(ajax_auth_object.routeDownload),
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                "scbets_action": ajax_auth_object.ajaxDownload,
                txt_codex: btoa(a)
            },
            success: function(json) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(json);
                a.href = url;
                a.download = fileName + '_' + getDateHoy() + '.pdf';
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function() {
                console.log("Error");
            }
        });
    }
</script>


<div class="container-fluid">
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-2">
                    <form>
                        <input type="text" class="form-control product-search" id="input-search" placeholder="Buscar ejemplares..." />
                    </form>
                </div>
                <div class="col-md-8 col-xl-10 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <div class="action-btn show-btn">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bookListSelect" class="btn-light-danger btn me-2 text-danger d-flex align-items-center font-weight-medium">
                            <i class="ti-control-forward"></i>
                            Datos en proceso
                        </a>
                    </div>
                    <div class="action-btn show-btn">
                        <a href="javascript:void(0)" id="autorization" data-bs-toggle="modal" data-bs-target="#bookListAutorization" class="btn-light-info btn me-2 text-info d-flex align-items-center font-weight-medium">
                            <i class="ti-control-forward"></i>
                            Autorización
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center bg-light p-0" id="content-list"> </div>

    </div>




    <div class="row encabezado">
        <div class="col-lg-12" style="display: none;">
            <div class="d-flex no-block align-items-center p-3 bg-white text-muted mb-2">
                <div class="me-2">
                    <img src="./assets/images/logo.svg" alt="user" class="" width="60" />
                </div>
                <div class="ms-2 ml-5">
                    <h4 class="mb-0 text-muted">Biblioteca de la escuela de trabajo social de zacatecaz.</h4>
                    <p class="mb-0"></p>
                </div>
            </div>
        </div>

        <div class="col-lg-12" style="display: none;">
            <div class="card">
                <div class="card-body">

                    <table class="table font-10" border="0" style="width: 100%;">
                        <tr>
                            <td colspan="2" align="left" width="47.5%">
                                <h6 class="text-dark font-11">Datos del ejemplar: </h6>
                            </td>
                            <td width="5%" border="0"></td>
                            <td colspan="2" align="left" width="47.5%">
                                <h6 class="text-dark font-11">Datos del consultor: </h6>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" width="15%">
                                <span class="text-dark">Folio: </span>
                            </td>
                            <td align="center" width="32.5%">0</td>
                            <td width="5%" border="0"></td>
                            <td align="center">
                                <span class="text-dark" width="15%">Matrícula: </span>
                            </td>
                            <td align="center" width="32.5%">0</td>
                        </tr>

                        <tr>
                            <td align="center" width="15%">
                                <span class="text-dark">
                                    <div><img src="./scbets-server/temp/testa4514da429b7799362fc7b8bd5da03eb.png" width="70" alt=""></div>
                                </span>
                            </td>
                            <td align="justify" width="32.5%">
                                <p><span class="text-dark">Titulo: </span> -------</p>
                                <p><span class="text-dark">Autor(s): </span> -------</p>
                                <p><span class="text-dark">Editorial, lugar y fecha de edición: </span> -------</p>
                            </td>
                            <td width="5%" border="0"></td>
                            <td align="center" width="15%">
                                <span class="text-dark">
                                    <div><img src="./scbets-server/temp/testa4514da429b7799362fc7b8bd5da03eb.png" width="70" alt=""></div>
                                </span>
                            </td>
                            <td align="justify" width="32.5%">
                                <p><span class="text-dark">Consultor: </span> -------</p>
                                <p><span class="text-dark">Correo electrónico: </span> -------</p>
                                <p><span class="text-dark">Semestre: </span> -------</p>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="center">
                                <p><span class="text-dark">Fecha de expedición: </span> -------</p>
                            </td>
                            <td width="5%" border="0"></td>
                            <td colspan="2" align="center">
                                <p><span class="text-dark">Fecha de devolución: </span> -------</p>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-sm font-10" border="0" style="width: 100%;">
                        <tr>
                            <td width="15%" border="0">
                                <div><img src="./scbets-server/temp/testa4514da429b7799362fc7b8bd5da03eb.png" width="70" alt=""></div>
                            </td>
                            <td align="left" width="85%">
                                <p><span class="text-dark">Autorizador: </span> -------</p>
                                <p><span class="text-dark">Correo electrónico: </span> -------</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="modal fade" id="book-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detalles </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-sm" style="width: 100%;">
                            <tr>
                                <td width="20%"><span class="text-dark">Folio:</span> </td>
                                <td width="80%"><span class="txtFolio text-muted"></span></td>
                            </tr>
                            <tr>
                                <td rowspan="2" align="center">
                                    <div class="txtIMG"></div>
                                </td>
                                <td><span class="text-dark">Título: </span>
                                    <!--</td>
                            </tr>
                            <tr>
                                <td>--><span class="txtTitulo text-muted"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="text-dark">Autore(s):</span></td>
                            </tr>
                            <tr>
                                <td colspan="2"> <span class="txtAutor text-muted"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="text-dark">Editorial, Lugar y fecha de edición:</span> </td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="txtEdicion text-muted"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="txt_btn"></span>

                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <form action="#" method="post">
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="ti-shift-right"></i> Detalles </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" width="10%">QR</th>
                                                <th scope="col" width="25%">Folio</th>
                                                <th scope="col" width="55%">Titulo</th>
                                                <th scope="col" width="10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="listSelect"></tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th scope="col" width="10%">QR</th>
                                                <th scope="col" width="25%">Folio</th>
                                                <th scope="col" width="55%">Titulo</th>
                                                <th scope="col" width="10%"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

    </form>
</div>



<div class="container">
    <form id="addPrestamo" action="#" method="post">
        <div class="modal fade" id="bookListSelect" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="ti-shift-right"></i> Expedición </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <label for="scbets_matricula" class="control-label col-form-label">Matrícula*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    <input type="text" list="ice-cream-flavors" name="scbets_matricula" id="scbets_matricula" class="form-control" placeholder="matricula" aria-label="matricula" aria-describedby="basic-addon1" required>
                                    <datalist id="ice-cream-flavors" class="txt_consultor"></datalist>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="scbets_devolucion" class="control-label col-form-label">Fecha de devolución*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2"><i class=" ti-calendar"></i></span>
                                    <input type="date" name="scbets_devolucion" id="scbets_devolucion" class="form-control" placeholder="fecha" aria-label="fecha" aria-describedby="basic-addon2" required>
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" width="10%">QR</th>
                                                <th scope="col" width="25%">Folio</th>
                                                <th scope="col" width="55%">Titulo</th>
                                                <th scope="col" width="10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="listSelect"></tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th scope="col" width="10%">QR</th>
                                                <th scope="col" width="25%">Folio</th>
                                                <th scope="col" width="55%">Titulo</th>
                                                <th scope="col" width="10%"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <br>
                        <div class="p-3 ">
                            <div class="text-end">
                                <button type="submit" class="btn btn-info rounded-pill px-4 waves-effect waves-light">
                                    <i class="ti-shift-right"></i> Expedir
                                </button>
                                <button type="button" class="btn btn-dark rounded-pill px-4 waves-effect waves-light" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>

    </form>
</div>

<script>
    function format(value) {
        let codex = value._aresx;
        let book = '';
        $.each(value.collection, function(indexInArray, valueOfElement) {
            console.log(atob(valueOfElement.titulo))
            book += ('<tr>' +
                '<td><i class="fa fa-plus"></i></td>' +
                '<th scope ="row"> ' + valueOfElement.folio + ' </th>' +
                '<td>' + atob(valueOfElement.titulo) + '</td>' +
                '<td>' + atob(valueOfElement.autor) + '</td>' +
                '</tr>');
        });

        let contenido = '<div class="table-responsive">' +
            '<table class="table table-dark table-striped table-bordered table-sm">' +
            '<thead>' +
            '<tr>' +
            '<td colspan="5" align="center">DATOS DEL PRESTAMO</td>' +
            '</tr>' +
            '<tr>' +
            '<th scope="col">Folio:</th>' +
            '<td scope="col">' + atob(value._cresx) + '</td>' +
            '<th scope="col"></th>' +
            '<th scope="col">Fecha:</th>' +
            '<td scope="col">' + atob(value._bresx) + '</td>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr>' +
            '<td colspan="5">CONSULTOR</td>' +
            '</tr>' +
            '<tr>' +
            '<th scope="row">Matrícula:</th>' +
            '<td>' + atob(value.consult[0].matricula) + '</td>' +
            '<td></td>' +
            '<th>Nombre:</th>' +
            '<td>' + atob(value.consult[0].name) + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="5">EJEMPLARES</td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="5">' +

            '<table class="table table-dark table-sm table-striped table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th scope="col"><i class="fa fa-plus"></i></th>' +
            '<th scope="col">Folio</th>' +
            '<th scope="col">Titulo</th>' +
            '<th scope="col">Autor</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="TableBook">' + book +

            '</tbody>' +
            '</table>' +


            '</td>' +
            '</tr>' +
            '</tbody>' +
            '</table>' +

            '</div>';

        return contenido;
    }

    let listAuth;
    $(document).ready(function() {
        listAuth = $('#listAuth').DataTable({
            "ajax": {
                "url": atob(ajax_auth_object.routeLink),
                "type": "POST",
                "dataType": 'JSON',
                "data": {
                    "scbets_action": ajax_auth_object.ajaxAuth,
                }
            },

            "columns": [{
                    "className": 'dt-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '',
                },
                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        return atob(o._bresx);
                    }
                },
                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        return atob(o._cresx);
                    }
                },

                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        return atob(o._mresx);
                    }
                },
                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        var s;
                        if (atob(o._mresx) == 'EN PROCESO') {
                            s = '<a href="#" type="button" data-codex="' + o._aresx + '" class="btn waves-light btn-rounded btn-xs btn-primary" onclick=onClickAprobate(' + atob(o._aresx) + ')>Aprobar</a> ';
                            s += '<a href="#" type="button" id="cancelBook" data-codex="' + o._aresx + '" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger" onclick=onClickCancel(' + atob(o._aresx) + ')>Cancelar</a>';
                        } else {
                            s = '';
                        }
                        return s;
                    }
                },

            ],

            "lengthMenu": [
                [3, 10, 25, 50, -1],
                [3, 10, 25, 50, "All"]
            ],
            "paging": true
        });

        // Add event listener for opening and closing details
        $('#listAuth tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = listAuth.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });

    function onClickAprobate(id) {
        $.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: btoa('AprobatePrestamo'),
                    txt_codex: btoa(id)
                },
            })
            .done(function(e) {
                console.log("success" + JSON.stringify(e));
                if (e.success) {
                    setNotify('success', e.messages, 'right');
                } else {
                    setNotify('warning', e.messages, 'right');
                }
                listAuth.ajax.reload(null, false);
            })
            .fail(function(e) {
                console.log("error" + JSON.stringify(e));
            })
            .always(function(e) {
                console.log("complete" + JSON.stringify(e));
            });
    }

    function onClickCancel(id) {
        $.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: ajax_auth_object.ajaxCancel,
                    txt_codex: btoa(id)
                },
            })
            .done(function(e) {
                console.log("success" + JSON.stringify(e));
                if (e.success) {
                    setNotify('success', e.messages, 'right');
                } else {
                    setNotify('warning', e.messages, 'right');
                }
                listAuth.ajax.reload(null, false);
            })
            .fail(function(e) {
                console.log("error" + JSON.stringify(e));
            })
            .always(function(e) {
                console.log("complete" + JSON.stringify(e));
            });
    }
</script>
<style>
    td.dt-control {
        background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.dt-control {
        background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
</style>

<div class="content">
    <form id="addAuth" action="#" method="post">
        <div class="modal fade" id="bookListAutorization" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Autorización</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="table-responsive">
                                    <table id="listAuth" class="table table-sm mb-0 display nowrap" style="width: 100%;">
                                        <thead class="tabla-light">
                                            <tr>
                                                <th></th>
                                                <th>Fecha</th>
                                                <th>Folio</th>
                                                <th>Estatus</th>
                                                <th>Operacion</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>