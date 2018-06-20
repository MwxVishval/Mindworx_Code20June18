
<style type="text/css">
    #Edit_Entity label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
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
        background-image : url('<?php echo base_url(); ?>assets/images/loading.gif');
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
        border: 1px solid #ccc;
        height: 194px;
        overflow-x: auto;
        overflow-y: auto;
        padding: 10px;
    }
    .radio_integrated div{
        padding: 5px 0px;
    }

   

    .form-check label{
        position: relative;
        cursor: pointer;
        color: #666;
        font-size: 22px;
    }

    input[type="checkbox"], input[type="radio"]{
        position: absolute;
        right: 9000px;
    }

    /*Check box*/
    input[type="checkbox"] + .label-text:before{
        content: "\f096";
        font-family: "FontAwesome";
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing:antialiased;
        width: 1em;
        display: inline-block;
        margin-right: 5px;
    }

    input[type="checkbox"]:checked + .label-text:before{
        content: "\f14a";
        color: #2a3f54;
        animation: effect 250ms ease-in;
    }

    input[type="checkbox"]:disabled + .label-text{
        color: #aaa;
    }

    input[type="checkbox"]:disabled + .label-text:before{
        content: "\f0c8";
        color: #ccc;
    }

    @keyframes effect{
        0%{transform: scale(0);}
        25%{transform: scale(1.3);}
        75%{transform: scale(1.4);}
        100%{transform: scale(1);}
    }
    
    .customLegend {
    border: 1px solid #e5e5e5;
    padding: 1.5em 0 1em;
    margin-top: 0.5em;
    position: relative;
    margin-bottom: 1.5em;
}

.customLegend legend {
    border: 0;
    background: #fff;
    width: auto;
    transform: translateY(-50%);
    position: absolute;
    top: 0;
    left: 1em;
    color: #d61f27;
    padding: 0 .5em;
    font-size: 15px;
    font-weight: 500;
}

.customLegend .checkbox-inline {
    margin-left: 0px;
    padding-left: 18px;
    margin-bottom: 20px;
    width: 160px;
}


</style>
<script type="text/javascript">

    (function ($, W, D)
    {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Edit_Entity").validate({
                            rules: {
                                ent_name: "required",
                                ent_address: "required",
                                ent_year: "required",
                                flow: "required",
                                entity_color: "required",
                                entity_secondary_color: "required",
                                ent_type: {
                                    required: true
                                }
                            },
                            messages: {
                                ent_name: "Please Enter Your Entity Name",
                                ent_address: "Please Enter Your Address",
                                ent_year: "Please Enter Your Entity Year",
                                ent_type: "Please Select Entity Type",
                                flow: "Please Select flow",
                                entity_color: "Please Select Entity Color",
                                entity_secondary_color: "Please Select Entity secondary color",
                            },
                            submitHandler: function (form) {
                                form.submit();
                            }
                        });
                    }
                }
        //when the dom has loaded setup form validation rules
        $(D).ready(function ($) {
            JQUERY4U.UTIL.setupFormValidation();
        });
    })(jQuery, window, document);
</script>

<div class="" id="msgPane" style="display: none">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <span id="msg"></span>
</div>

<div class="x_panel"  style="height-min:600px;">
    <div class="x_title">
        <h2>Edit Entity<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     
        <form id="Edit_Entity" name="Edit_Entity" data-parsley-validate class="form-horizontal form-label-left"  method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ent_id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Entity Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="ent_name" name="ent_name" value="<?php echo $result[0]['ent_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('ent_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="ent_address" id="ent_address"><?php echo $result[0]['ent_address'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('ent_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Year <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="ent_year" name="ent_year" readonly value="<?php echo $result[0]['ent_year'] ?>" class="date-picker form-control col-md-7 col-xs-12"  type="text">
                    <span class="text-danger"><?php echo form_error('ent_year'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Logo <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="file"> 
                    <span class="text-danger"><?php echo form_error('upload'); ?></span>
                    <?php echo '<img src="data:image/gif;base64,' . $result[0]['entity_logo'] . '"  height="100" width="100" />'; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Color <span class="required">*</span>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="demo1 form-control colorpicker-element" value="<?php echo $result[0]['entity_color'] ?>" type="text" name="entity_color">
                    <span class="text-danger"><?php echo form_error('entity_color'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Secondary Color <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="demo1 form-control colorpicker-element" value="<?php echo $result[0]['entity_secondary_color'] ?>" type="text" name="entity_secondary_color">
                    <span class="text-danger"><?php echo form_error('entity_color'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Flow <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12" name="flow" id="flow">
                        <option value="">Select</option>
                        <option value="0" <?php
                        if ($result[0]['flow'] == 0) {
                            echo ' selected="selected"';
                        }
                        ?>  >Single Acceptance</option>
                        <option value="1" <?php
                        if ($result[0]['flow'] == 1) {
                            echo ' selected="selected"';
                        }
                        ?>>Multiple Acceptance</option>
                    </select>

                    <span class="text-danger"><?php echo form_error('flow'); ?></span>
                </div>
            </div>


            <?php if ($Admin_check == TRUE || $SuperAdmin_check == TRUE) { ?>  
                <div class="form-group advance">
                    <label class="control-labels col-md-3 col-sm-3 col-xs-12 text-right"><a class="advancedbtn" href="#">Advanced</a>
                    </label>

                    <div class="col-md-6 col-sm-6 col-xs-12 hidefieldhold" style="display:none;">
                        <div class="brd1">
                            <p>Configure active modules for this Entity:</p>
                            <div class="form-group form-control">
                                <div class="form-check pull-left">
                                    <?php
                                    if ($SuperAdmin_check == TRUE) {
                                        $class = '';                                       
                                    } else {
                                       $class = 'check_disabled';                                        
                                    }
                                    ?>
                                 
                                    <label class="<?php echo $result[0]['isadv_mapfunctionality'] == 1 ? $class : '' ?>">
                                 
                                        <input  <?php echo $result[0]['isadv_mapfunctionality'] == 1 ? 'checked' : '' ?>  type="checkbox" id="hidefield" name="isadv_mapfunctionality">
                                        <span class="label-text"></span>
                                    </label>

                                </div>

                                <label class="pull-left text-left" for="last-name">Advanced Map Functionality
                                </label>
                            </div>

                            <div class="form-group form-control">
                                <div class="form-check pull-left">
                                    <label class="<?php echo $result[0]['isscheduling'] == 1 ? $class : '' ?>">
                                        <input <?php echo $result[0]['isscheduling'] == 1 ? 'checked' : '' ?>  type="checkbox" id="hidefield" name="isscheduling">
                                        <span class="label-text"></span>
                                    </label>
                                </div>

                                <label class="pull-left text-left" for="last-name">Scheduling
                                </label>
                            </div>

                            <div class="form-group form-control">
                                <div class="form-check pull-left">
                                    <label class="<?php echo $result[0]['isadv_reporting'] == 1 ? $class : '' ?>"> 
                                        <input checked="<?php echo $result[0]['isadv_reporting'] == 1 ? 'checked' : '' ?>"  type="checkbox" id="hidefield" name="isadv_reporting">
                                        <span class="label-text"></span>
                                    </label>
                                </div>

                                <label class="pull-left text-left" for="last-name">Advanced Reporting
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

            <?php } ?>



            <div class="clearfix"></div>
            <div class="ln_solid"></div>


            <!--            <div class="ln_solid"></div>-->
            <div class="form-group" style="display: none">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <!--<a href="<?php echo base_url() ?>entity" class="btn btn-primary">Cancel</a>-->
                    <input type="submit" class="btn btn-success" name="submit" id="submit" value="Update">
                </div>
            </div>
        </form>
        <div class="ln_solid"></div>
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
        <div class="ln_solid"></div>
        <div class="form-group clearfix">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="<?php echo base_url() ?>entity" class="btn btn-primary">Cancel</a>
                <input type="submit" class="btn btn-success" value="Update" onclick="submitForm()">
            </div>
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
                <!--                <li>
                                    <a class="flow1" href="#flow" data-toggle="tab">Flow</a>
                                </li>-->
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
                    <div class="form-group">
                        <label>Task start dependency?</label>
                        <select class="form-control" id="task_dependency1">
                            <option value="">Loading....</option>
                        </select>
                    </div>

                    <div>
                        <div class="form-group clearfix">
                            <div class="col-sm-2" style="margin-left: -10px;">
                                <input type="text" id="create_label" name="label" placeholder="Label" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="create_field_type" name="field_type">
                                    <option value="">Field Type</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="NUMBER">NUMBER</option>
                                    <option value="TEXTAREA">TEXTAREA</option>
                                    <option value="RADIO">RADIO</option>
                                    <option value="CHECKBOX">CHECKBOX</option>
                                    <option value="SELECT">SELECT</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" name="create_limit" id="create_limit" placeholder="Limit" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="create_category" name="category">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success" onclick="create_not_integrate()" id="created_add_not_integrated1">ADD</button>
                            </div>
                            <div style="display: none; padding-top: 45px;" id="create_select_integrated_no">
                                <div class="row" style="padding-left:10px;">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="create_select_integrated_text">
                                    </div>
                                    <div class="col-md-4 radio_integrated"  id="create_select_data">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-success" id="create_add_select_integrated">Add -></button>
                                    </div>
                                </div>
                                <div class="row" style="display: none;">
                                    <div class="col-md-1" id="create_select_add_more">
                                        <button class="btn btn-success">Add More</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-success" id="create_complete_select_integrate">Done</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 pull-right">
                                        <button type="button" class="btn btn-success" disabled id="create_add_select_integrate_data">ADD</button>
                                    </div>
                                </div>
                            </div>
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
                        <div class="form-group clearfix mgleftmns">
                            <input type="hidden" id="create_api_settings_id">
                            <div class="col-sm-4">
                                <!--<input type="text" id="create_method" rel="validate" placeholder="Method" class="form-control">-->
                                <textarea cols="100" rows="2" id="create_method" readonly="YES" class="form-control" ></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-2 pull-right text-right">
                                <button type="button" id="add_create_api" class="btn btn-success ">Generate API</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="update1">
                    <div class="form-group radio">
                        <span>Integrated API?</span>
                        <label><input type="radio" value="1" class="update_api1"/> Yes </label>
                        <label><input type="radio" value="0" class="update_api1"/> No </label>
                    </div>
                    <div class="form-group" style="display: none;">
                        <p>What end point to you want us POST back to?</p>
                    </div>
                    <div id="update_integrated_api" style="display: none;">
                        <input type="hidden" id="update_api_settings_id">
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="text" id="update_method1" name=""  placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="update_endpoint1" name=""  placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="update_username1" name=""  placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-4 mgtop">
                                <input type="text" id="update_password1" name=""  placeholder="Password" class="form-control">
                            </div>
                            <!--                            <div class="col-md-4 mgtop">
                                                            <input type="text" id="update_xml_file1" name=""  placeholder="XML File" class="form-control">
                                                        </div>-->
                            <div class="col-md-4 mgtop">
                                <input type="text" id="update_api_key1" name=""  placeholder="API Key" class="form-control">
                            </div>
                        </div> 

                        <div class="form-group clearfix">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" id="add_update_api">ADD</button>
                            </div>
                        </div>
                    </div>
                    <div>


                        <!--                        <div class="form-group clearfix">
                                                    <div class="col-md-6">
                                                        <label for="usr">Map fields:</label>
                                                        <select class="form-control" id="update_map_fields">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="usr">End Point Fields:</label>
                                                        <input type="text" class="form-control"  id="update_end_point_control">
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix mgtop">
                                                    <div class="col-md-12 text-right">
                                                        <button type="button" id="update_yes_addbutton" class="btn btn-success">ADD</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <table id="append_update_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                                        <tr>
                                                            <th>Map Field</th>
                                                            <th>End Point</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </table>
                                                </div>-->

                        <div class="input-group">
                            <p>What fields would you like to be available to update?</p>
                            <div class="col-md-2 ">
                                <input type="text" id="update_label" name=""  placeholder="Label" class="form-control">
                            </div>
                            <div class="col-md-2 ">
                                <select class="form-control" id="update_field_type">
                                    <option value="">..</option>
                                    <option value="SELECT">SELECT</option>
                                    <option value="RADIOLIST">RADIO LIST</option>
                                    <option value="SWITCH">SWITCH</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="NUMBER">NUMBER</option>
                                    <option value="TEXTAREA">TEXTAREA</option>
                                    <!--<option value="SWITCH">SWITCH</option>-->
                                </select>
                            </div>

                            <div class="col-md-2 ">
                                <input type="number" id="update_limit" name=""  placeholder="Limit" class="form-control">
                            </div>
                            <div class="col-md-2 ">
                                <select class="form-control" id="update_tab_category">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-md-2 ">
                                <label> <input type="checkbox" id="update_required" class="checkbox"> required </label>
                            </div>
                        </div>


                        <select class="form-control"  id="update_field_dependOn" style="display: none; width: 350px;" >
                            <option value="">depend On</option>
                        </select>


                        <div style="display: none;" id="select_integrated">
                            <span>Do you want this select to be integrated?  </span>
                            <label><input type="radio" value="1" class="update_available_api1"/> Yes </label>
                            <label><input type="radio" value="0" class="update_available_api1"/> No </label>
                        </div>

                        <div style="display: none;" id="select_integrated_no">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="select_integrated_text">
                                </div>
                                <div class="col-md-4 radio_integrated" id="select_data">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="add_select_integrated">Add -></button>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-md-1" id="select_add_more">
                                    <button class="btn btn-success">Add More</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="complete_select_integrate">Done</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 pull-right">
                                    <button type="button" class="btn btn-success" disabled id="add_select_integrate_data">ADD</button>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" id="select_integrated_yes">
                            <div class="input-group">
                                <div class="col-md-2">
                                    <input type="text" id="select_update_method" name=""  placeholder="Method" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="select_update_endpoint" name=""  placeholder="Endpoint" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="select_update_username" name=""  placeholder="Username" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="select_update_password" name=""  placeholder="Password" class="form-control">
                                </div>
                                <!--                                <div class="col-md-2">
                                                                    <input type="text" id="select_update_xml_file" name=""  placeholder="XML File" class="form-control">
                                                                </div>-->
                                <div class="col-md-2 ">
                                    <input type="text" id="select_update_api_key" name=""  placeholder="API Key" class="form-control">
                                </div>
                            </div> 
                            <div class="input-group pull-right">
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" id="submit_api_data">ADD</button>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" id="radio_integrated">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="radio_integrated_text">
                                </div>
                                <div class="col-md-4 radio_integrated" id="radio_data">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="add_radio_integrated">Add -></button>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-md-1" id="radio_add_more">
                                    <button class="btn btn-success">Add More</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="complete_radio_integrate">Done</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 pull-right">
                                    <button type="button" class="btn btn-success" disabled id="add_radio_integrate_data">ADD</button>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" id="checkbox_integrated">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="checkbox_integrated_text">
                                </div>
                                <div class="col-md-4 radio_integrated" id="checkbox_data">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="add_checkbox_integrated">Add -></button>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-md-1" id="checkbox_add_more">
                                    <button class="btn btn-success">Add More</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="complete_checkbox_integrate">Done</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 pull-right">
                                    <button type="button" class="btn btn-success" disabled id="add_checkbox_integrate_data">ADD</button>
                                </div>
                            </div>
                        </div>
                        <div id="add_other_integrate" style="display: block;">
                            <div class="row">
                                <div class="col-md-2 pull-right">
                                    <button type="button" class="btn btn-success" id="add_other_integrate_data">ADD</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p>Map All fields </p>
                            <div class="clearfix"></div>
                            <div class="col-md-8">
                                <p>Create Fields</p>
                                <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="append_update_data">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>Type</th>
                                            <th>Limit</th>
                                            <th>Category</th>
                                            <th>Items</th>
                                            <th>Required</th>
                                            <th>Depond On</th>
                                            <th>End Point</th>
                                            <th>Action</th>
                                            <th class="append_update_data">Field post backs to</th>
                                            <th class="append_update_data"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!--                            <div class="col-md-4">
                                                            <p>Field post backs to:</p>
                                                            <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="append_update_map_data">
                                                                <thead>
                                                                    <tr>
                                                                        <th><span style="opacity: 0">test</span></th>
                                                                        <th><span style="opacity: 0">test</span></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                            
                                                                </tbody>
                                                            </table>
                                                        </div>-->
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
                    <div class="form-group radio">
                        <span>Enable assets</span>
                        <label class="inline-radio"><input id="asset_status" type="radio"  value="1"> Yes </label>
                        <label class="inline-radio"><input id="asset_status" type="radio" value="0"> No </label>
                    </div>
                    <div class="form-group radio">
                        <span>Integrated API?</span>
                        <label class="inline-radio"><input class="asset_api1" type="radio"  value="1"> Yes </label>
                        <label class="inline-radio"><input class="asset_api1" type="radio" value="0"> No </label>
                    </div>
                    <div id="asset_integrated_api1" style="display: none;">
                        <input type="hidden" id="assets_api_settings_id">
                        <div class="form-group clearfix">
                            <p>Fetch Asset from list</p>
                            <div class="col-md-4 mgleftmns">
                                <input type="text" id="assets_method1" name=""  placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="assets_endpoint1" name=""  placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="assets_username1" name=""  placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-4 mgtop mgleftmns">
                                <input type="text" id="assets_password1" name=""  placeholder="Password" class="form-control">
                            </div>
                            <!--                            <div class="col-md-4 mgtop">
                                                            <input type="text" id="assets_xml_file1" name=""  placeholder="XML File" class="form-control">
                                                        </div>-->
                            <div class="col-md-4 mgtop">
                                <input type="text" id="assets_api_key1" name=""  placeholder="API Key" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group clearfix">
                            <div class="col-md-12 text-right">
                                <button type="button" id="add_assets_api" class="btn btn-success ">ADD</button>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group clearfix">
                            <div class="col-md-5">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="assets_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="assets_end_point_control">
                            </div>
                            <div class="col-md-2">
                                <div class="btnwolabel">
                                    <button type="button" id="assets_yes_addbutton" class="btn btn-success">ADD</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <table id="append_assets_yes_data" class="table table-striped table-bordered table-striped table-hover table-condensed">
                                    <tr>
                                        <th>Map Field</th>
                                        <th>End Point</th>
                                        <th>Action</th>
                                    </tr>
                                </table>
                            </div>                         
                        </div>
                    </div>
                    <div id="asset_integrated_api_no1" style="display:none">
                        <div class="form-group clearfix">
                            <div class="col-md-12 mgleftmns">
                                <form id="asset_upload1" method="POST" enctype="multipart/form-data" >
                                    <input type="file" class="form-control" value="uploaded csv" id="asset_upload_csv1">
                                </form>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <p>Or Enter items below</p>
                        </div>
                        <div class="form-group clearfix mgleftmns">
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
                                <input type="button" id="add_asset_value1" value="Add" class="btn btn-success" style="display:block">
                            </div>
                        </div>
                        <div class="form-group clearfix">
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
                    <div class="form-group clearfix">
                        <label class="col-xs-1">1. </label>
                        <div class="col-xs-11">
                            <input type="text" class="form-control" id="assigned_state">
                        </div>                 
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-xs-1">2. </label>
                        <div class="col-xs-11">
                            <input type="text" class="form-control" id="accepted_state">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-xs-1">3. </label>
                        <div class="col-xs-11">
                            <input form="text" class="form-control" id="rejected_state">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-xs-1">4. </label>
                        <div class="col-xs-11">
                            <input type="text" class="form-control" id="inprogress_state">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-xs-1">5. </label>
                        <div class="col-xs-11">
                            <input type="text" class="form-control" id="onhold_state">
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-xs-1">6. </label>
                        <div class="col-xs-11">
                            <input type="text" class="form-control" id="resolved_state">
                        </div>
                    </div>
                    <div class="form-group clearfix text-right">
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
                    <div class="form-group radio clearfix">
                        <span>Integrated API? </span>
                        <label><input type="radio" class="onhold_api1" value="1"> Yes </label>
                        <label><input type="radio" class="onhold_api1" value="0"> No </label>
                    </div>
                    <div class="form-group radio clearfix">
                        <span>Add comment field</span>
                        <label><input type="radio" class="onhold_comment" value="1"> Yes </label>
                        <label><input type="radio" class="onhold_comment" value="0"> No </label>
                    </div>
                    <div id="onhold_integrated_api1" style="display: none">
                        <input type="hidden" id="onhold_api_settings_id">
                        <div class="form-group clearfix mgleftmns">
                            <div class="col-md-4">
                                <input type="text" id="onhold_method" placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="onhold_endpoint" placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="onhold_username" placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-4 mgtop">
                                <input type="text" id="onhold_password" placeholder="Password" class="form-control">
                            </div>
                            <!--                            <div class="col-md-4 mgtop">
                                                            <input type="text" id="onhold_xml_file" placeholder="XML File" class="form-control">
                                                        </div>-->
                            <div class="col-md-4 mgtop">
                                <input type="text" id="onhold_api_key" placeholder="Api Key" class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" id="add_onhold_api">ADD</button>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group clearfix">
                            <div class="col-md-5">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="onhold_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="onhold_end_point_control">
                            </div>
                            <div class="col-md-2">
                                <div class="btnwolabel">
                                    <button type="button" id="onhold_yes_addbutton" class="btn btn-success">ADD</button>
                                </div>                            
                            </div>
                        </div>
                        <hr />
                        <div class="form-group clearfix">
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
                        <div class="form-group clearfix mgleftmns">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control" id="onhold_command">
                                </div>
                                <input type="button" class="btn btn-success" value="ADD" id="onhold_command_submit">
                            </div>
                            <div class="col-md-12 mgtop">
                                <!--                                <div class="radio_integrated " id="onhold_command_list"></div>-->
                                <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="onhold_command_list">
                                    <tr>
                                        <th>Command</th>
                                        <th style="width: 10%"> Action </th>
                                    </tr>
                                </table>

                            </div>                       
                        </div>

                    </div>
                </div>

                <div class="tab-pane" id="reject1">
                    <div class="form-group radio clearfix">
                        <span>Integrated API? </span>
                        <label><input type="radio" class="reject_api1" value="1"> Yes </label>
                        <label><input type="radio" class="reject_api1" value="0"> No </label>
                    </div>
                    <div class="form-group radio clearfix">
                        <span>Add comment field</span>
                        <label><input type="radio" class="reject_comment" value="1"> Yes </label>
                        <label><input type="radio" class="reject_comment" value="0"> No </label>
                    </div>
                    <div id="reject_integrated_api1" style="display: none">
                        <input type="hidden" id="reject_api_settings_id">
                        <div class="form-group clearfix mgleftmns">
                            <div class="col-md-4">
                                <input type="text" id="reject_method" placeholder="Method" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="reject_endpoint" placeholder="Endpoint" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="reject_username" placeholder="Username" class="form-control">
                            </div>
                            <div class="col-md-4 mgtop">
                                <input type="text" id="reject_password" placeholder="Password" class="form-control">
                            </div>
                            <!--                            <div class="col-md-4 mgtop">
                                                            <input type="text" id="reject_xml_file" placeholder="XML File" class="form-control">
                                                        </div>-->
                            <div class="col-md-4 mgtop">
                                <input type="text" id="reject_api_key" placeholder="Api Key" class="form-control">
                            </div>
                        </div>
                        <div class="from-group clearfix">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" id="add_reject_api">ADD</button>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group clearfix mgleftmns">
                            <div class="col-md-5">
                                <label for="usr">Map fields:</label>
                                <select class="form-control" id="reject_map_fields">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="usr">End Point Fields:</label>
                                <input type="text" class="form-control"  id="reject_end_point_control">
                            </div>
                            <div class="col-md-2">
                                <div class="btnwolabel">
                                    <button type="button" id="reject_yes_addbutton" class="btn btn-success">ADD</button>
                                </div>								
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
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
                        <div class="form-group clearfix mgleftmns">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control" id="reject_command">
                                </div>
                                <input type="button" class="btn btn-success" value="ADD" id="reject_command_submit">
                            </div>
                            <div class="col-md-12 mgtop">
                                <!--<div class="radio_integrated" id="reject_command_list"></div>-->
                                <table class="table table-striped table-bordered table-striped table-hover table-condensed" id="reject_command_list">
                                    <tr>
                                        <th>Command</th>
                                        <th style="width: 10%"> Action </th>
                                    </tr>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="tab-pane" id="engineertype1">
                    <?php if (count($fsetypes) == 0) { ?>
                        <div class="jumbotron mrtp10 text-center">Please add a Service Engineer Type, before adding an Engineer.</div>
                    <?php } else { ?>
                        <div class="col-md-5 mrtp20">
                            <span class="mrbt5">Available Engineer Type</span>
                            <select id="sbOne" multiple="multiple">
                            </select>
                        </div>

                        <div class="col-md-2 mrtp20">
                            <div class="panebtnhld-1">
                              
                               
                                
                                <input class="panebtn" type="button" id="right" value=">" />
                                
                                 <input class="panebtn" type="button" id="left" value="<" />
                            </div>
                        </div>

                        <div class="col-md-5 mrtp20">
                              <span class="mrbt5">Task Type Engineers </span>
                            <select id="sbTwo" multiple="multiple">
                            </select>
                        </div>
                    <?php } ?>


                </div>
                
                <div class="tab-pane" id="taskreport1">
                 
                    
                    <div class="form-group hidefieldhold">
                        <div class="pull-left" style="line-height: 22px;">
                        
                      	<div class="form-check">
                            <label>
                                <input type="checkbox" id="sendtasks" name="send_taskreport"> <span class="label-text"></span>
                               
                            </label>
                        </div>
                    </div>
                        
                    <label class="control-label col-md-8 col-sm-8 col-xs-12" for="send_taskreport">Send Task Report after task completed
                    </label>
                    
                </div>
                    <div class="clearfix"></div>
                    
                    <div class="form-group" id="sndtsks" style="display:none;">
                   
                    <div class="col-md-12 col-sm-12 col-xs-12">
                           <fieldset class="customLegend row">
                               
                                <div class="row">
                               <label class="checkbox-inline"> 
                                    <input type="checkbox" id="assignmnetinfo" name="auto1"> <span class="label-text"></span>Assignment
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="operationinfo" name="auto2"> <span class="label-text"></span>Task Operations
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="locationinfo" name="auto2"> <span class="label-text"></span>Task Location
                                  </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="createinfo" name="auto2"> <span class="label-text"></span>Create Information
                                  </label>
                                </div>
                                <div class="row">
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="updateinfo" name="auto1"> <span class="label-text"></span>Update Informatica
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="assetinfo" name="auto2"> <span class="label-text"></span>Assets/Parts
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="attachmentinfo" name="auto2"> <span class="label-text"></span>Attachment
                                  </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="customerinfo" name="auto2"> <span class="label-text"></span>Customer Interaction
                                  </label> 
                                </div>
                              </fieldset>
                    </div>
                    
                    
                </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div id="divLoading">
    </div>
</div>


<script>
    var url = '<?php echo base_url(); ?>';
</script>

<script src="assets/js/tasktype.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
<?php if ($Admin_check == TRUE && $SuperAdmin_check == FALSE) { ?>
            $('.advance :input').prop("disabled", true);
<?php } ?>
    });


    function submitForm() {
        $('#submit').click();
    }


    $(".control-labels").click(function () {
        $('.hidefieldhold').toggle(600);
    });
    
    
      
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>
<style>
    .check_disabled input[type="checkbox"]:disabled , .check_disabled .label-text:before {
        content: "\f14a" !important;
        color: #ccc !important;
    }
    .advance input[type="checkbox"]:disabled { 
        color : darkGray;
        font-style: italic;
    }
    .subject-info-box-1,
    .subject-info-box-2 {
        float: left;
        width: 45%;

        select {
            height: 200px;
            padding: 0;

            option {
                padding: 4px 10px 4px 10px;
            }

            option:hover {
                background: #EEEEEE;
            }
        }
    }

    .subject-info-arrows {
        float: left;
        width: 10%;

        input {
            width: 70%;
            margin-bottom: 5px;
        }
    }
    select[multiple], select[size] {
        height: 400px;
        /* float: left; */
        width: 243px;
        margin-right: 20px;
    }

    .panebtn {
        background: #2a3f54;
        padding: 10px;
        color: #fff;
        border: 1px solid #5a728d;
    }

    .panebtnhld {
        margin-top: 60%;
        margin-left: 12%;
    }

    select[multiple], select[size] {
        height: auto;
        /* float: left; */
        width: 243px;
        margin-right: 20px;
        min-height: 310px;
    }

    .mrtp20 {
        margin-top:20px;
    }

    .mrtp10 {
        margin-top:10%;
    }

    .font16 {
        font-size: 16px;

    }
    
    .mrbt5 {
    margin-bottom: 5px;
    display: block;
    font-size: 15px;
    font-weight: 600;
}
    
    .panebtnhld-1 {
    margin-top: 98%;
    margin-left: 14%;
}

.panebtnhld-1 .panebtn {
    display: block;
    margin-bottom: 20px;
}

</style>


