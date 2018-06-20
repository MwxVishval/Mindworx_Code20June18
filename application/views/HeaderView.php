<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo TITLE; ?> |  <?php echo $title; ?></title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/icheck/flat/green.css" rel="stylesheet">
        <!--[if lt IE 9]>
              <script src="../assets/js/ie8-responsive-file-warning.js"></script>
              <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
              <![endif]-->
    </head>
    <style>
        .dt-buttons
        {
            display: none !important;
        }
    </style>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="" class="site_title"><i class="fa fa-group"></i> <span><?php echo HEADER; ?> !</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <!-- menu prile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo base_url(); ?>assets/images/img.jpg" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2><?php echo $this->session->userdata('session_data')->name; ?></h2>
                            </div>
                        </div>
                        <!-- /menu prile quick info -->
                        <br />
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>Menu</h3>
                                <ul class="nav side-menu">
                                    <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
                                    </li>
                                    <li><a><i class="fa fa-edit"></i> Management <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <li><a href="<?php echo base_url() ?>entity">Entity</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>branch">Branch</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>asset">Asset</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>serviceEngineer">Service Engineer</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>customer">Customer</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>incident">Incident</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>project">Project</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>webuser">Web User</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>sla">SLA</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>assetcategory">Asset Category</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>fseType">Service Engineer Type</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>statusType">Status Type</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>userType">User Type</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>taskType">Task Type</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-desktop"></i> Task <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <li><a href="<?php echo base_url() ?>task">Task View</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>addTask">Task Assign</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-users"></i>Work Order<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <li><a href="<?php echo base_url() ?>workOrder">Work Order View</a>
                                            </li>
                                            <li><a href="<?php echo base_url() ?>addWorkOrder">Work Order Assign</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo base_url() ?>report"><i class="fa fa-line-chart"></i>Report<span class="fa fa-chevron-down"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            
                            <a data-toggle="tooltip" data-placement="top" title="Lock" href="<?php echo base_url() ?>locked">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            </a>
                            
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url() ?>logout">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav class="" role="navigation">
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="<?php echo base_url(); ?>assets/images/img.jpg" alt=""><?php echo $this->session->userdata('session_data')->name; ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                        <li><a href="<?php echo base_url() ?>logout""><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                        </li>
                                    </ul>
                                </li>

                                <li role="presentation" class="dropdown" >
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false" >
                                        <i class="fa fa-bell-o"  id = "check_notification"></i>
                                        <span class="badge bg-green"><div id='count_notification'></div></span>
                                    </a>
                                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                        <div id="notification_dropdown" ></div>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="alert alert-success fade in" id="success_msg" style="display: none;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> <?php
                                    if ($this->session->flashdata('success_msg')) {
                                        echo $this->session->flashdata('success_msg');
                                    }
                                    ?>
                                </div>
                                <div class="alert alert-danger fade in" id="error_msg" style="display: none;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error !</strong> <?php
                                    if ($this->session->flashdata('error_msg')) {
                                        echo $this->session->flashdata('error_msg');
                                    }
                                    ?>
                                </div>
                                <div class="alert alert-warning" id="warning_msg" style="display:none;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Warning!</strong> There was a problem with your network connection.
                                </div>  
                                <div class="alert alert-info fade in" id="note_msg" style="display: none;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Note!</strong> <?php
                                    if ($this->session->flashdata('note_msg')) {
                                        echo $this->session->flashdata('note_msg');
                                    }
                                    ?>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $("#error_msg").css("display", "none");
                                        <?php if ($this->session->flashdata('error_msg')) { ?>
                                                                                    $("#error_msg").css("display", "block");
                                                                                    setTimeout(function () {
                                                                                        $('#error_msg').fadeOut('fast');

                                                                                    }, 3000);
                                        <?php } ?>

                                                                                $("#success_msg").css("display", "none");

                                        <?php if ($this->session->flashdata('success_msg')) { ?>
                                                                                    $("#success_msg").css("display", "block");
                                                                                    setTimeout(function () {
                                                                                        $('#success_msg').fadeOut('fast');

                                                                                    }, 3000);
                                        <?php } ?>

                                                                                $("#note_msg").css("display", "none");

                                        <?php if ($this->session->flashdata('note_msg')) { ?>
                                                                                    $("#note_msg").css("display", "block");
                                                                                    setTimeout(function () {
                                                                                        $('#note_msg').fadeOut('fast');

                                                                                    }, 3000);
                                        <?php } ?>

                                    });
                                </script>

                                <script>
                                    function loadlink() {
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>HomeController/notification",
                                            type: "POST",
                                            data: {id: '<?php echo $this->session->userdata('session_data')->user_id; ?>'},
                                            dataType: "HTML",
                                            success: function (data)
                                            {
                                                $('#notification_dropdown').html(data);
                                            },
                                            error: function (jqXHR, textStatus, errorThrown)
                                            {

                                            }
                                        });
                                    }

                                    loadlink(); // This will run on page load
                                    setInterval(function () {
                                        loadlink() // this will run after every 5 seconds
                                    }, 60000);

                                    function countnotification() {
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>HomeController/notificationCount",
                                            type: "POST",
                                            data: {id: '<?php echo $this->session->userdata('session_data')->user_id; ?>'},
                                            dataType: "HTML",
                                            success: function (data)
                                            {

                                                $('#count_notification').html(data);
                                            },
                                            error: function (jqXHR, textStatus, errorThrown)
                                            {

                                            }
                                        });
                                    }

                                    countnotification(); // This will run on page load
                                    setInterval(function () {
                                        countnotification() // this will run after every 5 seconds
                                    }, 60000);

                                    $('#check_notification').on('click', function (event) {
                                        event.preventDefault();

                                        $.ajax({
                                            url: "<?php echo base_url(); ?>HomeController/notificationCheck",
                                            type: "POST",
                                            data: {id: '<?php echo $this->session->userdata('session_data')->user_id; ?>'},
                                            dataType: "HTML",
                                            success: function (data)
                                            {

                                            },
                                            error: function (jqXHR, textStatus, errorThrown)
                                            {

                                            }
                                        });
                                    });


                                </script>

