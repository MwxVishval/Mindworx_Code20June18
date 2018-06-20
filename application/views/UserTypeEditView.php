<style type="text/css">
    #Edit_WebUser_Type label.error {
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
                        $("#Edit_WebUser_Type").validate({
                            rules: {
                                web_user_type: "required",
                                web_user_description: "required",

                            },
                            messages: {
                                web_user_type: "Please Enter Web User Type",
                                web_user_description: "Please Enter Web User Description",

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
        <h2>Edit Web User Type<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />

        <form id="Edit_WebUser_Type" name="Edit_WebUser_Type" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Web User Type  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_user_type" name="web_user_type" value="<?php echo $result[0]['web_user_type']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_user_type'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Web User Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="web_user_description" id="web_user_description"><?php echo $result[0]['web_user_description']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('web_user_description'); ?></span>
                </div>
            </div>
            <?php echo $permission; ?>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>userType" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>

