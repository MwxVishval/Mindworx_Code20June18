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
<div class="x_panel" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Report <small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form id="Generate_Report" name="Generate_Report" data-parsley-validate class="form form-label-left customReportForm" action="<?php echo base_url() ?>generateReport" method="POST">
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
                                    <label class="control-label col-xs-12 col-sm-12">Entity</label>
                                    <div class="col-xs-12 col-sm-12">
                                        <?php $attributes = 'class="form-control" name="ent_id" id="ent_id"';
                                        echo form_dropdown('ent_id', $ent_name, set_value('ent_id'), $attributes);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">Branch</label>
                                    <div class="col-xs-12 col-sm-12">
                                        <?php $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                                        echo form_dropdown('branch_id', $branch_name, set_value('branch_id'), $attributes);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">Project</label>
                                    <div class="col-xs-12 col-sm-12">
                                    <?php $attributes = 'class="form-control" name="proj_id" id="proj_id"';
                                    echo form_dropdown('proj_id', $proj_name, set_value('proj_id'), $attributes);
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">Incident</label>
                                    <div class="col-xs-12 col-sm-12">
                                    <?php $attributes = 'class="form-control" name="incident_id" id="incident_id"';
                                    echo form_dropdown('incident_id', $incident_name, set_value('incident_id'), $attributes);
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-12">FSE</label>
                                    <div class="col-xs-12 col-sm-12">
                                    <?php $attributes = 'class="form-control" name="fse_id" id="fse_id"';
                                    echo form_dropdown('fse_id', $fse_name, set_value('fse_id'), $attributes);
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<script type="text/javascript">// <![CDATA[
    $(document).ready(function () {
        $('#taskid').change(function () { //any select change on the dropdown with id country trigger this code

            var taskid = $('#taskid').val(); // here we are taking country id of the selected one.
            alert(taskid);
            $.ajax({
                url: "<?php echo base_url() ?>dashboard",
                type: 'POST',
                data: {"taskid": taskid}, //here we are calling our user controller and get_cities method with the country_id

                success: function (html) {
                    $('#results').html();
                },
                failure: function () {
                    alert('some error');
                }

            });

        });
    });
    // ]]>
</script>
<script>
    var handleDataTableButtons = function () {
        "use strict";
        0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "csv",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdf",
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
            responsive: !0
        })
    },
            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons()
                    }
                }
            }();
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
            keys: true
        });
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });
    });
    TableManageButtons.init();
</script>

