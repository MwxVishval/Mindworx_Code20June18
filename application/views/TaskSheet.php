<style>

    #onhold_value:hover{
        background-color:#FF0000;
    }


    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    .nav-tabs > li > span {
        display:none;
        cursor:pointer;
        position:absolute;
        right: 6px;
        top: 8px;
        color: red;
    }

    .nav-tabs > li:hover > span {
        display: inline-block;
    }

    span {
        cursor: pointer;
    }

    .create_add_button_2{
        margin-top: 23px;
    }

    #divLoading.show {
        display : block;
        position : fixed;
        z-index: 100;
        background-image : url('/Qmobility2/assets/images/loading.gif');
        background-color:#666;
        opacity : 0.4;
        background-repeat : no-repeat;
        background-position : center;
        left : 0;
        bottom : 0;
        right : 0;
        top : 0;
    }

    .radio_integrated {
        border: 1px solid #050505;
        height: 194px;
        overflow-x: auto;
        overflow-y: auto;
    }

</style>


<div class="" id="msgPane" style="display: none">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <span id="msg"></span>
</div>


<div class="x_panel" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Entity Tasksheet Create</h2>
        <div class="clearfix"></div>
    </div>
    <input type="hidden" name="ent_id" id="ent_id" value="<?= $ent_id ?>">

    <div class="clearfix"></div>
    <br>

    <div class="form-group">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Task Type Name" id="task_type_name">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-success add-task-type">Add</button>
        </div>
    </div>
    <br>
    <br>

    <div id="exTab1">	
        <ul id="parent_nav" class="nav nav-tabs">

        </ul>

        <div id="parent_tab" class="tab-content clearfix">

        </div>
    </div>
</div>

<div class="tab-pane active" id="clone" style="display: none">
    <div class="x_content">
        <div class="col-sm-3">
            <ul class="nav nav-tabs tabs-left">
                <li class="active">
                    <a class="categories1" href="#categories" data-toggle="tab">Categories</a>
                </li>
                <li>
                    <a class="create1" href="#create" data-toggle="tab">Create</a>
                </li>
                <li>
                    <a class="update1" href="#update" data-toggle="tab">Update</a>
                </li>
                <li>
                    <a class="complete1" href="#complete" data-toggle="tab">Complete</a>
                </li>
                <li>
                    <a class="assets1" href="#assets" data-toggle="tab">Assets</a>
                </li>
                <li>
                    <a class="states1" href="#states" data-toggle="tab">States</a>
                </li>
                <li>
                    <a class="flow1" href="#flow" data-toggle="tab">Flow</a>
                </li>
                <li>
                    <a class="onhold1" href="#onhold" data-toggle="tab">On Hold</a>
                </li>
                <li>
                    <a class="reject1" href="#reject" data-toggle="tab">Reject</a>
                </li>
                <li>
                    <a class="engineertype1" href="#engineertype" data-toggle="tab">Engineer Type</a>
                </li>
                <li>
                    <a class="taskreport1" href="#taskreport" data-toggle="tab">Task Report</a>
                </li>
            </ul>
        </div>

        <div class="col-sm-9">
            <div class="tab-content">
                <div class="tab-pane active" id="categories1">
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control" placeholder="Category" id="category_add1">
                        </div>
                        <button type="button" class="btn btn-success" id="category_add_button1">ADD</button>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="category_table1">
                                <tr>
                                    <th>Category</th>
                                    <th>Separate Update Screen</th>
                                    <th style="width: 10%"> Action </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="create1">
                    <div class="input-group">
                        <label>Task start dependency?</label>
                        <select class="form-control" id="task_dependency1">
                            <option value="">Loading....</option>
                        </select>
                    </div>

                    <div>
                        <div class="input-group">
                            <div class="col-xs-2">
                                <input type="text" id="create_label" name="label" placeholder="Label" class="form-control">
                            </div>
                            <div class="col-xs-2">
                                <select class="form-control" id="create_field_type" name="field_type">
                                    <option value="">Field Type</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="NUMBER">NUMBER</option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <input type="number" name="create_limit" id="create_limit" placeholder="Limit" class="form-control">
                            </div>
                            <div class="col-xs-2">
                                <select class="form-control" id="create_category" name="category">
                                    <option value="">Select</option>
                                    <option value="1">Category</option>
                                </select>
                            </div>
                            <div class="col-xs-2">

                                <?php $attri_control = array('1' => 'simple text box', '2' => 'combobox', '3' => 'listview', '4' => 'option box', '5' => 'checkbox', '6' => 'rich text'); ?>
                                <select class="form-control" id="create_attri_control" name="create_attri_control">
                                    <option value="">Select</option>
                                    <?php foreach ($attri_control as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="button" class="btn btn-success" onclick="create_not_integrate()" id="created_add_not_integrated1">ADD</button>
                        </div>
                        <div class="form-group">
                            <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="create_table">
                                <thead>
                                    <tr>
                                        <th>Label</th>
                                        <th>Type</th>
                                        <th>Limit</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="input-group radio">
                        <span>Integrated API?</span>
                        <label><input type="radio" value="1" class="create_api1"> Yes </label>
                        <label><input type="radio" value="0" class="create_api1"> No </label>
                    </div>

                    <div id="create_integrated_api_no1" style="display: none">

                    </div>

                    <div id="create_integrated_api1" style="display:none">
                        <div class="input-group">
                            <input type="hidden" id="create_api_settings_id">
                            <div class="col-xs-2">
                                <input type="text" id="create_method" rel="validate" placeholder="Method" class="form-control">
                            </div>
                            <div class="col-xs-2">
                                <input type="text"  id="create_endpoint" rel="validate" placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-xs-2">
                                <input type="text" id="create_username" rel="validate" placeholder="Username" class="form-control" >
                            </div>
                            <div class="col-xs-2">
                                <input type="text" id="create_password" rel="validate" placeholder="Password" class="form-control" >
                            </div>
                            <div class="col-xs-2">
                                <input type="text" id="create_xml_file"  rel="validate" placeholder="XML file" class="form-control" >
                            </div>
                            <div class="col-xs-2">
                                <input type="text" id="create_api_key" rel="validate" placeholder="API Key" class="form-control" >
                            </div>
                        </div>
                        <div class="input-group pull-right">
                            <div class="col-md-2">
                                <button type="button" id="add_create_api" class="btn btn-success ">ADD</button>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col-md-4">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="create_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="create_end_point_control">
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="create_yes_addbutton" class="btn btn-success">ADD</button>
                            </div>
                        </div>
                        <div class="row">
                            <table id="append_create_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <th>Map Field</th>
                                    <th>End Point</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="update1">
                    <div class="input-group radio">
                        <span>Integrated API?</span>
                        <label><input type="radio" value="1" class="update_api1"/> Yes </label>
                        <label><input type="radio" value="0" class="update_api1"/> No </label>
                    </div>
                    <div class="form-group" style="display: none;">
                        <p>What end point to you want us POST back to?</p>
                    </div>

                    <div id="update_integrated_api" style="display: none;">
                        <input type="hidden" id="update_api_settings_id">
                        <div class="input-group">
                            <div class="col-md-2">
                                <input type="text" id="update_method1" name=""  placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="update_endpoint1" name=""  placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="update_username1" name=""  placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="update_password1" name=""  placeholder="Password" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="update_xml_file1" name=""  placeholder="XML File" class="form-control">
                            </div>
                            <div class="col-md-2 ">
                                <input type="text" id="update_api_key1" name=""  placeholder="API Key" class="form-control">
                            </div>
                        </div> 

                        <div class="input-group pull-right">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" id="add_update_api">ADD</button>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col-md-4">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="update_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="update_end_point_control">
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button type="button" id="update_yes_addbutton" class="btn btn-success">ADD</button>
                        </div>
                        <div class="row">
                            <table id="append_update_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <th>Map Field</th>
                                    <th>End Point</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="update_integrated_api_no" style="display: none;">

                    </div>
                </div>
                <div class="tab-pane" id="complete1">
                    <div class="input-group radio">
                        <span>Integrated API?</span>
                        <label><input type="radio" value="1" class="complete_api" disabled="disabled"> Yes </label>
                        <label><input type="radio" value="0" class="complete_api" disabled="disabled"> No </label>
                        <span> (To change the integration setting ,Please update on the Created Tab)</span>
                    </div>
                    <div class="form-group">
                        <p>Features on completed screen </p>
                        <form>
                            <div class="checkbox">
                                <label><input type="checkbox" value="1" class="signature"> Signature Box</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" value="1" class="ratings"> Ratings Widget</label>
                            </div>
                            <div class="checkbox ">
                                <label><input type="checkbox" value="1" class="comments"> Comments Field </label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="assets1">
                    <div class="input-group radio">
                        <span>Enable assets</span>
                        <label class="inline-radio"><input id="asset_status" type="radio"  value="1"> Yes </label>
                        <label class="inline-radio"><input id="asset_status" type="radio" value="0"> No </label>
                    </div>
                    <div class="input-group radio">
                        <span>Integrated API?</span>
                        <label class="inline-radio"><input class="asset_api1" type="radio"  value="1"> Yes </label>
                        <label class="inline-radio"><input class="asset_api1" type="radio" value="0"> No </label>
                    </div>
                    <div id="asset_integrated_api1" style="display: none;">
                        <input type="hidden" id="assets_api_settings_id">
                        <div class="input-group">
                            <p>Fetch Asset from list</p>
                            <div class="col-md-2">
                                <input type="text" id="assets_method1" name=""  placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="assets_endpoint1" name=""  placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="assets_username1" name=""  placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="assets_password1" name=""  placeholder="Password" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="assets_xml_file1" name=""  placeholder="XML File" class="form-control">
                            </div>
                            <div class="col-md-2 ">
                                <input type="text" id="assets_api_key1" name=""  placeholder="API Key" class="form-control">
                            </div>
                        </div> 
                        <div class="input-group pull-right">
                            <div class="col-md-2">
                                <button type="button" id="add_assets_api" class="btn btn-success ">ADD</button>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col-md-4">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="assets_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="assets_end_point_control">
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button type="button" id="assets_yes_addbutton" class="btn btn-success">ADD</button>
                        </div>
                        <div class="row">
                            <table id="append_assets_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <th>Map Field</th>
                                    <th>End Point</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="asset_integrated_api_no1" style="display:none">
                        <div class="input-group">
                            <div class="col-md-12">
                                <form id="asset_upload1" method="POST" enctype="multipart/form-data" >
                                    <input type="file" value="uploaded csv" id="asset_upload_csv1">
                                </form>
                            </div>
                        </div>
                        <div class="input-group">
                            <p>Or Enter items below</p>
                        </div>
                        <div class="input-group">
                            <div class="col-md-3">
                                <input type="text" id="asset_display_name1" placeholder="Display name" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="asset_type1" placeholder="Type" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="asset_description1" placeholder="Description" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="button" id="add_asset_value1" value="Add" class="btn btn-success">
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="append_asset_data1">
                                <tr>
                                    <th>Display Name</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="states1">
                    <div class="input-group">
                        <label>1. </label>
                        <input type="text" id="assigned_state">
                    </div>
                    <div class="input-group">
                        <label>2. </label>
                        <input type="text" id="accepted_state">
                    </div>
                    <div class="input-group">
                        <label>3. </label>
                        <input type="text" id="rejected_state">
                    </div>
                    <div class="input-group">
                        <label>4. </label>
                        <input type="text" id="inprogress_state">
                    </div>
                    <div class="input-group">
                        <label>5. </label>
                        <input type="text" id="onhold_state">
                    </div>
                    <div class="input-group">
                        <label>6. </label>
                        <input type="text" id="resolved_state">
                    </div>
                    <div class="input-group">
                        <input id="submit_state" type="button" value="Save" class="btn btn-success">
                    </div>
                </div>
                <div class="tab-pane" id="flow1">
                    <div class="input-group">
                        <h3>Allow For : </h3>
                    </div>
                    <div class="input-group radio">
                        <label><input type="radio" class="allow_for" value="0"> 1 accepted task at a time</label>
                    </div>
                    <div class="input-group radio">
                        <label><input type="radio" class="allow_for" value="1"> Multiple accepted tasks at a time</label>
                    </div>
                </div>

                <div class="tab-pane" id="onhold1">
                    <div class="input-group radio">
                        <label>Integrated API? </label>
                        <label><input type="radio" class="onhold_api1" value="1"> Yes </label>
                        <label><input type="radio" class="onhold_api1" value="0"> No </label>
                    </div>
                    <div class="input-group radio">
                        <label>Add comment field</label>
                        <label><input type="radio" class="onhold_comment" value="1"> Yes </label>
                        <label><input type="radio" class="onhold_comment" value="0"> No </label>
                    </div>
                    <div id="onhold_integrated_api1" style="display: none">
                        <input type="hidden" id="onhold_api_settings_id">
                        <div class="input-group">
                            <div class="col-md-2">
                                <input type="text" id="onhold_method" placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="onhold_endpoint" placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="onhold_username" placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="onhold_password" placeholder="Password" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="onhold_xml_file" placeholder="XML File" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="onhold_api_key" placeholder="Api Key" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <button type="button" class="btn btn-success" id="add_onhold_api">ADD</button>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col-md-4">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="onhold_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="onhold_end_point_control">
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button type="button" id="onhold_yes_addbutton" class="btn btn-success">ADD</button>
                        </div>
                        <div class="row">
                            <table id="append_onhold_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <th>Map Field</th>
                                    <th>End Point</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="onhold_integrated_api_no1" style="display: none">
                        <div class="input-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="onhold_command">
                            </div>
                            <div class="col-md-6 radio_integrated" id="onhold_command_list">

                            </div>
                        </div>
                        <div class="input-group">
                            <div class="col-md-6">
                                <input type="button" class="btn btn-success" value="ADD" id="onhold_command_submit">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="reject1">
                    <div class="input-group radio">
                        <label>Integrated API? </label>
                        <label><input type="radio" class="reject_api1" value="1"> Yes </label>
                        <label><input type="radio" class="reject_api1" value="0"> No </label>
                    </div>
                    <div class="input-group radio">
                        <label>Add comment field</label>
                        <label><input type="radio" class="reject_comment" value="1"> Yes </label>
                        <label><input type="radio" class="reject_comment" value="0"> No </label>
                    </div>
                    <div id="reject_integrated_api1" style="display: none">
                        <input type="hidden" id="reject_api_settings_id">
                        <div class="input-group">
                            <div class="col-md-2">
                                <input type="text" id="reject_method" placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="reject_endpoint" placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="reject_username" placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="reject_password" placeholder="Password" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="reject_xml_file" placeholder="XML File" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="reject_api_key" placeholder="Api Key" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <button type="button" class="btn btn-success" id="add_reject_api">ADD</button>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col-md-4">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="reject_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="reject_end_point_control">
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <button type="button" id="reject_yes_addbutton" class="btn btn-success">ADD</button>
                        </div>
                        <div class="row">
                            <table id="append_reject_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                <tr>
                                    <th>Map Field</th>
                                    <th>End Point</th>
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="reject_integrated_api_no1" style="display: none">
                        <div class="input-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="reject_command">
                            </div>
                            <div class="col-md-6 radio_integrated" id="reject_command_list">

                            </div>
                        </div>
                        <div class="input-group">
                            <div class="col-md-6">
                                <input type="button" class="btn btn-success" value="ADD" id="reject_command_submit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="engineertype1">


                    <select id="sbOne" multiple="multiple">
                        <option value="1">Alpha</option>
                        <option value="2">Beta</option>
                        <option value="3">Gamma</option>
                        <option value="4">Delta</option>
                        <option value="5">Epsilon</option>
                    </select>

                    <select id="sbTwo" multiple="multiple">
                        <option value="6">Zeta</option>
                        <option value="7">Eta</option>
                    </select>

                    <br />

                    <input type="button" id="left" value="<" />
                    <input type="button" id="right" value=">" />
                    <input type="button" id="leftall" value="<<" />
                    <input type="button" id="rightall" value=">>" />


                </div>
                
                 <div class="tab-pane" id="taskreport1">
                 
                  ppppppppppppppppppppppppppppppp
                </div>
            </div>
        </div>

    </div>
</div>
<div id="divLoading">
</div>
<script>
    var url = '<?php echo base_url(); ?>';
</script>
<script src="assets/js/tasktype.js"></script>