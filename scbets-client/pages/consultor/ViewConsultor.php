<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Consultores</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="?scbets-inicio=">Home</a>
            </li>
            <li class="breadcrumb-item active">Consultores</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">

    </div>
</div>

<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJDb25zdWx0b3IucGhw",
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

    function onClen() {
        $('#txt_matricula').val("");
        $('#txt_email').val("");
        $('#txt_name').val("");
        $('#txt_firtsname').val("");
        $('#txt_status').val("");
    }
    let table_consultor;
    $(document).ready(function() {
        /* $.ajax({
             type: "POST",
             url: atob(ajax_auth_object.routeLink),
             dataType: 'json',
             data: {
                 txt_codex: null,
                 scbets_action: ajax_auth_object.ajaxjsn
             },
             complete: function(xhr, textStatus) {
                 //called when complete
                 console.log('complete: ' + JSON.stringify(xhr));
             },
             success: function(data, textStatus, xhr) {
                 //called when successful
                 console.log('uccess: ' + JSON.stringify(data));
             },
             error: function(xhr, textStatus, errorThrown) {
                 //called when there is an error
                 console.log('error: ' + JSON.stringify(xhr));
             }
         });*/


        table_consultor = $('#table_consultor').DataTable({
            "ajax": {
                "url": atob(ajax_auth_object.routeLink),
                "type": "POST",
                "data": {
                    "scbets_action": ajax_auth_object.ajaxjsn,
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
                        return atob(o._hresx);
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
                        return atob(o._gresx);
                    }
                },
                {
                    "data": null,
                    "bSortable": true,
                    "mRender": function(o) {
                        var s;
                        if (atob(o._iresx) == 1) {
                            s = '<i class="badge font-weight-medium bg-light-success text-success">Activo</i>';
                        } else if (atob(o._iresx) == 2) {
                            s = '<i class="badge font-weight-medium bg-light-warning text-warning">Susped</i>';
                        } else if (atob(o._iresx) == 3) {
                            s = '<i class="badge font-weight-medium bg-light-danger text-danger">Baja</i>';
                        } else if (atob(o._iresx) == 4) {
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
                            '" data-c="' + atob(o._hresx) +
                            '" data-d="' + atob(o._fresx) +
                            '" data-e="' + atob(o._gresx) +
                            '" data-f="' + atob(o._iresx) + '"  data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg-updte" id="data-edit">' +
                            '<i class="ti ti-pencil text-primary"></i>' + '</a> | ' +
                            ' <a href="#" class="red" data-a="' + (o._aresx) + '" data-bs-toggle="modal" data-bs-target="#al-danger-alert">' +
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
            let ddd = $(this).serialize();
            console.log(btoa('./scbets-server/ControllerUsuarios.php'))
            console.log(atob('Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJVc3Vhcmlvcy5waHA='))

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
                        onClen();
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }
                    table_consultor.ajax.reload(null, false);
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
            modal.find('.modal-body #upd_matricula').val(button.data('b'));
            modal.find('.modal-body #upd_email').val(button.data('c'));
            modal.find('.modal-body #upd_name').val(button.data('d'));
            modal.find('.modal-body #upd_firtsname').val(button.data('e'));
            modal.find('.modal-body #upd_status').val(button.data('f'));
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
                    table_consultor.ajax.reload(null, false);
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
                }
            });

        });

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
                    table_consultor.ajax.reload(null, false);
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + JSON.stringify(xhr));
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
                <div class="card-body" style="position: relative;">
                    <div class="d-md-flex no-block align-items-center">
                        <div>
                            <h3 class="card-title">Lista de consultores</h3>
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
                                <table id="table_consultor" class="table table-hover table-striped table-sm mb-0 display nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Matrícula</th>
                                            <th>E-mail</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
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
                            <div class="mb-3 row">
                                <label for="txt_email" class="col-sm-3 text-end control-label col-form-label">Correo electrónico*</label>
                                <div class="col-sm-9">
                                    <input type="email" id="txt_email" name="txt_email" class="form-control" placeholder="email" required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="txt_matricula" class="col-sm-3 text-end control-label col-form-label">Matrícula*</label>
                                <div class="col-sm-9">
                                    <input type="text" id="txt_matricula" name="txt_matricula" class="form-control" placeholder="Matrícula" required />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="txt_name" class="col-sm-3 text-end control-label col-form-label">Nombre*</label>
                                <div class="col-sm-9">
                                    <input type="text" id="txt_name" name="txt_name" class="form-control" placeholder="Nombre" required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="txt_firtsname" class="col-sm-3 text-end control-label col-form-label">Apellido(s)*</label>
                                <div class="col-sm-9">
                                    <input type="text" id="txt_firtsname" name="txt_firtsname" class="form-control" placeholder="Apellido(s)" required />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="txt_status" class="col-sm-3 text-end control-label col-form-label">Estatus*</label>
                                <div class="col-sm-9">
                                    <select id="txt_status" name="txt_status" class="form-control form-select" required>
                                        <option value=""></option>
                                        <option value="1">Activo</option>
                                        <option value="2">Suspend</option>
                                        <option value="3">Baja</option>
                                    </select>
                                </div>
                            </div>

                        </fieldset>

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
                    <div class="modal-footer">
                    </div>
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

                            <div class="mb-3 row">
                                <label for="upd_email" class="col-sm-3 text-end control-label col-form-label">Correo electrónico*</label>
                                <div class="col-sm-9">
                                    <input type="email" id="upd_email" name="upd_email" class="form-control" placeholder="email" required />
                                    <input type="hidden" id="upd_codex" name="upd_codex" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="upd_matricula" class="col-sm-3 text-end control-label col-form-label">Matrícula*</label>
                                <div class="col-sm-9">
                                    <input type="text" id="upd_matricula" name="upd_matricula" class="form-control" placeholder="Matrícula" required />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="upd_name" class="col-sm-3 text-end control-label col-form-label">Nombre*</label>
                                <div class="col-sm-9">
                                    <input type="text" id="upd_name" name="upd_name" class="form-control" placeholder="Nombre" required />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="upd_firtsname" class="col-sm-3 text-end control-label col-form-label">Apellido(s)*</label>
                                <div class="col-sm-9">
                                    <input type="text" id="upd_firtsname" name="upd_firtsname" class="form-control" placeholder="Apellido(s)" required />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="upd_status" class="col-sm-3 text-end control-label col-form-label">Estatus*</label>
                                <div class="col-sm-9">
                                    <select id="upd_status" name="upd_status" class="form-control form-select" required>
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
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
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