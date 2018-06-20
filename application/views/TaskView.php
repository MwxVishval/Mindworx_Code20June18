<style>
    .table-responsive {
        min-height: .01% !important;
        overflow-x: auto !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<div class="x_panel" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Task View</h2>
        <a href="<?php echo base_url() ?>task" id="send"  class="btn btn-success" style="float:right;">Search</a>
        <div class="clearfix"></div>
    </div>
    <?php
    if ($entityFeilds != FALSE) {
        if (!empty($entityFeilds)) {
            $task_field = json_decode($entityFeilds);
        } else {
            $task_field = array();
        }
    } else {
        $task_field = array();
    }
    ?>
    <div class="x_content">
        <!--<div class="table-responsive">--> 
        <table id="datatable" class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th >SNo</th>
                    <th>Task Name</th> 
                    <th>Task Type</th> 
                    <th>Field Engineer </th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Address</th>
                    <th>Date Logged</th>
                    <?php
                    if (isset($result[0]['customFields'])) {
                        if (!empty($result[0]['customFields'])) {
                            foreach ($result[0]['customFields'] as $key => $value){
                                echo "<th>".$key."</th>";
                            }
                        }
                    }
                    ?>
                    <th>FSE Checklist</th>
                    <th>FSE Comments</th>
                    <th>FSE Reason</th>
                    <th>FSE Feedback</th>                    
                    <th>Customer Sign</th>
                    <th>Start Trip</th>
                    <th>End Trip</th>
                    <th>Travel Time</th>
                    <th>Start Work</th>
                    <th>End Work</th>
                    <th>Repair Time</th>
                    <th>Travel KM</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 1;
                foreach ($result AS $r) {
                    ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $r['task_name']; ?></td>
                        <td><?php echo $r['task_type']; ?></td>
                        <td><?php echo $r['fse_name']; ?></td>
                        <td><?php echo $r['status_type']; ?></td>
                        <td><?php echo $r['priority_type']; ?></td>
                        <td><?php echo $r['task_address']; ?></td>
                        <td><?php echo $r['start_date']; ?></td>
                        
                        <?php
                    if (isset($r['customFields'])) {
                        if (!empty($r['customFields'])) {
                            foreach ($r['customFields'] as $key => $value){
                                echo "<td>".$value."</td>";
                            }
                        }
                    }
                    ?>
                         
                        <td><?php echo $r['fse_checklist']; ?></td>
                        <td><?php echo $r['fse_task_comments']; ?></td>
                        <td><?php echo $r['fse_reason']; ?></td>
                        <td><?php echo $r['fse_feedback']; ?></td>
                        <td> <?php if ($r['customer_sign'] != NULL) { ?>
                                <img alt="" src="<?php echo $r['customer_sign']; ?>" style="height:100px; width:100px">
    <?php } ?>
                        </td>
                        <td><?php echo $r['start_time']; ?></td>
                        <td><?php echo $r['reached_time']; ?></td>
                        <td><?php echo $r['total_travel_time']; ?></td>
                        <td><?php echo $r['start_to_work_time']; ?></td>
                        <td><?php echo $r['Work_completed_time']; ?></td>
                        <td><?php echo $r['total_worked_time']; ?></td>
                        <td><?php echo $r['geo_km']; ?></td>
                        <td><?php echo $r['created_date']; ?></td>
                        <td>
                            <form action="<?php echo base_url(); ?>updateTask" method="post">
                                <input type="hidden" value="<?php echo $r['id']; ?>" name="edit_id"  /> 
                                <input type="hidden" value="<?php echo $r['task_type_id']; ?>" name="task_type_id"  /> 
                                <input type="hidden" value="<?php echo $r['fse_id']; ?>" name="fse_id"  />
                                <input type="hidden" value="<?php echo $r['status_id']; ?>" name="status_id"  />  
                                <input type="hidden" value="<?php echo $r['task_location']; ?>" name="task_location"  /> 
                                <button class="fa fa-edit" name="edit" title="Edit" value="edit"></button>
                                <button class="fa fa-tasks" name="updateView" title="Update" value="updateView"></button>
                                <button class="fa fa-trash" name="delete" value="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"></button>
                             </form>
                        </td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
        <!--</div>-->
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
<script>
                                    var handleDataTableButtons = function () {
                                        "use strict";
                                        0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                                            dom: "Bfrtip",
                                            "scrollY": 500,
                                            "scrollX": true,
                                            scrollCollapse: true,
                                            scroller: true,
                                            columnDefs: [
                                                {visible: false, targets: 1}
                                            ],
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
        $('#datatable').dataTable({
            dom: "Bfrtip",
            "scrollY": 500,
            "scrollX": true,
            scrollCollapse: true,
            scroller: true,
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
        });
        $('#datatable-keytable').DataTable({
            keys: true
        });
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({
            ajax: "<?php echo base_url(); ?>assets/js/datatables/json/scroller-demo.json",
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
