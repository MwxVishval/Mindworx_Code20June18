<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Add_WorkOrder label.error {
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
                        $("#Add_WorkOrder").validate({
                            rules: {
                                task_id: "required",
                                work_order_description: "required",
                                customer_id: "required",
                                status_id: "required",
                                start_date: "required",
                                end_date: "required",
                            },
                            messages: {
                                task_id: "Please Select Task",
                                work_order_description: "Please Enter Work Order Description",
                                customer_id: "Please Select Customer Name",
                                status_id: "Please Select Status Type",
                                start_date: "Please Select Start Date",
                                end_date: "Please Select End Date",
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
        $("input[name$='optButtonradio']").click(function () {
            var test_desc = $(this).val();
            $("div.desc_entity").hide();
            $("#" + test_desc).show();
        });
    });
</script>
<div class="x_panel"  style="height:700px;">
    <div class="x_title">
        <h2>Add Work Order<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_WorkOrder" name="Add_WorkOrder" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addWorkOrder" method="POST">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Related Task <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12" name="task_id" id="task_id">
                        <option value="">Select</option>
                        <?php
                        foreach ($result['getTask'] AS $getTask) {
                            echo '<option value="' . $getTask['id'] . '">' . $getTask['task_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('task_id'); ?></span>
                </div>
            </div>  

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12" name="customer_id" id="customer_id">
                        <option value="">Select</option>
                        <?php
                        foreach ($result['getCustomer'] AS $getTask) {
                            echo '<option value="' . $getTask['id'] . '">' . $getTask['cus_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('customer_id'); ?></span>
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Work Order Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="work_order_description" id="work_order_description"><?php echo @$post['work_order_description'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('work_order_description'); ?></span>
                </div>
            </div>
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
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
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
                <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_end'); ?></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addWorkOrder" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>
<script>
    $('#datetimepicker_start').datetimepicker({
        value: '<?php echo date("Y/m/d H:i"); ?>',
        mask: '9999/19/39 29:59'
    });
    $('#datetimepicker_end').datetimepicker({
        value: '<?php echo date("Y/m/d H:i"); ?>',
        mask: '9999/19/39 29:59'
    });
</script>

