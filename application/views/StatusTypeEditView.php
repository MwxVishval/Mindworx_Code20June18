<style type="text/css">
    #Edit_Status_Type label.error {
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
                        $("#Edit_Status_Type").validate({
                            rules: {
                                status_type: "required",
                                status_description: "required",
                            },
                            messages: {
                                status_type: "Please Enter Status Type",
                                status_description: "Please Enter Status Description",
                               
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
                  <h2>Edit Status Type<small></small></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <form id="Edit_Status_Type" name="Edit_Status_Type" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
                       <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                     <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status Type   <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="status_type" name="status_type" value="<?php echo $result[0]['status_type']; ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('status_type'); ?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status Description <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="status_description" id="status_description"><?php echo $result[0]['status_description']; ?></textarea>
                          <span class="text-danger"><?php echo form_error('status_description'); ?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="<?php echo base_url() ?>statusType" class="btn btn-primary">Cancel</a>  
                        <input type="submit" class="btn btn-success" name="submit" value="Submit">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
           
   