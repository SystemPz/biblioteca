<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Decolución</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="?scbets-inicio=">Home</a>
            </li>
            <li class="breadcrumb-item active">Devolución</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">

    </div>
</div>

<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJEZXZvbHVjaW9uZXMucGhw",
        "loadingmessage": "Sending user info, please wait...",
        "ajaxint": "SW5zZXJ0",
        "ajaxupd": "VXBkYXRl",
        "ajaxjsn": "SnNvbg==",
        "ajaxfol": "Rm9saW8=",
        "ajaxSta": "U3RhdHVz",
        "ajaxQr": "UXI=",
        "ajaxSign": "c2Vzc2lvbl9pbnB1dA==",
        "ajaxAuth": "TGlzdEF1dG9yaXphdGlvbg==",
        "ajaxDownload": "RG93bmxvYWRQZGY=",
        "ajaxReturn": "RGV2b2x1dGlvbkJvb2s=",
    };

    function format(value) {
        // `d` is the original data object for the row
        let codex = value._aresx;
        //let data = getBooks(codex);
        //alert(JSON.stringify(data))
        //let consult = JSON.parse((value.consult));

        //let collection = JSON.parse((value.collection));
        /*let tit = collection[0].titulo;*/
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
        //console.log(collection)
        // console.log(consult[0].id);
        //alert((tit.replace("u00e1", 'á')));

        //let linea = tit.replace('u00e1', 'á');
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
            //"processing": true,
            //"serverSide": true,
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
                        if (atob(o._mresx) == 'PRESTADO') {
                            s = '<a href="#" type="button" class="btn waves-light btn-rounded btn-xs btn-danger" onclick=onClickDownload(' + atob(o._aresx) + ',' + atob(o.consult[0].matricula) + ')><i class="far fa-file-pdf"></i> Descarga</a>  ';
                        } else {
                            s = '';
                        }
                        return s;
                    }
                },
                {
                    "data": null,
                    "bSortable": true,
                    "className": 'dt-btn',
                    "mRender": function(o) {
                        var s;
                        if (atob(o._mresx) == 'PRESTADO') {
                            //s = '<a href="#" type="button" class="btn waves-light btn-rounded btn-xs btn-info" onclick=onClickDevolution(' + atob(o._aresx) + ')>Retornar</a> ';

                            s = '<a href="#" name="delete" data-codex=' + (o._aresx) + ' class="btn waves-light btn-rounded btn-xs btn-info" data-bs-toggle="modal" data-bs-target="#setting-modal-return">Retornar</a> ';
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

    $(document).ready(function() {

        $('#setting-modal-return').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('.modal-body #txt_codex').val(button.data('codex'));
            modal.find('.modal-body #scbets_action').val(ajax_auth_object.ajaxReturn);

            listAuth.ajax.reload(null, false);
        });

        $('#setting-return').submit(function(e) {
            //e.preventDefault();
            $.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('uccess: ' + JSON.stringify(data));
                    if (data.success) {
                        setNotify('success', data.messages, 'right');
                        listAuth.ajax.reload();
                    } else {
                        setNotify('warning', data.messages, 'right');
                        listAuth.ajax.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });
        });

        $("#listAuth").on('click', '.delete', function() {
            //var tr = $(this) /*.closest('tr');*/
            var rowCodex = $(this).attr("data-delete");
            //listAuth.ajax.reload(null, false);

            //var row = listAuth.row(tr);

            console.log('...' + rowCodex)
            $.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: ajax_auth_object.ajaxReturn,
                    txt_codex: rowCodex,
                },
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('uccess: ' + JSON.stringify(data));
                    if (data.success) {
                        setNotify('success', data.messages, 'right');
                        listAuth.ajax.reload();
                    } else {
                        setNotify('warning', data.messages, 'right');
                        listAuth.ajax.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });

        });
    });

    function onClickDevolution(codex) {
        console.log(codex)
        $.ajax({
            url: atob(ajax_auth_object.routeLink),
            type: 'POST',
            dataType: 'json',
            data: {
                scbets_action: ajax_auth_object.ajaxReturn,
                txt_codex: btoa(codex)
            },
            complete: function(xhr, textStatus) {
                //called when complete
                console.log('complete: ' + JSON.stringify(xhr));
            },
            success: function(data, textStatus, xhr) {
                //called when successful
                console.log('uccess: ' + JSON.stringify(data));
                if (data.success) {
                    setNotify('success', data.messages, 'right');
                    //listAuth.ajax.reload(null, false);
                } else {
                    setNotify('warning', data.messages, 'right');
                }
                setInterval(function() {
                    listAuth.draw();
                }, 3000);

            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                console.log('error: ' + JSON.stringify(xhr));
            }
        });


    }

    function onClickDownload(codex, fileName) {
        //console.log(id + '---' + fileNaame)
        /*$.ajax({
                type: "POST",
                url: atob(ajax_auth_object.routeLink),
                //dataType: 'blob',
                data: {
                    "scbets_action": ajax_auth_object.ajaxDownload,
                    txt_codex: btoa(id)
                },

            })
            .done(function(e) {
                console.log("success" + e);
            })
            .fail(function(e) {
                console.log("error" + e);
            })
            .always(function(e) {
                console.log("complete" + e);
            });*/

        $.ajax({
            type: 'POST',
            url: atob(ajax_auth_object.routeLink),
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                "scbets_action": ajax_auth_object.ajaxDownload,
                txt_codex: btoa(codex)
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

<style>
    td.dt-control {
        background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.dt-control {
        background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
</style>

<div class="container-fluid">
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="card-content-table">
                <div class="card-body">
                    <div class="d-md-flex no-block align-items-center">
                        <div>
                            <h3 class="card-title">Registro de prestamos</h3>
                            <h6 class="card-subtitle"></h6>
                        </div>
                        <div class="ms-auto">
                            <ul class="list-inline">
                                <li class="list-inline-item px-2">
                                    <h6 class="text-muted">
                                        <!--<a href="#" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                                            <i class="fa fa-circle me-1 text-success"></i>Nuevo registro
                                        </a>-->
                                    </h6>
                                </li>
                                <!--<li class="list-inline-item px-2">
                                    <h6 class="text-muted">
                                        <i class="fa fa-circle me-1 text-primary"></i>Premium
                                    </h6>
                                </li>-->
                            </ul>
                        </div>
                    </div>

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
                                            <th>Descarga</th>
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
</div>

<div class="container">
    <form id="formAdd" action="#" method="post" class="form-horizontal">
        <!--  Modal content for the above example -->
        <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-plus"></i> Nuevo regitro</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <fieldset>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="txt_folio" class="control-label col-form-label">Folio*</label>
                                    <input type="text" id="txt_folio" name="txt_folio" class="form-control" placeholder="folio">
                                    <input type="hidden" id="txt_variedad" value="ENC" name="txt_variedad" class="form-control" placeholder="">
                                </div>
                                <div class="col-lg-8">
                                    <label for="txt_titulo" class="control-label col-form-label">Titulo*</label>
                                    <input type="text" id="txt_titulo" name="txt_titulo" class="form-control" placeholder="título">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="txt_autor" class="control-label col-form-label">Autore(s)*</label>
                                    <input type="text" id="txt_autor" name="txt_autor" class="form-control" placeholder="autores">
                                </div>
                                <div class="col-lg-4">
                                    <label for="txt_NumPagina" class="control-label col-form-label">Número de páginas*</label>
                                    <input type="number" id="txt_NumPagina" name="txt_NumPagina" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="row">

                                <!--<div class="col-lg-4">
                                    <label for="txt_permiso" class="control-label col-form-label">Permiso*</label>
                                    <select id="txt_permiso" name="txt_permiso" class="form-control txt_permiso"></select>
                                </div>-->
                                <div class="col-lg-4">
                                    <label for="txt_categoria" class="control-label col-form-label">Categoría*</label>
                                    <select id="txt_categoria" name="txt_categoria" class="form-control txt_categoria"> </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="txt_ubicacion" class="control-label col-form-label">Ubicación*</label>
                                    <select id="txt_ubicacion" name="txt_ubicacion" class="form-control txt_ubicacion"> </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="txt_status" class="control-label col-form-label">Estatus*</label>
                                    <select id="txt_status" name="txt_status" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Activo</option>
                                        <option value="2">Suspend</option>
                                        <option value="3">Baja</option>
                                    </select>
                                </div>
                            </div>



                            <!-- <button type="submit" class="btn btn-info rounded-pill px-4 mt-3 ar">
                                Submit
                            </button>-->
                        </fieldset>
                        <br>

                        <div class="p-3 border-top">
                            <div class="text-end">
                                <button type="submit" class="btn btn-info rounded-pill px-4 waves-effect waves-light">
                                    Guardar
                                </button>
                                <button type="button" class="btn btn-dark rounded-pill px-4 waves-effect waves-light" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>

                    </div>
                    <!--<div class="modal-footer">-->
                    <!--<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    <!--</div>-->
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </form>
</div>

<div class="container">
    <form id="formUpdate" action="#" method="post">
        <!--  Modal content for the above example -->
        <div class="modal fade" id="bs-example-modal-lg-updte" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-plus"></i> Editar regitro</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <fieldset>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="upd_folio" class="control-label col-form-label">Folio*</label>
                                    <input type="text" id="upd_folio" name="upd_folio" class="form-control" placeholder="folio">
                                    <input type="hidden" id="upd_codex" name="upd_codex" class="form-control" placeholder="folio">
                                </div>
                                <div class="col-lg-8">
                                    <label for="upd_titulo" class="control-label col-form-label">Titulo*</label>
                                    <input type="text" id="upd_titulo" name="upd_titulo" class="form-control" placeholder="título">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="upd_autor" class="control-label col-form-label">Autore(s)*</label>
                                    <input type="text" id="upd_autor" name="upd_autor" class="form-control" placeholder="autores">
                                </div>
                                <div class="col-lg-4">
                                    <label for="upd_NumPagina" class="control-label col-form-label">Número de páginas*</label>
                                    <input type="number" id="upd_NumPagina" name="upd_NumPagina" class="form-control" placeholder="Apellido(s)">
                                </div>
                            </div>
                            <div class="row">
                                <!--<div class="col-lg-8">
                                    <label for="upd_lugarFechaEdicion" class="control-label col-form-label">Lugar y fecha de edición*</label>
                                    <input type="text" id="upd_lugarFechaEdicion" name="upd_lugarFechaEdicion" class="form-control" placeholder="Lugar fecha de edición">
                                </div>-->

                                <!--<div class="col-lg-4">
                                    <label for="upd_permiso" class="control-label col-form-label">Permiso*</label>
                                    <select id="upd_permiso" name="upd_permiso" class="form-control txt_permiso"></select>
                                </div>-->
                                <div class="col-lg-4">
                                    <label for="upd_categoria" class="control-label col-form-label">Categoría*</label>
                                    <select id="upd_categoria" name="upd_categoria" class="form-control txt_categoria"> </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="upd_ubicacion" class="control-label col-form-label">Ubicación*</label>
                                    <select id="upd_ubicacion" name="upd_ubicacion" class="form-control txt_ubicacion"> </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="upd_status" class="control-label col-form-label">Estatus*</label>
                                    <select id="upd_status" name="upd_status" class="form-control">
                                        <option value=""></option>
                                        <option value="1">Activo</option>
                                        <option value="2">Suspend</option>
                                        <option value="3">Baja</option>
                                    </select>
                                </div>
                            </div>

                        </fieldset>
                        <br>
                        <div class="p-3 border-top">
                            <div class="text-end">
                                <button type="submit" class="btn btn-info rounded-pill px-4 waves-effect waves-light">
                                    Actualizar
                                </button>
                                <button type="button" class="btn btn-dark rounded-pill px-4 waves-effect waves-light" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>

                    </div>
                    <!--<div class="modal-footer">-->
                    <!--<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    <!--</div>-->
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </form>
</div>

<div class="container">
    <form id="setting-return" method="post">
        <!-- Vertically centered modal -->
        <div class="modal fade" id="setting-modal-return" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content modal-filled bg-light-info">
                    <div class="modal-body p-4">
                        <div class="text-center text-info">
                            <i data-feather="check-circle" class="fill-white feather-lg"></i>
                            <h4 class="mt-2">Aprobar devolución</h4>
                            <p class="mt-3"></p>
                            <input type="hidden" name="txt_codex" id="txt_codex" class="form-control" />
                            <input type="hidden" name="scbets_action" id="scbets_action" class="form-control" />

                            <button type="submit" class="btn btn-light my-2" data-bs-dismiss="modal">Aprobar</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </form>
</div>