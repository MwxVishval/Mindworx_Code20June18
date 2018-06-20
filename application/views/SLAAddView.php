<style type="text/css">
    #Add_SLA label.error {
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
                        $("#Add_SLA").validate({
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

<div class="x_panel"  style="height:600px;">
    <div class="x_title">
        <h2>Add SLA<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_SLA" name="Add_SLA" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addSLA" method="POST">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">SLA Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sla_name" name="sla_name" value="<?php echo @$post['sla_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('sla_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">SLA Time<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" id="sla_name" name="sla_time_hours" value="<?php echo @$post['sla_time_hours'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('sla_time_hours'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">SLA Details <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="sla_details" id="sla_details"><?php echo @$post['sla_details'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('sla_details'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="sla_time" name="sla_time" type="radio" class="" checked  value="1" />
                    <label for="gender" class="">Hour</label>

                    <input id="sla_time" name="sla_time" type="radio" class=""  value="2"/>
                    <label for="gender" class="">Days</label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="checkbox" name="sla_week[]" value="weekend"> Include Weekends 
                    <input type="checkbox" name="sla_week[]" value="public"> Include Public Holidays <br />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>addSLA" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>

