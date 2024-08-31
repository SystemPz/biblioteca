<!--<div class="container-fluid">-->
<!-- -------------------------------------------------------------- -->
<!-- Page wrapper  -->
<!-- -------------------------------------------------------------- -->
<div class="email-app todo-box-container">
    <!-- -------------------------------------------------------------- -->
    <!-- Left Part -->
    <!-- -------------------------------------------------------------- -->
    <div class="left-part list-of-tasks">
        <a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
        <div class="scrollable" style="height: 100%">
            <div class="p-3">
                <a class="waves-effect waves-light btn btn-info d-block" enable href="javascript: void(0)" id="add-task">PRESTAMOS</a>
            </div>
            <div class="divider"></div>
            <ul class="list-group">
                <li>
                    <small class="p-3 d-block text-uppercase text-dark font-weight-medium">Carpetas</small>
                </li>
                <li class="list-group-item p-0 border-0">
                    <a href="javascript:void(0)" class="todo-link active list-group-item-action p-3 d-flex align-items-center" id="all-todo-list">
                        <i class="fa fa-circle text-dark me-2"></i> En Proceso
                        <span class="todo-badge badge bg-light-info text-info rounded-pill px-3 font-weight-medium ms-auto"></span>
                    </a>
                </li>
                <li class="list-group-item p-0 border-0">
                    <a href="javascript:void(0)" class="todo-link list-group-item-action p-3 d-flex align-items-center" id="current-task-important">
                        <i class="fa fa-circle text-warning me-2"></i>Prestado
                        <span class="todo-badge badge rounded-pill px-3 bg-light-danger ms-auto text-danger font-weight-medium"></span>
                    </a>
                </li>
                <li class="list-group-item p-0 border-0">
                    <a href="javascript:void(0)" class="todo-link list-group-item-action p-3 d-flex align-items-center" id="current-task-done">
                        <i class="fa fa-circle text-success me-2"></i> Finalizado
                        <span class="todo-badge badge rounded-pill px-3 text-success font-weight-medium bg-light-success ms-auto"></span>
                    </a>
                </li>
                <li class="list-group-item p-0 border-0">
                    <hr />
                </li>
                <!--<li class="list-group-item p-0 border-0">
                    <a href="javascript:void(0)" class="list-group-item-action p-3 d-flex align-items-center" id="current-todo-delete">
                        <i data-feather="trash-2" class="feather-sm me-2"></i> Eliminar
                    </a>
                </li>-->
            </ul>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Right Part -->
    <!-- -------------------------------------------------------------- -->
    <div class="right-part mail-list bg-white overflow-auto">
        <div id="todo-list-container">
            <div class="p-3 border-bottom">
                <div class="input-group searchbar">
                    <span class="input-group-text" id="search"><i class="icon-magnifier text-muted"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar registro" aria-describedby="search" />
                </div>
            </div>
            <!-- Todo list-->
            <div class="todo-listing">

                <div id="all-todo-container" class="p-3">                   

                </div>
                <!-- Modal -->
                <div class="modal fade" id="todoShowListItem" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-light d-flex">
                                <h5 class="modal-title task-heading"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="compose-box">
                                    <div class="compose-content">
                                        <label class="mb-0 fs-4">Task Details</label>
                                        <p class="task-text text-muted"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-block" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <!-- -------------------------------------------------------------- -->
    <!-- End Page wrapper  -->
    <!-- -------------------------------------------------------------- -->
</div>
<!--</div>-->
<script>
    const ajax_auth_object = {
        "routeLink": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJIaXN0b3J5LnBocA==",
        "loadingmessage": "Sending user info, please wait...",
        "HistoryLoading": "SGlzdG9yeURhdGFVc2Vy",
        "ajaxDownload": "RG93bmxvYWRQZGY=",
        "routeLinkDownload": "Li9zY2JldHMtc2VydmVyL0NvbnRyb2xsZXJEZXZvbHVjaW9uZXMucGhw",
    };

    function getDataProcessHistory() {
        let data = JSON.parse(localStorage.getItem('user'));
        jQuery.ajax({
            url: atob(ajax_auth_object.routeLink),
            type: 'POST',
            dataType: 'json',
            data: {
                scbets_action: ajax_auth_object.HistoryLoading,
                txt_codex: data.codex,
            },
            complete: function(xhr, textStatus) {
                //called when complete
                console.log('complete: ' + (xhr));
            },
            success: function(data, textStatus, xhr) {
                //called when successful
                console.log('success: ' + (data));
                if (data.data != []) {
                    //setNotify('success', data.messages, 'right');
                    $.each(data.data, function(indexInArray, valueOfElement) {
                        let cont = atob(valueOfElement._mresx) == 'PRESTADO' ? 'current-task-important' : atob(valueOfElement._mresx) == 'DEVUELTO' ? 'current-task-done' : 'all-todo-list';
                        let text_color = atob(valueOfElement._mresx) == 'PRESTADO' ? 'text-warning' : atob(valueOfElement._mresx) == 'DEVUELTO' ? 'text-success' : 'text-dark';

                        $("#all-todo-container").append('<div class="todo-item ' + cont + ' p-3 border-bottom position-relative">' +
                            '<div class="inner-item d-flex align-items-start">' +
                            '<div class="w-100">' +
                            '<div class="content-todo">' +
                            '<h5 class="font-weight-medium fs-4 todo-header">' +
                            atob(valueOfElement._cresx) + '---' + atob(valueOfElement.consult[0].name) + '--- ' + atob(valueOfElement._bresx) +
                            '</h5>' +
                            '<div class="todo-subtext text-muted fs-3" >' +
                            '<i class="fa fa-circle ' + text_color + ' me-2"></i> Registro obtenido de la base de datos del Sistema de Control Bibliotecario de la Escuela de Trabajo Social.' +
                            '</div>' +
                            '<span class="todo-time fs-2 text-muted me-2"><i class="icon-calender me-1"></i>' + valueOfElement.fechaString + '</span>' +

                            '</div>' +
                            '</div>' +
                            '<div class="ms-auto">' +
                            '<div class="dropdown-action">' +
                            '<div class="dropdown todo-action-dropdown">' +
                            '<button class="btn btn-link text-dark p-1 dropdown-toggle text-decoration-none todo-action-dropdown" type="button" id="more-action-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="icon-options-vertical"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="more-action-1">' +
                            //'<a class="dropdown-item" href="javascript:void(0);"><i class="fas fa-eye text-info me-1"></i>Detalle</a>' +
                            '<a class="important dropdown-item" href="javascript:void(0);" onclick=onClickDownload(' + atob(valueOfElement._aresx) + ',' + atob(valueOfElement.consult[0].matricula) + ')><i class=" far fa-file-pdf text-danger me-1"></i>Descarga</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                    });
                } else {
                    setNotify('warning', data.messages, 'right');
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                console.log('error: ' + (xhr));
            }
        });
    }


    function onClickDownload(codex, fileName) {
        $.ajax({
            type: 'POST',
            url: atob(ajax_auth_object.routeLinkDownload),
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

    $(function() {
        getDataProcessHistory();
        // Search Items
        $(".searchbar > input").on("keyup", function() {
            var rex = new RegExp($(this).val(), "i");
            $(".todo-listing .todo-item").hide();
            $(".todo-listing .todo-item")
                .filter(function() {
                    return rex.test($(this).text());
                })
                .show();
        });
    });

    // #####################################################
    // Notification Badge
    // #####################################################

    function dynamicNumberNotify(setTaskSectionCount) {
        var taskSectionCount = setTaskSectionCount;

        // Get Parents Div(s)
        var get_ParentsDiv = $(".todo-item");
        var get_TaskAllListParentsDiv = $(".todo-item.all-todo-list");
        var get_TaskCompletedListParentsDiv = $(".todo-item.current-task-done");
        var get_TaskImportantListParentsDiv = $(".todo-item.current-task-important");

        // Get Parents Div(s) Counts
        var get_TastListCount = get_TaskAllListParentsDiv.length;
        var get_CompletedTaskElementsCount = get_TaskCompletedListParentsDiv.length;
        var get_ImportantTaskElementsCount = get_TaskImportantListParentsDiv.length;

        // Get Badge Div(s)
        var getBadgeAllTaskDiv = $("#all-todo-list .todo-badge");
        var getBadgeCompletedTaskListDiv = $("#current-task-done .todo-badge");
        var getBadgeImportantTaskListDiv = $("#current-task-important .todo-badge");

        if (taskSectionCount === "allList") {
            if (get_TastListCount === 0) {
                getBadgeAllTaskDiv.text("");
                return;
            }
            if (get_TastListCount > 9) {
                getBadgeAllTaskDiv.css({
                    padding: "2px 0px",
                    height: "25px",
                    width: "25px",
                });
            } else if (get_TastListCount <= 9) {
                getBadgeAllTaskDiv.removeAttr("style");
            }
            getBadgeAllTaskDiv.text(get_TastListCount);
        } else if (taskSectionCount === "completedList") {
            if (get_CompletedTaskElementsCount === 0) {
                getBadgeCompletedTaskListDiv.text("");
                return;
            }
            if (get_CompletedTaskElementsCount > 9) {
                getBadgeCompletedTaskListDiv.css({
                    padding: "2px 0px",
                    height: "25px",
                    width: "25px",
                });
            } else if (get_CompletedTaskElementsCount <= 9) {
                getBadgeCompletedTaskListDiv.removeAttr("style");
            }
            getBadgeCompletedTaskListDiv.text(get_CompletedTaskElementsCount);
        } else if (taskSectionCount === "importantList") {
            if (get_ImportantTaskElementsCount === 0) {
                getBadgeImportantTaskListDiv.text("");
                return;
            }
            if (get_ImportantTaskElementsCount > 9) {
                getBadgeImportantTaskListDiv.css({
                    padding: "2px 0px",
                    height: "25px",
                    width: "25px",
                });
            } else if (get_ImportantTaskElementsCount <= 9) {
                getBadgeImportantTaskListDiv.removeAttr("style");
            }
            getBadgeImportantTaskListDiv.text(get_ImportantTaskElementsCount);
        }
    }

    new dynamicNumberNotify("allList");
    new dynamicNumberNotify("completedList");
    new dynamicNumberNotify("importantList");

    // #####################################################
    // Quill data
    // #####################################################

    var quill = new Quill("#taskdescription", {
        modules: {
            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ["bold", "italic", "underline"],
                ["image", "code-block"],
            ],
        },
        placeholder: "Add description here...",
        theme: "snow", // or 'bubble'
    });

    $("#addTaskModal").on("hidden.bs.modal", function(e) {
        // do something...
        $(this).find("input,textarea,select").val("").end();
        quill.deleteText(0, 2000);
    });

    $("#add-task").on("click", function(event) {
        event.preventDefault();
        $(".add-tsk").show();
        $(".edit-tsk").hide();
        $("#addTaskModal").modal("show");
    });

    // #####################################################
    // Checkbox checked event
    // #####################################################
    function donecheckCheckbox() {
        $('.todo-item input[type="checkbox"]').click(function() {
            if ($(this).is(":checked")) {
                $(this).parents(".todo-item").addClass("current-task-done");
            } else if ($(this).is(":not(:checked)")) {
                $(this).parents(".todo-item").removeClass("current-task-done");
            }
            new dynamicNumberNotify("completedList");
        });
    }

    // #####################################################
    // Remove current task
    // #####################################################
    function removeDropdown() {
        $(".dropdown-action .dropdown-menu .remove.dropdown-item").click(function() {
            if (!$(this).parents(".todo-item").hasClass("current-todo-delete")) {
                var getTaskParent = $(this).parents(".todo-item");
                var getTaskClass = getTaskParent.attr("class");

                var getFirstClass = getTaskClass.split(" ")[1];
                var getSecondClass = getTaskClass.split(" ")[2];
                var getThirdClass = getTaskClass.split(" ")[3];

                if (getFirstClass === "all-todo-list") {
                    getTaskParent.removeClass(getFirstClass);
                }
                if (
                    getSecondClass === "current-task-done" ||
                    getSecondClass === "current-task-important"
                ) {
                    getTaskParent.removeClass(getSecondClass);
                }
                if (
                    getThirdClass === "current-task-done" ||
                    getThirdClass === "current-task-important"
                ) {
                    getTaskParent.removeClass(getThirdClass);
                }
                $(this).parents(".todo-item").addClass("current-todo-delete");
            } else if ($(this).parents(".todo-item").hasClass("current-todo-delete")) {
                $(this).parents(".todo-item").removeClass("current-todo-delete");
            }
            new dynamicNumberNotify("allList");
            new dynamicNumberNotify("completedList");
            new dynamicNumberNotify("importantList");
        });
    }

    // #####################################################
    // Remove current task permanently
    // #####################################################
    function deletePermanentlyDropdown() {
        $(".dropdown-action .dropdown-menu .permanent-delete.dropdown-item").on(
            "click",
            function(event) {
                event.preventDefault();
                if ($(this).parents(".todo-item").hasClass("current-todo-delete")) {
                    $(this).parents(".todo-item").remove();
                }
            }
        );
    }

    // #####################################################
    // Move current task with other tasks
    // #####################################################
    function reviveTaskDropdown() {
        $(".dropdown-action .dropdown-menu .revive.dropdown-item").on(
            "click",
            function(event) {
                event.preventDefault();
                if ($(this).parents(".todo-item").hasClass("current-todo-delete")) {
                    var getTaskParent = $(this).parents(".todo-item");
                    var getTaskClass = getTaskParent.attr("class");
                    var getFirstClass = getTaskClass.split(" ")[1];
                    $(this).parents(".todo-item").removeClass(getFirstClass);
                    $(this).parents(".todo-item").addClass("all-todo-list");
                    $(this).parents(".todo-item").hide();
                }
                new dynamicNumberNotify("allList");
                new dynamicNumberNotify("completedList");
                new dynamicNumberNotify("importantList");
            }
        );
    }

    // #####################################################
    //  Make task Important
    // #####################################################
    function importantTaskDropdown() {
        $(".important").click(function() {
            if (!$(this).parents(".todo-item").hasClass("current-task-important")) {
                $(this).parents(".todo-item").addClass("current-task-important");
                $(this).html("Back to List");
            } else if (
                $(this).parents(".todo-item").hasClass("current-task-important")
            ) {
                $(this).parents(".todo-item").removeClass("current-task-important");
                $(this).html("Important");
                $(".list-group-item-action#all-todo-list").trigger("click");
            }
            new dynamicNumberNotify("importantList");
        });
    }

    // #####################################################
    //  Edit Current task
    // #####################################################
    function editTaskDropdown() {
        $(".dropdown-action .dropdown-menu .edit.dropdown-item").click(function() {
            event.preventDefault();
            var $_outerThis = $(this);

            $(".add-tsk").hide();
            $(".edit-tsk").show();

            var $_taskTitle = $_outerThis
                .parents(".todo-item")
                .children()
                .find(".todo-header")
                .attr("data-todo-header");
            var $_taskText = $_outerThis
                .parents(".todo-item")
                .children()
                .find(".todo-subtext")
                .attr("data-todosubtextText");
            var $_taskJson = JSON.parse($_taskText);

            $("#task").val($_taskTitle);
            quill.setContents($_taskJson);

            $(".edit-tsk")
                .off("click")
                .on("click", function(event) {
                    var $_innerThis = $(this);
                    var $_task = document.getElementById("task").value;
                    var $_taskDescription =
                        document.getElementById("taskdescription").value;
                    // Get current date
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, "0");
                    var mm = String(today.getMonth()); //January is 0!
                    var yyyy = today.getFullYear();
                    var monthNames = [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ];
                    today = dd + " " + monthNames[mm] + " " + yyyy;
                    // getting text of task title and task description
                    var $_taskDescriptionText = quill.getText();
                    var $_taskDescriptionInnerHTML = quill.root.innerHTML;

                    var delta = quill.getContents();
                    var $_textDelta = JSON.stringify(delta);

                    var length = 125;

                    var trimmedString =
                        $_taskDescriptionText.length > length ?
                        $_taskDescriptionText.substring(0, length - 3) + "..." :
                        $_taskDescriptionText;

                    var $_taskEditedTitle = $_outerThis
                        .parents(".todo-item")
                        .children()
                        .find(".todo-header")
                        .html($_task);
                    var $_taskEditedText = $_outerThis
                        .parents(".todo-item")
                        .children()
                        .find(".todo-subtext")
                        .html(trimmedString);
                    var $_taskEditedText = $_outerThis
                        .parents(".todo-item")
                        .children()
                        .find(".todo-time")
                        .html(today);

                    var $_taskEditedTitleDataAttr = $_outerThis
                        .parents(".todo-item")
                        .children()
                        .find(".todo-header")
                        .attr("data-todo-header", $_task);
                    var $_taskEditedTextDataAttr = $_outerThis
                        .parents(".todo-item")
                        .children()
                        .find(".todo-subtext")
                        .attr("data-todosubtextText", $_textDelta);
                    var $_taskEditedTextDataAttr = $_outerThis
                        .parents(".todo-item")
                        .children()
                        .find(".todo-subtext")
                        .attr("data-todosubtext-html", $_taskDescriptionInnerHTML);
                    $("#addTaskModal").modal("hide");
                });
            $("#addTaskModal").modal("show");
        });
    }

    // #####################################################
    // Click on current task get more detail
    // #####################################################
    function taskItem() {
        $(".todo-item .content-todo").on("click", function(event) {
            event.preventDefault();

            var $_taskTitle = $(this)
                .parents(".todo-item")
                .children()
                .find(".todo-header")
                .attr("data-todo-header");
            var $todoHtml = $(this).find(".todo-subtext").attr("data-todosubtext-html");

            $(".task-heading").text($_taskTitle);
            $(".task-text").html($todoHtml);

            $("#todoShowListItem").modal("show");
        });
    }

    var $btns = $(".list-group-item-action").click(function() {
        if (this.id == "all-todo-list") {
            var $el = $("." + this.id).fadeIn();
            $("#all-todo-container > div").not($el).hide();
        } else if (this.id == "current-todo-delete") {
            var $el = $("." + this.id).fadeIn();
            $("#all-todo-container > div").not($el).hide();
        } else {
            var $el = $("." + this.id).fadeIn();
            $("#all-todo-container > div").not($el).hide();
        }
        $btns.removeClass("active");
        $(this).addClass("active");
    });

    donecheckCheckbox();
    removeDropdown();
    deletePermanentlyDropdown();
    reviveTaskDropdown();
    importantTaskDropdown();
    editTaskDropdown();
    taskItem();

    // #####################################################
    // Add New Task
    // #####################################################
    $(".add-tsk").click(function(e) {
        // Setting current date
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");
        var mm = String(today.getMonth()); //January is 0!
        var time = String(today.getTime());
        var yyyy = today.getFullYear();
        var monthNames = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ];
        today = dd + " " + monthNames[mm] + " " + yyyy;
        var cdate = dd + mm + time;
        var $_task = document.getElementById("task").value;

        var $_taskDescriptionText = quill.getText();
        var $_taskDescriptionInnerHTML = quill.root.innerHTML;

        var delta = quill.getContents();
        var $_textDelta = JSON.stringify(delta);

        $html =
            '<div class="todo-item all-todo-listtodo-item all-todo-list p-3 border-bottom position-relative">' +
            '<div class="inner-item d-flex align-items-start">' +
            '<div class="w-100">' +
            '<div class="checkbox checkbox-info d-flex align-items-start">' +
            '<input type="checkbox" class="material-inputs" id="' + cdate + '">' +
            '<label for="' + cdate + '"></label>' +
            "<div>" +
            '<h5 class="font-medium font-16 todo-header mb-0" data-todo-header="' + $_task + '">' + $_task + "</h5>" +
            "<div class='todo-subtext text-muted' data-todosubtext-html='" + $_taskDescriptionInnerHTML + "' data-todosubtextText='" + $_textDelta + "'> " +
            $_taskDescriptionText +
            "</div>" +
            '<span class="todo-time font-12 text-muted"><i class="icon-calender mr-1"></i>' + today + "</span>" +
            "</div>" +
            '<div class="ml-auto">' +
            '<div class="dropdown-action">' +
            '<div class="dropdown todo-action-dropdown">' +
            '<button class="btn btn-link text-dark p-1 dropdown-toggle text-decoration-none todo-action-dropdown" type="button" id="more-action-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            '<i class="icon-options-vertical"></i>' +
            "</button>" +
            '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="more-action-1">' +
            '<a class="edit dropdown-item" href="javascript:void(0);"><i class="fas fa-edit text-info mr-1"></i> Edit</a>' +
            '<a class="important dropdown-item" href="javascript:void(0);"><i class="fas fa-star text-warning mr-1"></i> Important</a>' +
            '<a class="remove dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt text-danger mr-1"></i>Remove</a>' +
            '<a class="permanent-delete dropdown-item" href="javascript:void(0);">Permanent Delete</a>' +
            '<a class="revive dropdown-item" href="javascript:void(0);">Revive Task</a>' +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        $("#all-todo-container").prepend($html);
        $("#addTaskModal").modal("hide");
        donecheckCheckbox();
        removeDropdown();
        deletePermanentlyDropdown();
        reviveTaskDropdown();
        editTaskDropdown();
        taskItem();
        importantTaskDropdown();
        new dynamicNumberNotify("allList");
        $(".list-group-item-action#all-todo-list").trigger("click");

        $(".add-tsk").attr("disabled", "disabled");
    });

    $("#task").keyup(function() {
        var empty = false;
        $("#task").each(function() {
            if ($(this).val() == "") {
                empty = true;
            }
        });

        if (empty) {
            $(".add-tsk").attr("disabled", "disabled");
        } else {
            $(".add-tsk").removeAttr("disabled");
        }
    });
</script>