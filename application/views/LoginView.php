<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/ico" sizes="16x16"> 
        <title><?php echo TITLE; ?> | Login </title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/icheck/flat/green.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <!--[if lt IE 9]>
              <script src="../assets/js/ie8-responsive-file-warning.js"></script>
              <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
              <![endif]-->

        <script>
            $(document).ready(function () {
                $("#login_error").css("display", "none");
            <?php if ($this->session->flashdata('error')) { ?>

                                $('#login_error').html('<?php echo $this->session->flashdata('error'); ?>').css("display", "block");
                                setTimeout(function () {
                                    $('#login_error').fadeOut('fast');
                                }, 3000);
                                //$("#login_error").css("display", "block");

            <?php } ?>
            });
        </script>
    </head>
    <style>
        .logoimage{
            /*border: 1px solid #ddd;*/
            /*border-radius: 2px;*/
            padding: 1px;
            width: 70px;
            height: 70px;
        }
     </style>
    <body style="background:#F7F7F7;">

        <div class="">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>

            <div id="wrapper">
                <div id="login" class="animate form">
                    <section class="login_content">
                        <form action="<?php echo base_url() ?>check" method="POST" name="login">
                            <h1>Login</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username"  name="username" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password"  name="password" />
                            </div>
                            <div id="login_error" style="color:red; padding-bottom: 10px; font-weight: 10px;">

                            </div>
                            <div>
                                <button class="btn btn-default submit">Log in</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><img src="<?php echo base_url(); ?>assets/images/WorkWide.png" class="logoimage" > <?php echo TITLE; ?></h1>
                                    <p><?php echo FOOTER; ?></p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
