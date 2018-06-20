<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo TITLE; ?> |  <?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/ico" sizes="16x16"> 
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
        
        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/quintica.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/icheck/flat/green.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
        <link href="<?php echo base_url(); ?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
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
        .logoimage{
            /*border: 1px solid #ddd;*/
            /*border-radius: 2px;*/
            padding: 1px;
            width: 214px;
            
        }
    </style>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo base_url(); ?>dashboard" class="site_title">

                                <img src="<?php echo base_url(); ?>assets/images/WorkWide.png" class="logoimage" >  </a>
                        </div>
                        <?php $CI = & get_instance(); ?>
                        <div class="clearfix"></div>
                        <!-- menu prile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <?php
                                if ($CI->profileImageWeb() != FALSE) {
                                    echo '<img src="data:image/gif;base64,' . $CI->profileImageWeb() . '"  alt="..." class="img-circle profile_img" />';
                                } else {
                                    ?>
                                    <img src="<?php echo base_url(); ?>assets/images/img.jpg" alt="..." class="img-circle profile_img">    
                                <?php } ?>
<!--<img src="<?php //echo base_url();          ?>assets/images/img.jpg" alt="..." class="img-circle profile_img"> -->
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
                                    <?php if (TRUE) { ?>  
                                        <li><a href="<?php echo base_url() ?>dashboard"><!--<img src="<?php // echo base_url(); ?>assets/images/dash.png" style="width:15px; margin-right:10px;"><i class="fa fa-tasks"></i>--> <i class="fa fa-th-large"></i>Dashboard </a>
                                        </li> <?php } ?>
  <li><a href="<?php echo base_url() ?>assetrouting"><i class="fa fa-sitemap"></i> Asset routing </a>
                                    <li><a><i class="fa fa-user"></i> Management <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if (($this->session->userdata('session_data')->is_admin == 1) || ($this->session->userdata('session_data')->entity_admin == $this->session->userdata('session_data')->user_id)) { ?>  <li><a href="<?php echo base_url() ?>entity">Entity</a>
                                                </li> <?php } ?>
                                            <?php if (($this->session->userdata('session_data')->is_admin == 1) || ($this->session->userdata('session_data')->entity_admin == $this->session->userdata('session_data')->user_id)) { ?>  <li><a href="<?php echo base_url() ?>branch">Branch</a>
                                                </li> <?php } ?>
                                            <?php if ($CI->userPermissionMenu(4, 1) == TRUE) { ?>  <!-- <li><a href="<?php //echo base_url() ?>asset">Asset</a> -->
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(6, 1) == TRUE) { ?>  <li><a href="<?php echo base_url() ?>serviceEngineer">Service Engineer</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(18, 1) == TRUE) { ?> <!-- <li><a href="<?php //echo base_url() ?>customer">Customer</a> -->
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenus(10, 1) == TRUE) { ?>  <li><a href="<?php echo base_url() ?>incident">Incident</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenus(11, 1) == TRUE) { ?>    <li><a href="<?php echo base_url() ?>project">Project</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(12, 1) == TRUE) { ?>   <li><a href="<?php echo base_url() ?>webuser">Web User</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenus(15, 1) == TRUE) { ?>  <li><a href="<?php //echo base_url() ?>sla">SLA</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(5, 1) == TRUE) { ?> <!-- <li><a href="<?php //echo base_url() ?>assetcategory">Asset Category</a> -->
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(7, 1) == TRUE) { ?>  <li><a href="<?php echo base_url() ?>fseType">Service Engineer Type</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenus(13, 1) == TRUE) { ?>   <li><a href="<?php echo base_url() ?>statusType">Status Type</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenus(22, 1) == TRUE) { ?>   <li><a href="<?php echo base_url() ?>callstatusType">Call Status</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenus(23, 1) == TRUE) { ?>   <li><a href="<?php echo base_url() ?>callType">Call Type</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(24, 1) == TRUE) { ?>   <li><a href="<?php echo base_url() ?>priorityType">Priority</a>
                                        </li> <?php } ?>
                                    <?php if ($CI->userPermissionMenu(14, 1) == TRUE) { ?>  <li><a href="<?php echo base_url() ?>userType">User Type</a>
                                        </li> <?php } ?>
                                    <?php if (FALSE) { ?>  <li><a href="<?php echo base_url() ?>apiSetting">API Setting</a>
                                        </li> <?php } ?> 

                                    <?php if ($CI->userPermissionMenu(17, 1) == TRUE) { ?>  <!-- <li><a href="<?php // echo base_url()  ?>taskType">Task Type</a> -->
                                        </li> <?php } ?>
                                </ul>
                                </li>
                                <?php if ($CI->userPermissionMenu(8, 1) == TRUE) { ?><li><a><i class="fa fa-shopping-bag"></i> Task <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <li><a href="<?php echo base_url() ?>task">Task Report</a>
                                            </li> 
                                            <?php if (FALSE) { ?> <li><a href="<?php echo base_url() ?>addTask">New Task Create</a>
                                                </li> <?php } ?>

                                            <?php if ($CI->userPermissionMenu(8, 2) == TRUE) { ?> <li><a class="buttons" href="#popup1" >New Task Create</a>
                                                </li> <?php } ?>

                                            <?php if ($CI->userPermissionMenu(8, 2) == TRUE) { ?> <li><a href="<?php echo base_url() ?>alltasks">Task List</a>
                                                </li> <?php } ?>


                                        </ul>
                                    </li><?php } ?>

                                <?php if (FALSE) { ?>   
                                    <?php if ($CI->userPermissionMenu(9, 1) == TRUE) { ?><li><a><i class="fa fa-support"></i> Work Order <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu" style="display: none">
                                                <li><a href="<?php echo base_url() ?>workOrder">Work Order View</a>
                                                </li> 
                                                <?php if ($CI->userPermissionMenu(9, 2) == TRUE) { ?> <li><a href="<?php echo base_url() ?>addWorkOrder">Work Order Assign</a>
                                                    </li> <?php } ?>
                                            </ul>
                                        </li><?php } ?><?php } ?>
                                <?php if (FALSE) { ?>
                                    <?php if ($CI->userPermissionMenu(19, 1) == TRUE) { ?>
                                        <li><a href="<?php echo base_url() ?>report"><i class="fa fa-line-chart"></i>Report</a>

                                        </li></li> <?php }
                        } ?>
<?php if ($CI->userPermissionMenu(21, 1) == TRUE) { ?>  
                                    <li><a href="<?php echo base_url() ?>UiAction"><i class="fa fa-exclamation-circle"></i> UI Action Report </a>
                                    </li> <?php } ?>
<?php if ($CI->userPermissionMenu(20, 1) == TRUE) { ?>  
                                    <li><a href="<?php echo base_url() ?>UiLoad"><i class="fa fa-exclamation-circle"></i> UI Load Report </a>
                                    </li> <?php } ?>    
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                        <!-- /menu footer buttons -->
                        <?php
                        if ($this->session->userdata('session_data')->is_admin == 1) {
                            $s = "apiSetting";
                            $p = 'API Setting';
                        } else {
                            $s = "setting";
                            $p = 'Profile';
                        }
                        ?> 
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="<?php echo $p; ?>" href="<?php echo base_url() . $s ?>">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            
                             <a data-toggle="tooltip" data-placement="top" title="Lock" href="<?php echo base_url() ?>locked">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            </a>
                            
                            <a data-toggle="tooltip" data-placement="top" onclick="toggleFullScreen(document.body)" title="FullScreen">
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
                                        <!--<img src="<?php //echo base_url();          ?>assets/images/img.jpg" alt="">--><?php echo $this->session->userdata('session_data')->name; ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                        <li><a href="<?php echo base_url() ?>logout""><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                        </li>
                                    </ul>
                                </li>

                                <li role="presentation" class="dropdown" >
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false" id = "check_notification" >
                                        <i class="fa fa-bell-o" ></i>
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
                                                countnotification();
                                            },
                                            error: function (jqXHR, textStatus, errorThrown)
                                            {

                                            }
                                        });
                                    });

                                    function toggleFullScreen(elem) {
                                        // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                                        if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
                                            if (elem.requestFullScreen) {
                                                elem.requestFullScreen();
                                            } else if (elem.mozRequestFullScreen) {
                                                elem.mozRequestFullScreen();
                                            } else if (elem.webkitRequestFullScreen) {
                                                elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                                            } else if (elem.msRequestFullscreen) {
                                                elem.msRequestFullscreen();
                                            }
                                        } else {
                                            if (document.cancelFullScreen) {
                                                document.cancelFullScreen();
                                            } else if (document.mozCancelFullScreen) {
                                                document.mozCancelFullScreen();
                                            } else if (document.webkitCancelFullScreen) {
                                                document.webkitCancelFullScreen();
                                            } else if (document.msExitFullscreen) {
                                                document.msExitFullscreen();
                                            }
                                        }
                                    }
                                </script>
<?php $data_list = $CI->gettasktypeHeader(); ?>
                                <div id="popup1" class="overlay">
                                    <div class="popup">
                                        <h2>Task Type</h2>
                                        <a class="close" href="#">&times;</a>
                                        <div class="content">
                                            <select class="form-control col-md-7 col-xs-12" name="tasktypeid" id="tasktypeid">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($data_list AS $getStatus) {
                                                    echo '<option value="' . $getStatus['id'] . '"> <b>' . $getStatus['task_type'] . '</b> (' . $getStatus['ent_name'] . ')</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $('#tasktypeid').change(function () {
                                        $('#loadingDiv').css("display", "block")
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>TaskController/settasktype",
                                            type: "POST",
                                            data: {id: $(this).val()},
                                            success: function (data)
                                            {
                                                $('#loadingDiv').css("display", "none")
                                                window.location.href = 'addTask'
                                            },
                                            error: function (jqXHR, textStatus, errorThrown)
                                            {
                                                $('#loadingDiv').css("display", "none")
                                                window.location.href = 'task'
                                            }
                                        });


                                        // window.location = $(this).val();
                                    });
                                </script>

                                <div id="loadingDiv"></div>

                                <style>

                                    #loadingDiv{
                                        position:fixed;
                                        top:0px;
                                        right:0px;
                                        width:100%;
                                        height:100%;
                                        background-color:#666;
                                        background-image:url('<?php echo base_url(); ?>assets/images/giphy.gif');
                                        background-repeat:no-repeat;
                                        background-position:center;
                                        z-index:10000000;
                                        opacity: 0.4;
                                        display:none;
                                        filter: alpha(opacity=40); /* For IE8 and earlier */
                                    }


                                    .overlay {
                                        position: fixed;
                                        top: 0;
                                        bottom: 0;
                                        left: 0;
                                        right: 0;
                                        background: rgba(0, 0, 0, 0.7);
                                        transition: opacity 500ms;
                                        visibility: hidden;
                                        opacity: 0;
                                        z-index: 10000;
                                    }
                                    .overlay:target {
                                        visibility: visible;
                                        opacity: 1;
                                    }

                                    .popup {
                                        margin: 70px auto;
                                        padding: 20px;
                                        background: #fff;
                                        border-radius: 5px;
                                        width: 30%;
                                        position: relative;
                                        transition: all 5s ease-in-out;

                                    }

                                    .popup h2 {
                                        margin-top: 0;
                                        color: #333;
                                        font-family: Tahoma, Arial, sans-serif;
                                    }
                                    .popup .close {
                                        position: absolute;
                                        top: 7px;
                                        right: 20px;
                                        transition: all 200ms;
                                        font-size: 30px;
                                        font-weight: bold;
                                        text-decoration: none;
                                        color: #333;
                                    }
                                    .popup .close:hover {
                                        color: #06D85F;
                                    }
                                    .popup .content {
                                        max-height: 30%;
                                        overflow: auto;

                                    }

                                    @media screen and (max-width: 700px){
                                        .box{
                                            width: 70%;
                                        }
                                        .popup{
                                            width: 70%;
                                        }
                                    }

                                </style>
