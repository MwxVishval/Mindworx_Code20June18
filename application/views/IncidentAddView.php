<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Add_Incident label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
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
                        $("#Add_Incident").validate({
                            rules: {
                                incident_name: "required",
                                incident_details: "required",
                                incident_company_address: "required",
                                status_id: "required",
                                /*sla_id: "required",*/
								datetimepicker_start: "required",
                                datetimepicker_end: "required",
                                customer_id: {
                                    required: true,
                                },
                                ent_id: {
                                    required: true,
                                },
                                branch_id: {
                                    required: true,
                                },
                            },
                            messages: {
                                incident_name: "Please Enter Incident Name",
                                incident_details: "Please Enter Incident Details",
                                incident_company_address: "Please Enter Incident Company Address",
                                customer_id: "Please Select Customer Name",
                                ent_id: "Please Select Entity Name",
                                branch_id: "Please Select Branch Name",
                                status_id: "Please Select Status",
                                /*sla_id: "Please Select SLA",*/
								datetimepicker_start: "Please Select Your Start Date",
                                datetimepicker_end: "Please Select Your End Date",
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
        $("input[name$='optradio']").click(function () {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
    });
</script>

<div class="x_panel"  style="height:900px;">
    <div class="x_title">
        <h2>Add Incident<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Incident" name="Add_Incident" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addIncident" method="POST">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Company / Branch
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                        <label><input type="radio" name="optradio" checked="checked" value="comapnyDiv">Company</label> 
                        <label><input type="radio" name="optradio" value="branchDiv">Branch</label>
                    </div>
                </div>
            </div>
            <div class="form-group desc" id="comapnyDiv">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $entity_name, set_value('ent_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>  
            <div class="form-group desc" style="display:none;" id="branchDiv">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>

            </div> 
<!--            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php //$attributes = 'class="form-control" name="customer_id" id="customer_id"';
                  //  echo form_dropdown('customer_id', $customer_name, set_value('customer_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php //echo form_error('customer_id'); ?></span>
                </div>
            </div>-->
            <input type="hidden" value="<?php echo date("Y/m/d H:i"); ?>" /><br/>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Incident Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="incident_name" name="incident_name" value="<?php echo @$post['incident_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('incident_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Incident Company Address<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="incident_company_address" id="incident_company_address"><?php echo @$post['incident_company_address'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('incident_company_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Incident Details<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="incident_details" id="incident_details"><?php echo @$post['incident_details'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('incident_details'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="status_id" id="status_id"';
                    echo form_dropdown('status_id', $status_type, set_value('status_type'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('status_id'); ?></span>
                </div>
            </div>
            <!--<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">SLA<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php //$attributes = 'class="form-control" name="sla_id" id="sla_id"';
                    //echo form_dropdown('sla_id', $sla_name, set_value('sla_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php //echo form_error('sla_id'); ?></span>
                </div>
            </div>-->
			 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Zone Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="zone_id" id="zone_id"';
                    echo form_dropdown('zone_id', $zone_name, set_value('zone_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('zone_id'); ?></span>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" name="start_date" id="datetimepicker_start"   class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_start'); ?></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_end'); ?></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addIncident" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>
<script>
//    $('#datetimepicker_start').datetimepicker({
//        value: '<?php echo date("Y/m/d"); ?>',
//        mask: '9999/19/39',
//		timepicker:false,
//    });
//    $('#datetimepicker_end').datetimepicker({
//        value: '<?php echo date("Y/m/d"); ?>',
//        mask: '9999/19/39',
//		timepicker:false,
//    });
    
     $("#datetimepicker_start").datetimepicker({
         //dateFormat :'dd M yy',
         value: '<?php echo date("Y/m/d"); ?>',
         mask: '9999/19/39',
         maxDate:'0',
         timepicker:false,
        onSelectDate: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate());
            $("#datetimepicker_end").datetimepicker("option", "minDate", dt);
        }
    });
    
    $("#datetimepicker_end").datetimepicker({
        //dateFormat :'dd M yy',
        value: '<?php echo date("Y/m/d"); ?>',
         mask: '9999/19/39',
         minDate:'<?php echo date("Y/m/d"); ?>',
        timepicker:false,
        onSelectDate: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate());
            $("#datetimepicker_start").datetimepicker("option", "maxDate", dt);
        }
    });
    
    
</script>     