<style type="text/css">
    #Add_Task_Type label.error {
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
                        $("#Add_Task_Type").validate({
                            rules: {
                                task_type: "required",
                                task_type_description: "required",
                            },
                            messages: {
                                task_type: "Please Enter Task Type",
                                task_type_description: "Please Enter Task Description",
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

<div class="x_panel"  style="height:600px;">
    <div class="x_title">
        <h2>Add Task Type<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Task_Type" name="Add_Task_Type" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addTaskType" method="POST">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Task Type <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="task_type" name="task_type" value="<?php echo @$post['task_type'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('task_type'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Task Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="task_type_description" id="task_type_description"><?php echo @$post['task_type_description'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('task_type_description'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addTaskType" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>

        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>      