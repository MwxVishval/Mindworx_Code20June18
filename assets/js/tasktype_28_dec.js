var categories = [], assets = [], tabs = [], create_no = [];
var tab_status = 0;
$(window).load(function () {
    getTabDetails();
});

$('.add-task-type').on('click', function () {
    var ent_id = $('#ent_id').val();
    var task_type_name = $('#task_type_name').val();
    if (task_type_name) {
        $('#task_type_name').css('border-color', '');
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_task_type',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type_name: task_type_name},
            success: function (res) {
                if (res.error) {
//                    alert(res.error);
                    showInformation('error', res.error);
                    $('#divLoading').removeClass('show');
                } else {
                    var tmpTabs = {id: res.id, task_type: res.task_type, task_type_description: res.task_type_description, integrated_api: res.integrated_api};
                    tabs.push(tmpTabs);
                    cloneTask(res.id, res.task_type);
                    selectedOptions(res.id, res.integrated_api);
//                    var htm = '<option value="' + res.id + '">' + res.task_type + '</option>';
                    appendTaskDependency('', true);
                    $('#task_type_name').val('');
                    $('#divLoading').removeClass('show');
                }
            }, error: function (error) {
//                alert('Something went wrong! Please try again!');
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    } else {
        $('#task_type_name').css('border-color', 'red');
    }
});

function cloneTask(id, task_type) {
    var tabId = 'tasktype_' + id;
    $('#parent_nav').append('<li data-tab="' + id + '"><a href="#' + tabId + '" data-toggle="tab" id="task_tab_' + id + '">' + task_type + '</a><span>x</span></li>');
    var clone_div = $('#clone').clone();
    clone_div.removeAttr('style');
    clone_div.removeAttr('id');
    clone_div.attr('id', tabId);
    clone_div.find('.categories1').attr({href: "#categories_" + id, class: "categories_" + id});
    clone_div.find('.create1').attr({href: "#create_" + id});
    clone_div.find('.update1').attr({href: "#update_" + id});
    clone_div.find('.complete1').attr({href: "#complete_" + id});
    clone_div.find('.assets1').attr({href: "#assets_" + id});
    clone_div.find('.states1').attr({href: "#states_" + id});
    clone_div.find('.flow1').attr({href: "#flow_" + id});
    clone_div.find('.onhold1').attr({href: "#onhold_" + id});
    clone_div.find('.reject1').attr({href: "#reject_" + id});

    clone_div.find('#categories1').attr({id: "categories_" + id, class: "tab-pane active"});
    clone_div.find('#create1').attr({id: "create_" + id});
    clone_div.find('#update1').attr({id: "update_" + id});
    clone_div.find('#complete1').attr({id: "complete_" + id});
    clone_div.find('#assets1').attr({id: "assets_" + id});
    clone_div.find('#states1').attr({id: "states_" + id});
    clone_div.find('#flow1').attr({id: "flow_" + id});
    clone_div.find('#onhold1').attr({id: "onhold_" + id});
    clone_div.find('#reject1').attr({id: "reject_" + id});

    clone_div.find('#category_add1').attr({id: "category_add_" + id});
    clone_div.find('#category_add_button1').attr({id: "category_add_button_" + id, 'data-category': id, onclick: "addCategory(" + id + ")"});
    clone_div.find('#category_table1').attr({id: "category_table_" + id});

    clone_div.find('.create_api1').attr({name: "create_api_" + id, onchange: "togIntegratedApi('create', " + id + ", true)", class: ''});
    clone_div.find('#task_dependency1').attr({id: "task_dependency_" + id});
    clone_div.find('#create_integrated_api1').attr({id: "create_integrated_api_" + id});
    clone_div.find('#create_integrated_api_no1').attr({id: "create_integrated_api_no_" + id});

    clone_div.find('#created_add_not_integrated1').attr({id: "created_add_not_integrated" + id, onclick: "create_not_integrate(" + id + ")"});

    clone_div.find('#create_label').attr({id: "create_label" + id + ""});
    clone_div.find('#create_field_type').attr({id: "create_field_type" + id + ""});
    clone_div.find('#create_limit').attr({id: "create_limit" + id + ""});
    clone_div.find('#create_category').attr({id: "create_category" + id + ""});
    clone_div.find('#create_attri_control').attr({id: "create_attri_control" + id + ""});
//    clone_div.find('#create_no_table').attr({id: "create_no_table_" + id + ""});

    clone_div.find('#label').attr({id: "label" + id + ""});
    clone_div.find('#field_type').attr({id: "field_type" + id + ""});
    clone_div.find('#limit').attr({id: "limit" + id + ""});
    clone_div.find('#category').attr({id: "category" + id + ""});
    clone_div.find('#create_table').attr({id: "create_table_" + id + ""});

    clone_div.find('.update_api1').attr({name: "update_api_" + id, class: ''});
    clone_div.find('#update_tab_category').attr({id: "update_tab_category_" + id});
    clone_div.find('.update_available_api1').attr({name: "update_available_api_" + id, class: ''});

    clone_div.find('.complete_api').attr({name: "complete_api_" + id, class: ''});
    clone_div.find('.signature').attr({id: "signature_" + id, class: '', onchange: "changeCompletedScreen('signature', " + id + ")"});
    clone_div.find('.ratings').attr({id: "ratings_" + id, class: '', onchange: "changeCompletedScreen('ratings', " + id + ")"});
    clone_div.find('.comments').attr({id: "comments_" + id, class: '', onchange: "changeCompletedScreen('comments', " + id + ")"});

    clone_div.find('#asset_integrated_api1').attr({id: "asset_integrated_api_" + id});
    clone_div.find('#asset_integrated_api_no1').attr({id: "asset_integrated_api_no_" + id});
    clone_div.find('#asset_status').attr({name: "asset_status" + id, id: '', onchange: "changeIntegratedApi(" + id + ", 'asset_status', '')"});
    clone_div.find('.asset_api1').attr({name: "asset_api_" + id, onchange: "togIntegratedApi('asset', " + id + ", true)", class: ''});
    clone_div.find('#asset_upload1').attr({id: "asset_upload_" + id});
    clone_div.find('#asset_upload_csv1').attr({id: "asset_upload_csv_" + id, onchange: "upload_csv(" + id + ")"});
    clone_div.find('#asset_display_name1').attr({id: "asset_display_name_" + id});
    clone_div.find('#asset_type1').attr({id: "asset_type_" + id});
    clone_div.find('#asset_description1').attr({id: "asset_description_" + id});
    clone_div.find('#add_asset_value1').attr({onclick: "add_asset_value(" + id + ")", id: ''});
    clone_div.find('#append_asset_data1').attr({id: "append_asset_data_" + id});

    clone_div.find('#created_method').attr({id: "created_method" + id, class: "form-control validate" + id});
    clone_div.find('#created_endpoint').attr({id: "created_endpoint" + id, class: "form-control validate" + id});
    clone_div.find('#created_username').attr({id: "created_username" + id, class: "form-control validate" + id});
    clone_div.find('#created_password').attr({id: "created_password" + id, class: "form-control validate" + id});
    clone_div.find('#created_xml_file').attr({id: "created_xml_file" + id, class: "form-control validate" + id});
    clone_div.find('#created_api_key').attr({id: "created_api_key" + id, class: "form-control validate" + id});

    clone_div.find('#create_yes_save_data').attr({id: "create_yes_save_data" + id, onclick: "create_yes_save_data(" + id + ")"});

    clone_div.find('#create_yes_addbutton').attr({id: "create_yes_addbutton" + id, onclick: "create_yes_addbutton(" + id + ")"});
    clone_div.find('#append_create_yes_data').attr({id: "append_create_yes_data" + id});
    clone_div.find('#api_settings_id').attr({id: "api_settings_id" + id});

    clone_div.find('#map_fields').attr({id: "map_fields" + id, class: "form-control validate_map" + id});
    clone_div.find('#end_point_control').attr({id: "end_point_control" + id, class: "form-control validate_map" + id});

    clone_div.find('#onhold_integrated_api1').attr({id: "onhold_integrated_api_" + id});
    clone_div.find('.onhold_api1').attr({name: "onhold_api_" + id, onchange: "togIntegratedApi('onhold', " + id + ", true)", class: ''});
    clone_div.find('#onhold_integrated_api_no1').attr({id: "onhold_integrated_api_no_" + id});

    clone_div.find('#reject_integrated_api1').attr({id: "reject_integrated_api_" + id});
    clone_div.find('.reject_api1').attr({name: "reject_api_" + id, onchange: "togIntegratedApi('reject', " + id + ", true)", class: ''});

    clone_div.find('.flow_task').attr({name: "allow_for_api_" + id, onchange: "togIntegratedApi('allow_for', " + id + ", true)", class: ''});

    clone_div.find('#reject_integrated_api_no1').attr({id: "reject_integrated_api_no_" + id});

    $('#parent_tab.tab-content').append(clone_div);
    $('#task_tab_' + id).click();
}

$("#parent_nav.nav-tabs").on("click", "span", function () {
    if (confirm('Are you sure?')) {
        var that = $(this);

        var task_id = $(this).parent().data('tab');
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/remove_task_type',
            type: 'post',
            dataType: 'json',
            data: {task_id: task_id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var anchor = that.siblings('a');
                    $(anchor.attr('href')).remove();
                    $(".nav-tabs li").children('a').first().click();
//                alert(res.success);
                    for (var j = 0; j < tabs.length; j++) {
                        if (task_id == tabs[j].id) {
                            tabs.splice(j, 1);
                            that.parent().remove();
                            break;
                        }
                    }
                    appendTaskDependency('', true);
                    showInformation('success', res.success);
                } else {
                    alert(res.error);
                    showInformation('error', res.error);
                }
            }, error: function (error) {
//            alert('Something went wrong! Please try again!');
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function addCategory(id) {
    var category = $('#category_add_' + id).val();
    var ent_id = $('#ent_id').val();
    if (category) {
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_category',
            type: 'post',
            data: {category: category, ent_id: ent_id, task_type: id},
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $('#category_add_' + id).css('border-color', '');
                    $('#category_add_' + id).val('');
                    var cat = {id: res.id, category: res.category, ent_id: ent_id, task_type: res.task_type};
                    categories.unshift(cat);
                    showCategories();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
                $('#divLoading').removeClass('show');
            },
            error: function (error) {
//                alert('Something went wrong! Please try again!');
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#category_add_' + id).css('border-color', 'red');
    }
}

$('body').on('click', ".removecategory", function () {
    if (confirm('Are you sure?')) {
        var that = $(this).closest('tr');
        var cat_id = $(this).data('category_id');
        var separate_update_screen = 0;
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/update_category',
            type: 'post',
            data: {cat_id: cat_id, separate_update_screen: separate_update_screen, rem: 1},
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.error) {
//                    alert('Something went wrong! Please try again!');
                    showInformation('error', 'Something went wrong! Please try again!');
                } else {
                    for (var j = 0; j < categories.length; j++) {
                        if (cat_id == categories[j].id) {
                            categories.splice(j, 1);
                            that.remove();
                            break;
                        }
                    }
                    showCategories();
                    showInformation('success', res.success);
                }
            },
            error: function (error) {
//                alert('Something went wrong! Please try again!');
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function togIntegratedApi(type, id, updateStatus = false) {
    if (type != '' && id != '') {
        var value = $("input[name=" + type + "_api_" + id + "]:checked").val();

        if (updateStatus) {
            changeIntegratedApi(id, type, value);
        }

        if (value == 1) {
            $('#' + type + '_integrated_api_no_' + id).hide();
            $('#' + type + '_integrated_api_' + id).show();
        } else {
            $('#' + type + '_integrated_api_' + id).hide();
            $('#' + type + '_integrated_api_no_' + id).show();
        }

        if (type == 'create') {
            $("input[name=complete_api_" + id + "][value=" + value + "]").prop('checked', true);
        }
    }
}

function changeIntegratedApi(id, type, value) {
    if (value == null || value == '') {
        var value = $("input[name=" + type + "" + id + "]:checked").val();
    }

    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/update_task_type',
        type: 'post',
        dataType: 'json',
        data: {task_id: id, type: type, value: value},
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.success) {
                showInformation('success', res.success);
            } else {
                showInformation('error', 'Something went wrong! Please try again!');
            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });
}

function add_asset_value(id) {
    var ent_id = $('#ent_id').val();
    var asset_display_name = $("#asset_display_name_" + id).val();
    var asset_type = $("#asset_type_" + id).val();
    var asset_description = $("#asset_description_" + id).val();
    var error = 0;
    if (asset_display_name == "") {
        $("#asset_display_name_" + id).css('border-color', 'red');
        error = 1;
    } else {
        $("#asset_display_name_" + id).css('border-color', '');
    }
    if (asset_type == "") {
        $("#asset_type_" + id).css('border-color', 'red');
        error = 1;
    } else {
        $("#asset_type_" + id).css('border-color', '');
    }
    if (asset_description == "") {
        $("#asset_description_" + id).css('border-color', 'red');
        error = 1;
    } else {
        $("#asset_description_" + id).css('border-color', '');
    }
    if (error == 0) {
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_asset',
            type: 'post',
            data: {ent_id: ent_id, task_type: id, display_name: asset_display_name, type: asset_type, description: asset_description},
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.error) {
//                    alert('Something went wrong! Please try again!');
                    showInformation('error', res.error);
                } else {
                    var asset_html = "<tr><td>" + asset_display_name + "</td><td>" + asset_type + "</td><td>" + asset_description + "</td><td><span class='glyphicon glyphicon-remove removeasset' data-asset='" + res.id + "'></span></td></tr>"
                    $('#append_asset_data_' + id).append(asset_html);
                    $("#asset_display_name_" + id).val('');
                    $("#asset_type_" + id).val('');
                    $("#asset_description_" + id).val('');
                    showInformation('success', res.success);
                }
            },
            error: function (error) {
//                alert('Something went wrong! Please try again!');
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

$('body').on('click', "#create_add_button_2", function () {
    var test = $('#map_field').val();
    var html = "<div class='input-group'><div class='col-md-4'><input type='text' value='" + test + "' class='form-control'></div><div class='col-md-4'><select class='form-control'> <option value='" + test + "'>Category</option></select></div><div class='col-md-4'><select name='' class='form-control'> <option value=''>loading ...</option></select></div></div></div>";
    $('#append_data_1').after(html);
});

function showCategories() {
    var table_id = [];
    for (var j = 0; j < categories.length; j++) {
        if (table_id.indexOf(categories[j].task_type) == -1) {
            table_id.push(categories[j].task_type);
            $('#category_table_' + categories[j].task_type).find("tr:not(:first)").remove();
//            $('#category' + categories[j].task_type).empty().append('<option value="">Select</option>');
            $('#create_category' + categories[j].task_type).empty().append('<option value="">Select</option>');
            $('#update_tab_category_' + categories[j].task_type).empty().append('<option value="">Select Category</option>');
        }
        var htm = '', category_select_htm = '';
        var id = categories[j].task_type;
        htm += '<tr><td>' + categories[j].category + '</td>';
        htm += '<td><input type="checkbox" class="separate_update_screen" data-category_id ="' + categories[j].id + '"';
        category_select_htm += '<option value="' + categories[j].id + '">' + categories[j].category + '</option>';
        if (categories[j].separate_update_screen > 0) {
            htm += ' checked ';
        }
        htm += '></td>';
        htm += '<td><span class="glyphicon glyphicon-remove removecategory" data-category_id ="' + categories[j].id + '"></span></td></tr>';
        $('#category_table_' + id).append(htm);
//        $('#category' + id).append(category_select_htm);
        $('#create_category' + id).append(category_select_htm);
        $('#update_tab_category_' + id).append(category_select_htm);
    }
}

$('body').on('click', '.separate_update_screen', function () {
    var cat_id = $(this).data('category_id');
    var separate_update_screen = 0;
    if ($(this).prop('checked')) {
        separate_update_screen = 1;
    }
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/update_category',
        type: 'post',
        data: {cat_id: cat_id, separate_update_screen: separate_update_screen},
        dataType: 'json',
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.error) {
//                alert('Something went wrong! Please try again!');
                showInformation('error', 'Something went wrong! Please try again!');
            } else {
//                alert(res.success);
                showInformation('success', res.success);
            }
        },
        error: function (error) {
//            alert('Something went wrong! Please try again!');
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });
});

function upload_csv(id) {
    var ent_id = $('#ent_id').val();
    var files = $('#asset_upload_csv_' + id)[0].files;
    var file_name = $('#asset_upload_csv_' + id)[0].files[0].name;
    var ext = file_name.split('.');
    if (ext[1].toLowerCase() == 'csv') {
        $('#asset_upload_csv_' + id).css('border-color', '');
        var formData = new FormData();
        $.each(files, function (key, value)
        {
            formData.append(key, value);
        });
        formData.append('ent_id', ent_id);
        formData.append('task_type', id);

        /*for (var key of formData.entries()) {
         console.log(key[0] + ', ' + key[1]);
         }*/
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/upload_csv',
            enctype: 'multipart/form-data',
            type: 'post',
            data: formData,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var htm = '';
                    for (var i = 0; i < res.data.length; i++) {
                        htm += "<tr><td>" + res.data[i].display_name + "</td><td>" + res.data[i].type + "</td><td>" + res.data[i].description + "</td><td><span class='glyphicon glyphicon-remove removeasset' data-asset='" + res.data[i].id + "'></span></td></tr>";
                    }
                    $('#append_asset_data_' + id).append(htm);
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#asset_upload_csv_' + id).css('border-color', 'red');
    }
}


/*************  ChinnaRasu  *************/
function create_not_integrate(id) {

    var create_label = document.getElementById("create_label" + id).value;
    var create_field_type = document.getElementById("create_field_type" + id).value;
    var create_limit = document.getElementById("create_limit" + id).value;
    var create_category = document.getElementById("create_category" + id).value;
    var create_attri_control = document.getElementById("create_attri_control" + id).value;


    var ent_id = $('#ent_id').val();

    if (create_label == "") {
        $("#create_label" + id).css('border-color', 'red');
        error = 1;
    } else {
        $("#create_label" + id).css('border-color', '');
    }
    if (create_field_type == "") {
        $("#create_field_type" + id).css('border-color', 'red');
        error = 2;
    } else {
        $("#create_field_type" + id).css('border-color', '');
    }
    if (create_limit == "") {
        $("#create_limit" + id).css('border-color', 'red');
        error = 3;
    } else {
        $("#create_limit" + id).css('border-color', '');
    }
    if (create_category == "") {
        $("#create_category" + id).css('border-color', 'red');
        error = 4;
    } else {
        $("#create_category" + id).css('border-color', '');
    }
    if (create_attri_control == "") {
        $("#create_attri_control" + id).css('border-color', 'red');
        error = 4;
    } else {
        $("#create_attri_control" + id).css('border-color', '');
    }

    if (create_label != "" && create_field_type != "" && create_limit != "" && create_category != "" && create_attri_control != "") {


        var formData = {
            'ent_id': ent_id,
            'task_id': id,
            'label': create_label,
            'field_type': create_field_type,
            'limit': create_limit,
            'category': create_category,
            'create_attri_control': create_attri_control,
            'task_type': id
        };
        $.ajax({
            url: url + 'EntitySettingController/create_not_integrated',
            type: 'post',
            data: formData,
            async: true, //blocks window close
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    /*$.ajax({
                     url: url + 'EntitySettingController/create_not_integrated_data',
                     type: 'post',
                     dataType: "json",
                     data: {ent_id: ent_id},
                     async: true, //blocks window close
                     success: function (data) {
                     
                     var html = "";
                     for (i = 0; i < data.length; i++) {
                     
                     html += '<tr><td>' + data[i]['Ext_att_name'] + '</td><td>' + data[i]['Ext_att_type'] + '</td><td>' + data[i]['Ext_att_size'] + '</td><td>' + data[i]['Ext_att_category_id'] + '</td><td><span id="remove_id' + data[i]['extr_att_id'] + '" onclick="remove_row(' + data[i]['extr_att_id'] + ')" class="glyphicon glyphicon-remove"></span></td></tr>';
                     
                     }
                     $("#create_table_" + id + "  tbody").html(html);
                     document.getElementById("label" + id).value = "";
                     document.getElementById("field_type" + id).value = "";
                     document.getElementById("limit" + id).value = "";
                     document.getElementById("category" + id).value = "";
                     },
                     error: function () {
                     alert('Something went wrong! Please try again!');
                     }
                     });*/
                    var selCategoryText = $("#create_category" + id + " option:selected").text();

                    create_no.push(res);
                    var htm = '<tr><td>' + res.Ext_att_name + '</td><td>' + res.Ext_att_type + '</td><td>' + res.Ext_att_size + '</td><td>' + selCategoryText + '</td><td><span id="remove_id' + res.extr_att_id + '" onclick="remove_row(' + res.extr_att_id + ')" class="glyphicon glyphicon-remove"></span></td></tr>';
                    $("#create_table_" + id + "  tbody").append(htm);
//                    $("#create_no_table_" + id + "  tbody").append(htm);
                    document.getElementById("api_settings_id" + id).value = res.API_Settings_ID;

                    document.getElementById("create_label" + id).value = "";
                    document.getElementById("create_field_type" + id).value = "";
                    document.getElementById("create_limit" + id).value = "";
                    document.getElementById("create_category" + id).value = "";
                    document.getElementById("create_attri_control" + id).value = "";
                    var option = '<option value="' + res.Ext_att_name + '">' + res.Ext_att_name + '</option>';
                    $("#map_fields" + id).append(option);
                } else {
                    alert('Something went wrong! Data not inserted!');
                }

            },
            error: function () {
                alert('Something went wrong! Please try again!');
            }
        });
    }
}

function remove_row(id) {
    if (confirm('Are you sure?')) {
        $.ajax({
            url: url + 'EntitySettingController/create_not_integrated_delete',
            type: 'post',
            data: {id: id},
            success: function (data) {
                if (data == 'success') {
                    var option = '<option value="">Select</option>', attr_id = [];
                    for (var j = 0; j < create_no.length; j++) {
                        if (attr_id.indexOf(create_no[j].Task_type_ID) == -1) {
                            $("#map_fields" + create_no[j].Task_type_ID).html('');
                            attr_id.push(create_no[j].Task_type_ID);
                        }
                        if (id == create_no[j].extr_att_id) {
                            create_no.splice(j, 1);
                            $("#remove_id" + id + "").closest("tr").remove();
//                            break;
                        } else {
                            option += "<option value='" + create_no[j].Ext_att_name + "'>" + create_no[j].Ext_att_name + "</option>";
                        }
                    }
                    for (var i = 0; i < create_no.length; i++) {
                        $("#map_fields" + create_no[i].Task_type_ID).html(option);
                    }
                }
            }
            ,
            error: function (error) {
                alert('Something went wrong! Please try again!');
            }
        });
    }
}

function created_tab_not_integrated_data(id) {
    $.ajax({
        url: url + 'EntitySettingController/create_not_integrated_data',
        type: 'post',
        dataType: "json",
        data: {ent_id: id},
        async: true, //blocks window close
        success: function (data) {

            var html = "";
            for (i = 0; i < data.length; i++) {

                html += '<tr><td>' + data[i]['Ext_att_name'] + '</td><td>' + data[i]['Ext_att_type'] + '</td><td>' + data[i]['Ext_att_size'] + '</td><td>' + data[i]['Ext_att_category_id'] + '</td><td><span id="remove_id' + data[i]['extr_att_id'] + '" onclick="remove_row(' + data[i]['extr_att_id'] + ')" class="glyphicon glyphicon-remove"></span></td></tr>';

            }
            $("#create_table_" + id + "  tbody").html(html);
//            $("#create_no_table_" + id + "  tbody").html(html);

        },
        error: function (error) {
            alert('Something went wrong! Please try again!');
        }
    });
}

function showCreate_Api_Yes() {

    var html = "";
    for (var i = 0; i < create_yes.length; i++) {
        document.getElementById("created_method" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_Method_Name;
        document.getElementById("created_endpoint" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_End_point;
        document.getElementById("created_username" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_User_name;
        document.getElementById("created_password" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_Password;
        document.getElementById("created_xml_file" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_XML_File;
        document.getElementById("created_api_key" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_Key;
        document.getElementById("api_settings_id" + create_yes[i].API_Task_Type_id).value = create_yes[i].API_Settings_ID;

        if (create_yes[i].API_Method_Name != "") {
            $("#create_yes_save_data" + create_yes[i].API_Task_Type_id).hide();
        }
    }
}

function showCreate_Api_Yes_list() {

    for (var i = 0; i < create_yes_list.length; i++) {
        var html = '';
        /*        html = "<div class='input-group' id=remove_create_yes" + create_yes_list[i].API_Mapping_Id + "><div class='col-md-2'><input type='text' value='" + create_yes_list[i].API_Field + "' class='form-control' id='map_field'></div><div class='col-md-4'><input type='text' value='" + create_yes_list[i].End_Point +
         "' class='form-control' id='map_field'></div><div class='col-md-2'><span id=remove_ele_id" + create_yes_list[i].API_Mapping_Id + " data-map_id='" + create_yes_list[i].API_Mapping_Id +
         "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_create_yes'></span></div></div>";
         */
        html = "<tr id=remove_create_yes" + create_yes_list[i].API_Mapping_Id + "><td>" + create_yes_list[i].API_Field + "</td><td>" + create_yes_list[i].End_Point + "</td><td><span id=remove_ele_id" + create_yes_list[i].API_Mapping_Id + " data-map_id='" + create_yes_list[i].API_Mapping_Id +
                "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_create_yes'></span></td></tr>";
        $('#append_create_yes_data' + create_yes_list[i].task_type).append(html);
    }
}
function create_yes_save_data(id) {
    var created_method = document.getElementById("created_method" + id).value;
    var created_endpoint = document.getElementById("created_endpoint" + id).value;
    var created_username = document.getElementById("created_username" + id).value;
    var created_password = document.getElementById("created_password" + id).value;
    var created_xml_file = document.getElementById("created_xml_file" + id).value;
    var created_api_key = document.getElementById("created_api_key" + id).value;
    var create_api = document.getElementsByName("create_api_" + id)[0].value;

    var ent_id = $('#ent_id').val();
    var error = 0;

    $("input.validate" + id).each(function () {

        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {

            $(this).css('border-color', '');
        }

    });

    if (error == 0) {
        var formData = {
            'ent_id': ent_id,
            'task_type_id': id,
            'created_method': created_method,
            'created_endpoint': created_endpoint,
            'created_username': created_username,
            'created_password': created_password,
            'created_xml_file': created_xml_file,
            'created_api_key': created_api_key,
            'create_api': create_api

        };
        $.ajax({
            url: url + 'EntitySettingController/create_integrated',
            type: 'post',
            data: formData,
            async: true, //blocks window close
            dataType: 'json',
            success: function (res) {
                created_username = document.getElementById("api_settings_id" + id).value = res.extr_att_id;

            },
            error: function () {
                alert('Something went wrong! Please try again!');
            }
        });

    }
}

/*************  ChinnaRasu  *************/

function getTabDetails() {
    $('#divLoading').addClass('show');
    var ent_id = $('#ent_id').val();
    $.ajax({
        url: url + 'EntitySettingController/getTabDetails',
        type: 'post',
        data: {ent_id: ent_id},
        dataType: 'json',
        success: function (res) {
            if (res.error) {
//                alert('Something went wrong! Please try again!');
                showInformation('error', 'Something went wrong! Please try again!');
            } else {
                tabs = res.task_type;
                categories = res.categories;
                assets = res.assets;
                create_no = res.create;
                create_yes = res.create_yes;
                create_yes_list = res.create_yes_list;
                if (tabs.length > 0) {
                    var htm = '<option>Loading....</option>';
                    for (var i = 0; i < tabs.length; i++) {
                        cloneTask(tabs[i].id, tabs[i].task_type);
                        htm += '<option value="' + tabs[i].id + '">' + tabs[i].task_type + '</option>';
                        selectedOptions(tabs[i].id, tabs[i].integrated_api);
                        completedScreen(tabs[i].id, tabs[i].completed_screen);
                    }
                    appendTaskDependency(htm, false);
                }
                $('#parent_nav.nav-tabs li:nth-child(1) a').click();
                showCategories();
                showAssets();
                showCreate_Api_No();
                showCreate_Api_Yes();
                showCreate_Api_Yes_list();
            }
            $('#divLoading').removeClass('show');
        }, error: function (error) {
//            alert('Something went wrong! Please try again!');
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        },
    });
}

function appendTaskDependency(htm, status) {
    var count = 1;
    if (status) {
        count = 2;
        htm = '<option>Loading....</option>';
    }
    while (count > 0) {
        for (var i = 0; i < tabs.length; i++) {
            if (count == 1) {
                $('#task_dependency_' + tabs[i].id).html(htm);
            } else {
                htm += '<option value="' + tabs[i].id + '">' + tabs[i].task_type + '</option>';
            }
        }
        count--;
    }
}

function showAssets() {
    for (var i = 0; i < assets.length; i++) {
        var htm = '';
        htm += "<tr><td>" + assets[i].display_name + "</td><td>" + assets[i].type + "</td><td>" + assets[i].description + "</td><td><span class='glyphicon glyphicon-remove removeasset' data-asset='" + assets[i].id + "'></span></td></tr>";
        $('#append_asset_data_' + assets[i].task_type).append(htm);
    }
}

function selectedOptions(id, values) {
    $("input[name=create_api_" + id + "][value=" + values.create + "]").attr('checked', 'checked');
    togIntegratedApi('create', id);
    $("input[name=update_api_" + id + "][value=" + values.update + "]").attr('checked', 'checked');
    togIntegratedApi('update', id);
    $("input[name=asset_api_" + id + "][value=" + values.asset + "]").attr('checked', 'checked');
    $("input[name=asset_status" + id + "][value=" + values.asset_status + "]").attr('checked', 'checked');
    togIntegratedApi('asset', id);
    $("input[name=onhold_api_" + id + "][value=" + values.onhold + "]").attr('checked', 'checked');
    togIntegratedApi('onhold', id);
    $("input[name=reject_api_" + id + "][value=" + values.reject + "]").attr('checked', 'checked');
    togIntegratedApi('reject', id);
    $("input[name=allow_for_api_" + id + "][value=" + values.allow_for + "]").attr('checked', 'checked');
    togIntegratedApi('reject', id);
}

function showCreate_Api_No() {
    for (var i = 0; i < create_no.length; i++) {
        var htm = '', option = '';
        htm += '<tr><td>' + create_no[i].Ext_att_name + '</td><td>' + create_no[i].Ext_att_type + '</td><td>' + create_no[i].Ext_att_size + '</td><td>' + create_no[i].category + '</td><td><span id="remove_id' + create_no[i].extr_att_id + '" onclick="remove_row(' + create_no[i].extr_att_id + ')" class="glyphicon glyphicon-remove"></span></td></tr>';
        $("#create_table_" + create_no[i].Task_type_ID).append(htm);
//        $("#create_no_table_" + create_no[i].Task_type_ID).append(htm);
        option += "<option value='" + create_no[i].Ext_att_name + "'>" + create_no[i].Ext_att_name + "</option>";
        $("#map_fields" + create_no[i].Task_type_ID).append(option);
    }
}

function showInformation(type, msg) {
    var txt = '', className = '';
    $('#msgPane').attr({class: "alert fade in"});
    if (type == 'success') {
        className = 'alert-success';
        txt = '<strong>Success!</strong> ' + msg;
    } else {
        className = 'alert-danger';
        txt = '<strong>Error!</strong> ' + msg;
    }
    $('#msgPane').addClass(className);

    $('#msgPane').show();
    $('#msg').html(txt);
    $('#msgPane').fadeOut(2000);
//    $('#msgPane').removeClass(className);
    /*setTimeout(function () {
     $('#msgPane').removeClass(className);
     }, 1800);*/
}

$('body').on('click', '.removeasset', function () {
    if (confirm('Are you sure?')) {
        $('#divLoading').addClass('show');
        var that = $(this).closest('tr')
        var asset_id = $(this).data('asset');
        $.ajax({
            url: url + 'EntitySettingController/remove_asset',
            type: 'post',
            dataType: 'json',
            data: {asset_id: asset_id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    that.remove();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

/*$(document).ready(function() {
 var formData = new FormData();
 formData.append('test', 45);
 console.log(formData);
 for (var key of formData.entries()) {
 console.log(key[0] + ', ' + key[1]);
 }
 });*/


function create_yes_addbutton(id) {
    var map_field = $('#map_fields' + id).val();
    var end_point = $('#end_point_control' + id).val();
    var error = 0;
    if (map_field == '') {
        $('#map_fields' + id).css('border-color', 'red');
        error = 1;
    } else {
        $('#map_fields' + id).css('border-color', '');
    }

    if (end_point == '') {
        $('#end_point_control' + id).css('border-color', 'red');
        error = 1;
    } else {
        $('#end_point_control' + id).css('border-color', '');
    }

    if (error == 0) {
        var text = $('#map_fields' + id + ' option:selected').text();
        var ent_id = $('#ent_id').val();
        var api_id = $('#api_settings_id' + id).val();

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_map_fields',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, api: map_field, text: text, end_point: end_point, api_id: api_id, task_type: id},
            success: function (res) {
//                console.log(res);
                $('#divLoading').removeClass('show');
                if (res.success) {
                    $('#map_fields' + id).val('');
                    $('#end_point_control' + id).val('');

                    /*var html = "<div class='input-group' id=remove_create_yes" + res.API_Mapping_Id + "><div class='col-md-2'><input type='text' value='" + res.API_Field + "' class='form-control'></div><div class='col-md-4'><input type='text' value='" + res.End_Point +
                     "' class='form-control'></div><div class='col-md-2'><span id=remove_ele_id" + res.API_Mapping_Id + " data-map_id='" + res.API_Mapping_Id +
                     "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_create_yes'></span></div></div>";
                     */
                    var html = "<tr id=remove_create_yes" + res.API_Mapping_Id + "><td>" + res.API_Field + "</td><td>" + res.End_Point + "</td><td><span id=remove_ele_id" + res.API_Mapping_Id + " data-map_id='" + res.API_Mapping_Id +
                            "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_create_yes'></span></td></tr>";
                    $('#append_create_yes_data' + res.task_type).append(html);

                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    }
}

$('body').on('click', '.remove_create_yes', function () {
    if (confirm('Are you sure?')) {
        $('#divLoading').addClass('show');
        var id = $(this).data('map_id');
        var that = $(this);
        $.ajax({
            url: url + 'EntitySettingController/remove_map_fields',
            type: 'post',
            dataType: 'json',
            data: {map_id: id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    $('#remove_create_yes' + id).remove();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    }
});

function changeCompletedScreen(type, id) {
    var value = 0;
    if ($('#' + type + '_' + id).is(":checked")) {
        value = 1;
    }
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/update_complete_screen',
        type: 'post',
        dataType: 'json',
        data: {task_type: id, type: type, value: value},
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.success) {
                showInformation('success', res.success);
            } else {
                showInformation('error', 'Something went wrong! Please try again!');
            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });
}

function completedScreen(id, values) {
    if (values.signature == 1)
        $('#signature_' + id).prop('checked', true);
    if (values.ratings == 1)
        $('#ratings_' + id).prop('checked', true);
    if (values.comments == 1)
        $('#comments_' + id).prop('checked', true);
}