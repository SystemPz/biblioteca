<?php
ob_start();
session_start();
require_once './scbets-server/ControllerModel.php/ControllerModel.php';
$con = new DataBase();
if ($con->getConexion() != true) {
  //header("Location: error/inic.error.php");
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Biblioteca Escolar de la ETS.</title>

  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/logo.svg" />
  <link rel="stylesheet" href="./assets/apexcharts/apexcharts.css" />

  <!-- Custom CSS -->

  <link href="./assets/css/style.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/font-awesome/css/all.min.css" />
  <link rel="stylesheet" href="./assets/themify-icons/themify-icons.css" />
  <link rel="stylesheet" href="./assets/materialdesign/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="./assets/dataTable/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="./assets//css/jquery.steps.css">
  <link rel="stylesheet" href="./assets/css/steps.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="./assets/js/jquery.min.js"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="./assets/js/bootstrap.bundle.min.js"></script>

  <!--<script src="./assets/jQuery/jquery.ui.touch-punch-improved.js"></script>
  <script src="./assets/jQuery/jquery-ui.min.js"></script>-->
  <!-- apps -->
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/js/app.init.js"></script>
  <script src="./assets/js/app-style-switcher.js"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="./assets/js/perfect-scrollbar.jquery.min.js"></script>
  <script src="./assets/js/sparkline.js"></script>
  <!--Wave Effects -->
  <script src="./assets/js/waves.js"></script>
  <!--Menu sidebar -->
  <script src="./assets/js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="./assets/js/feather.min.js"></script>
  <script src="./assets/js/custom.min.js"></script>
  <!--This page JavaScript -->
  <script src="./assets/jQuery/quill.min.js"></script>
  <script src="./assets/apexcharts/apexcharts.min.js"></script>

  <script src="./assets/code/highcharts.js"></script>
  <script src="./assets/code/highcharts-3d.js"></script>
  <script src="./assets/code/modules/exporting.js"></script>
  <script src="./assets/code/modules/export-data.js"></script>
  <script src="./assets/code/modules/accessibility.js"></script>
  <!-- Chart JS -->

  <script src="./assets/Xlsx/xlsx.full.min.js"></script>


  <script src="./assets/dataTable/jQuery/jquery.dataTables.min.js"></script>
  <script src="./assets/dataTable/js/dataTables.bootstrap4.min.js"></script>

  <script src="./assets/js/jquery.steps.min.js"></script>
  <script src="./assets/js/jquery.validate.min.js"></script>

  <script src="./assets/js/jquery.PrintArea.js"></script>




  <script src="./assets/notify/bootstrap-notify.min.js"></script>
  <script>
    let ajax_react_data_session = "U2Vzc2lvbkRhdGFTZXQ=";

    function setNotify(success, messages, posicion) {
      if (success == 'success') icon = 'fa-solid fa-check-double mr-2';
      if (success == 'info') icon = 'fa-solid fa-circle-info mr-2';
      if (success == 'danger') icon = 'fa-solid fa-bug mr-2';
      if (success == 'warning') icon = 'fa-solid fa-triangle-exclamation mr-2';
      $.notify({
        // options
        icon: icon,
        title: 'Aviso: ',
        message: messages,
        //url: 'https://github.com/mouse0270/bootstrap-notify',
        target: '_blank'
      }, {
        // settings
        element: 'body',
        position: null,
        type: success,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
          from: "bottom",
          align: posicion
        },
        offset: 50,
        spacing: 10,
        z_index: 3000,
        delay: 5000,
        timer: 2000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
          '<button type="button" class="btn-close" data-notify="dismiss" aria-label="Close"></button>' +
          '<span data-notify="icon"></span> ' +
          '<span data-notify="title">{1}</span> ' +
          '<span data-notify="message">{2}</span>' +
          '<div class="progress" data-notify="progressbar">' +
          '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
          '</div>' +
          '<a href="{3}" target="{4}" data-notify="url"></a>' +
          '</div>'
      });
    }

    $(document).ready(function() {
      let data = JSON.parse(localStorage.getItem('user'));
      if ((data) != {}) {
        getDataUser(data.codex, data.type_user);
      }
    });

    function getDataUser(codex, type) {
      $.ajax({
        type: "POST",
        url: "./scbets-server/ControllerUserSession.php",
        data: {
          stmt_action: ajax_react_data_session,
          txt_codex: codex,
          type_user: type,
        },
        dataType: "json",
        success: function(response) {
          if (atob(type) == "ADMIN") {
            $(".user-sesion").html(atob(response.data[0]._cresx));
            $(".user-name").html(atob(response.data[0]._gresx) + ' ' + atob(response.data[0]._hresx));
            $(".user-email").html(atob(response.data[0]._dresx));

            $('.upd_name').val(atob(response.data[0]._gresx));
            $('.upd_firtsname').val(atob(response.data[0]._hresx));
            $('.upd_email').val(atob(response.data[0]._dresx));
            $('.upd_password').val(atob(response.data[0]._fresx));
            $('.upd_status').val(atob(response.data[0]._iresx));
            $('.upd_codex').val((response.data[0]._aresx));
          } else if (atob(type) == "CONSULT") {
            $(".user-sesion").html(atob(response.data[0]._dresx));
            $(".user-name").html(atob(response.data[0]._fresx) + ' ' + atob(response.data[0]._gresx));
            $(".user-email").html(atob(response.data[0]._hresx));

            $('.upd_matricula').val(atob(response.data[0]._dresx));
            $('.upd_matricula').prop('disabled', true);

            $('.upd_email').val(atob(response.data[0]._hresx));
            $('.upd_email').prop('disabled', true);

            $('.upd_name').val(atob(response.data[0]._fresx));
            $('.upd_name').prop('disabled', true);

            $('.upd_firtsname').val(atob(response.data[0]._gresx));
            $('.upd_firtsname').prop('disabled', true);

            $('.upd_status').val(atob(response.data[0]._iresx));
            $('.upd_status').prop('disabled', true);

            $('.upd_codex').val((response.data[0]._aresx));

            $('.btn_consult').attr('disabled', true);

          }

        }
      });
    }

    function getDateHoy() {
      let fecha_string;
      const date = new Date();
      fecha_string = ((date.getDate() < 10 ? '0' + date.getDate() : date.getDate()) + '_' + ((date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + '_' + date.getFullYear() + '_' + (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + '_' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + '_' + (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds()));
      return fecha_string;
    }

    function startTime() {
      var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
      const date = new Date();

      $(".time").html(date.toLocaleTimeString());
      $(".fecha").html(date.getDate() + " de " + meses[date.getMonth()] + " de " + date.getFullYear());
      $(".date").html(date.toLocaleDateString());
      setTimeout(function() {
        startTime();
      }, 1000);
      $(".code").html((date.getDate() < 10 ? '0' + date.getDate() : date.getDate()) + '' + ((date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + '' + date.getFullYear() + '-' + (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + '' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + '' + (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds()));
      $("#input_code").val((date.getDate() < 10 ? '0' + date.getDate() : date.getDate()) + '' + ((date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)) + '' + date.getFullYear() + '-' + (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + '' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + '' + (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds()));
    }
  </script>
</head>

<body onload="startTime()">
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#1e88e5" stroke-width="2"></path>
      <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#1e88e5" stroke-width="2"></path>
      <path id="teabag" fill="#1e88e5" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
      <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#1e88e5"></path>
      <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#1e88e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <?php
    if ($con->getConexion() != true) {
      //header("Location: error/inic.error.php");
    } else {

      if (isset($_SESSION['user_session']) != null || isset($_SESSION['user_session']) != "") {

    ?>
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
          <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
              <!-- This is for the sidebar toggle which is visible on mobile only -->
              <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="#">
                <i class="ti-menu ti-close"></i>
              </a>
              <!-- ============================================================== -->
              <!-- Logo -->
              <!-- ============================================================== -->
              <a class="navbar-brand" href="?scbets">
                <!-- Logo icon -->
                <b class="logo-icon">
                  <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                  <!-- Dark Logo icon -->
                  <img src="./assets/images/logo-text.svg" alt="homepage" class="dark-logo" />
                  <!-- Light Logo icon -->
                  <img src="./assets/images/logo-light-icon.svg" alt="homepage" class="light-logo" width="50" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                  <!-- dark Logo text -->
                  <img src="./assets/images/logo-text.svg" alt="homepage" class="dark-logo" />
                  <!-- Light Logo text -->
                  <img src="./assets/images/logo-light-text.svg" class="light-logo" alt="homepage" />
                </span>
              </a>
              <!-- ============================================================== -->
              <!-- End Logo -->
              <!-- ============================================================== -->
              <!-- ============================================================== -->
              <!-- Toggle which is visible on mobile only -->
              <!-- ============================================================== -->
              <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
              </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
              <!-- ============================================================== -->
              <!-- toggle and nav items -->
              <!-- ============================================================== -->
              <ul class="navbar-nav me-auto">
                <!-- This is  -->
                <li class="nav-item">
                  <a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark" href="javascript:void(0)">
                    <i class="ti-menu"></i>
                  </a>
                </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Mega Menu -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown mega-dropdown">
                  <!--<a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-view-grid"></i></a>-->
                  <div class="dropdown-menu dropdown-menu-animate-up">
                    <div class="mega-dropdown-menu row">
                      <div class="col-lg-3 col-xl-2 mb-4">
                        <h4 class="mb-3">CAROUSEL</h4>
                        <!-- CAROUSEL -->
                        <div id="carouselExampleControls" class="carousel slide carousel-dark" data-bs-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item active">
                              <img class="d-block img-fluid" src="./assets/images/big/img1.jpeg" alt="First slide" />
                            </div>
                            <div class="carousel-item">
                              <img class="d-block img-fluid" src="./assets/images/big/img2.jpeg" alt="Second slide" />
                            </div>
                            <div class="carousel-item">
                              <img class="d-block img-fluid" src="./assets/images/big/img3.jpeg" alt="Third slide" />
                            </div>
                          </div>
                          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                          </a>
                        </div>
                        <!-- End CAROUSEL -->
                      </div>
                      <div class="col-lg-3 mb-4">
                        <h4 class="mb-3">ACCORDION <?php echo $_SESSION['user_session']; ?></h4>
                        <!-- Accordian -->
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Accordion Item #1
                              </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                              <div class="accordion-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod
                                high life accusamus terry richardson ad squid.
                              </div>
                            </div>
                          </div>
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Accordion Item #2
                              </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                              <div class="accordion-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod
                                high life accusamus terry richardson ad squid.
                              </div>
                            </div>
                          </div>
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Accordion Item #3
                              </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                              <div class="accordion-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod
                                high life accusamus terry richardson ad squid.
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 mb-4">
                        <h4 class="mb-3">CONTACT US</h4>
                        <!-- Contact -->
                        <form>
                          <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name" />
                            <label>Enter Name</label>
                          </div>
                          <div class="mb-3 form-floating">
                            <input type="email" class="form-control" placeholder="Enter email" />
                            <label>Enter Email address</label>
                          </div>
                          <div class="mb-3 form-floating">
                            <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                            <label>Enter Message</label>
                          </div>
                          <button type="submit" class="btn px-4 rounded-pill btn-info">
                            Submit
                          </button>
                        </form>
                      </div>
                      <div class="col-lg-3 col-xlg-4 mb-4">
                        <h4 class="mb-3">List style</h4>
                        <!-- List style -->
                        <ul class="list-style-none">
                          <li>
                            <a href="#" class="font-weight-medium"><i data-feather="check-circle" class="feather-sm text-success me-2"></i>
                              You can give link</a>
                          </li>
                          <li>
                            <a href="#" class="font-weight-medium"><i data-feather="check-circle" class="feather-sm text-success me-2"></i>
                              Give link</a>
                          </li>
                          <li>
                            <a href="#" class="font-weight-medium"><i data-feather="check-circle" class="feather-sm text-success me-2"></i>
                              Another Give link</a>
                          </li>
                          <li>
                            <a href="#" class="font-weight-medium"><i data-feather="check-circle" class="feather-sm text-success me-2"></i>
                              Forth link</a>
                          </li>
                          <li>
                            <a href="#" class="font-weight-medium"><i data-feather="check-circle" class="feather-sm text-success me-2"></i>
                              Another fifth link</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Mega Menu -->
                <!-- ============================================================== -->
              </ul>
              <!-- ============================================================== -->
              <!-- Right side toggle and nav items -->
              <!-- ============================================================== -->
              <ul class="navbar-nav">


                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!--<img src="./assets/images/users/1.jpeg" alt="user" width="30" class="profile-pic rounded-circle" />-->
                    <div class="d-flex no-block align-items-center p-1 text-white mb-0">
                      <div class="">
                        <img src="./assets/images/users/profile.svg" alt="user" width="30" class="profile-pic rounded-circle" />
                      </div>
                      <div class="ms-2">
                        <h5 class="mb-0 text-white"><span class="user-email"></span></h5>
                      </div>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                    <div class="d-flex no-block align-items-center p-3 bg-dark text-white mb-2">
                      <div class="">
                        <img src="./assets/images/users/profile.svg" alt="user" class="rounded-circle" width="60" />
                      </div>
                      <div class="ms-2">
                        <h5 class="mb-0 text-white"><span class="user-name"></span></h5>
                        <p class="mb-0"><span class="user-email"></span></p>
                      </div>
                    </div>
                    <a class="dropdown-item" href="?scbets-profile">
                      <i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>
                      Mi Perfil
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?scbets-reports">
                      <i data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                      Configuraciones
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php?logout=true">
                      <i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i>
                      Cerrar Sesión
                    </a>
                    <div class="dropdown-divider"></div>
                    <div class="pl-4 p-2">
                      <a href="?scbets-profile" class="btn d-block w-100 btn-dark rounded-pill">Vista Perfil</a>
                    </div>
                  </div>
                </li>
                <!-- ============================================================== -->
                <!-- Language -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">

                </li>
              </ul>
            </div>
          </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
          <!-- Sidebar scroll-->
          <div class="scroll-sidebar">
            <!-- User profile -->
            <div class="user-profile position-relative" style="
              background: url(./assets/images/background/user-info.svg)
                no-repeat;
            ">
              <!-- User profile image -->
              <div class="profile-img">
                <img src="./assets/images/users/profile.svg" alt="user" class="w-100" />
              </div>
              <!-- User profile text-->
              <div class="profile-text pt-1 dropdown">
                <a href="#" class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><span class="user-name"></span></a>
                <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="?scbets-profile"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>
                    Mi Perfil</a>

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#"><i data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                    Configuración
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php?logout=true"><i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i>
                    Cerrar sesión</a>
                  <div class="dropdown-divider"></div>
                  <div class="ps-4 p-2">
                    <a href="?scbets-profile" class="btn d-block w-100 btn-info rounded-pill">Vista Perfil</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- End User profile text-->
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
              <ul id="sidebarnav">
                <li class="nav-small-cap">
                  <i class="mdi mdi-dots-horizontal"></i>
                  <span class="hide-menu">Administración</span>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                    <i class="mdi mdi-gauge"></i>
                    <span class="hide-menu">Panel de control </span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="?scbets-inicio=" class="sidebar-link">
                        <i class="mdi mdi-adjust"></i>
                        <span class="hide-menu"> Inicio </span>
                      </a>
                    </li>
                  </ul>
                </li>
                <?php
                if (($_SESSION["type_user"]) == "CONSULT") {
                ?>
                  <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                      <i class="mdi mdi-gauge"></i>
                      <span class="hide-menu">Operaciones</span> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="?scbets-search=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Busqueda </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-history=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Historial </span>
                        </a>
                      </li>
                    </ul>
                  </li>


                <?php
                }
                if (($_SESSION["type_user"]) == "ADMIN") {
                ?>
                  <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                      <i class="mdi mdi-account-multiple"></i>
                      <span class="hide-menu">Control usuarios </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">

                      <li class="sidebar-item">
                        <a href="?scbets-lista-usuarios=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Lista de usuarios</span>
                        </a>
                      </li>

                      <li class="sidebar-item">
                        <a href="?scbets-lista-consultores=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Lista de consultor </span>
                        </a>
                      </li>


                    </ul>
                  </li>

                  <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Datos auxiliares</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                      <i class="mdi mdi-arrange-bring-to-front"></i>
                      <span class="hide-menu">Asignación </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="?scbets-categorias=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Categorias </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-ubicaciones=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Ubicaciones </span>
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Ejemplares</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                      <i class="mdi mdi-file-multiple"></i>
                      <span class="hide-menu">Documentos </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                      <li class="sidebar-item">
                        <a href="?scbets-libros=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Libros </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-recepcionales=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Documentos recepcionales </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-enciclopedias=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Enciclopedias </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-engargolados=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Engargolados </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-revistas=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Revistas </span>
                        </a>
                      </li>
                      <li class="sidebar-item">
                        <a href="?scbets-otros=" class="sidebar-link">
                          <i class="mdi mdi-adjust"></i>
                          <span class="hide-menu"> Otros </span>
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Transacciones</span>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="?scbets-prestamos=" aria-expanded="false">
                      <i class="mdi mdi-shuffle-variant"></i>
                      <span class="hide-menu">Prestamos</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="?scbets-devoluciones=" aria-expanded="false">
                      <i class="mdi mdi-clipboard-flow"></i>
                      <span class="hide-menu">Devoluciones</span></a>
                  </li>

                  <li class="sidebar-item">
                    <a href="?scbets-history=" class="sidebar-link">
                      <i class="mdi mdi-format-list-bulleted-type"></i>
                      <span class="hide-menu"> Historial </span>
                    </a>
                  </li>

                <?php
                }
                ?>

              </ul>
            </nav>
            <!-- End Sidebar navigation -->
          </div>
          <!-- End Sidebar scroll-->
          <!-- Bottom points-->
          <div class="sidebar-footer">
            <!-- item-->
            <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Settings"><i class="ti-settings"></i></a>
            <!-- item-->
            <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Email"><i class="mdi mdi-gmail"></i></a>
            <!-- item-->
            <a href="logout.php?logout=true" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout"><i class="mdi mdi-power"></i></a>
          </div>
          <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
          <!-- ============================================================== -->
          <!-- Bread crumb and right sidebar toggle -->
          <!-- ============================================================== -->
          <?php
          if (($_SESSION['type_user']) == 'ADMIN') {
            if (isset($_GET['scbets-lista-usuarios'])) {
              require_once './scbets-client/pages/usuarios/ViewUsuarios.php';
            } else if (isset($_GET['scbets-lista-consultores'])) {
              require_once './scbets-client/pages/consultor/ViewConsultor.php';
            } else if (isset($_GET['scbets-categorias'])) {
              require_once './scbets-client/pages/categorias/ViewCategorias.php';
            } else if (isset($_GET['scbets-ubicaciones'])) {
              require_once './scbets-client/pages/ubicaciones/ViewUbicaciones.php';
            } else if (isset($_GET['scbets-libros'])) {
              require_once './scbets-client/pages/libros/ViewLibros.php';
            } else if (isset($_GET['scbets-recepcionales'])) {
              require_once './scbets-client/pages/documentosRecepcionales/ViewDocRecepcionales.php';
            } else if (isset($_GET['scbets-enciclopedias'])) {
              require_once './scbets-client/pages/enciclopedias/ViewEnciclopedias.php';
            } else if (isset($_GET['scbets-engargolados'])) {
              require_once './scbets-client/pages/engargolados/ViewEngargolados.php';
            } else if (isset($_GET['scbets-revistas'])) {
              require_once './scbets-client/pages/revistas/ViewRevistas.php';
            } elseif (isset($_GET['scbets-otros'])) {
              require_once './scbets-client/pages/otros/ViewOtros.php';
            } else if (isset($_GET['scbets-prestamos'])) {
              require_once './scbets-client/pages/prestamos/ViewPrestamos.php';
            } else if (isset($_GET['scbets-devoluciones'])) {
              require_once './scbets-client/pages/devolucion/ViewDevoluciones.php';
            } elseif (isset($_GET['scbets-profile'])) {
              require_once './scbets-client/pages/perfil/ViewPerfil.php';
            } elseif (isset($_GET['scbets-history'])) {
              require_once './scbets-client/pages/historico/ViewHistoricoUser.php';
            } elseif(isset($_GET['scbets-reports'])) {
              require_once './scbets-client/pages/reportBook/ViewReportBook.php';
            } else {
              require_once './scbets-client/pages/home/ViewHome.php';
            }
          }
          if (($_SESSION["type_user"]) == "CONSULT") {
            if (isset($_GET['scbets-search'])) {
              require_once './scbets-client/pages/consultor/ViewSearch.php';
            } elseif (isset($_GET['scbets-profile'])) {
              require_once './scbets-client/pages/perfil/ViewPerfil.php';
            } elseif (isset($_GET['scbets-history'])) {
              require_once './scbets-client/pages/consultor/ViewHistorico.php';
            } else {
              require_once './scbets-client/pages/home/ViewHomeConsult.php';
            }
          }
          ?>
          <!-- ============================================================== -->
          <!-- End Bread crumb and right sidebar toggle -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Container fluid  -->
          <!-- ============================================================== -->

          <!-- ============================================================== -->
          <!-- End Container fluid  -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- footer -->
          <!-- ============================================================== -->
          <footer class="footer justify-center">
            Escuela de Trabajo Social, Zacatecas.
          </footer>
          <!-- ============================================================== -->
          <!-- End footer -->
          <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    <?php
      } else {
        require_once './scbets-client/pages/login/SignIn.php';
      }
    }
    ?>
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- customizer Panel -->
  <!-- ============================================================== -->
  <!--<aside class="customizer">
    <a href="javascript:void(0)" class="service-panel-toggle"><i class="fa fa-spin fa-cog"></i></a>
    <div class="customizer-body">
      <ul class="nav customizer-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><i class="mdi mdi-wrench fs-6"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#chat" role="tab" aria-controls="chat" aria-selected="false"><i class="mdi mdi-message-reply fs-6"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="mdi mdi-star-circle fs-6"></i></a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <div class="p-3 border-bottom">

            <h5 class="font-weight-medium mb-2 mt-2">Layout Settings</h5>
            <div class="form-check mt-3">
              <input type="checkbox" name="theme-view" class="form-check-input" id="theme-view" />
              <label class="form-check-label" for="theme-view">
                <span>Dark Theme</span>
              </label>
            </div>
            <div class="form-check mt-2">
              <input type="checkbox" class="sidebartoggler form-check-input" name="collapssidebar" id="collapssidebar" />
              <label class="form-check-label" for="collapssidebar">
                <span>Collapse Sidebar</span>
              </label>
            </div>
            <div class="form-check mt-2">
              <input type="checkbox" name="sidebar-position" class="form-check-input" id="sidebar-position" />
              <label class="form-check-label" for="sidebar-position">
                <span>Fixed Sidebar</span>
              </label>
            </div>
            <div class="form-check mt-2">
              <input type="checkbox" name="header-position" class="form-check-input" id="header-position" />
              <label class="form-check-label" for="header-position">
                <span>Fixed Header</span>
              </label>
            </div>
            <div class="form-check mt-2">
              <input type="checkbox" name="boxed-layout" class="form-check-input" id="boxed-layout" />
              <label class="form-check-label" for="boxed-layout">
                <span>Boxed Layout</span>
              </label>
            </div>
          </div>
          <div class="p-3 border-bottom">

            <h5 class="font-weight-medium mb-2 mt-2">Logo Backgrounds</h5>
            <ul class="theme-color m-0 p-0">
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin1"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin2"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin3"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin4"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin5"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin6"></a>
              </li>
            </ul>

          </div>
          <div class="p-3 border-bottom">

            <h5 class="font-weight-medium mb-2 mt-2">Navbar Backgrounds</h5>
            <ul class="theme-color m-0 p-0">
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin1"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin2"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin3"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin4"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin5"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin6"></a>
              </li>
            </ul>

          </div>
          <div class="p-3 border-bottom">

            <h5 class="font-weight-medium mb-2 mt-2">Sidebar Backgrounds</h5>
            <ul class="theme-color m-0 p-0">
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin1"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin2"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin3"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin4"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin5"></a>
              </li>
              <li class="theme-item list-inline-item me-1">
                <a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin6"></a>
              </li>
            </ul>

          </div>
        </div>
     
        <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="pills-profile-tab">
          <ul class="mailbox list-style-none mt-3">
            <li>
              <div class="message-center chat-scroll position-relative">
                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_1" data-user-id="1">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/1.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle online"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Pavan kumar</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:30 AM</span>
                  </div>
                </a>

                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_2" data-user-id="2">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/2.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle busy"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Sonu Nigam</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">I've sung a song! See you at</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:10 AM</span>
                  </div>
                </a>

                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_3" data-user-id="3">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/3.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle away"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Arijit Sinh</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">I am a singer!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:08 AM</span>
                  </div>
                </a>

                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_4" data-user-id="4">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/4.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle offline"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Nirav Joshi</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:02 AM</span>
                  </div>
                </a>
              
                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_5" data-user-id="5">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/5.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle offline"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Sunil Joshi</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:02 AM</span>
                  </div>
                </a>
                
                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_6" data-user-id="6">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/6.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle offline"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Akshay Kumar</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:02 AM</span>
                  </div>
                </a>
                
                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_7" data-user-id="7">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/7.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle offline"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Pavan kumar</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:02 AM</span>
                  </div>
                </a>
                
                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id="chat_user_8" data-user-id="8">
                  <span class="user-img position-relative d-inline-block">
                    <img src="./assets/images/users/8.jpeg" alt="user" class="rounded-circle w-100" />
                    <span class="profile-status rounded-circle offline"></span>
                  </span>
                  <div class="w-75 d-inline-block v-middle ps-3">
                    <h5 class="message-title mb-0 mt-1">Varun Dhavan</h5>
                    <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                    <span class="fs-2 text-nowrap d-block text-muted">9:02 AM</span>
                  </div>
                </a>

              </div>
            </li>
          </ul>
        </div>
       
        <div class="tab-pane fade p-3" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
          <h6 class="mt-3 mb-3">Activity Timeline</h6>
          <div class="steamline">
            <div class="sl-item">
              <div class="sl-left bg-light-success text-success">
                <i data-feather="user" class="feather-sm fill-white"></i>
              </div>
              <div class="sl-right">
                <div class="font-weight-medium">
                  Meeting today <span class="sl-date"> 5pm</span>
                </div>
                <div class="desc">you can write anything</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left bg-light-info text-info">
                <i data-feather="camera" class="feather-sm fill-white"></i>
              </div>
              <div class="sl-right">
                <div class="font-weight-medium">Send documents to Clark</div>
                <div class="desc">Lorem Ipsum is simply</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left">
                <img class="rounded-circle" alt="user" src="./assets/images/users/2.jpeg" />
              </div>
              <div class="sl-right">
                <div class="font-weight-medium">
                  Go to the Doctor <span class="sl-date">5 minutes ago</span>
                </div>
                <div class="desc">Contrary to popular belief</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left">
                <img class="rounded-circle" alt="user" src="./assets/images/users/1.jpeg" />
              </div>
              <div class="sl-right">
                <div>
                  <a href="javascript:void(0)">Stephen</a>
                  <span class="sl-date">5 minutes ago</span>
                </div>
                <div class="desc">Approve meeting with tiger</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left bg-light-primary text-primary">
                <i data-feather="user" class="feather-sm fill-white"></i>
              </div>
              <div class="sl-right">
                <div class="font-weight-medium">
                  Meeting today <span class="sl-date"> 5pm</span>
                </div>
                <div class="desc">you can write anything</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left bg-light-info text-info">
                <i data-feather="send" class="feather-sm fill-white"></i>
              </div>
              <div class="sl-right">
                <div class="font-weight-medium">Send documents to Clark</div>
                <div class="desc">Lorem Ipsum is simply</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left">
                <img class="rounded-circle" alt="user" src="./assets/images/users/4.jpeg" />
              </div>
              <div class="sl-right">
                <div class="font-weight-medium">
                  Go to the Doctor <span class="sl-date">5 minutes ago</span>
                </div>
                <div class="desc">Contrary to popular belief</div>
              </div>
            </div>
            <div class="sl-item">
              <div class="sl-left">
                <img class="rounded-circle" alt="user" src="./assets/images/users/6.jpeg" />
              </div>
              <div class="sl-right">
                <div>
                  <a href="javascript:void(0)">Stephen</a>
                  <span class="sl-date">5 minutes ago</span>
                </div>
                <div class="desc">Approve meeting with tiger</div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </aside>-->

  <div class="chat-windows"></div>
</body>

</html>