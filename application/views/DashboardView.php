<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<div class="row">
    <div  align="center" class="col-xs-12 <!--x_panel-->">
        <div style="width:20%; display:inline-block;">
            <div class="form-group">
                <label class="control-label col-md-6 col-sm-6 col-xs-12">Customer</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?php $attributes = 'class="form-control" name="customer_id" id="customer_id"';
                    echo form_dropdown('customer_id', $customer_name, set_value('customer_id'), $attributes);
                    ?>
                </div>
            </div>
        </div>
        <div style="width:20%; display:inline-block;">
            <div class="form-group">
                <label class="control-label col-md-6 col-sm-6 col-xs-12">Branch</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?php $attributes = 'class="form-control" name="branch_id" id="branch_id"';
                    echo form_dropdown('branch_id', $branch_name, set_value('branch_id'), $attributes);
                    ?>
                </div>
            </div>
        </div>
        <div style="width:20%; display:inline-block;">
            <div class="form-group">
                <label class="control-label col-md-6 col-sm-6 col-xs-12">Start Date</label>
                <div class="col-md-9 col-sm-9 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" name="start_date" id="datetimepicker_start"   class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_start'); ?></span>
                </div>
            </div>
        </div>
        <div style="width:20%; display:inline-block;">
            <div class="form-group">
                <label class="control-label col-md-6 col-sm-6 col-xs-12">End Date</label>
                <div class="col-md-9 col-sm-9 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" value="" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-th"></i></span>
                    <span class="text-danger"><?php echo form_error('datetimepicker_end'); ?></span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12 desc">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Project</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content" id="projectDivs" >
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>New</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $newProjectCount[0]['totalnewProject']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Pending</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $pendingProjectCount[0]['totalpendingProject']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>In Progress</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $progressProjectCount[0]['totalprogressProject']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Completed</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $completedProjectCount[0]['totalcompletedProject']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Failed</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $failedProjectCount[0]['totalfailedProject']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Cancelled</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $cancelledProjectCount[0]['totalcancelledProject']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Incident</h2>

                <div class="clearfix"></div>
            </div>
             <div class="x_content">

                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>New</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $newIncidentCount[0]['totalnewIncident']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Pending</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $pendingIncidentCount[0]['totalpendingIncident']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>In Progress</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $progressIncidentCount[0]['totalprogressIncident']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Completed</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $completedIncidentCount[0]['totalcompletedIncident']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Failed</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $failedIncidentCount[0]['totalfailedIncident']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Cancelled</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $cancelledIncidentCount[0]['totalcancelledIncident']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="clearfix"></div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Tasks</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>New</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $newTaskCount[0]['totalnewTask']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Pending</span>
                    </div>

                    <div class="w_right w_20">
                        <span><?php echo $pendingTaskCount[0]['totalpendingTask']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>In Progress</span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $progressTaskCount[0]['totalprogressTask']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Completed</span>
                    </div>

                    <div class="w_right w_20">
                        <span><?php echo $completedTaskCount[0]['totalcompletedTask']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Failed</span>
                    </div>

                    <div class="w_right w_20">
                        <span><?php echo $failedTaskCount[0]['totalfailedTask']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Cancelled</span>
                    </div>

                    <div class="w_right w_20">
                        <span><?php echo $cancelledTaskCount[0]['totalcancelledTask']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Top FSE (per task completed)</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <?php 
                                    foreach ($fseTaskComplete AS $fsec){
                ?>
                
                
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span><?php echo $fsec['fse_username']; ?></span>
                    </div>
                    <div class="w_right w_20">
                        <span><?php echo $fsec['total']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                                    <?php } ?>
<!--                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>John Smith</span>
                    </div>
                    <div class="w_right w_20">
                        <span>12</span>
                    </div>
                    <div class="clearfix"></div>
                </div>-->
<!--                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Ann Noone</span>
                    </div>
                    <div class="w_right w_20">
                        <span>34</span>
                    </div>
                    <div class="clearfix"></div>
                </div>-->
<!--                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Jess Samuels</span>
                    </div>
                    <div class="w_right w_20">
                        <span>357</span>
                    </div>
                    <div class="clearfix"></div>
                </div>-->
<!--                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Leroto Mota</span>
                    </div>
                    <div class="w_right w_20">
                        <span>4</span>
                    </div>
                    <div class="clearfix"></div>
                </div>-->
<!--                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>Sipa Moophosa</span>
                    </div>
                    <div class="w_right w_20">
                        <span>4</span>
                    </div>
                    <div class="clearfix"></div>
                </div>-->

            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>


    <script>
        $('#datetimepicker_start').datetimepicker({
            value: '<?php echo date("Y/m/d H:i"); ?>',
            mask: '9999/19/39 29:59'
        });
        $('#datetimepicker_end').datetimepicker({
            value: '<?php echo date("Y/m/d H:i"); ?>',
            mask: '9999/19/39 29:59'
        });
    </script>

    <script type="text/javascript">// <![CDATA[
        $(document).ready(function () {
            $('#optSelect').change(function () { //any select change on the dropdown with id country trigger this code
                if ($('#optSelect').val() == 'incidentDiv') {
                    $('#projectDivs').hide();
                    $('#incidentDivs').show();
                } else if ($('#optSelect').val() == 'projectDiv') {
                    $('#incidentDivs').hide();
                    $('#projectDivs').show();

                }
            });
        });
        // ]]>
    </script>




