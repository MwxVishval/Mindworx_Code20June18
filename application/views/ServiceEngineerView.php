<style>
    .table-responsive {
        min-height: .01% !important;
        overflow-x: auto !important;
    }
</style>
<div class="x_panel serviceEngineerlists" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Service Engineer <small></small></h2>
        <a href="<?php echo base_url() ?>addserviceEngineer" id="send"  class="btn btn-success" style="float:right;">Add Service Engineer</a>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SNo</th>
                    <th>FSE Name</th>
                    <th>FSE Type</th>
                    <th>FSE User Name</th>
                    <th>FSE Email</th>
                    <th>FSE Mobile</th>
                    <th>FSE Address</th>
                    <th>Company / Branch</th>
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
                        <td><?php echo $r['fse_name']; ?></td>
                        <td><?php echo $r['fse_type']; ?></td>
                        <td><?php echo $r['fse_username']; ?></td>
                        <td><?php echo $r['fse_email']; ?></td>
                        <td><?php echo $r['fse_mobile']; ?></td>
                        <td><?php echo $r['fse_address']; ?></td>
                        <td><?php if ($r['ent_id'] == 0) {
                          echo @$r['branch_name'];
                         } else {
                           echo @$r['ent_name'];
                         } ?></td>
                        <td>
                            <form action="<?php echo base_url(); ?>updateserviceEngineer" method="post">
                                <input type="hidden" value="<?php echo $r['id']; ?>" name="edit_id"  />
<!--                                <input type="hidden" value="<?php echo $r['fse_type_id']; ?>" name="fse_type_id"  />
                                <input type="hidden" value="<?php echo $r['fse_type_id']; ?>" name="fse_type_id"  />-->
                                <input type="hidden" value="<?php echo $r['fse_email']; ?>" name="fse_email"  />
                                <input type="hidden" value="<?php echo $r['fse_username']; ?>" name="fse_username"  />
                                <button class="fa fa-edit" name="edit" title="Edit" value="edit"></button>
                                <button class="fa fa-trash" name="delete" value="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"></button>
                                    <?php if ($r['fse_status'] == 0) { ?>
                                           <button class="fa fa-check" name="unblock" value="unblock" title="Unblock" onclick="return confirm('Are you sure you want to unblock this item?');"></button>
                                    <?php } else { ?>
                                           <button class="fa fa-times" name="block" value="block" title="Block" onclick="return confirm('Are you sure you want to block this item?');"></button>
                                    <?php } ?>
                                    <button class="fa fa-lock" name="resetpassword" value="resetpassword" title="Reset Password" onclick="return confirm('Are you sure you want to reset password for this item?');"></button>
                                </form>
                        </td>
                        </tr>
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
