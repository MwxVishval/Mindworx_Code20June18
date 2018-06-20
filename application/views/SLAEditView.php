<style type="text/css">
    #Edit_SLA label.error {
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
                        $("#Edit_SLA").validate({
                            rules: {
                                sla_name: "required",
                                sla_details: "required",
                                branch_id: {
                                    required: true,
                                },
                                ent_id: {
                                    required: true,
                                }
                            },
                            messages: {
                                sla_name: "Please Enter SLA Name",
                                sla_details: "Please Enter SLA Details",
                                branch_id: "Please Select Branch Name",
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
        $("#sla_amount").on("keyup", function () {
            var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
                    val = this.value;

            if (!valid) {
                console.log("Invalid input!");
                this.value = val.substring(0, val.length - 1);
            }
        });
    });
</script>
<?php
$sla_week = explode(',', substr($result[0]['sla_week'], 1, -1));
?>
<div class="x_panel"  style="height:600px;">
    <div class="x_title">
        <h2>Edit SLA<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />

        <form id="Edit_SLA" name="Edit_SLA" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">SLA Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sla_name" name="sla_name" value="<?php echo $result[0]['sla_name']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('sla_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">SLA Time<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sla_name" name="sla_time_hours" value="<?php echo $result[0]['sla_time_hours']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('sla_time_hours'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">SLA Details <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="sla_details" id="sla_details"><?php echo $result[0]['sla_details']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('sla_details'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="sla_time" name="sla_time" type="radio" class="" <?php if ($result[0]['sla_time'] == 1) echo "checked='checked'"; ?>  value="1" />
                    <label for="gender" class="">Hour</label>

                    <input id="sla_time" name="sla_time" type="radio" class="" <?php if ($result[0]['sla_time'] == 2) echo "checked='checked'"; ?> value="2"/>
                    <label for="gender" class="">Days</label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="checkbox" name="sla_week[]" value="weekend" <?php if (in_array("weekend", $sla_week)) echo "checked='checked'"; ?>> Include Weekends 
                    <input type="checkbox" name="sla_week[]" value="public" <?php if (in_array("public", $sla_week)) echo "checked='checked'"; ?>> Include Public Holidays <br />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>sla" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Update">
                </div>
            </div>
        </form>
    </div>
</div>

