<style>
    .table-responsive {
        min-height: .01% !important;
        overflow-x: auto !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<div class="x_panel" style="min-height:600px; height: auto;">
    <h2>Report<b>List</b></h2>
    <?php
    if ($entityFeilds != FALSE) {
        if (!empty($entityFeilds)) {
            $task_field = json_decode($entityFeilds);
        } else {
            $task_field = array();
        }
    }else{$task_field = array();}
    ?>
    <div class="x_content">
         <table id="datatable" class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th >SNo</th>
                    <?php if (in_array(0, $task_field)) { ?> <th>Task Name</th> <?php } ?>
                    <?php if (in_array(1, $task_field)) { ?> <th>FSE</th> <?php } ?>
                    <?php if (in_array(2, $task_field)) { ?> <th>Entity/Branch</th> <?php } ?>
                    <?php if (in_array(3, $task_field)) { ?> <th>Incident/Project</th> <?php } ?>
                    <?php if (in_array(4, $task_field)) { ?> <th>Call Number</th> <?php } ?>                  
                    <th>Status</th>
                    <?php if (in_array(6, $task_field)) { ?> <th>SLA</th> <?php } ?>
                    <?php if (in_array(7, $task_field)) { ?> <th>Task Description</th> <?php } ?>
                    <?php if (in_array(8, $task_field)) { ?> <th>Date Logged</th> <?php } ?>
                    <?php if (in_array(9, $task_field)) { ?> <th>Address</th> <?php } ?>
                    <?php if (in_array(10, $task_field)) { ?> <th>Product Name</th> <?php } ?>
                    <?php if (in_array(11, $task_field)) { ?> <th>Serial Number</th> <?php } ?>
                    <?php if (in_array(12, $task_field)) { ?> <th>Product Code</th> <?php } ?>
                    <?php if (in_array(13, $task_field)) { ?> <th>Check List</th> <?php } ?>
                    <?php if (in_array(14, $task_field)) { ?> <th>Book Code</th> <?php } ?>
                    <?php if (in_array(15, $task_field)) { ?> <th>Manual Docket Number</th> <?php } ?>
                    <?php if (in_array(29, $task_field)) { ?> <th>Customer Name</th> <?php } ?>
                    <?php if (in_array(16, $task_field)) { ?> <th>Customer Contact Person</th> <?php } ?>
                    <?php if (in_array(17, $task_field)) { ?> <th>Customer Contact Number</th> <?php } ?>
                    <?php if (in_array(18, $task_field)) { ?> <th>Model</th> <?php } ?>
                    <?php if (in_array(19, $task_field)) { ?> <th>Problem</th> <?php } ?>
                    <?php if (in_array(20, $task_field)) { ?> <th>Call Status</th> <?php } ?>
                    <?php if (in_array(21, $task_field)) { ?> <th>Call Type</th> <?php } ?>
                    <?php if (in_array(22, $task_field)) { ?> <th>Priority</th> <?php } ?>
                    <?php if (in_array(23, $task_field)) { ?> <th>Message</th> <?php } ?>
                    <?php if (in_array(24, $task_field)) { ?> <th>Comment Charge</th> <?php } ?>
                    <?php if (in_array(25, $task_field)) { ?> <th>Previous Meter Reading</th> <?php } ?>
                    <?php if (in_array(26, $task_field)) { ?> <th>Previous Color Reading</th> <?php } ?>
                    <?php if (in_array(27, $task_field)) { ?> <th>Customer Order Number</th> <?php } ?>
                    <?php if (in_array(28, $task_field)) { ?> <th>Outstanding Calls</th> <?php } ?>

                    <th>FSE Checklist</th>
                    <th>FSE Comments</th>
                    <th>FSE Reason</th>
                    <th>Customer Sign</th>
                    <th>Customer Document</th>
                    <th>Created Date</th>
                   
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 1;
                foreach ($result AS $r) {
                    ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <?php if (in_array(0, $task_field)) { ?><td>
                                <?php echo $r['task_name']; ?></td> <?php } ?>

                        <?php if (in_array(1, $task_field)) { ?><td>
                                <?php echo $r['fse_name']; ?></td> <?php } ?>

                        <?php if (in_array(2, $task_field)) { ?><td>
                                <?php
                                if ($r['branch_id'] != 0) {
                                    echo $r['branch_name'];
                                } else {
                                    echo $r['ent_name'];
                                }
                                ?>
                            </td><?php } ?>
                        <?php if (in_array(3, $task_field)) { ?><td>
                                <?php
                                if ($r['project_id'] != 0) {
                                    echo $r['proj_name'];
                                } else {
                                    echo $r['incident_name'];
                                }
                                ?>
                            </td><?php } ?>
                        <?php if (in_array(4, $task_field)) { ?><td>
                                <?php echo $r['call_number']; ?></td> <?php } ?>
                        
                        <td><?php echo $r['status_type']; ?></td>

                        <?php if (in_array(6, $task_field)) { ?><td>
                                <?php echo $r['sla_name']; ?></td> <?php } ?>
                        
                        <?php if (in_array(7, $task_field)) { ?><td>
                                <?php echo $r['task_description']; ?></td> <?php } ?>
                        
                        <?php if (in_array(8, $task_field)) { ?><td>
                                <?php echo $r['start_date']; ?></td> <?php } ?>
                        
                        <?php if (in_array(9, $task_field)) { ?><td>
                                <?php echo $r['task_address']; ?></td> <?php } ?>
                        
                        <?php if (in_array(10, $task_field)) { ?><td>
                                <?php echo $r['product_name']; ?></td> <?php } ?>
                        
                        <?php if (in_array(11, $task_field)) { ?><td>
                                <?php echo $r['serial_number']; ?></td> <?php } ?>
                        
                        <?php if (in_array(12, $task_field)) { ?><td>
                                <?php echo $r['product_code']; ?></td> <?php } ?>
                        
                        <?php
                        $f = str_replace('"]', ", ", $r['task_checklist']);
                        $resstring = str_replace('["', " ", $f);
                        $resstrings = str_replace('"', " ", $resstring);
                        ?>
                        
                        <?php if (in_array(13, $task_field)) { ?><td>
                                <?php echo $resstrings; ?></td> <?php } ?>
                        
                        <?php if (in_array(14, $task_field)) { ?><td>
                                <?php echo $r['book_code']; ?></td> <?php } ?>
                        
                        <?php if (in_array(15, $task_field)) { ?><td>
                                <?php echo $r['manual_docket_number']; ?></td> <?php } ?>
                        
                        <?php if (in_array(29, $task_field)) { ?><td>
                                <?php echo $r['customer_name']; ?></td> <?php } ?>
                        
                        <?php if (in_array(16, $task_field)) { ?><td>
                                <?php echo $r['customer_contact_person']; ?></td> <?php } ?>
                        
                        <?php if (in_array(17, $task_field)) { ?><td>
                                <?php echo $r['customer_contact_number']; ?></td> <?php } ?>
                        
                        <?php if (in_array(18, $task_field)) { ?><td>
                                <?php echo $r['model']; ?></td> <?php } ?>
                        
                        <?php if (in_array(19, $task_field)) { ?><td>
                                <?php echo $r['problem']; ?></td> <?php } ?>
                        
                        <?php if (in_array(20, $task_field)) { ?><td>
                                <?php echo $r['callstatus_type']; ?></td> <?php } ?>
                        
                        <?php if (in_array(21, $task_field)) { ?><td>
                                <?php echo $r['calltype_type']; ?></td> <?php } ?>
                        
                        <?php if (in_array(22, $task_field)) { ?><td>
                                <?php echo $r['priority_type']; ?></td> <?php } ?>
                        
                        <?php if (in_array(23, $task_field)) { ?><td>
                                <?php echo $r['message']; ?></td> <?php } ?>
                        
                        <?php if (in_array(24, $task_field)) { ?><td>
                                <?php echo $r['comment_charge']; ?></td> <?php } ?>
                        
                        <?php if (in_array(25, $task_field)) { ?><td>
                                <?php echo $r['previous_meter_reading']; ?></td> <?php } ?>
                        
                        <?php if (in_array(26, $task_field)) { ?><td>
                                <?php echo $r['previous_color_reading']; ?></td> <?php } ?>
                        
                        <?php if (in_array(27, $task_field)) { ?><td>
                                <?php echo $r['customer_order_number']; ?></td> <?php } ?>
                        
                        <?php if (in_array(28, $task_field)) { ?><td>
                                <?php echo $r['outstanding_calls']; ?></td> <?php } ?>
                        

                        <td><?php echo $r['fse_checklist']; ?></td>
                        <td><?php echo $r['fse_task_comments']; ?></td>
                        <td><?php echo $r['fse_reason']; ?></td>
                        <td> <?php if ($r['customer_sign'] != NULL) { ?>
                                <img alt="" src="<?php echo $r['customer_sign']; ?>" style="height:100px; width:100px">
                            <?php } ?>
                        </td>
                        <td> <?php if ($r['customer_document'] != NULL) { ?>
                                <img alt="" src="data:image/jpg;base64,<?php echo $r['customer_document']; ?>" style="height:100px; width:100px">
                            <?php } ?>
                        </td>
                        <td><?php echo $r['created_date']; ?></td>
                        
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

