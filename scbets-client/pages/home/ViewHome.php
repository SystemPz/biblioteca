<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Panel de Control</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Panel de control</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">

    </div>
</div>

<script>
    const ajax_auth_object = {
        "ajaxurl": "",
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJTZXR0aW5nLnBocA==",
        "loadingmessage": "Sending user info, please wait...",
        "ajaxGlobal": "VG90YWxFamVtcGxhcmVz",
        "ajaxUsers": "VG90YWxVc2Vycw==",
        "ajaxConsul": "VG90YWxDb25zdWx0cw==",
        "ajaxProcess": "UHJlY2Vzc1JlYWRTdHVkZW50cw==",
    };
    $(document).ready(function() {
        let globalBook = function getTotalBook() {
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: ajax_auth_object.ajaxGlobal
                },
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + xhr);
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('success: ' + data);
                    if (data != null || data != {}) {
                        var option_Our_Visitors = {
                            series: [data.totalLibros, data.totalDocumentos, data.totalEnciclopedias, data.totalEngargolados, data.totalRevistas, data.totalOtros],
                            labels: ["Libros", "DocRecepción", "Enciclopedias", "Engargolados", "Revistas", "Otros"],
                            chart: {
                                type: "donut",
                                height: 250,
                                fontFamily: "Poppins,sans-serif",
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                width: 0,
                            },
                            plotOptions: {
                                pie: {
                                    expandOnClick: true,
                                    donut: {
                                        size: "83",
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                offsetY: 7,
                                            },
                                            value: {
                                                show: false,
                                            },
                                            total: {
                                                show: true,
                                                color: "#a1aab2",
                                                fontSize: "13px",
                                                label: "Ejemplares",
                                            },
                                        },
                                    },
                                },
                            },
                            colors: ["#1e88e5", "#26c6da", "#e75c62", "#745af2", "#3dcd8b", "#eceff1"],
                            tooltip: {
                                show: true,
                                fillSeriesColor: false,
                            },
                            legend: {
                                show: false,
                            },
                            responsive: [{
                                    breakpoint: 1025,
                                    options: {
                                        chart: {
                                            height: 270,
                                        },
                                    },
                                },
                                {
                                    breakpoint: 426,
                                    options: {
                                        chart: {
                                            height: 250,
                                        },
                                    },
                                },
                            ],
                        };

                        var chart_pie_donut = new ApexCharts(
                            document.querySelector("#our-visitors"),
                            option_Our_Visitors
                        );
                        chart_pie_donut.render();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + xhr);
                }
            });

        }
        globalBook();
        // -----------------------------------------------------------------------
        // Our visitor
        // -----------------------------------------------------------------------
        let globalPrestamo = function totalPrestamos() {
            jQuery.ajax({
                url: atob(ajax_auth_object.routeLink),
                type: 'POST',
                dataType: 'json',
                data: {
                    scbets_action: ajax_auth_object.ajaxProcess
                },
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + (xhr));
                },
                success: function(data, textStatus, xhr) {
                    console.log('success: ' + (data));
                    var options_Sales_Overview = {
                        series: [{
                            name: "Pixel ",
                            data: data.data,
                        }, ],
                        chart: {
                            fontFamily: "Poppins,sans-serif",
                            type: "bar",
                            height: 330,
                            offsetY: 10,
                            toolbar: {
                                show: false,
                            },
                        },
                        grid: {
                            show: true,
                            strokeDashArray: 3,
                            borderColor: "rgba(0,0,0,.1)",
                        },
                        colors: ["#1e88e5"],
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "30%",
                                endingShape: "flat",
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            show: true,
                            width: 5,
                            colors: ["transparent"],
                        },
                        xaxis: {
                            type: "category",
                            categories: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            labels: {
                                style: {
                                    colors: "#a1aab2",
                                },
                            },
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: "#a1aab2",
                                },
                            },
                        },
                        fill: {
                            opacity: 1,
                            colors: ["#21c1d6"],
                        },
                        tooltip: {
                            theme: "dark",
                        },
                        legend: {
                            show: false,
                        },
                        responsive: [{
                            breakpoint: 767,
                            options: {
                                stroke: {
                                    show: false,
                                    width: 5,
                                    colors: ["transparent"],
                                },
                            },
                        }, ],
                    };

                    var chart_column_basic = new ApexCharts(
                        document.querySelector("#sales-overview"),
                        options_Sales_Overview
                    );
                    chart_column_basic.render();
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + xhr);
                }
            });


        }
        globalPrestamo();

    });
</script>

<div class="container-fluid">
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-wrap">
                                <div>
                                    <h3 class="card-title">Lectura estadístico</h3>
                                    <h6 class="card-subtitle">
                                        Vista de lectura por mes </h6>
                                </div>
                                <div class="ms-auto">
                                    <ul class="list-inline">
                                        <li class="list-inline-item px-2">
                                            <h6 class="text-success">
                                                <i class="fa fa-circle font-10 me-2"></i>Lectura
                                            </h6>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="sales-overview" style="height: 360px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h3 class="card-title">Ejemplares</h3>
                    <h6 class="card-subtitle">Estadísticas de clasificaciones</h6>
                    <div id="our-visitors" class="mt-4"></div>
                </div>
                <div class="card-body text-center border-top">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item px-2">
                            <h6 class="text-info">
                                <i class="fa fa-circle font-10 me-2"></i>Libros
                            </h6>
                        </li>
                        <li class="list-inline-item px-2">
                            <h6 class="text-success">
                                <i class="fa fa-circle font-10 me-2"></i>DocRecepción
                            </h6>
                        </li>
                        <li class="list-inline-item px-2">
                            <h6 class="" style="color: #e75c62;">
                                <i class="fa fa-circle font-10 me-2"></i>Enciclopedia
                            </h6>
                        </li>
                        <li class="list-inline-item px-2">
                            <h6 class="text-primary">
                                <i class="fa fa-circle font-10 me-2"></i>Engargolados
                            </h6>
                        </li>
                        <li class="list-inline-item px-2">
                            <h6 class="" style="color: #3dcd8b;">
                                <i class="fa fa-circle font-10 me-2"></i>Revistas
                            </h6>
                        </li>
                        <li class="list-inline-item px-2">
                            <h6 class="" style="color: #eceff1;">
                                <i class="fa fa-circle font-10 me-2"></i>Otros
                            </h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h3 class="card-title">Usuarios</h3>
                    <h6 class="card-subtitle">Estadísticas de Usuarios</h6>
                    <script>
                        $(document).ready(function() {
                            const usersTotal = function totalUsers() {
                                jQuery.ajax({
                                    url: atob(ajax_auth_object.routeLink),
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        scbets_action: ajax_auth_object.ajaxUsers
                                    },
                                    complete: function(xhr, textStatus) {
                                        //called when complete
                                        console.log('complete: ' + xhr);
                                    },
                                    success: function(data, textStatus, xhr) {
                                        //called when successful
                                        console.log('success: ' + data);
                                        if (data != null || data != {}) {
                                            Highcharts.chart('container_users', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                colors: ["#21c1d6", "#ffb22b", "#fc4b6c", "#1e88e5", "#745af2", "#eceff1"],
                                                //colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
                                                //colors: ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'],
                                                title: {
                                                    text: 'estadística de usuarios'
                                                },
                                                xAxis: {
                                                    categories: ['Usuarios']
                                                },
                                                credits: {
                                                    enabled: false
                                                },
                                                series: [{
                                                    name: 'activos',
                                                    data: [data.totalA]
                                                }, {
                                                    name: 'suspendidos',
                                                    data: [data.totalS]
                                                }, {
                                                    name: 'bajas',
                                                    data: [data.totalB]
                                                }]
                                            });


                                            /*var options_Sales_Overview = {
                                                series: [{
                                                    data: [data.totalA, 0, 0]
                                                }, {
                                                    data: [0, data.totalS, 0]
                                                }, {
                                                    data: [0, 0, data.totalB]
                                                }],
                                                chart: {
                                                    fontFamily: "Poppins,sans-serif",
                                                    type: "bar",
                                                    height: 330,
                                                    offsetY: 10,
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                grid: {
                                                    show: true,
                                                    strokeDashArray: 3,
                                                    borderColor: "rgba(0,0,0,.1)",
                                                },
                                                colors: ["#1e88e5", "#ffb22b", "#fc4b6c", ],
                                                plotOptions: {
                                                    bar: {
                                                        horizontal: false,
                                                        columnWidth: "30%",
                                                        endingShape: "flat",
                                                    },
                                                },
                                                dataLabels: {
                                                    enabled: false,
                                                },
                                                stroke: {
                                                    show: true,
                                                    width: 5,
                                                    colors: ["transparent"],
                                                },
                                                xaxis: {
                                                    type: "category",
                                                    categories: ["Activos", "Suspendidos", "Bajas"],
                                                    axisTicks: {
                                                        show: false,
                                                    },
                                                    axisBorder: {
                                                        show: false,
                                                    },
                                                    labels: {
                                                        style: {
                                                            colors: "#a1aab2",
                                                        },
                                                    },
                                                },
                                                yaxis: {
                                                    labels: {
                                                        style: {
                                                            colors: "#a1aab2",
                                                        },
                                                    },
                                                    title: {
                                                        text: 'Totales'
                                                    }
                                                },
                                                fill: {
                                                    opacity: 1,
                                                    colors: ["#21c1d6"],
                                                },
                                                tooltip: {
                                                    theme: "dark",
                                                },
                                                legend: {
                                                    show: false,
                                                },
                                                responsive: [{
                                                    breakpoint: 767,
                                                    options: {
                                                        stroke: {
                                                            show: false,
                                                            width: 5,
                                                            colors: ["transparent"],
                                                        },
                                                    },
                                                }, ],
                                            };

                                            var chart_column_basic = new ApexCharts(
                                                document.querySelector("#container_users"),
                                                options_Sales_Overview
                                            );
                                            chart_column_basic.render();*/



                                        }
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        //called when there is an error
                                        console.log('error: ' + (xhr));
                                    }

                                });
                            }
                            usersTotal();


                        });
                    </script>
                    <div id="container_users" class="mt-4"></div>
                </div>
                <div class="card-body text-center border-top">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item px-2">
                            <h6 class="text-info">
                                <i class="fa fa-circle font-10 me-2"></i>Usuarios
                            </h6>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h3 class="card-title">Consultores</h3>
                    <h6 class="card-subtitle">Estadísticas de Consultores</h6>
                    <script>
                        $(document).ready(function() {
                            const conultTotal = function totalConsut() {
                                jQuery.ajax({
                                    url: atob(ajax_auth_object.routeLink),
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        scbets_action: ajax_auth_object.ajaxConsul
                                    },
                                    complete: function(xhr, textStatus) {
                                        //called when complete
                                        console.log('complete: ' + xhr);
                                    },
                                    success: function(data, textStatus, xhr) {
                                        //called when successful
                                        console.log('success: ' + data);
                                        if (data != null || data != {}) {
                                            Highcharts.chart('container_consultor', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                colors: ["#21c1d6", "#ffb22b", "#fc4b6c", "#1e88e5", "#745af2", "#eceff1"],
                                                //colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
                                                //colors: ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'],
                                                title: {
                                                    text: 'estadística de usuarios'
                                                },
                                                xAxis: {
                                                    categories: ['Usuarios']
                                                },
                                                credits: {
                                                    enabled: false
                                                },
                                                series: [{
                                                    name: 'activos',
                                                    data: [data.totalA]
                                                }, {
                                                    name: 'suspendidos',
                                                    data: [data.totalS]
                                                }, {
                                                    name: 'bajas',
                                                    data: [data.totalB]
                                                }]
                                            });

                                            /*var options_Sales_Overview_con = {
                                                series: [{
                                                    data: [data.totalA, 0, 0]
                                                }, {
                                                    data: [0, data.totalS, 0]
                                                }, {
                                                    data: [0, 0, data.totalB]
                                                }],
                                                chart: {
                                                    fontFamily: "Poppins,sans-serif",
                                                    type: "bar",
                                                    height: 330,
                                                    offsetY: 10,
                                                    toolbar: {
                                                        show: false,
                                                    },
                                                },
                                                grid: {
                                                    show: true,
                                                    strokeDashArray: 3,
                                                    borderColor: "rgba(0,0,0,.1)",
                                                },
                                                colors: ["#1e88e5", "#ffb22b", "#fc4b6c", ],
                                                plotOptions: {
                                                    bar: {
                                                        horizontal: false,
                                                        columnWidth: "30%",
                                                        endingShape: "flat",
                                                    },
                                                },
                                                dataLabels: {
                                                    enabled: false,
                                                },
                                                stroke: {
                                                    show: true,
                                                    width: 5,
                                                    colors: ["transparent"],
                                                },
                                                xaxis: {
                                                    type: "category",
                                                    categories: ["Activos", "Suspendidos", "Bajas"],
                                                    axisTicks: {
                                                        show: false,
                                                    },
                                                    axisBorder: {
                                                        show: false,
                                                    },
                                                    labels: {
                                                        style: {
                                                            colors: "#a1aab2",
                                                        },
                                                    },
                                                },
                                                yaxis: {
                                                    labels: {
                                                        style: {
                                                            colors: "#a1aab2",
                                                        },
                                                    },
                                                    title: {
                                                        text: 'Totales'
                                                    }
                                                },
                                                fill: {
                                                    opacity: 1,
                                                    colors: ["#21c1d6"],
                                                },
                                                tooltip: {
                                                    theme: "dark",
                                                },
                                                legend: {
                                                    show: false,
                                                },
                                                responsive: [{
                                                    breakpoint: 767,
                                                    options: {
                                                        stroke: {
                                                            show: false,
                                                            width: 5,
                                                            colors: ["transparent"],
                                                        },
                                                    },
                                                }, ],
                                            };

                                            var chart_column_basic_con = new ApexCharts(
                                                document.querySelector("#container_consultor"),
                                                options_Sales_Overview_con
                                            );
                                            chart_column_basic_con.render();*/

                                        }
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        //called when there is an error
                                        console.log('error: ' + JSON.stringify(xhr));
                                    }

                                });
                            }
                            conultTotal();
                        });
                    </script>
                    <div id="container_consultor" class="mt-4"></div>
                </div>
                <div class="card-body text-center border-top">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item px-2">
                            <h6 class="text-info">
                                <i class="fa fa-circle font-10 me-2"></i>Consultores
                            </h6>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script>
        const ajax_auth_objects = {
            "ajaxurl": "",
            "routeLinkTotal": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJTZXR0aW5nLnBocA==",
            "loadingmessage": "Sending user info, please wait...",
            "ajaxListSta": "VG90YWxFamVtcGxhclN0YXR1cw==",
            "ajaxCatSta": "Q2F0ZWdvcmlhVG90YWxCb29r",
            "ajaxTotalBook": "Q2F0ZWdvcmlhVG90YWxCb29r",
        };
        //alert(btoa('CategoriaTotalBook'))
        $(document).ready(function() {

            jQuery.ajax({
                url: atob(ajax_auth_objects.routeLinkTotal),
                type: 'post',
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_objects.ajaxListSta,
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + (xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('success: ' + (data));
                    if (data != []) {
                        let table = $("#data-table").DataTable({
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
                                },
                                {
                                    "data": null,
                                    "bSortable": false,
                                    "className": "text-center",
                                    "mRender": function(o) {
                                        return parseInt(o.Activos) + parseInt(o.Suspendidos) + parseInt(o.Bajas);
                                    }
                                },
                                {
                                    "defaultContent": "<button type='button' data-bs-toggle='modal' data-bs-target='#exportModal' class='form btn btn-primary btn-xs '> <span class='mdi mdi-cloud-download'></span></button>"
                                }

                            ],
                            "paging": false,
                            "searching": false,
                            "footerCallback": function(row, data, start, end, display) {
                                var api = this.api();

                                // Remove the formatting to get integer data for summation
                                var intVal = function(i) {
                                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                                };

                                // Total over all pages
                                var total = api
                                    .column(2)
                                    .data()
                                    .reduce(function(a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                // Total over this page
                                var pageTotalA = api.column(1, {
                                    page: 'current'
                                }).data().reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                // Total over this page
                                var pageTotalS = api.column(2, {
                                    page: 'current'
                                }).data().reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                // Total over this page
                                var pageTotalB = api.column(3, {
                                    page: 'current'
                                }).data().reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                // Update footer
                                //$(api.column(2).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');
                                $(api.column(1).footer()).html(pageTotalA);
                                $(api.column(2).footer()).html(pageTotalS);
                                $(api.column(3).footer()).html(pageTotalB);
                                $(api.column(4).footer()).html(pageTotalA + pageTotalS + pageTotalB);
                            },
                            "createdRow": function(row, data, index) {
                                $('td', row).eq(1).addClass('text-success h6');
                                $('td', row).eq(2).addClass('text-warning h6');
                                $('td', row).eq(3).addClass('text-danger h6');
                                $('td', row).eq(4).addClass('text-dark h6');

                            },
                        });

                        $('#data-table tbody').on('click', 'button.form', function() //Al hacer click sobre el boton button.form de la linea de arriba
                            {
                                var data_form = table.row($(this).parents("tr")).data();
                                $("#txt_type").val(data_form.type);
                                $("#content-report").html("");
                                $("#txt_typeName").html("");
                                $("#btn").html("");
                                let _type = "";
                                if (data_form.type == "LIB") {
                                    _type = "Libros";
                                    $("#content-report").load('./scbets-client/pages/home/_viewLib.html');
                                }
                                if (data_form.type == "DOC") {
                                    _type = "Documentos Recepcionales";
                                    $("#content-report").load('./scbets-client/pages/home/_viewDoc.html');
                                }
                                if (data_form.type == "ENC") {
                                    _type = "Enciclopedias";
                                    $("#content-report").load('./scbets-client/pages/home/_viewEnc.html');
                                }
                                if (data_form.type == "ENG") {
                                    _type = "Engarcolados";
                                    $("#content-report").load('./scbets-client/pages/home/_viewEng.html');
                                }
                                if (data_form.type == "REV") {
                                    _type = "Revistas";
                                    $("#content-report").load('./scbets-client/pages/home/_viewRev.html');
                                }
                                if (data_form.type == "OTR") {
                                    _type = "Otros";
                                    $("#content-report").load('./scbets-client/pages/home/_viewOtr.html');
                                }
                                $("#txt_typeName").html('Reportes de la clasificación de ' + _type);


                                //
                                //alert(JSON.stringify(data_form))
                                /*prueba = "2"; //Pongo la variable a dos para saber que he pasado por aqui
                                //Oculto las dos tablas, cargo y muestro el div
                                $('#tbl_Historias').hide(400); //Oculto las dos tablas
                                $('#tbl_Tareas').hide(400);

                                $('#formulario').load('formulario.html'); //Cargo la web en el div
                                $('#formulario').show(100); //Muesto el div formulario
*/
                            });
                        //setNotify('success', data.messages, 'right');
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }

                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + (xhr));
                }
            });

            $("#exportStatus").on('click', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    url: atob(ajax_auth_objects.routeLinkTotal),
                    type: 'post',
                    dataType: 'json',
                    data: 'scbets_action=' + ajax_auth_objects.ajaxListSta,
                    complete: function(xhr, textStatus) {
                        //called when complete
                        console.log('complete: ' + (xhr));
                    },
                    success: function(data, textStatus, xhr) {
                        //called when successful
                        console.log('success: ' + (data));
                        const datos = data.map((d) => ({
                            EJEMPLARES: d.Ejemplar,
                            ACTIVOS: d.Activos,
                            SUSPENDIDOS: d.Suspendidos,
                            BAJA: d.Bajas,
                            TOTAL: parseInt(d.Activos) + parseInt(d.Suspendidos) + parseInt(d.Bajas)
                        }));

                        if (data != []) {
                            var wb = XLSX.utils.book_new(),
                                ws = XLSX.utils.json_to_sheet(datos);

                            XLSX.utils.book_append_sheet(wb, ws, "myFile");
                            XLSX.writeFile(wb, 'ReporteGlobalStatus_' + getDateHoy() + ".xlsx");

                            /*let wb = XLSX.utils.book_new();

                            wb.Props = {

                                Title: 'Excel Workbook',

                                Subject: 'Tutorial',

                                Author: 'Erich Buelow',

                                CreatedDate: new Date(),

                            };

                            let wsName = 'newSheet';

                            let wsData = [

                                ['A1', 'B1'],

                                ['A2', 'B2'],

                            ];

                            let ws = XLSX.utils.aoa_to_sheet(wsData);

                            XLSX.utils.book_append_sheet(wb, ws, wsName);

                            XLSX.writeFile(wb, 'out.xlsx');*/

                            setNotify('success', "Excel exportado", 'right');
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

            //alert(atob(ajax_auth_objects.ajaxCatSta))
            /*jQuery.ajax({
                url: atob(ajax_auth_objects.routeLinkTotal),
                type: 'post',
                dataType: 'json',
                data: 'scbets_action=' + ajax_auth_objects.ajaxCatSta,
                complete: function(xhr, textStatus) {
                    //called when complete
                    console.log('complete: ' + (xhr));
                },
                success: function(data, textStatus, xhr) {
                    //called when successful
                    console.log('success: => ' + JSON.stringify(data));
                    if (data != []) {

                        //setNotify('success', data.messages, 'right');
                    } else {
                        setNotify('warning', data.messages, 'right');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                    console.log('error: ' + (xhr));
                }
            });*/


        });
    </script>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-wrap">
                                <div>
                                    <h4 class="card-title">Reporte</h4>
                                    <h6 class="card-subtitle">Índice de Ejemplares</h6>
                                </div>
                                <div class="ms-auto">
                                    <ul class="list-inline">
                                        <li class="list-inline-item px-2">
                                            <h6 class="text-success">
                                                <a href="#" id="exportStatus"><i class="mdi mdi-file-excel font-2 me-2"></i>Exportar</a>
                                            </h6>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <script>

                            </script>
                            <div id="globalAll"></div>
                        </div>
                        <div class="col-12">

                            <div class="table-responsive">
                                <table id="data-table" class="table table-hover table-striped table-sm mb-0 display nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Elemplares</th>
                                            <th class="text-center">Activos</th>
                                            <th class="text-center">Suspendidos</th>
                                            <th class="text-center">Bajas</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
</div>


<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reportes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert customize-alert alert-dismissible alert-light-info text-info fade show" role="alert">

                                <strong></strong>
                                <div id="txt_typeName"></div>
                            </div>

                        </div>
                        <div class="col-lg-12" id="content-report">

                        </div>
                    </div>
                
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="btn"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>