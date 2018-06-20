<!--<div class="row tile_count">
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Web User</span>
            <div class="count"><?php echo $totalwebuser; ?></div>
            <span class="count_bottom"><i class="green">4% </i> From last Week</span>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total FSE</span>
            <div class="count"><?php echo $totalfse; ?></div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> From last Week</span>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Task</span>
            <div class="count"><?php echo $totaltask; ?></div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> </i> From last Week</span>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Branch</span>
            <div class="count"><?php echo $totalbranch; ?></div>
            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i> </i> From last Week</span>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Entity</span>
            <div class="count"><?php echo $totalentity; ?></div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> </i> From last Week</span>
        </div>
    </div>
    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
        <div class="left"></div>
        <div class="right">
            <span class="count_top"><i class="fa fa-user"></i> Total Project</span>
            <div class="count"><?php echo $totalprojectincident; ?></div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> </i> From last Week</span>
        </div>
    </div>

</div>-->

<div class="">
    <div class="clearfix"></div>
    <div class="row">
        <!-- bar chart -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>PROJECT <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="graph_donut" style="width:100%; height:280px;"></div>
                </div>
            </div>
        </div>
        <!-- /bar charts -->
        <!-- bar charts group -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>INCIDENT <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                    <div id="graph_donut2" style="width:100%; height:280px;"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- /bar charts group -->

        <!-- bar charts group -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>TASKS <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content2">
                    <div id="graph_donut3" style="width:100%; height:300px;"></div>
                </div>
            </div>
        </div>
        <!-- /bar charts group -->
        <!-- pie chart -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>TOP FSE<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content2">
                    <div id="graph_donut4" style="width:100%; height:300px;"></div>
                </div>
            </div>
        </div>
        <!-- /Pie chart -->
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/moris/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moris/morris.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/js/moris/example.js"></script>-->

<script>
    $(function () {

        Morris.Donut({
            element: 'graph_donut',
            data: <?php echo $ProjectCount; ?>,
            colors: ['#983331', '#888888', '#ACADAC', '#d61f27','#ff979b', '#888888'],
            formatter: function (y) {
                return y + ""
            }
        });

        Morris.Donut({
            element: 'graph_donut2',
           data: <?php echo $IncidentCount; ?>,
            colors: ['#983331', '#888888', '#ACADAC', '#d61f27','#ff979b', '#888888',],
            formatter: function (y) {
                return y + ""
            }
        });

        Morris.Donut({
            element: 'graph_donut3',
           data: <?php echo $TaskCount; ?>,
            colors: ['#983331', '#888888', '#ACADAC', '#d61f27','#ff979b', '#888888',],
            formatter: function (y) {
                return y + ""
            }
        });

        Morris.Donut({
            element: 'graph_donut4',
            data: <?php echo $fseTaskComplete; ?>,
            colors: ['#983331', '#888888', '#ACADAC', '#d61f27','#ff979b', '#888888',],
            formatter: function (y) {
                return y + ""
            }
        });


    });

</script>