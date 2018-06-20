<style type="text/css">
    #Add_Asset label.error {
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
                        $("#Add_Asset").validate({
                            rules: {
                                equp_name: "required",
                                equp_quantity: "required",
                                equp_serial_number: "required",
                                equp_description: "required",
                                ent_id: {
                                    required: true,
                                },
                                branch_id: {
                                    required: true,
                                },
                                equp_category_id: {
                                    required: true,
                                }
                            },
                            messages: {
                                equp_name: "Please Enter Asset Name",
                                equp_quantity: "Please Enter Quanity",
                                equp_serial_number: "Please Enter Serial Number",
                                equp_description: "Please Enter Description",
                                ent_id: "Please Select Entity Name",
                                branch_id: "Please Select Branch Name",
                                equp_category_id: "Please Select Category Name",
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

<div class="x_panel"  style="height:600px;">
    <div class="x_title">
        <h2>Add Asset<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Asset" name="Add_Asset" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addAsset" method="POST">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="equp_category_id" id="equp_category_id"';
                    echo form_dropdown('equp_category_id', $category_type, set_value('equp_category_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('equp_category_id'); ?></span>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Name  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="equp_name" name="equp_name" value="<?php echo @$post['equp_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('equp_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Quantity<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" id="equp_quantity" name="equp_quantity" value="<?php echo @$post['equp_quantity'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('equp_quantity'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Serial Number<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="equp_serial_number" name="equp_serial_number" value="<?php echo @$post['equp_serial_number'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('equp_serial_number'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="equp_description" id="equp_description"><?php echo @$post['equp_description'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('equp_description'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addAsset" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>      