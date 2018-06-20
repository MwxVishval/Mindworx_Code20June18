<style>
    .table-responsive {
        min-height: .01% !important;
        overflow-x: auto !important;
    }
    #rowtabs .tab-content, #rowtabs .table, #rowtabs .nav-tabs>li.active>a {
        background: #ececec;
    }
    #rowtabs .table>tbody>tr>td {
        border-top:1px solid #d6d6d6;
        color:#051a2f;
    }

    #rowtabs .nav-tabs>li.active>a {
        font-weight: bold;
        color: #2a3f54;
    }

    .dataTables_scrollBody {
        overflow: initial !important;
    }

    .x_content {
        margin-top: 0;
        border-right: 1px solid #ccc;
      //  overflow-y: hidden;
        overflow-x: scroll;
    }

    .serviceEngineerlists, .tasklistviews {
        overflow-y: hidden;
        overflow-x: hidden;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<div class="x_panel tasklistviews" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Task Report</h2>
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



    <?php $k = 1; ?>


    <div class="x_content">
        <!--<div class="table-responsive">--> 
        <table id="datatable" class="table table-striped table-bordered tasklists ">
            <thead>
                <tr>
                    <th >S.No</th>
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
                            foreach ($result[0]['customFields'] as $key => $value) {
                                echo "<th>" . $key . "</th>";
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
                //var_dump ($result);
                foreach ($result AS $r) {
                    ?>
                    <?php //var_dump ($result); ?>
                    <tr class="row_show_<?php echo $k ?>"   onclick="taskdetail(this,'row_show_<?php echo $k ?>','<?php echo $r['id']; ?>','<?php echo $i; ?>','<?php echo $r['task_type_id']; ?>')">
                        <td><?php echo $i++ ?></td>
                        <td id="taskname"><?php echo $r['task_name']; ?></td>
                        <td><?php echo $r['task_type']; ?></td>
                        <td><?php echo $r['fse_name']; ?></td>
                        <td><?php echo $r['status_type']; ?></td>
                        <td><?php echo $r['priority_type']; ?></td>
                        <td><?php echo $r['task_address']; ?></td>
                        <td><?php echo $r['start_date']; ?></td>


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


                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#datatable .row_hidden_<?php echo $k ?>').hide();

                        $("#datatable .row_show_<?php echo $k ?>").click(function () {
                            $('.row_hidden_<?php echo $k ?>').toggle();
                        });
                    });
                </script>

                <?php $k++; ?>

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
<style type="text/css">

    .acf-map {
        width: 100%;
        height: 200px;
        border: #ccc solid 1px;
        margin: 20px 0;
    }

</style>

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
            }();</script>

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
//    ajax: "<?php echo base_url(); ?>assets/js/datatables/json/scroller-demo.json",
//            deferRender: true,
//            scrollY: 380,
//            scrollCollapse: true,
//            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });
    });
    TableManageButtons.init();</script>
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
//         $("#datatable tr").click(function(){
//             $(this).find('tr').each;
//              $(this).after = $('#rowtabs').toggle();
//      });




</script>
<script>
    function gmap(container,id,taskid) {
      // alert(taskid); alert(id); 
       var modal = document.getElementById('myModal');
        $.ajax({
            url: "<?php echo base_url() . 'TaskController/loadmap'; ?>",
            method: 'POST',
            //cache: false,
           data: {id: id,taskid:taskid },
            success: function (resp) {                
                  modal.style.display = "block";
                 $('#mapdataview').append(resp);
                
            }
        });

    }
</script> 


<script>
    
     function taskdetail(currentrow,container,id,rnum,tasktypeid) {
         console.log(currentrow);
        $.ajax({ 
      url: "<?php echo base_url() . 'TaskController/taskdetail'; ?>",
      method: 'POST',
      //cache: false,
      data: { id: id,tasktypeid:tasktypeid} ,
      success: function (resp) {    
          $(currentrow).after(resp);         
      }
    });
  }
</script>


<script>
var modal = document.getElementById('myModal');
var span = document.getElementsByClassName("close")[0];
function closepopup() {
    var modal = document.getElementById('myModal');
     $('#mapdataview').html('');
    modal.style.display = "none";
    
}

</script>

<div id="myModal" class="modal">
  <div class="modal-content" >
      <span class="close" onclick="closepopup()">&times;</span>
    <div id="mapdataview"></div>
    
  </div>
</div>

<style>
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>