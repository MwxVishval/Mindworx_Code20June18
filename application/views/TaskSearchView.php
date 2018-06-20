<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Generate_Report label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }	
    .customReportForm select {
        -webkit-appearance: none;
        -moz-appearance:    none;
        appearance:         none;
        position:relative;
        line-height:1;
        background:url('<?php echo base_url(); ?>assets/images/down-arrow.png') no-repeat 98% center;	   
    }	
</style>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">

    (function ($, W, D)
    {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Generate_Report").validate({
                            rules: {
                                tasktypeid: "required",
                            },
                            messages: {
                                tasktypeid: "Please Select Task Type",
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

<div class="x_panel" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Task Report Search <small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form id="Generate_Report" name="Generate_Report" data-parsley-validate class="form form-label-left customReportForm" action="<?php echo base_url() ?>tasklist" method="POST">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">Start Date</label>
                                    <div class="col-xs-12 col-sm-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                        <input size="16" type="text" value="" name="start_date" id="datetimepicker_start"   class="form-control col-md-7 col-xs-12">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                        <span class="text-danger"><?php echo form_error('datetimepicker_start'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">End Date</label>
                                    <div class="col-xs-12 col-sm-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                        <input size="16" type="text" value="" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                        <span class="text-danger"><?php echo form_error('datetimepicker_end'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">Task Type</label>
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="text" name="tasktypeid" value="<?php echo @$entitycreateFilds[0]['fse_name'] ?>" id="fse_id_h" class="form-control col-md-7 col-xs-12" style="float: left;" />
                                        <input type="hidden" name = "tasktypeid" value="<?php echo @$entitycreateFilds[0]['fse_id'] ?>" id="fse_id" value=""/>
                                        <div id="autocomplete-container" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                                        <span class="text-danger"><?php echo form_error('fse_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <script type="text/javascript">
                            $(function () {
                                $("#fse_id_h").autocomplete({
                                    source: function (request, response) {
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>TaskController/getTask_autocomplete_c",
                                            dataType: "json",
                                            type: "POST",
                                            data: request,
                                            success: function (data) {
                                                response(data);
                                            }
                                        });
                                    },
                                    focus: function (event, ui) {
                                        $("#fse_id_h").val(ui.item.label);
                                        return false;
                                    },
                                    select: function (event, ui) {
                                        $('#fse_id').val(ui.item.value);
                                        return false;
                                    },
                                    change: function (e, u) {
                                        if (u.item == null) {
                                            $(this).val("");
                                            return false;
                                        }
                                    },
                                    appendTo: '#autocomplete-container',
                                    minLength: 2
                                });
                            });
                        </script>

                        <div class="col-xs-12 col-sm-12">
                            <div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-12">
                                        <input type="submit" class="btn btn-success" name="submit" value="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Datatables-->
<script src="<?php echo base_url(); ?>assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/responsive.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.scroller.min.js"></script>


<!-- pace -->
<script src="<?php echo base_url(); ?>assets/js/pace/pace.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>

<script>
                            $('#datetimepicker_start').datetimepicker({
                                value: '<?php echo date("Y/m/d H:i", strtotime("-1 months")); ?>',
                                mask: '9999/19/39 29:59'
                            });
                            $('#datetimepicker_end').datetimepicker({
                                value: '<?php echo date("Y/m/d H:i"); ?>',
                                mask: '9999/19/39 29:59'
                            });
</script>

