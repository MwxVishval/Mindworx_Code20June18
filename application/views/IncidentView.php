<div class="x_panel" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Incident <small></small></h2>
        <a href="<?php echo base_url() ?>addIncident" id="send"  class="btn btn-success" style="float:right;">Add Incident</a>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SNo</th>
                    <th>Created Date</th>
                    <th>Name</th>
                    <th>Status</th>
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
                        <td><?php echo $r['incident_created_date']; ?></td>
                        <td><?php echo $r['incident_name']; ?></td>
                        <td><?php echo $r['status_type']; ?></td>
                <form action="<?php echo base_url(); ?>updateIncident" method="post">
                    <td>
                        <input type="hidden" value="<?php echo $r['id']; ?>" name="edit_id"  />
                        <input type="hidden" value="<?php echo $r['customer_id']; ?>" name="customer_id"  />
                        <input type="hidden" value="<?php echo $r['ent_id']; ?>" name="ent_id"  />
                        <button class="fa fa-edit" name="edit" value="edit"></button>&nbsp;&nbsp;
                        <button class="fa fa-trash" name="delete" value="delete" onclick="return confirm('Are you sure you want to delete this item?');"></button>
                        <button class="fa fa-times" name="close" value="close" title="COMPLETE" onclick="return confirm('Are you sure you want to close this incident?');"></button>
                        <!--<div class="header toggleContent"><span>+</span></div>-->
                    </td>
                </form>
                </tr>
                <!--<tr>
                    <td colspan="7">
                        <input type="hidden" value="<?php echo $r['id']; ?>" name="edit_id"  />
                        <input type="hidden" value="<?php echo $r['customer_id']; ?>" name="customer_id"  />
                        <input type="hidden" value="<?php echo $r['ent_id']; ?>" name="ent_id"  />
                        <div class="container">									
                            <div class="content" id="results_<?php echo $r['id']; ?>">
                                <table border="1" width="100%" class="table table-striped table-bordered" id="results_<?php echo $r['id']; ?>">
                                    <tr>
                                        <td><b>Task Name</b>
                                        </td>
                                        <td><b>Task Type</b>
                                        </td>
                                        <td><b>Task Address</b>
                                        </td>
                                        <td><b>FSE</b>
                                        </td>
                                        <td><b>Assigned Date</b>
                                        </td>
                                        <td><b>Status</b>
                                        </td>
                                        <td><b>Action</b>
                                        </td>
                                    </tr>
                                    <?php
                                    foreach ($resultTasks as $key => $rst) {
                                        if ($r['id'] == $key) {
                                            ?>
                                            <?php
                                            foreach ($rst as $task) {
                                                ?><tr>
                                                    <td><?php echo $task['task_name']; ?></td>
                                                    <td><?php echo $task['task_type']; ?></td>
                                                    <td><?php echo $task['task_address']; ?></td>
                                                    <td><?php echo $task['fse_name']; ?></td>
                                                    <td><?php echo $task['assign_date']; ?></td>
                                                    <td><?php echo $task['status_type']; ?></td>
                                                    <td>
                                                        <form action="<?php echo base_url(); ?>updateTask" method="post">
                                                            <input type="hidden" value="<?php echo $r['id']; ?>" name="edit_id"  /> 
                                                            <button class="fa fa-edit" name="edit" value="edit"></button>
                                                            <button class="fa fa-trash" name="delete" value="delete" onclick="return confirm('Are you sure you want to delete this item?');"></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            <?php
                                        }
                                    }
                                    ?>

                                </table>
                            </div>
                        </div>
                    </td>
                </tr>-->
<?php } ?>

            </tbody>
        </table>
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
                                                                                                                                    $(".header").click(function () {

                                                                                                                                        $header = $(this);
                                                                                                                                        //getting the next element
                                                                                                                                        $content = $header.parent().parent().next().find('.content');
                                                                                                                                        //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
                                                                                                                                        $content.slideToggle(500, function () {
                                                                                                                                            //execute this after slideToggle is done
                                                                                                                                            //change text of header based on visibility of content div
                                                                                                                                            $header.text(function () {
                                                                                                                                                //change text based on condition
                                                                                                                                                return $content.is(":visible") ? "-" : "+";
                                                                                                                                            });
                                                                                                                                        });

                                                                                                                                    });

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

<style type="text/css">

    .container .header {
        background-color:#d3d3d3;
        padding: 2px;
        cursor: pointer;
        font-weight: bold;
    }
    .container .content {
        display: none;
        padding : 5px;
    }
    .toggleContent{
        display: inline-block;
        text-align: center;
        width: 30px;
    }
    .toggleContent, .toggleContent > span{
        line-height:20px;
    }
</style>
