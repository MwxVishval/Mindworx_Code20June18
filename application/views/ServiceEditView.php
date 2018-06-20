<style type="text/css">
    #Edit_ServiceEnginner label.error {
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
        // var fse_type=$("#fse_type_id").val();
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Edit_ServiceEnginner").validate({
                            rules: {
                                fse_name: "required",
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
//                                fse_type_id: {
//                                    required: true
//                                }
                            },
                            messages: {
                                fse_name: "Please Enter FSE Name",
                                fse_username: "Please Enter Valid FSE UserName length between 6-18",
                                fse_password: "Please Enter Valid Password length between 6-18,1 Uppercase, 1 Lowercase, 1 Number",
                                fse_cpassword: "Please Enter the Same Password",
                                //  fse_type_id1: "Please Select FSE Type",
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
    }, "Please enter a valid.");
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
        <h2>Edit Service Engineer<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_ServiceEnginner"  onsubmit="return SubmitForm()"  name="Edit_ServiceEnginner" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_name" name="fse_name" value="<?php echo $result[0]['fse_name']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE UserName <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_username" name="fse_username"  value="<?php echo $result[0]['fse_username']; ?>" class="form-control col-md-7 col-xs-12" maxlength="18" >
                    <span class="text-danger"><?php echo form_error('fse_username'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fse_type_id11">FSE Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 check" id="myid"  onclick="dropdownvalidation();">
                    <?php //var_dump($result) ?>
                    <input id="fse_type_id"  style="width:500px;" type="text" name="fse_type_id"  />

                    <?php if ($result[0]['fse_list'] == '0' || $result[0]['fse_list'] == '') { ?>
                        <span class="text-danger" style="color:#FB3A3A;font-weight:bold" id="fse_type_error">Please Select FSE Type</span>
                    <?php } else { ?>
                        <span class="text-danger" style="display:none; color:#FB3A3A;font-weight:bold" id="fse_type_error">Please Select FSE Type</span>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_email" name="fse_email" value="<?php echo $result[0]['fse_email']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('fse_email'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">FSE Mobile <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="fse_mobile" name="fse_mobile" value="<?php echo $result[0]['fse_mobile']; ?>" class="form-control col-md-7 col-xs-12" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                    <span class="text-danger"><?php echo form_error('fse_mobile'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">FSE Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="fse_address" id="fse_address"><?php echo $result[0]['fse_address']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('fse_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Company / Branch
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                        <label><input type="radio" name="optradio" <?php if ($result[0]['ent_id'] != 0) { ?> checked="checked" <?php } ?> value="companyDiv">Company</label> 
                        <label><input type="radio" name="optradio" <?php if ($result[0]['branch_id'] != 0) { ?> checked="checked" <?php } ?> value="branchDiv">Branch</label>
                    </div>
                </div>
            </div> 

            <div class="form-group desc" id="companyDiv" <?php if ($result[0]['ent_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>> 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $entity_name, set_value('ent_id', $result[0]['ent_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>
            <div class="form-group desc"  id="branchDiv" <?php if ($result[0]['branch_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id', $result[0]['branch_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>
            </div> 
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>serviceEngineer" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Update">
                    <!--                    <button class="btn btn-success" name="submit" value="Submit" onclick="SubmitForm();">Submit</button>-->
                </div>
            </div>

        </form>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
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
                                        value: '<?php echo $result[0]['fse_list'] ?>'

                                    });
                                }
                            });
                        });

</script>

<script type="text/javascript">
    function SubmitForm()
    {
        var x = $('[name="fse_type_id"]').val();
        if (x.length == 2)
        {
            $('#fse_type_error').show();
            return false;
        }
        else
        {
            return true;
        }

    }
</script>

<script>
    function dropdownvalidation()
    {
        var x = $('[name="fse_type_id"]').val();       
        if (x.length > 2)
        {            
            $('#fse_type_error').hide();
            return false;
        }
        else if (x.length == 2) {          
            $('#fse_type_error').show();
        }
    }

</script>

