<style type="text/css">
    #Add_Branch label.error {
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
                        $("#Add_Branch").validate({
                            rules: {
                                branch_name: "required",
                                branch_location: "required",
                                ent_id: {
                                    required: true
                                }
                            },
                            messages: {
                                branch_name: "Please Enter Branch Name",
                                branch_location: "Please Enter Branch Location",
                                ent_id: "Please Select Entity Type",
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
        <h2>Profile<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Branch" name="setting" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>setting" method="POST">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_name" name="web_name" value="<?php echo @$result->web_name; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_password" name="web_password" value="<?php echo @$result->web_password; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_password'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_email" name="web_email" value="<?php echo @$result->web_email; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_email'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phone <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_phone" name="web_phone" value="<?php echo @$result->web_phone; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_phone'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="web_address" id="web_address"><?php echo @$result->web_address; ?></textarea>
                    <span class="text-danger"><?php echo form_error('web_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
        
    </div>
</div>

