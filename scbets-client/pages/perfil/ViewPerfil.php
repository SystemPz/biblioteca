<div class="container-fluid">

  <div class="row page-titles">
    <div class="col-md-5 col-12 ">
      <h3 class="text-themecolor mb-0">Vista de Perfil</h3>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
          <a href="?scbets">Home</a>
        </li>
        <li class="breadcrumb-item active">Perfil de usuario</li>
      </ol>
    </div>
    <div class="col-md-7 col-12 align-self-end ">
       <span class="fecha"></span> <span class="time"></span>
    </div>
  </div>
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <!-- Row -->
  <script>
    const ajax_auth_object = {
      "routeLinkU": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJVc3Vhcmlvcy5waHA=",
      "routeLinkC": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJDb25zdWx0b3IucGhw",
      "ajaxupd": "VXBkYXRl",
    };
  </script>
  <div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card">
        <div class="card-body">
          <center class="mt-4">
            <img src="./assets/images/users/profile.svg" class="rounded-circle" width="150" />
            <h4 class="card-title mt-2"><span class="user-name"></span></h4>
            <h6 class="card-subtitle"><span class="user-sesion"></span></h6>
            <div class="row text-center justify-content-md-center">

            </div>
          </center>
        </div>
        <div>
          <hr />
        </div>
        <div class="card-body">
          <small class="text-muted">Correo electónico </small>
          <h6><span class="user-email"></span></h6>
          <small class="text-muted pt-4 db">identificador</small>
          <h6><span class="user-sesion"></span></h6>


        </div>
      </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
      <div class="card">
        <!-- Tabs -->
        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
          <!--<li class="nav-item">
                    <a
                      class="nav-link active"
                      id="pills-timeline-tab"
                      data-bs-toggle="pill"
                      href="#current-month"
                      role="tab"
                      aria-controls="pills-timeline"
                      aria-selected="true"
                      >Historial</a
                    >
                  </li>-->
          <li class="nav-item">
            <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Perfil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-setting-tab" data-bs-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Ajustes</a>
          </li>
        </ul>
        <!-- Tabs -->
        <div class="tab-content" id="pills-tabContent">

          <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 col-xs-6 b-r">
                  <strong>Nombre</strong>
                  <br />
                  <p class="text-muted"><span class="user-name"></span></p>
                </div>

                <div class="col-md-6 col-xs-6 b-r">
                  <strong>Correo electrónico</strong>
                  <br />
                  <p class="text-muted"><span class="user-email"></span></p>
                </div>
                <!--<div class="col-md-4 col-xs-6">
                          <strong>Location</strong>
                          <br />
                          <p class="text-muted">London</p>
                        </div>-->
              </div>
              <hr />
              <p class="mt-4" style="text-align: justify;">La Biblioteca Escolar es un lugar de estudio y trabajo para el uso de toda la comunidad de la Escuela de Trabajo Social. Para garantizar que predomine un ambiente de seguridad y orden en la Biblioteca Escolar, se recomienda seguir el lineamiento establecida de la misma área. Solicitamos a toda la comunidad escolar a hacer buen uso de las facilidades y servicios que ofrece la Biblioteca Escolar y a seguir las normas y reglas. 
              </p>
              <p>
                
              </p>
             
              <h4 class="font-weight-medium mt-4"></h4>
              <hr />


            </div>
          </div>
          <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
            <div class="card-body">

              <!--<form class="form-horizontal ">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label class="col-md-12">Usuario</label>
                    <div class="col-md-12">
                      <input type="text" placeholder="Nombre" class="upd_name form-control form-control-line" />
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="example-email" class="col-md-12">Correo Electrónico</label>
                    <div class="col-md-12">
                      <input type="email" name="upd_email" placeholder="email@example.com" class="upd_email form-control form-control-line" />
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label class="col-md-12">Contraseña</label>
                    <div class="col-md-12">
                      <input type="password" value="password" class="form-control form-control-line" />
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label class="col-md-12">Nombre</label>
                    <div class="col-md-12">
                      <input type="text" placeholder="Nombre" name="upd_name" class="upd_name form-control form-control-line" />
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="col-md-12">Apellidos</label>
                    <div class="col-md-12">
                      <input type="text" placeholder="Apellidos" name="upd_firtsname" class="upd_firtsname form-control form-control-line" />
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="col-sm-12">Select Country</label>
                  <div class="col-sm-12">
                    <select class="form-control form-control-line">
                      <option>London</option>
                      <option>India</option>
                      <option>Usa</option>
                      <option>Canada</option>
                      <option>Thailand</option>
                    </select>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="col-sm-12">
                    <button class="btn btn-success">
                      Update Profile
                    </button>
                  </div>
                </div>
              </form>-->
              <hr>
              <?php
              if ($_SESSION['type_user'] == "ADMIN") {
              ?>
                <script>
                  $(document).ready(function() {
                    $("#formUpdate").submit(function(e) {
                      e.preventDefault();
                      jQuery.ajax({
                        url: atob(ajax_auth_object.routeLinkU),
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
                          table_user.ajax.reload(null, false);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                          //called when there is an error
                          console.log('error: ' + JSON.stringify(xhr));
                        }
                      });

                    });
                  });
                </script>
                <form id="formUpdate" action="#" method="post">
                  <fieldset>

                    <div class="mb-3 row">
                      <label for="upd_name" class="col-sm-4 text-end control-label col-form-label">Nombre*</label>
                      <div class="col-sm-8">
                        <input type="text" id="upd_name" name="upd_name" class="upd_name form-control" placeholder="Nombre">
                        <input type="hidden" id="upd_codex" name="upd_codex" class="upd_codex form-control" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="upd_firtsname" class="col-sm-4 text-end control-label col-form-label">Apellido(s)*</label>
                      <div class="col-sm-8">
                        <input type="text" id="upd_firtsname" name="upd_firtsname" class="upd_firtsname form-control" placeholder="Apellido(s)">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="upd_email" class="col-sm-4 text-end control-label col-form-label">Correo electrónico*</label>
                      <div class="col-sm-8">
                        <input type="email" id="upd_email" name="upd_email" class="upd_email form-control" placeholder="email">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="upd_password" class="col-sm-4 text-end control-label col-form-label">Contraseña*</label>
                      <div class="col-sm-8">
                        <input type="password" id="upd_password" name="upd_password" class="upd_password form-control" placeholder="Contraseña">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="upd_status" class="col-sm-4 text-end control-label col-form-label">Estatus*</label>
                      <div class="col-sm-8">
                        <select id="upd_status" name="upd_status" class="upd_status form-select form-control">
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
                      <button type="submit" class="btn_admin btn btn-info btn-block rounded-pill px-4 waves-effect waves-light">
                        Actualizar
                      </button>

                    </div>
                  </div>

                </form>
              <?php
              }
              if ($_SESSION["type_user"] == "CONSULT") {
              ?>

                <script>
                  $(document).ready(function() {
                    $("#formUpdate").submit(function(e) {
                      e.preventDefault();
                      jQuery.ajax({
                        url: atob(ajax_auth_object.routeLinkC),
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
                        },
                        error: function(xhr, textStatus, errorThrown) {
                          //called when there is an error
                          console.log('error: ' + JSON.stringify(xhr));
                        }
                      });

                    });
                  });
                </script>

                <form id="formUpdate" action="#" method="post">

                  <fieldset>

                    <div class="mb-3 row">
                      <label for="upd_email" class="col-sm-4 text-end control-label col-form-label">Correo electrónico*</label>
                      <div class="col-sm-8">
                        <input type="email" id="upd_email" name="upd_email" class="upd_email form-control" placeholder="email">
                        <input type="hidden" id="upd_codex" name="upd_codex" class="upd_codex form-control" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="upd_matricula" class="col-sm-4 text-end control-label col-form-label">Matrícula*</label>
                      <div class="col-sm-8">
                        <input type="text" id="upd_matricula" name="upd_matricula" class="upd_matricula form-control" placeholder="Matrícula">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <label for="upd_name" class="col-sm-4 text-end control-label col-form-label">Nombre*</label>
                      <div class="col-sm-8">
                        <input type="text" id="upd_name" name="upd_name" class="upd_name form-control" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="upd_firtsname" class="col-sm-4 text-end control-label col-form-label">Apellido(s)*</label>
                      <div class="col-sm-8">
                        <input type="text" id="upd_firtsname" name="upd_firtsname" class="upd_firtsname form-control" placeholder="Apellido(s)">
                      </div>
                    </div>

                    <div class="mb-3 row">
                      <label for="upd_status" class="col-sm-4 text-end control-label col-form-label">Estatus*</label>
                      <div class="col-sm-8">
                        <select id="upd_status" name="upd_status" class="upd_status form-control form-select">
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
                      <button type="submit" class="btn_consult btn btn-info rounded-pill px-4 waves-effect waves-light">
                        Actualizar
                      </button>

                    </div>
                  </div>
                </form>

              <?php
              }
              ?>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Column -->
  </div>
  <!-- Row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>
<!-- -------------------------------------------------------------- -->