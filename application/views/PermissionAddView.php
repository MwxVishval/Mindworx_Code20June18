<style type="text/css">
    #Add_Permission label.error {
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
                        $("#Add_Permission").validate({
                            rules: {
                                user_id: "required"
                            },
                            messages: {
                                user_id: "Please Select Your User Name",
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

<div class="x_panel"  style="height-min:600px;">
    <div class="x_title">
        <h2>Add Permission<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Permission" name="Add_Permission" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addPermission" method="POST">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Type <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="user_id" id="user_id"';
                    echo form_dropdown('user_id', $user_type, set_value('user_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('user_id'); ?></span>
                </div>
            </div>
            <?php echo $permission; ?>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>permission" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>      