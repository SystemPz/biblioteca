<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Engargolados</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="?scbets-inicio=">Home</a>
            </li>
            <li class="breadcrumb-item active">Engargolados</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">

    </div>
</div>

<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJWYXJpYW50ZXMucGhw",
        "loadingmessage": "Sending user info, please wait...",
        "ajaxint": "SW5zZXJ0",
        "ajaxupd": "VXBkYXRl",
        "ajaxjsn": "SnNvbg==",
        "ajaxfol": "Rm9saW8=",
        "ajaxSta": "U3RhdHVz",
        "ajaxQr": "UXI=",
        "ajaxSign": "c2Vzc2lvbl9pbnB1dA==",
        "ajaxDel": "b25EZWxldGU=",
    };

    function onClean() {
        $('#txt_folio').val("");
        $('#txt_titulo').val("");
        $('#txt_autor').val("");
        $('#txt_NumPagina').val("");
        $('#txt_categoria').val("");
        $('#txt_ubicacion').val("");
        $('#txt_status').val("");
    }

    let data_table;
    $(document).ready(function() {
        data_table = $('#data_table').DataTable({
            "ajax": {
                "url": atob(ajax_auth_object.routeLink),
                "type": "POST",
                "data": {
                    "scbets_action": ajax_auth_object.ajaxjsn,
                    txt_variedad: btoa('ENG'),
                    txt_codex: ''
                }
            },

            "columns": [{
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        return atob(o._dresx);
                    }
                },
                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        return atob(o._eresx);
                    }
                },

                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        return atob(o._fresx);
                    }
                },

                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        var s;
                        if (atob(o._nresx) == 1) {
                            s = '<i class="badge font-weight-medium bg-light-success text-success">Activo</i>';
                        } else if (atob(o._nresx) == 2) {
                            s = '<i class="badge font-weight-medium bg-light-warning text-warning">Susped</i>';
                        } else if (atob(o._nresx) == 3) {
                            s = '<i class="badge font-weight-medium bg-light-danger text-danger">Baja</i>';
                        } else if (atob(o._nresx) == 4) {
                            s = '<i class="fa fa-circle text-dark"></i> <i>Baja</i>';
                        }
                        return s;
                    }
                },
                {
                    "data": null,
                    "bSortable": false,
                    "mRender": function(o) {
                        return '<a href="#" class="blue" data-a="' + (o._aresx) +
                            '" data-b="' + atob(o._dresx) +
                            '" data-c="' + atob(o._eresx) +
                            '" data-d="' + atob(o._fresx) +
                            '" data-e="' + atob(o._gresx) +
                            '" data-f="' + atob(o._iresx) +
                            '" data-g="' + atob(o._jresx) +
                            '" data-h="' + atob(o._kresx) +
                            '" data-i="' + atob(o._nresx) + '"  data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg-updte" id="data-edit">' +
                            '<i class="ti ti-pencil text-primary"></i>' + '</a> | ' +
                            ' <a href="#" class="red" data-a="' + (o._aresx) + '" data-bs-toggle="modal" data-bs-target="#al-danger-alert" >' +
                            '<i class="ti ti-close text-danger"></i>' + '</a> ';

                    }
                }
            ],

            "lengthMenu": [
                [3, 10, 25, 50, -1],
                [3, 10, 25, 50, "All"]
            ],
            "paging": true
        });

    });
    $(document).ready(function() {
        $("#formAdd").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: $(this).attr('method'),
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxint + '&&' + $(this).serialize(),
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('uccess: ' + JSON.stringify(data));
                    if (data.success) {
                        setNotify('success', data.messages, 'right');
                        onClean();
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }
                    data_table.ajax.reload(null, false);
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });

        });

        $("#bs-example-modal-lg-updte").on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this)
            modal.find('.modal-body #upd_folio').val(button.data('b'));
            modal.find('.modal-body #upd_titulo').val(button.data('c'));
            modal.find('.modal-body #upd_autor').val(button.data('d'));
            modal.find('.modal-body #upd_NumPagina').val(button.data('f'));
            //modal.find('.modal-body #upd_permiso').val(button.data('g'));
            modal.find('.modal-body #upd_categoria').val(button.data('e'));
            modal.find('.modal-body #upd_ubicacion').val(button.data('h'));
            modal.find('.modal-body #upd_status').val(button.data('i'));
            modal.find('.modal-body #upd_codex').val(button.data('a'));
        });

        $("#formUpdate").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: $(this).attr('method'),
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxupd + '&&' + $(this).serialize(),
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('uccess: ' + JSON.stringify(data));
                    if (data.success) {
                        setNotify('success', data.messages, 'right');
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }
                    data_table.ajax.reload(null, false);
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });

        });

        let getPermiso = function permisos() {
            let $permiso = $('.txt_permiso');
            $permiso.html('<option></option>');

            $.each([{
                "id": 1,
                "name": "Reserva"
            }, {
                "id": 2,
                "name": "Prestamo"
            }], function(id, name) {
                $permiso.append('<option value=' + name.id + '>' + name.name + '</option>');
            });
        }
        getPermiso();

        let getCategorias = function categorias() {
            jQuery.ajax({
                url: './scbets-server/ControllerCategorias.php',
                type: 'POST',
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxjsn,
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));

                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    var $catergoria = $('.txt_categoria');
                    $catergoria.html('<option></option>');
                    $.each(data.data, function(indexInArray, valueOfElement) {
                        console.log(atob(valueOfElement._cresx));
                        $catergoria.append('<option value=' + atob(valueOfElement._aresx) + '>' + atob(valueOfElement._cresx) + '</option>');
                    });
                    console.log('success: ' + JSON.stringify(data));

                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });
        }
        getCategorias();

        let getUbicaciones = function ubicaciones() {
            jQuery.ajax({
                url: './scbets-server/ControllerUbicaciones.php',
                type: 'POST',
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxjsn,
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + JSON.stringify(xhr));

                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    var $ubicacion = $('.txt_ubicacion');
                    $ubicacion.html('<option></option>');
                    $.each(data.data, function(indexInArray, valueOfElement) {
                        console.log(atob(valueOfElement._cresx));
                        $ubicacion.append('<option value=' + atob(valueOfElement._aresx) + '>' + atob(valueOfElement._cresx) + '</option>');
                    });
                    console.log('success: ' + JSON.stringify(data));

                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });
        }
        getUbicaciones();

    });

    $(document).ready(function() {

        $("#al-danger-alert").on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this)
            modal.find('.modal-body #txt_codex').val(button.data('a'))
        });

        $("#onDelete").submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: $(this).attr('method'),
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_object.ajaxDel + '&&' + $(this).serialize(),
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
                    data_table.ajax.reload(null, false);
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + (xhr));
                }
            });
        });
    });
</script>

<div class="container-fluid">
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="card-content-table">
                <div class="card-body">
                    <div class="d-md-flex no-block align-items-center">
                        <div>
                            <h3 class="card-title">Lista de engargolados</h3>
                            <h6 class="card-subtitle"></h6>
                        </div>
                        <div class="ms-auto">
                            <ul class="list-inline">
                                <li class="list-inline-item px-2">
                                    <h6 class="text-muted">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                                            <i class="fa fa-circle me-1 text-success"></i>Nuevo registro
                                        </a>
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
                                <table id="data_table" class="table table-hover table-striped table-sm mb-0 display nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Titulo</th>
                                            <th>Autores</th>
                                            <th>Status</th>
                                            <th>opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
                                    <input type="text" id="txt_folio" name="txt_folio" class="form-control" placeholder="folio" required />
                                    <input type="hidden" id="txt_variedad" value="ENG" name="txt_variedad" class="form-control" placeholder="">
                                </div>
                                <div class="col-lg-8">
                                    <label for="txt_titulo" class="control-label col-form-label">Titulo*</label>
                                    <input type="text" id="txt_titulo" name="txt_titulo" class="form-control" placeholder="título" required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="txt_autor" class="control-label col-form-label">Autore(s)*</label>
                                    <input type="text" id="txt_autor" name="txt_autor" class="form-control" placeholder="autores" required />
                                </div>
                                <div class="col-lg-4">
                                    <label for="txt_NumPagina" class="control-label col-form-label">Número de páginas*</label>
                                    <input type="number" id="txt_NumPagina" name="txt_NumPagina" class="form-control" placeholder="Num. pag" required />
                                </div>
                            </div>
                            <div class="row">

                                <!--<div class="col-lg-4">
                                    <label for="txt_permiso" class="control-label col-form-label">Permiso*</label>
                                    <select id="txt_permiso" name="txt_permiso" class="form-control txt_permiso"></select>
                                </div>-->
                                <div class="col-lg-4">
                                    <label for="txt_categoria" class="control-label col-form-label">Categoría*</label>
                                    <select id="txt_categoria" name="txt_categoria" class="form-control form-select txt_categoria" required> </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="txt_ubicacion" class="control-label col-form-label">Ubicación*</label>
                                    <select id="txt_ubicacion" name="txt_ubicacion" class="form-control form-select txt_ubicacion" required> </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="txt_status" class="control-label col-form-label">Estatus*</label>
                                    <select id="txt_status" name="txt_status" class="form-control form-select" required>
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
                                    <input type="text" id="upd_folio" name="upd_folio" class="form-control" placeholder="folio" required />
                                    <input type="hidden" id="upd_codex" name="upd_codex" class="form-control" placeholder="folio">
                                </div>
                                <div class="col-lg-8">
                                    <label for="upd_titulo" class="control-label col-form-label">Titulo*</label>
                                    <input type="text" id="upd_titulo" name="upd_titulo" class="form-control" placeholder="título" required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <label for="upd_autor" class="control-label col-form-label">Autore(s)*</label>
                                    <input type="text" id="upd_autor" name="upd_autor" class="form-control" placeholder="autores" required />
                                </div>
                                <div class="col-lg-4">
                                    <label for="upd_NumPagina" class="control-label col-form-label">Número de páginas*</label>
                                    <input type="number" id="upd_NumPagina" name="upd_NumPagina" class="form-control" placeholder="Num. pag" required />
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
                                    <select id="upd_categoria" name="upd_categoria" class="form-control form-select txt_categoria" required> </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="upd_ubicacion" class="control-label col-form-label">Ubicación*</label>
                                    <select id="upd_ubicacion" name="upd_ubicacion" class="form-control form-select txt_ubicacion" required> </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="upd_status" class="control-label col-form-label">Estatus*</label>
                                    <select id="upd_status" name="upd_status" class="form-control form-select" required>
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
    <form id="onDelete" method="post">
        <!-- Vertically centered modal -->
        <div class="modal fade" id="al-danger-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content modal-filled bg-light-danger">
                    <div class="modal-body p-4">
                        <div class="text-center text-danger">
                            <i data-feather="x-octagon" class="fill-white feather-lg"></i>
                            <h4 class="mt-2">Seguro que desea eliminar?</h4>
                            <p class="mt-3">El registro se eliminara permanentemente.</p>
                            <input type="hidden" name="txt_codex" id="txt_codex" class="form-control" />
                            <button type="submit" class="btn btn-light my-2" data-bs-dismiss="modal">Eliminar</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </form>
</div>