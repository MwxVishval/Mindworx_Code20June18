<style type="text/css">
    #Add_ServiceEnginner label.error {
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
        var fsetype = $("#fse_type_id").val();
        // alert(fsetype);
        //   return false;
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Add_ServiceEnginner").validate({
                            rules: {
                                fse_name: "required",
                                fse_type_id: "required",
                                fse_username: {
                                    //regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
                                    required: true,
                                    minlength: 6,
                                    maxlength: 18,
                                },
                                ent_id: "required",
                                branch_id: "required",
                                fse_password: {
                                    regx: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/,
                                    required: true,
                                    minlength: 6,
                                    maxlength: 18,
                                },
                                fse_cpassword: {
                                    equalTo: "#fse_password",
                                    minlength: 6,
                                    maxlength: 18,
                                },
                                fse_email: {
                                    required: true,
                                    email: true
                                },
                                fse_mobile: "required",
                                fse_address: "required",
                                fse_type_id: "required"
                            },
                            messages: {
                                fse_name: "Please Enter FSE Name",
                                fse_username: "Please Enter Valid FSE UserName length between 6-18",
                                fse_password: "Please Enter Valid Password length between 6-18,1 Uppercase, 1 Lowercase, 1 Number",
                                fse_cpassword: "Please Enter the Same Password",
                                fse_type_id: "Please Select FSE Type",
                                fse_email: "Please Enter Valid FSE Email",
                                fse_mobile: "Please Enter FSE Mobile",
                                fse_address: "Please Enter FSE Address",
                                ent_id: "Please Select Entity Name",
                                branch_id: "Please Select Branch Name",
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

    $.validator.addMethod("regx", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Please enter a valid");

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
        <h2>Add Service Engineer<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_ServiceEnginner" onsubmit="return SubmitForm()" name="Add_ServiceEnginner" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addserviceEngineer" method="POST" >

            <input type="hidden" name="service_id" value="1">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_name" autocomplete="off" name="fse_name" value="<?php echo @$post['fse_name'] ?>" class="form-control col-md-7 col-xs-12" >
                    <span class="text-danger"><?php echo form_error('fse_name'); ?></span>
                </div>	   
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE UserName <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_username" autocomplete="off" name="fse_username" value="<?php echo @$post['fse_username'] ?>" class="form-control col-md-7 col-xs-12" maxlength="18">
                    <span class="text-danger"><?php echo form_error('fse_username'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_password" autocomplete="off" name="fse_password" value="<?php echo @$post['fse_password'] ?>" class="form-control col-md-7 col-xs-12" maxlength="18">
                    <span class="text-danger"><?php echo form_error('fse_password'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">FSE Confirm Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php // var_dump($post) ?>
                    <input type="text" id="fse_cpassword" autocomplete="off" name="fse_cpassword" value="<?php echo @$post['fse_cpassword'] ?>" class="form-control col-md-7 col-xs-12" maxlength="18">
                    <span class="text-danger"><?php echo form_error('fse_cpassword'); ?></span>
                </div>
            </div> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fse_type">FSE Type<span class="required">*</span>
                </label>
                  <?php if (count($fse_type) == 1) { ?>
                <span class="mrtp10 text-center englable"> Please add a Service Engineer Type, before adding an Engineer</span>

                    <?php } else { ?>
                <div class="col-md-6 col-sm-6 col-xs-12"onclick="dropdownvalidation();" >
                    <?php //var_dump($fse_type)?>
                    <input id="fse_type_id" style="width:500px;" type="text" name="fse_type_id" value="<?php echo @$post['fse_type_id'] ?>" />
                    <span class="text-danger" style="display:none;color:#FB3A3A;font-weight:bold" id="fse_type_error">Please Select FSE Type</span>
                </div> 
                    <?php } ?>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_email" autocomplete="off" name="fse_email" value="<?php echo @$post['fse_email'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_email'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Mobile <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_mobile" autocomplete="off" name="fse_mobile" value="<?php echo @$post['fse_mobile'] ?>" class="form-control col-md-7 col-xs-12" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                    <span class="text-danger"><?php echo form_error('fse_mobile'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">FSE Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="fse_address" id="fse_address"><?php echo @$post['fse_address'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('fse_address'); ?></span>
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
                    <?php
                    $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $entity_name, set_value('ent_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>  
            <div class="form-group desc" style="display:none;" id="branchDiv">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>
            </div> 
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addserviceEngineer" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit" onclick=";">
                </div>
            </div>

        </form>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <link href="<?php echo base_url(); ?>assets/css/tag.css" rel="stylesheet">
 <script src="<?php echo base_url(); ?>assets/js/taginput.js"></script>

<script>
                        $(document).ready(function () {
                            var jsonData = [];
                            $.ajax({
                                url: "<?php echo base_url() ?>managementcontroller/get_fse_type",
                                type: 'post',
                                dataType: 'json',
                                success: function (res) {
                                    jsonData = res;

                                    var ms1 = $('#fse_type_id').tagSuggest({
                                        data: jsonData,
                                        sortOrder: 'name',
                                        maxDropHeight: 200,
                                        name: 'fse_type_id',
                                    });

                                }
                            });

                        });
</script>
<script type="text/javascript">
    function SubmitForm()
    {
        var x = $('[name="fse_type_id"]').val();
        // alert(x.length);
        if (x.length > 2)

        {
            $('#fse_type_error').hide();
            return true;
        }
        else if (x.length == 2)
        {
            $('#fse_type_error').show();
            return false; 

        }
    }
</script>

<script>
 function dropdownvalidation()
    {
        var x = $('[name="fse_type_id"]').val();
        // alert(x.length);
        if (x.length > 2)

        {
         //   alert(x.length)
            $('#fse_type_error').hide();
            return false;
        }
        else if (x.length == 2)
        {
             //alert(x.length)
            $('#fse_type_error').show();
        }
        
    }


</script>

