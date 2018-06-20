<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Add_Task label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }
    
    /*Check box*/
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

.ui-autocomplete {
    height:300px;
    overflow-y: scroll;
}

.tab-content>.tab-pane {
    display: none;
    max-height: 220px;
    overflow: auto;
    overflow-x: hidden;
}

@keyframes effect{
	0%{transform: scale(0);}
	25%{transform: scale(1.3);}
	75%{transform: scale(1.4);}
	100%{transform: scale(1);}
}


</style>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">
    (function ($, W, D)
    {
        var JQUERY4U = {};
        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Add_Task").validate({
                            rules: {
                                task_type_id: "required",
                                task_name: "required",
                                fse_id_h: "required",
                                branch_id: "required",
                                ent_id: "required",
                                project_id_h: "required",
                                incident_id_h: "required",
                                customer_id: "required",
                                status_id: "required",
                                sla_id: "required",
                                task_description: "required",
                                datetimepicker_start: "required",
                                datetimepicker_end: "required",
                                task_address: "required",
                                product_name: "required",
                                serial_number: "required",
                                product_code: "required",
                                book_code: "required",
                                customer_name: "required",
                                manual_docket_number: "required",
                                customer_contact_person: "required",
                                customer_contact_number: "required",
                                model: "required",
                                problem: "required",
                                location: "required",
                                call_status: "required",
                                call_type: "required",
                                priority: "required",
                                customerAddress: "required",
                                message: "required",
                                comment_charge: "required",
                                previous_meter_reading: "required",
                                previous_color_reading: "required",
                                customer_order_number: "required",
                                outstanding_calls: "required",
                                call_number: "required",
                                productline: "required",
                                sn_problem1: "required",
                                sn_problem2: "required",
                            },
                            messages: {
                                task_type_id: "Please Select Task Type",
                                task_name: "Please Enter Task Name",
                                fse_id: "Please Select FSE Name",
                                branch_id: "Please Select Branch Name",
                                ent_id: "Please Select Entity Name",
                                project_id: "Please Select Project Name",
                                incident_id: "Please Select Incident Name",
                                customer_id: "Please Select Customer Name",
                                customerAddress: "Please Enter the Customer Address",
                                status_id: "Please Select Status Type",
                                sla_id: "Please Select SLA Name",
                                task_description: "Please Enter the Task Description",
                                datetimepicker_start: "Please Select logged Date",
                                datetimepicker_end: "Please Select End Date",
                                task_address: "Please Select Task Address",
                                product_name: "Please Enter Product Name",
                                serial_number: "Please Enter Product Serial Number",
                                product_code: "Please Enter Product Code",
                                book_code: "Please Enter Book code",
                                manual_docket_number: "Please Enter manual docket number ",
                                customer_name: "Please Enter Customer name",
                                customer_contact_person: "Please Enter customer contact person",
                                customer_contact_number: "Please Enter customer contact number",
                                model: "Please Enter model",
                                problem: "Please Enter problem",
                                location: "Please Enter location",
                                call_status: "Please Enter call status",
                                call_type: "Please Enter call type",
                                priority: "Please Enter priority",
                                message: "Please Enter message",
                                comment_charge: "Please Enter comment charge",
                                previous_meter_reading: "Please Enter previous meter reading",
                                previous_color_reading: "Please Enter previous color reading",
                                customer_order_number: "Please Enter customer order number",
                                outstanding_calls: "Please Enter outstanding calls",
                                call_number: "Please Enter call Number",
                                productline: "Please Select Product Line",
                                sn_problem1: "Please Select Problem 1",
                                sn_problem2: "Please Select Problem 2",
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
<script>
    $(document).ready(function () {
        $('#task_address').val('');
        //$("div.desc").hide();
        $("input[name$='optradio']").click(function () {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
        $("input[name$='optButtonradio']").click(function () {
            var test_desc = $(this).val();
            $("div.desc_entity").hide();
            $("#" + test_desc).show();
        });
    });
</script>
<div class="x_panel"  style="">
    <div class="x_title">
        <h2>Add Task<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Task" name="Add_Task" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addTask" method="POST">
            <?php
            if ($entityFeilds != FALSE) {
                $task_field = json_decode($entityFeilds);
            } else {
                $task_field = array();
            }
            ?>
            <?php //if (in_array(2, $task_field)) { ?>
            <?php if (FALSE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Entity / Branch
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label><input type="radio" name="optButtonradio" checked="checked" value="EntityDiv">Entity</label> 
                            <label><input type="radio" name="optButtonradio" value="BranchDiv">Branch</label>
                        </div>
                    </div>
                </div>
                <div class="form-group desc_entity" id="EntityDiv">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="ent_id" id="ent_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($result['getEntity'] AS $getEntity) {
                                echo '<option value="' . $getEntity['id'] . '">' . $getEntity['ent_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                    </div>
                </div>			
                <div class="form-group desc_entity" id="BranchDiv" style="display:none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="branch_id" id="branch_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($result['getBranch'] AS $getBranch) {
                                echo '<option value="' . $getBranch['id'] . '">' . $getBranch['branch_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                    </div>
                </div>
            
             
            
            <?php } ?>
            <?php if (TRUE) { ?>
            <div class="form-group hidefieldhold">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Auto-route Task
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        
                      	<div class="form-check">
                            <label>
                                <input type="checkbox" id="hidefield" name="auto_routecheck"> <span class="label-text"></span>
                            </label>
                        </div>
                    </div>
                </div>
            
            
            
            
            <div class="form-group hidefieldhold">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="send_taskreport">Send Task Report after task completed
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        
                      	<div class="form-check">
                            <label>
                                <input type="checkbox" id="sendtask" name="send_taskreport"> <span class="label-text"></span>
                            </label>
                        </div>
                    </div>
                </div>
            
            <div class="form-group sndtsk" style="display:none;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                           <fieldset class="customLegend row">
                                <legend>Enter Your Name</legend>
                                <div class="row">
                               <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto1"> <span class="label-text"></span>Assignment
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto2"> <span class="label-text"></span>Task Operations
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto2"> <span class="label-text"></span>Task Location
                                  </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto2"> <span class="label-text"></span>Create Information
                                  </label>
                                </div>
                                <div class="row">
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto1"> <span class="label-text"></span>Update Informatica
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto2"> <span class="label-text"></span>Assets/Parts
                                  </label>
                                  <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto2"> <span class="label-text"></span>Attachment
                                  </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="hidefield" name="auto2"> <span class="label-text"></span>Customer Interaction
                                  </label> 
                                </div>
                              </fieldset>
                    </div>
                </div>
            
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Task Title <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="task_name" name="task_name" value="<?php echo @$post['task_name'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('task_name'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (TRUE) { ?>
                <div class="form-group field">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Field Engineer <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="fse_id_h" id="fse_id_h" class="form-control col-md-7 col-xs-12" style="float: left;" />
                        <input type="hidden" name = "fse_id" id="fse_id" value=""/>
                        <div id="autocomplete-container" style="position: relative; float: left; width: 400px;"></div>
                        <span class="text-danger"><?php echo form_error('fse_id'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <script type="text/javascript">
                $(function () {
                    $("#fse_id_h").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "<?php echo base_url(); ?>TaskController/getFse_autocomplete_c",
                                dataType: "json",
                                type: "POST",
                                data: request,
                                success: function (data) {
                                    response(data);
                                }
                            });
                        },
                        focus: function (event, ui) {
                            $("#fse_id_h").val(ui.item.label);
                            return false;
                        },
                        select: function (event, ui) {
                            $('#fse_id').val(ui.item.key);
                            return false;
                        },
                        change: function (e, u) {
                            if (u.item == null) {
                                $(this).val("");
                                return false;
                            }
                        },

                        appendTo: '#autocomplete-container',
                        minLength: 1
                    });
                });
            </script>

            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="status_id" id="status_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($result['getStatus'] AS $getStatus) {
                                echo '<option value="' . $getStatus['id'] . '">' . $getStatus['status_type'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('status_id'); ?></span>
                    </div>
                </div> 
            <?php } ?>

            <?php
            //if (in_array(22, $task_field)) 
            if (TRUE) {
                ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Priority <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="priority" id="priority">
                            <option value="">Select</option>
                            <?php
                            foreach ($result['Priority'] AS $Priority) {
                                echo '<option value="' . $Priority['id'] . '">' . $Priority['priority_type'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('priority'); ?></span>
                    </div>
                </div>
            <?php } ?>

            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="task_address" id="task_address" ><?php echo @$post['task_address'] ?></textarea>
                        <span class="text-danger"><?php echo form_error('task_address'); ?></span>
                        <input type="hidden" id="task_location" name="task_location" />
                    </div>
                </div>
            <?php } ?>

            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Logged <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                        <input size="16" type="text" value="" name="start_date" id="datetimepicker_start"   class="form-control col-md-7 col-xs-12">
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                        <span class="text-danger"><?php echo form_error('datetimepicker_start'); ?></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" /><br/>
                </div>
            <?php } ?>
             <input type="hidden" id="ent_id" name="ent_id" value="<?php echo $entityid ?>" />
            <?php
            if (!empty($entitycreateFilds)) {
                foreach ($entitycreateFilds as $key => $value) {
                    ?>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?php echo $value['Ext_att_name'] ?> <span class="required">*</span>
                        </label>
                        <?php if ($value['Ext_att_type'] == 'TEXT' || $value['Ext_att_type'] == 'NUMBER') { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="<?php
                                if ($value['Ext_att_type'] == "TEXT") {
                                    echo "text";
                                } else {
                                    echo "number";
                                }
                                ?>" id="<?php echo $value['extr_att_id'] ?>" maxlength="<?php echo $value['Ext_att_size'] ?>" name="<?php echo $value['extr_att_id'] ?>" value="" class="form-control col-md-7 col-xs-12" required>
                                <span class="text-danger"><?php echo form_error($value['extr_att_id']); ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($value['Ext_att_type'] == 'TEXTAREA') { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="form-control col-md-7 col-xs-12" required maxlength="<?php echo $value['Ext_att_size'] ?>" name="<?php echo $value['extr_att_id'] ?>" id="<?php echo $value['extr_att_id'] ?>" ></textarea>
                                <span class="text-danger"><?php echo form_error($value['extr_att_id']); ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($value['Ext_att_type'] == 'SELECT') { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="<?php echo $value['extr_att_id'] ?>" id="<?php echo $value['extr_att_id'] ?>" required>
                                    <option value="">Select</option>
                                    <?php
                                    $select_arr = json_decode($value['extra_attr_option']);
                                    if (!empty($select_arr)) {
                                        foreach ($select_arr AS $arr) {
                                            echo '<option value="' . $arr . '">' . $arr . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error($value['extr_att_id']); ?></span>
                            </div>   
                        <?php } ?> 
                        <?php if ($value['Ext_att_type'] == 'CHECKBOX') { ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                $select_arr = json_decode($value['extra_attr_option']);
                                if (!empty($select_arr)) {
                                    foreach ($select_arr AS $arr) {
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="<?php echo $arr; ?>" name="<?php echo $value['extr_att_id']; ?>[]"> <?php echo $arr; ?>
                                            </label>
                                        </div>
                                                
                                <?php
                                }
                            }
                            ?>    
                         </div> 
                    <?php } ?>
                        <?php if ($value['Ext_att_type'] == 'RADIO') { ?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                $select_arr = json_decode($value['extra_attr_option']);
                                if (!empty($select_arr)) {
                                    foreach ($select_arr AS $arr) {
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" value="<?php echo $arr; ?>" id="<?php echo $value['extr_att_id']; ?>" name="<?php echo $value['extr_att_id']; ?>"> <?php echo $arr; ?>
                                            </label>
                                        </div>
                                                
                                <?php
                                }
                            }
                            ?>    
                         </div> 
                    <?php } ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>task" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>
<script>

                $("select#section_code").change(function () {
                    var section_code = $("#section_code option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>TaskController/locationCode",
                        data: {section_code: section_code}
                    }).done(function (data) {
                        $("#location_code").html(data);
                    });
                });
                $("select#sn_problem1").change(function () {
                    var sn_problem1 = $("#sn_problem1 option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>TaskController/problemTwo",
                        data: {sn_problem1: sn_problem1}
                    }).done(function (data) {
                        $("#sn_problem2").html(data);
                    });
                });
                $("select#sn_problem2").change(function () {
                    var sn_problem2 = $("#sn_problem2 option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>TaskController/snLocation",
                        data: {sn_problem2: sn_problem2}
                    }).done(function (data) {
                        $("#sn_location").html(data);
                    });
                });
                $("select#productline").change(function () {

                    var productline = $("#productline option:selected").val();
                    actionCodeGet(productline);
                    sectionCodeGet(productline);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>TaskController/problemOne",
                        data: {productline: productline}
                    }).done(function (data) {
                        $("#sn_problem1").html(data);
                    });
                });
                function actionCodeGet(productline) {
                    // alert(productline);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>TaskController/actionCode",
                        data: {productline: productline}
                    }).done(function (data) {
                        $("#action_code").html(data);
                    });
                }

                function sectionCodeGet(productline) {
                    // alert(productline);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>TaskController/sectionCode",
                        data: {productline: productline}
                    }).done(function (data) {
                        $("#section_code").html(data);
                    });
                }


                $('#datetimepicker_start').datetimepicker({
                    value: '<?php echo date("Y/m/d H:i"); ?>',
                    mask: '9999/19/39 29:59'
                });
                $('#datetimepicker_end').datetimepicker({
                    value: '<?php echo date("Y/m/d H:i"); ?>',
                    mask: '9999/19/39 29:59'
                });</script>

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 100%;
        width: 100%;
        top: -6px;
    }
    .modal-body
    {
        padding: 0px;
    }

    #floating-panel {
        position: absolute;


        z-index: 5;
        background-color: #fff;


        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        /*padding-left: 10px;*/
        width: 350px;
        background: none;
        padding-top: 5px;
        left:35%;
    }
    .addBar
    {
        height: 28px;padding: 0px 6px;line-height: 10px;
    }
</style>


<script>



    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: -31.20340495091738, lng: 24.547855854034424}
        });
        //-31.20340495091738, 24.547855854034424
        var geocoder = new google.maps.Geocoder();
        // Try HTML5 geolocation.
        /*
         if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function(position) {
         var pos = {
         lat: position.coords.latitude,
         lng: position.coords.longitude
         };
         
         //infoWindow.setPosition(pos);
         //infoWindow.setContent('Location found.');
         map.setCenter(pos);
         }, function() {
         handleLocationError(true, infoWindow, map.getCenter());
         });
         } else {
         // Browser doesn't support Geolocation
         handleLocationError(false, infoWindow, map.getCenter());
         }
         */



        document.getElementById('submit').addEventListener('click', function () {
            geocodeAddress(geocoder, map);
        });
        //Add listener
        google.maps.event.addListener(map, "click", function (event) {
            var latitude = event.latLng.lat();
            var longitude = event.latLng.lng();
            console.log(latitude + ', ' + longitude);
            var point = new google.maps.LatLng(latitude, longitude);
            // alert(point);
            $('#task_location').val(point);
            findAddress(point);
        }); //end addListener

    }

    function findAddress(point) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: point}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    // infoWindow.setContent(results[0].formatted_address);
                    // infoWindow.setPosition(point);
                    // infoWindow.open(map);
                    // alert(results[0].formatted_address);
                    $('#task_address').val(results[0].formatted_address);
                    $('#myModal').css('display', 'none');
                }
            }
        });
    }

    function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeubS8KjHiTu2TI7I5X_4IjGZCI0zeKGY&callback=initMap">
</script>
<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }



    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        /*padding: 2px 16px;*/
        background-color: #172d44;
        color: white;
        font-size: 14px;
    }
    .modal-header h2 {
        margin: 0px !important;
        padding: 5px !important;
        font-size: 14px;
    }
    .modal-body {padding: 0px; height: 400px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
    }
</style>



<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" id="close_map">&times;</span>
            <h2>Select Address from Google Map</h2>
        </div>
        <div class="modal-body">
            <div id="floating-panel">
                <input id="address" type="textbox" class="addBar" value="">
                <input id="submit" type="button" class="addBar" value="Get Address">
            </div>

            <div id="map"></div>
        </div>

    </div>

</div>

<script>
// Get the modal
    var modal = document.getElementById('myModal');
// Get the button that opens the modal
    var btn = document.getElementById("task_address");
// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

    var spanId = document.getElementById("close_map");
// When the user clicks the button, open the modal 
    btn.onclick = function () {
        modal.style.display = "block";
        google.maps.event.trigger(map, "resize");
    }

// When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

    spanId.onclick = function () {
        modal.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var max_fields = 20; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button "); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-group"> <label for="last-name" class="control-label col-md-3 col-sm-3 col-xs-12"></label> <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="taskchecklist[]" class="form-control col-md-7 col-xs-12"></div><a class="btn btn-primary remove_field" href="#">Remove</a></div>'); //add input box
            }
        });
        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
    
    
    $("#hidefield").click(function(){
             $('.field').toggle(600);
      });
      
      
      $("#sendtask").click(function(){
             $('.sndtsk').toggle(600);
      });
      
</script>
