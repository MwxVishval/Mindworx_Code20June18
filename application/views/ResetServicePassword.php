<style type="text/css">
    #Reset_Password label.error {
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
                        $("#Reset_Password").validate({
                            rules: {
                                fse_password: {
                                    required: true,
                                    minlength: 4,
                                    maxlength: 10,

                                },
                                fse_confirm_password: {
                                    equalTo: "#fse_password",
                                    minlength: 4,
                                    maxlength: 10
                                },
                            },
                            messages: {
                                fse_password: "Please Enter Valid Password length between 4-10",
                                fse_confirm_password: "Please Enter the Same Password",

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
        <h2>Reset Service Enginner Password<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Reset_Password" name="Reset_Password" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>resetPassword" method="POST">
            <input type="hidden" name="id" value="<?php echo $post_data['edit_id']; ?>">
            <input type="hidden" name="fse_email" value="<?php echo $post_data['fse_email']; ?>">
            <input type="hidden" name="fse_username" value="<?php echo $post_data['fse_username']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Password<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_password" name="fse_password" value="<?php echo @$post['fse_password'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_password'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Confirm Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_confirm_password" name="fse_confirm_password" value="<?php echo @$post['fse_confirm_password'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_confirm_password'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>resetPassword" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="Btnsubmit" value="Reset">
                </div>
            </div>
        </form>
    </div>
</div>

