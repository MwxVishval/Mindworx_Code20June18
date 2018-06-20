<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Edit_Project label.error {
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
                        $("#Edit_Project").validate({
                            rules: {
                                proj_name: "required",
                                proj_details: "required",
                                proj_company_address: "required",
                                status_id: "required",
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
                                proj_name: "Please Enter Project Name",
                                proj_details: "Please Enter Project Details",
                                proj_company_address: "Please Enter Project Company Address",
                                customer_id: "Please Select Customer Name",
                                ent_id: "Please Select Entity Name",
                                branch_id: "Please Select Branch Name",
                                status_id: "Please Select Status",
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
        <h2>Edit Project<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_Project" name="Edit_Project" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Company / Branch
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                        <label><input type="radio" name="optradio" <?php if ($result[0]['ent_id'] != 0) { ?> checked="checked" <?php } ?> value="companyDiv">Company</label> 
                        <label><input type="radio" name="optradio" <?php if ($result[0]['branch_id'] != 0) { ?> checked="checked" <?php } ?> value="branchDiv">Branch</label>
                    </div>
                </div>
            </div> 
            <div class="form-group desc" id="companyDiv" <?php if ($result[0]['ent_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>> 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $ent_id, set_value('ent_id', $result[0]['ent_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>
            <div class="form-group desc"  id="branchDiv" <?php if ($result[0]['branch_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id', $result[0]['branch_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>
            </div>

<!--            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php //$attributes = 'class="form-control" name="customer_id" id="customer_id"';
                    //echo form_dropdown('customer_id', $customer_id, set_value('customer_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php //echo form_error('customer_id'); ?></span>
                </div>
            </div>-->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="proj_name" name="proj_name" value="<?php echo $result[0]['proj_name']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('proj_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project Company Address<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="proj_company_address" id="proj_company_address"><?php echo $result[0]['proj_company_address']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('proj_company_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project Details<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="proj_details" id="proj_details"><?php echo $result[0]['proj_details']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('proj_details'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="status_id" id="status_id"';
                    echo form_dropdown('status_id', $status_type, set_value('status_id', $result[0]['status_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('status_id'); ?></span>
                </div>
            </div>
			 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Zone Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="zone_id" id="zone_id"';
                    echo form_dropdown('zone_id', $zone_name, set_value('zone_id',$result[0]['zone_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('zone_id'); ?></span>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                    <input size="16" type="text" value="<?php echo $result[0]['start_date']; ?>" name="start_date" id="datetimepicker_start"   class="form-control col-md-7 col-xs-12">
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
                    <input size="16" type="text" value="<?php echo $result[0]['end_date']; ?>" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_end'); ?></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>project" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Update">
                </div>
            </div>

        </form>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>
<script>
//    $('#datetimepicker_start').datetimepicker({
//        value: '<?php echo $result[0]['start_date']; ?>',
//        mask: '9999/19/39',
//		timepicker:false,
//       
//    });
//    $('#datetimepicker_end').datetimepicker({
//        value: '<?php echo $result[0]['end_date']; ?>',
//        mask: '9999/19/39',
//		timepicker:false,
//        
//    });

$("#datetimepicker_start").datetimepicker({
         //dateFormat :'dd M yy',
         value: '<?php echo $result[0]['start_date']; ?>',
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
        value: '<?php echo $result[0]['end_date']; ?>',
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
