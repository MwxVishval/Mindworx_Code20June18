<style type="text/css">
    #Edit_Branch label.error {
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
                        $("#Edit_Branch").validate({
                            rules: {
                                branch_name: "required",
                                branch_location: "required",
                                ent_id: {
                                    required: true
                                }
                            },
                            messages: {
                                branch_name: "Please Enter Branch Name",
                                branch_location: "Please Enter Branch Location",
                                ent_id: "Please Select Entity Type",
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
        <h2>Edit Branch<small></small></h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_Branch" name="Edit_Branch" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                    echo form_dropdown('ent_id', $ent_id, set_value('ent_id', $ent_id), $attributes);
                    ?>
                    <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Branch Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="branch_name" name="branch_name" value="<?php echo $result[0]['branch_name']; ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('branch_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Location <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="branch_location" id="branch_location"><?php echo $result[0]['branch_location']; ?></textarea>
                    <span class="text-danger"><?php echo form_error('branch_location'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>branch" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>

