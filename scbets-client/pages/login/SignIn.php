<h1 class="visually-hidden">SCBETSZ examples</h1>
<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJVc2VyU2Vzc2lvbi5waHA=",
        "loadingmessage": "Sending user info, please wait...",
        "ajaxint": "SW5zZXJ0",
        "ajaxupd": "VXBkYXRl",
        "ajaxjsn": "SnNvbg==",
        "ajaxfol": "Rm9saW8=",
        "ajaxSta": "U3RhdHVz",
        "ajaxQr": "UXI=",
        "ajaxSign": "c2Vzc2lvbl9pbnB1dA==",
    };

    $(document).ready(function() {
        $("#signinpt").submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: atob(ajax_auth_object.routeLink),
                    type: $(this).attr('method'),
                    dataType: 'json',
                    data: 'stmt_action=' + ajax_auth_object.ajaxSign + '&&' + $(this).serialize(),
                })
                .done(function(e) {
                    //console.log(e.messages.url + "success" + JSON.stringify(e.data));
                    if (e.success) {
                        setNotify('success', "Sesión iniciada correctamente", 'right');
                        window.localStorage.setItem('user', JSON.stringify(e.data));
                        setTimeout(() => {
                            location.reload();
                            console.log('recargar')
                        }, 3000);
                    } else {
                        setNotify('danger', e.messages, 'right');
                    }

                })
                .fail(function(e) {
                    console.log("error" + (e));
                })
                .always(function(e) {
                    console.log("complete" + (e));
                });

        });
    });
</script>
<div class="px-4 py-5 text-center">
    <img class="d-block mx-auto mb-4" src="./assets/images/logoBookETS.svg" alt="scbets-zacatecas-book" width="">
    <div class="d-none d-sm-block content-center">
        <h3 class="display-5 fw-bold">Biblioteca Escolar</h3>

    </div>
    <div class="col-lg-12 mx-auto">
        <h6 class="lead mb-4">Sistema de Control Bibliotecario de la Escuela de Trabajo Social, Zacatecas.</h6>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <form class="form-horizontal r-separator border-top" method="post" id="signinpt" action="#">
                            <div class="card-body bg-light">
                                <h4 class="card-title mt-2 pb-3">Iniciar Sesión</h4>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row align-items-center mb-0">
                                            <label for="inputEmail3" class="col-2 text-end control-label col-form-label"><i class=" ti-user"></i></label>
                                            <div class="col-10 border-start pt-2 pb-2">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="usuario@example.com" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group row align-items-center mb-0">
                                            <label for="inputEmail3" class="col-2 text-end control-label col-form-label"><i class=" ti-lock"></i></label>
                                            <div class="col-10 border-start pt-2 pb-2">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña..." pattern="^([A-Za-z]|[0-9])+$" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-0 text-end">
                                    <button type="submit" class="btn btn-info rounded-pill px-4 waves-effect waves-light block">
                                        Iniciar sesión
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>