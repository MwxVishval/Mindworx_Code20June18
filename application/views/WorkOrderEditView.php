<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Edit_WorkOrder label.error {
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
                        $("#Edit_WorkOrder").validate({
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
<div class="x_panel"  style="height:600px;">
    <div class="x_title">
        <h2>Edit Work Order<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_WorkOrder" name="Edit_WorkOrder" class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Related Task <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12" name="task_id" id="task_id">
                        <option value="">Select</option>
                        <?php
                        foreach ($results['getTask'] AS $getTask) {
                            $selected = ($getTask['id'] == $result[0]['task_id']) ? 'selected' : null;
                            echo '<option value="' . $getTask['id'] . '" echo ' . $selected . '>' . $getTask['task_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12" name="customer_id" id="customer_id">
                        <option value="">Select</option>
                        <?php
                        foreach ($results['getCustomer'] AS $getCustomer) {
                            $selected = ($getCustomer['id'] == $result[0]['customer_id']) ? 'selected' : null;
                            echo '<option value="' . $getCustomer['id'] . '" echo ' . $selected . '>' . $getCustomer['cus_name'] . '</option>';
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
                    <textarea class="form-control col-md-7 col-xs-12" name="work_order_description" id="work_order_description"><?php echo $result[0]['work_order_description']; ?></textarea>
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
                        foreach ($results['getStatus'] AS $getStatus) {
                            $selected = ($getStatus['id'] == $result[0]['status_id']) ? 'selected' : null;
                            echo '<option value="' . $getStatus['id'] . '" echo ' . $selected . '>' . $getStatus['status_type'] . '</option>';
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
                <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" value="<?php echo $result[0]['end_date']; ?>" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_end'); ?></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>workOrder" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>
<script>
    $('#datetimepicker_start').datetimepicker({
        value: '<?php echo $result[0]['start_date']; ?>',
        mask: '9999/19/39 29:59'
    });
    $('#datetimepicker_end').datetimepicker({
        value: '<?php echo $result[0]['end_date']; ?>',
        mask: '9999/19/39 29:59'
    });
</script> 
