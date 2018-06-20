<style type="text/css">
    #Add_Customer label.error {
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
                        $("#Add_Customer").validate({
                            rules: {
                                cus_name: "required",
                                cus_username: "required",
                                sla_id: "required",
                                cus_phone: {
                                    required: true,
                                    minlength: 9,
                                    maxlength: 10,
                                },
                                cus_pass: {
                                    required: true,
                                    minlength: 4,
                                    maxlength: 10,

                                },
                                cus_cpass: {
                                    equalTo: "#cus_pass",
                                    minlength: 4,
                                    maxlength: 10
                                },
                                cus_email: {
                                    required: true,
                                    email: true
                                },
                                cus_address: "required",
                                branch_id: {
                                    required: true
                                },
                                ent_id: {
                                    required: true,
                                }
                            },
                            messages: {
                                cus_name: "Please Enter Customer Name",
                                cus_username: "Please Enter UserName",
                                cus_pass: "Please Enter Valid Password length between 4-10",
                                cus_cpass: "Please Enter the Same Password",
                                cus_email: "Please Enter Valid Email",
                                cus_phone: "Please Enter Valid Phone Number length between 9-10",
                                cus_address: "Please Enter Address",
                                branch_id: "Please Select Branch Name",
                                ent_id: "Please Select Entity Name",
                                sla_id: "Please Select SLA",
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
        //$("div.desc").hide();
        $("input[name$='optradio']").click(function () {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
    });
</script>
<div class="x_panel"  style="height:900px;">
    <div class="x_title">
        <h2>Add Customer<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Customer" name="Add_Customer" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addCustomer" method="POST">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cus_name" name="cus_name" value="<?php echo @$post['cus_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('cus_name'); ?></span>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer UserName  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cus_username" name="cus_username" value="<?php echo @$post['cus_username'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('cus_username'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Password<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cus_pass" name="cus_pass" value="<?php echo @$post['cus_pass'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('cus_pass'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Confirm Password<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cus_cpass" name="cus_cpass" value="<?php echo @$post['cus_cpass'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('cus_cpass'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Email<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="email" id="cus_email" name="cus_email" value="<?php echo @$post['cus_email'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('cus_email'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Phone<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cus_phone" name="cus_phone" value="<?php echo @$post['cus_phone'] ?>" class="form-control col-md-7 col-xs-12" onkeyup="if (/\D/g.test(this.value))
                                this.value = this.value.replace(/\D/g, '')">
                    <span class="text-danger"><?php echo form_error('cus_phone'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="cus_address" id="cus_address"><?php echo @$post['cus_address'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('cus_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Primary SLA<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="sla_id" id="sla_id"';
                    echo form_dropdown('sla_id', $sla_name, set_value('sla_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('sla_id'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addCustomer" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>      