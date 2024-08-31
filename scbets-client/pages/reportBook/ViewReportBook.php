<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Reportes</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Reportes de libros</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
           
        </div>
    </div>
</div>

<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJTZXR0aW5nLnBocA==",
        "loadingmessage": "Sending user info, please wait...",
        "ajaxListSta": "VG90YWxFamVtcGxhclN0YXR1cw==",
        "ajaxjsn": "SnNvbg==",
    };
    $(document).ready(function() {

        jQuery.ajax({
            url: atob(ajax_auth_object.routeLink),
            type: 'post',
            dataType: 'json',
            data: 'scbets_action=' + ajax_auth_object.ajaxListSta,
            complete: function(xhr, textStatus) {
                //called when complete
                console.log('complete: ' + (xhr));
            },
            success: function(data, textStatus, xhr) {
                //called when successful
                console.log('success: ' + (data));
                $("#data-content").html("");
                
                if (data != []) {
                    $("#data-table").DataTable({
                        data: data,

                        columns: [{
                                "data": "Ejemplar"
                            },
                            {
                                "data": "Activos",
                                "className": "text-center",
                            },
                            {
                                "data": "Suspendidos",
                                "className": "text-center",
                            },
                            {
                                "data": "Bajas",
                                "className": "text-center",
                            }
                        ],
                        "paging": false,
                        "searching": false
                    });
                    setNotify('success', data.messages, 'right');
                } else {
                    setNotify('warning', data.messages, 'right');
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                console.log('error: ' + (xhr));
            }
        });
    });
</script>


<div class="container-fluid">
    <!-- -------------------------------------------------------------- -->
    <!-- Start Page Content -->
    <!-- -------------------------------------------------------------- -->
    <!-- basic table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Reporte</h4>
                    <div class="table-responsive">
                        <table id="data-table" class="table table-hover table-striped table-sm mb-0 display nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Elemplares</th>
                                    <th class="text-center">Activos</th>
                                    <th class="text-center">Suspendidos</th>
                                    <th class="text-center">Bajas</th>
                                </tr>
                            </thead>
                            <tbody id="data-content">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>