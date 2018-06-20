<style type="text/css">
    #Edit_Asset label.error {
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
                        $("#Edit_Asset").validate({
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
        <h2>Edit Asset<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_Asset" name="Edit_Asset" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>updateAsset" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="equp_category_id" id="equp_category_id"';
                    echo form_dropdown('equp_category_id', $category_type, set_value('equp_category_id'), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('equp_category_id'); ?></span>
                    <?php $attributes = 'class="form-control" name="equp_category_id" id="equp_category_id"';
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span> 
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
                    <?php $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $entity_name, set_value('ent_id', $result[0]['ent_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>
            </div>
            <div class="form-group desc"  id="branchDiv" <?php if ($result[0]['branch_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id', $result[0]['branch_id']), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asset Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="equp_name" name="equp_name" value="<?php echo $result[0]['equp_name']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('equp_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Quantity<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" id="equp_quantity" name="equp_quantity" value="<?php echo $result[0]['equp_quantity']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('equp_quantity'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Serial Number<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="equp_serial_number" name="equp_serial_number" value="<?php echo $result[0]['equp_serial_number']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('equp_serial_number'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Asset Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="equp_description" id="equp_description"><?php echo $result[0]['equp_description']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('equp_description'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>asset" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Update">
                </div>
            </div>
        </form>
    </div>
</div>

