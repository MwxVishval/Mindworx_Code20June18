<style type="text/css">
    #Add_WebUser label.error {
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
                        $("#Add_WebUser").validate({
                            rules: {
                                web_name: "required",
                                web_username: "required",
                                web_password: {
                                    required: true,
                                    minlength: 4,
                                    maxlength: 10,
                                },
                                web_cpassword: {
                                    equalTo: "#web_password",
                                    minlength: 4,
                                    maxlength: 10
                                },
                                web_phone: {
                                    required: true,
                                    minlength: 9,
                                    maxlength: 10,
                                },
                                web_address: "required",
                                web_email: {
                                    required: true,
                                    email: true
                                },
                                branch_id: {
                                    required: true,
                                },
                                user_type: {
                                    required: true,
                                },
                                ent_id: {
                                    required: true,
                                }
                            },
                            messages: {
                                web_name: "Please Enter Web Name",
                                web_username: "Please Enter User Name",
                                web_password: "Please Enter Valid Password length between 4-10",
                                web_cpassword: "Please Enter the Same Password",
                                web_phone: "Please Enter Valid Phone Number length between 9-10",
                                web_email: "Please Enter Valid Email Address",
                                web_address: "Please Enter Address",
                                branch_id: "Please Select Branch Name",
                                user_type: "Please Select User Type",
                                ent_id: "Please Select Entity Name",
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
        <h2>Add WebUser<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_WebUser" name="Add_WebUser" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addWebuser" method="POST">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Web Name  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_name" autocomplete="off" name="web_name" value="<?php echo @$post['web_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">User Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_username" autocomplete="off" name="web_username" value="<?php echo @$post['web_username'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_username'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_password" autocomplete="off" name="web_password" value="<?php echo @$post['web_password'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_password'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Confirm Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_cpassword" autocomplete="off" name="web_cpassword" value="<?php echo @$post['web_cpassword'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_cpassword'); ?></span>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">User Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="user_type" id="user_type"';
                    echo form_dropdown('user_type', $user_type, set_value('user_type'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('user_type'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Company / Branch
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                        <label><input type="radio" name="optradio" checked="checked" value="comapnyDiv">Company</label> 
                        <label><input type="radio" name="optradio" value="branchDiv">Branch</label>
                    </div>
                </div>
            </div>
            <div class="form-group desc" id="comapnyDiv">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $entity_name, set_value('ent_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>  
            <div class="form-group desc" style="display:none;" id="branchDiv">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>

            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_email" autocomplete="off" name="web_email" value="<?php echo @$post['web_email'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_email'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="web_phone" autocomplete="off" name="web_phone" value="<?php echo @$post['web_phone'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('web_phone'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="web_address" id="web_address"><?php echo @$post['web_address'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('web_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addWebuser" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>

        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>      