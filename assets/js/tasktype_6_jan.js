var categories = [], assets = [], tabs = [], create_no = [], create_yes = [], update_yes = [], assets_yes = [], onhold_yes = [], reject_yes = [];
var create_yes_list = [], update_yes_list = [], assets_yes_list = [], onhold_yes_list = [], reject_yes_list = [];
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
                    showInformation('error', res.error);
                    $('#divLoading').removeClass('show');
                } else {
                    var tmpTabs = {id: res.id, task_type: res.task_type, task_type_description: res.task_type_description, integrated_api: res.integrated_api};
                    tabs.push(tmpTabs);
                    cloneTask(res.id, res.task_type);
                    selectedOptions(res.id, res.integrated_api);
                    appendTaskDependency('', true);
                    stateValues(res.id, res.states_data);
                    $('#task_type_name').val('');
                    $('#divLoading').removeClass('show');
                }
            }, error: function (error) {
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

    clone_div.find('#label').attr({id: "label" + id + ""});
    clone_div.find('#field_type').attr({id: "field_type" + id + ""});
    clone_div.find('#limit').attr({id: "limit" + id + ""});
    clone_div.find('#category').attr({id: "category" + id + ""});
    clone_div.find('#create_table').attr({id: "create_table_" + id + ""});

    clone_div.find('.update_api1').attr({name: "update_api_" + id, onchange: "togIntegratedApi('update', " + id + ", true)", class: ''});
    clone_div.find('#update_api_settings_id').attr({id: "update_api_settings_id_" + id});
    clone_div.find('#update_method1').attr({id: "update_method_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_endpoint1').attr({id: "update_endpoint_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_username1').attr({id: "update_username_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_password1').attr({id: "update_password_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_xml_file1').attr({id: "update_xml_file_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_api_key1').attr({id: "update_api_key_" + id, class: "form-control update-validate" + id});

    clone_div.find('#update_integrated_api').attr({id: "update_integrated_api_" + id});
    clone_div.find('#update_integrated_api_no').attr({id: "update_integrated_api_no_" + id});

    clone_div.find('#update_label').attr({id: "update_label_" + id});
    clone_div.find('#update_field_type').attr({id: "update_field_type_" + id, onchange: "selectIntegrated(" + id + ")"});
    clone_div.find('#update_limit').attr({id: "update_limit_" + id});
    clone_div.find('#update_tab_category').attr({id: "update_tab_category_" + id});
    clone_div.find('.update_available_api1').attr({name: "update_available_api_" + id, onchange: "changeSelIntegrated(" + id + ")", class: ''});
    clone_div.find('#add_update_api').attr({id: "add_update_api_" + id, onclick: "add_api_data('update', " + id + ")"});

    clone_div.find('.complete_api').attr({name: "complete_api_" + id, class: ''});
    clone_div.find('.signature').attr({id: "signature_" + id, class: '', onchange: "changeCompletedScreen('signature', " + id + ")"});
    clone_div.find('.ratings').attr({id: "ratings_" + id, class: '', onchange: "changeCompletedScreen('ratings', " + id + ")"});
    clone_div.find('.comments').attr({id: "comments_" + id, class: '', onchange: "changeCompletedScreen('comments', " + id + ")"});

    clone_div.find('#asset_integrated_api1').attr({id: "asset_integrated_api_" + id});
    clone_div.find('#asset_integrated_api_no1').attr({id: "asset_integrated_api_no_" + id});

    clone_div.find('#add_assets_api').attr({id: "add_assets_api_" + id, onclick: "add_api_data('assets', " + id + ")"});
    clone_div.find('#assets_api_settings_id').attr({id: "assets_api_settings_id_" + id});
    clone_div.find('#assets_method1').attr({id: "assets_method_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_endpoint1').attr({id: "assets_endpoint_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_username1').attr({id: "assets_username_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_password1').attr({id: "assets_password_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_xml_file1').attr({id: "assets_xml_file_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_api_key1').attr({id: "assets_api_key_" + id, class: "form-control assets-validate" + id});

    clone_div.find('#asset_status').attr({name: "asset_status" + id, id: '', onchange: "changeIntegratedApi(" + id + ", 'asset_status', '')"});
    clone_div.find('.asset_api1').attr({name: "asset_api_" + id, onchange: "togIntegratedApi('asset', " + id + ", true)", class: ''});
    clone_div.find('#asset_upload1').attr({id: "asset_upload_" + id});
    clone_div.find('#asset_upload_csv1').attr({id: "asset_upload_csv_" + id, onchange: "upload_csv(" + id + ")"});
    clone_div.find('#asset_display_name1').attr({id: "asset_display_name_" + id});
    clone_div.find('#asset_type1').attr({id: "asset_type_" + id});
    clone_div.find('#asset_description1').attr({id: "asset_description_" + id});
    clone_div.find('#add_asset_value1').attr({onclick: "add_asset_value(" + id + ")", id: ''});
    clone_div.find('#append_asset_data1').attr({id: "append_asset_data_" + id});

    clone_div.find('#create_method').attr({id: "create_method_" + id, class: "form-control create-validate" + id});
    clone_div.find('#create_endpoint').attr({id: "create_endpoint_" + id, class: "form-control create-validate" + id});
    clone_div.find('#create_username').attr({id: "create_username_" + id, class: "form-control create-validate" + id});
    clone_div.find('#create_password').attr({id: "create_password_" + id, class: "form-control create-validate" + id});
    clone_div.find('#create_xml_file').attr({id: "create_xml_file_" + id, class: "form-control create-validate" + id});
    clone_div.find('#create_api_key').attr({id: "create_api_key_" + id, class: "form-control create-validate" + id});

    clone_div.find('#add_create_api').attr({id: "add_create_api_" + id, onclick: "add_api_data('create', " + id + ")"});

    clone_div.find('#create_yes_addbutton').attr({id: "create_yes_addbutton" + id, onclick: "addMapFields('create', " + id + ")"});
    clone_div.find('#append_create_yes_data').attr({id: "append_create_yes_data" + id});
    clone_div.find('#create_api_settings_id').attr({id: "create_api_settings_id_" + id});

    clone_div.find('#create_map_fields').attr({id: "create_map_fields" + id, class: "form-control create_validate_map" + id});
    clone_div.find('#create_end_point_control').attr({id: "create_end_point_control" + id, class: "form-control create_validate_map" + id});

    clone_div.find('#update_map_fields').attr({id: "update_map_fields" + id, class: "form-control update_validate_map" + id});
    clone_div.find('#update_end_point_control').attr({id: "update_end_point_control" + id, class: "form-control update_validate_map" + id});
    clone_div.find('#update_yes_addbutton').attr({id: "update_yes_addbutton" + id, onclick: "addMapFields('update', " + id + ")"});
    clone_div.find('#append_update_yes_data').attr({id: "append_update_yes_data" + id});

    clone_div.find('#assets_map_fields').attr({id: "assets_map_fields" + id, class: "form-control assets_validate_map" + id});
    clone_div.find('#assets_end_point_control').attr({id: "assets_end_point_control" + id, class: "form-control assets_validate_map" + id});
    clone_div.find('#assets_yes_addbutton').attr({id: "assets_yes_addbutton" + id, onclick: "addMapFields('assets', " + id + ")"});
    clone_div.find('#append_assets_yes_data').attr({id: "append_assets_yes_data" + id});

    clone_div.find('#assigned_state').attr({id: "assigned_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#accepted_state').attr({id: "accepted_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#rejected_state').attr({id: "rejected_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#inprogress_state').attr({id: "inprogress_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#onhold_state').attr({id: "onhold_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#resolved_state').attr({id: "resolved_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#submit_state').attr({id: "submit_state_" + id, onclick: "updateStates(" + id + ")"});

    clone_div.find('.allow_for').attr({name: "allow_for" + id, class: '', onchange: "changeIntegratedApi(" + id + ", 'allow_for', '')"});

    clone_div.find('#onhold_map_fields').attr({id: "onhold_map_fields" + id, class: "form-control onhold_validate_map" + id});
    clone_div.find('#onhold_end_point_control').attr({id: "onhold_end_point_control" + id, class: "form-control onhold_validate_map" + id});
    clone_div.find('#onhold_yes_addbutton').attr({id: "onhold_yes_addbutton" + id, onclick: "addMapFields('onhold', " + id + ")"});
    clone_div.find('#append_onhold_yes_data').attr({id: "append_onhold_yes_data" + id});

    clone_div.find('#reject_map_fields').attr({id: "reject_map_fields" + id, class: "form-control reject_validate_map" + id});
    clone_div.find('#reject_end_point_control').attr({id: "reject_end_point_control" + id, class: "form-control reject_validate_map" + id});
    clone_div.find('#reject_yes_addbutton').attr({id: "reject_yes_addbutton" + id, onclick: "addMapFields('reject', " + id + ")"});
    clone_div.find('#append_reject_yes_data').attr({id: "append_reject_yes_data" + id});

    clone_div.find('#onhold_api_settings_id').attr({id: "onhold_api_settings_id_" + id});
    clone_div.find('#onhold_method').attr({id: "onhold_method_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_endpoint').attr({id: "onhold_endpoint_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_username').attr({id: "onhold_username_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_password').attr({id: "onhold_password_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_xml_file').attr({id: "onhold_xml_file_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_api_key').attr({id: "onhold_api_key_" + id, class: "form-control onhold-validate" + id});

    clone_div.find('#onhold_integrated_api1').attr({id: "onhold_integrated_api_" + id});
    clone_div.find('#add_onhold_api').attr({id: "add_onhold_api_" + id, onclick: "add_api_data('onhold', " + id + ")"});
    clone_div.find('.onhold_api1').attr({name: "onhold_api_" + id, onchange: "togIntegratedApi('onhold', " + id + ", true)", class: ''});
    clone_div.find('#onhold_integrated_api_no1').attr({id: "onhold_integrated_api_no_" + id});
    clone_div.find('#onhold_command').attr({id: "onhold_command_" + id});
    clone_div.find('#onhold_command_list').attr({id: "onhold_command_list_" + id});
    clone_div.find('#onhold_command_submit').attr({id: "onhold_command_submit_" + id, onclick: "appendCommandData('onhold', " + id + ")"});
    clone_div.find('.onhold_comment').attr({name: "onhold_comment" + id, onchange: "changeIntegratedApi(" + id + ", 'onhold_comment', '')", class: ''});

    clone_div.find('#reject_api_settings_id').attr({id: "reject_api_settings_id_" + id});
    clone_div.find('#reject_method').attr({id: "reject_method_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_endpoint').attr({id: "reject_endpoint_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_username').attr({id: "reject_username_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_password').attr({id: "reject_password_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_xml_file').attr({id: "reject_xml_file_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_api_key').attr({id: "reject_api_key_" + id, class: "form-control reject-validate" + id});

    clone_div.find('#reject_integrated_api1').attr({id: "reject_integrated_api_" + id});
    clone_div.find('#add_reject_api').attr({id: "add_reject_api_" + id, onclick: "add_api_data('reject', " + id + ")"});
    clone_div.find('.reject_api1').attr({name: "reject_api_" + id, onchange: "togIntegratedApi('reject', " + id + ", true)", class: ''});
    clone_div.find('#reject_command').attr({id: "reject_command_" + id});
    clone_div.find('#reject_command_list').attr({id: "reject_command_list_" + id});
    clone_div.find('#reject_command_submit').attr({id: "reject_command_submit_" + id, onclick: "appendCommandData('reject', " + id + ")"});
    clone_div.find('.reject_comment').attr({name: "reject_comment" + id, onchange: "changeIntegratedApi(" + id + ", 'reject_comment', '')", class: ''});

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
                    showInformation('error', res.error);
                }
            }, error: function (error) {
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
                    showInformation('error', res.error);
                }
                $('#divLoading').removeClass('show');
            },
            error: function (error) {
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
                    showInformation('error', res.error);
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
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function togIntegratedApi(type, id, updateStatus) {
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
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function showCategories() {
    var table_id = [];
    for (var j = 0; j < categories.length; j++) {
        if (table_id.indexOf(categories[j].task_type) == -1) {
            table_id.push(categories[j].task_type);
            $('#category_table_' + categories[j].task_type).find("tr:not(:first)").remove();
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
                showInformation('error', res.error);
            } else {
                showInformation('success', res.success);
            }
        },
        error: function (error) {
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

function create_not_integrate(id) {
    var create_label = document.getElementById("create_label" + id).value;
    var create_field_type = document.getElementById("create_field_type" + id).value;
    var create_limit = document.getElementById("create_limit" + id).value;
    var create_category = document.getElementById("create_category" + id).value;

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

    if (create_label != "" && create_field_type != "" && create_limit != "" && create_category != "") {


        var formData = {
            'ent_id': ent_id,
            'task_id': id,
            'label': create_label,
            'field_type': create_field_type,
            'limit': create_limit,
            'category': create_category,
            'task_type': id
        };
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/create_not_integrated',
            type: 'post',
            data: formData,
            async: true, //blocks window close
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var selCategoryText = $("#create_category" + id + " option:selected").text();

                    create_no.push(res);
                    var htm = '<tr><td>' + res.Ext_att_name + '</td><td>' + res.Ext_att_type + '</td><td>' + res.Ext_att_size + '</td><td>' + selCategoryText + '</td><td><span id="remove_id' + res.extr_att_id + '" onclick="remove_row(' + res.extr_att_id + ')" class="glyphicon glyphicon-remove"></span></td></tr>';
                    $("#create_table_" + id + "  tbody").append(htm);

                    document.getElementById("create_label" + id).value = "";
                    document.getElementById("create_field_type" + id).value = "";
                    document.getElementById("create_limit" + id).value = "";
                    document.getElementById("create_category" + id).value = "";
                    var option = '<option value="' + res.extr_att_id + '">' + res.Ext_att_name + '</option>';
                    $("#create_map_fields" + id).append(option);
                    $("#update_map_fields" + id).append(option);
                    $("#assets_map_fields" + id).append(option);
                    $("#onhold_map_fields" + id).append(option);
                    $("#reject_map_fields" + id).append(option);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }

            },
            error: function () {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function remove_row(id) {
    if (confirm('Are you sure?')) {
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/create_not_integrated_delete',
            type: 'post',
            data: {id: id},
            success: function (data) {
                $('#divLoading').removeClass('show');
                if (data == 'success') {
                    var option = '<option value="">Select</option>', attr_id = [];
                    for (var j = 0; j < create_no.length; j++) {
                        if (attr_id.indexOf(create_no[j].Task_type_ID) == -1) {
                            $("#create_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#update_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#assets_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#onhold_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#reject_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            attr_id.push(create_no[j].Task_type_ID);
                        }
                        if (id == create_no[j].extr_att_id) {
                            create_no.splice(j, 1);
                            $("#remove_id" + id + "").closest("tr").remove();
                        } else {
                            option += "<option value='" + create_no[j].extr_att_id + "'>" + create_no[j].Ext_att_name + "</option>";
                        }
                    }
                    for (var i = 0; i < create_no.length; i++) {
                        $("#create_map_fields" + create_no[i].Task_type_ID).html(option);
                        $("#update_map_fields" + create_no[i].Task_type_ID).html(option);
                        $("#assets_map_fields" + create_no[i].Task_type_ID).html(option);
                        $("#onhold_map_fields" + create_no[i].Task_type_ID).html(option);
                        $("#reject_map_fields" + create_no[i].Task_type_ID).html(option);
                    }

                    for (var k = 0; k < create_yes_list.length; k++) {
                        if (id == create_yes_list[k].API_Field) {
                            $('#append_create_yes_data' + create_yes_list[k].task_type).find('tr').slice(1).remove();
                            create_yes_list.splice(k, 1);
                            showMapFields('create', create_yes_list);
                        }
                    }
                    for (var k = 0; k < update_yes_list.length; k++) {
                        if (id == update_yes_list[k].API_Field) {
                            $('#append_update_yes_data' + update_yes_list[k].task_type).find('tr').slice(1).remove();
                            update_yes_list.splice(k, 1);
                            showMapFields('update', update_yes_list);
                        }
                    }
                    for (var k = 0; k < assets_yes_list.length; k++) {
                        if (id == assets_yes_list[k].API_Field) {
                            $('#append_assets_yes_data' + assets_yes_list[k].task_type).find('tr').slice(1).remove();
                            assets_yes_list.splice(k, 1);
                            showMapFields('assets', assets_yes_list);
                        }
                    }
                    for (var k = 0; k < onhold_yes_list.length; k++) {
                        if (id == onhold_yes_list[k].API_Field) {
                            $('#append_onhold_yes_data' + onhold_yes_list[k].task_type).find('tr').slice(1).remove();
                            onhold_yes_list.splice(k, 1);
                            showMapFields('onhold', onhold_yes_list);
                        }
                    }
                    for (var k = 0; k < reject_yes_list.length; k++) {
                        if (id == reject_yes_list[k].API_Field) {
                            $('#append_reject_yes_data' + reject_yes_list[k].task_type).find('tr').slice(1).remove();
                            reject_yes_list.splice(k, 1);
                            showMapFields('reject', reject_yes_list);
                        }
                    }
                }
            }
            ,
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function getTabDetails() {
    $('#divLoading').addClass('show');
    var ent_id = $('#ent_id').val();
    $.ajax({
        url: url + 'EntitySettingController/getTabDetails',
        type: 'post',
        data: {ent_id: ent_id},
        dataType: 'json',
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.error) {
                showInformation('error', res.error);
            } else {
                tabs = res.task_type;
                categories = res.categories;
                assets = res.assets;
                create_no = res.create;
                api_data = res.api_data;
                integrateData = res.integrateData;

                if (tabs.length > 0) {
                    var htm = '<option>Loading....</option>';
                    for (var i = 0; i < tabs.length; i++) {
                        cloneTask(tabs[i].id, tabs[i].task_type);
                        htm += '<option value="' + tabs[i].id + '">' + tabs[i].task_type + '</option>';
                        selectedOptions(tabs[i].id, tabs[i].integrated_api);
                        completedScreen(tabs[i].id, tabs[i].completed_screen);
                        stateValues(tabs[i].id, tabs[i].states_data);
                    }
                    appendTaskDependency(htm, false);
                }
                $('#parent_nav.nav-tabs li:nth-child(1) a').click();

                if (res.api_data.create) {
                    showApiData('create', res.api_data.create);
                }
                if (res.api_data.update) {
                    showApiData('update', res.api_data.update);
                }
                if (res.api_data.assets) {
                    showApiData('assets', res.api_data.assets);
                }
                if (res.api_data.onhold) {
                    showApiData('onhold', res.api_data.onhold);
                }
                if (res.api_data.reject) {
                    showApiData('reject', res.api_data.reject);
                }

                if (res.integrateData.create) {
                    create_yes_list = res.integrateData.create;
                    showMapFields('create', res.integrateData.create);
                }
                if (res.integrateData.update) {
                    update_yes_list = res.integrateData.update;
                    showMapFields('update', res.integrateData.update);
                }
                if (res.integrateData.assets) {
                    assets_yes_list = res.integrateData.assets;
                    showMapFields('assets', res.integrateData.assets);
                }
                if (res.integrateData.onhold) {
                    onhold_yes_list = res.integrateData.onhold;
                    showMapFields('onhold', res.integrateData.onhold);
                }
                if (res.integrateData.reject) {
                    reject_yes_list = res.integrateData.reject;
                    showMapFields('reject', res.integrateData.reject);
                }

                if (res.commands.onhold) {
                    showCommands('onhold', res.commands.onhold);
                }
                if (res.commands.reject) {
                    showCommands('reject', res.commands.reject);
                }

                showCategories();
                showAssets();
                showCreate_Api_No();
            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        },
    });
}

function stateValues(id, data) {
    $('#assigned_state_' + id).val(data.assigned);
    $('#accepted_state_' + id).val(data.accepted);
    $('#rejected_state_' + id).val(data.rejected);
    $('#inprogress_state_' + id).val(data.inprogress);
    $('#onhold_state_' + id).val(data.onhold);
    $('#resolved_state_' + id).val(data.resolved);
}

function showApiData(type, data) {
    for (var i = 0; i < data.length; i++) {
        $("#" + type + "_method_" + data[i].qm_task_type_id).val(data[i].API_Method_Name);
        $("#" + type + "_endpoint_" + data[i].qm_task_type_id).val(data[i].API_End_point);
        $("#" + type + "_username_" + data[i].qm_task_type_id).val(data[i].API_User_name);
        $("#" + type + "_password_" + data[i].qm_task_type_id).val(data[i].API_Password);
        $("#" + type + "_xml_file_" + data[i].qm_task_type_id).val(data[i].API_XML_File);
        $("#" + type + "_api_key_" + data[i].qm_task_type_id).val(data[i].API_Key);
        $("#" + type + "_api_settings_id_" + data[i].qm_task_type_id).val(data[i].API_Settings_ID);

        $("#add_" + type + "_api_" + data[i].qm_task_type_id).hide();
    }
}

function showMapFields(type, data) {
    for (var i = 0; i < data.length; i++) {
        var html = '';
        html = "<tr id=remove_map_fields" + data[i].API_Mapping_Id + "><td>" + data[i].MapTo + "</td><td>" + data[i].End_Point + "</td><td><span id=remove_ele_id" + data[i].API_Mapping_Id + " data-map_id='" + data[i].API_Mapping_Id +
                "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_map_fields'></span></td></tr>";
        $('#append_' + type + '_yes_data' + data[i].task_type).append(html);
    }
}

function showCommands(type, data) {
    for (var i = 0; i < data.length; i++) {
        $('#' + type + '_command_list_' + data[i].task_type).append('<div>' + data[i].command + '</div>');
    }
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
    togIntegratedApi('create', id, '');
    $("input[name=update_api_" + id + "][value=" + values.update + "]").attr('checked', 'checked');
    togIntegratedApi('update', id, '');
    $("input[name=asset_api_" + id + "][value=" + values.asset + "]").attr('checked', 'checked');
    $("input[name=asset_status" + id + "][value=" + values.asset_status + "]").attr('checked', 'checked');
    togIntegratedApi('asset', id, '');
    $("input[name=allow_for" + id + "][value=" + values.allow_for + "]").attr('checked', 'checked');
    $("input[name=onhold_api_" + id + "][value=" + values.onhold + "]").attr('checked', 'checked');
    togIntegratedApi('onhold', id, '');
    $("input[name=onhold_comment" + id + "][value=" + values.onhold_comment + "]").attr('checked', 'checked');
    $("input[name=reject_api_" + id + "][value=" + values.reject + "]").attr('checked', 'checked');
    togIntegratedApi('reject', id, '');
    $("input[name=reject_comment" + id + "][value=" + values.reject_comment + "]").attr('checked', 'checked');
}

function showCreate_Api_No() {
    for (var i = 0; i < create_no.length; i++) {
        var htm = '', option = '';
        htm += '<tr><td>' + create_no[i].Ext_att_name + '</td><td>' + create_no[i].Ext_att_type + '</td><td>' + create_no[i].Ext_att_size + '</td><td>' + create_no[i].category + '</td><td><span id="remove_id' + create_no[i].extr_att_id + '" onclick="remove_row(' + create_no[i].extr_att_id + ')" class="glyphicon glyphicon-remove"></span></td></tr>';
        $("#create_table_" + create_no[i].Task_type_ID).append(htm);
        option += "<option value='" + create_no[i].extr_att_id + "'>" + create_no[i].Ext_att_name + "</option>";
        $("#create_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#update_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#assets_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#onhold_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#reject_map_fields" + create_no[i].Task_type_ID).append(option);
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

function addMapFields(type, id) {
    var map_field = $('#' + type + '_map_fields' + id).val();
    var end_point = $('#' + type + '_end_point_control' + id).val();
    var api_id = $('#' + type + '_api_settings_id_' + id).val();
    var error = 0;
    if (map_field == '') {
        $('#' + type + '_map_fields' + id).css('border-color', 'red');
        error = 1;
    } else {
        $('#' + type + '_map_fields' + id).css('border-color', '');
    }

    if (end_point == '') {
        $('#' + type + '_end_point_control' + id).css('border-color', 'red');
        error = 1;
    } else {
        $('#' + type + '_end_point_control' + id).css('border-color', '');
    }
    if (api_id == '') {
        error = 1;
        add_api_data(type, id);
    }

    if (error == 0) {
        var text = $('#' + type + '_map_fields' + id + ' option:selected').text();
        var ent_id = $('#ent_id').val();

        var tab_id = '';
        if (type == 'create') {
            tab_id = 2;
        } else if (type == 'update') {
            tab_id = 3;
        } else if (type == 'assets') {
            tab_id = 5;
        } else if (type == 'onhold') {
            tab_id = 8;
        } else if (type == 'reject') {
            tab_id = 9;
        }

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_map_fields',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, api: map_field, text: text, end_point: end_point, api_id: api_id, task_type: id, task_type_tab: tab_id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    $('#' + type + '_map_fields' + id).val('');
                    $('#' + type + '_end_point_control' + id).val('');

                    var html = "<tr id=remove_map_fields" + res.API_Mapping_Id + "><td>" + res.MapTo + "</td><td>" + res.End_Point + "</td><td><span id=remove_ele_id" + res.API_Mapping_Id + " data-map_id='" + res.API_Mapping_Id +
                            "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_map_fields'></span></td></tr>";
                    $('#append_' + type + '_yes_data' + res.task_type).append(html);

                    showInformation('success', res.success);
                    delete res.success;
                    if (type == 'create') {
                        create_yes_list.push(res);
                    } else if (type == 'update') {
                        update_yes_list.push(res);
                    } else if (type == 'assets') {
                        assets_yes_list.push(res);
                    } else if (type == 'onhold') {
                        onhold_yes_list.push(res);
                    } else if (type == 'reject') {
                        reject_yes_list.push(res);
                    }
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

$('body').on('click', '.remove_map_fields', function () {
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
                    that.closest("tr").remove();
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

function selectIntegrated(id) {
    var selValue = $('#update_field_type_' + id).val();
    if (selValue == 'SELECT') {
        $("input[name=update_available_api_" + id + "]").prop("checked", false);
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#select_integrated_' + id).show();
    } else if (selValue == 'RADIO LIST') {
        $('.select_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#radio_integrated_' + id).show();
    } else if (selValue == 'CHECKBOX') {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).show();
    } else {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
    }
}

function changeSelIntegrated(id) {
    var value = $("input[name=update_available_api_" + id + "]:checked").val();
    if (value == 1) {
        $('#select_integrated_no_' + id).hide();
        $('#select_integrated_yes_' + id).show();
    } else {
        $('#select_integrated_yes_' + id).hide();
        $('#select_integrated_no_' + id).show();
    }
}

function add_api_data(type, id) {
    var error = 0;
    $("input." + type + "-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var method = $("#" + type + "_method_" + id).val();
        var endpoint = $("#" + type + "_endpoint_" + id).val();
        var username = $("#" + type + "_username_" + id).val();
        var password = $("#" + type + "_password_" + id).val();
        var xml_file = $("#" + type + "_xml_file_" + id).val();
        var api_key = $("#" + type + "_api_key_" + id).val();
        var api = 1;
        var ent_id = $('#ent_id').val();
        var tab_id = 0;

        if (type == 'create') {
            tab_id = 2;
        } else if (type == 'update') {
            tab_id = 3;
        } else if (type == 'assets') {
            tab_id = 5;
        } else if (type == 'onhold') {
            tab_id = 8;
        } else if (type == 'reject') {
            tab_id = 9;
        }

        var formData = {
            'ent_id': ent_id,
            'tab_id': tab_id,
            'task_type_id': id,
            'method': method,
            'endpoint': endpoint,
            'username': username,
            'password': password,
            'xml_file': xml_file,
            'api_key': api_key,
            'api': api

        };
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/create_integrated',
            type: 'post',
            data: formData,
            async: true,
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    $("#add_" + type + "_api_" + id).hide();
                    $("#" + type + "_api_settings_id_" + id).val(res.extr_att_id);
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            },
            error: function () {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function appendCommandData(type, id) {
    var value = $('#' + type + '_command_' + id).val();
    if (value) {
        $('#' + type + '_command_' + id).css('border-color', '');

        var ent_id = $('#ent_id').val();
        var tab_id = '';
        if (type == 'onhold') {
            tab_id = 8;
        } else if (type == 'reject') {
            tab_id = 9;
        }
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/addCommands',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type: id, tab_id: tab_id, command: value},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    $('#' + type + '_command_list_' + id).append('<div>' + value + '</div>');
                    $('#' + type + '_command_' + id).val('');
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
        $('#' + type + '_command_' + id).css('border-color', 'red');
    }
}

function updateStates(id) {
//    alert(id);
    var error = 0;
    $("input.states-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var assigned = $('#assigned_state_' + id).val();
        var accepted = $('#accepted_state_' + id).val();
        var rejected = $('#rejected_state_' + id).val();
        var inprogress = $('#inprogress_state_' + id).val();
        var onhold = $('#onhold_state_' + id).val();
        var resolved = $('#resolved_state_' + id).val();

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/update_states',
            type: 'post',
            dataType: 'json',
            data: {task_type: id, assigned: assigned, accepted: accepted, rejected: rejected, inprogress: inprogress, onhold: onhold, resolved: resolved},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    showInformation('success', res.success);
                } else {
                    showInformation('success', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    }
}