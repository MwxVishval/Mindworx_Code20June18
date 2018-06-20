<style type="text/css">
    #Edit_FSE_Type label.error {
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
                        $("#Edit_FSE_Type").validate({
                            rules: {
                                fse_type: "required",
                                fse_description: "required",
                            },
                            messages: {
                                fse_type: "Please Enter FSE Type Name",
                                fse_description: "Please Enter FSE Description",
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
        <h2>Edit FSE Type<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_FSE_Type" name="Edit_FSE_Type" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Type  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_type" name="fse_type" value="<?php echo $result[0]['fse_type']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_type'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">FSE Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="fse_description" id="fse_description"><?php echo $result[0]['fse_description']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('fse_description'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>fseType" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>

        </form>
    </div>
</div>

