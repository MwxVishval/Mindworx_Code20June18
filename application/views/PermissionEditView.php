<style type="text/css">
    #Edit_Permission label.error {
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
                        $("#Edit_Permission").validate({
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

<div class="x_panel"  style="height:600px;">
    <div class="x_title">
        <h2>Edit Permission<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_Permission" name="Edit_Permission" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Type <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="user_id" id="user_id"';
                    echo form_dropdown('user_id', $user_type, set_value('user_type', $result[0]['user_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('user_id'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Permission Value <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="checkbox">
                        <label><input type="checkbox" value="<?php echo @$post['permission_value'] ?>" id="permission_value" name="permission_value">Add</label>
                        <label><input type="checkbox" value="<?php echo @$post['permission_value'] ?>" id="permission_value" name="permission_value">View</label>
                        <label><input type="checkbox" value="<?php echo @$post['permission_value'] ?>" id="permission_value" name="permission_value">Edit</label>
                        <label><input type="checkbox" value="<?php echo @$post['permission_value'] ?>" id="permission_value" name="permission_value">Delete</label>
                    </div>
                </div>
            </div>
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