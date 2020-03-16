<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <title>SIBARA</title>
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
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/fonts/clip-font.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/iCheck/skins/all.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/bower_components/sweetalert/dist/sweetalert.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/main.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/main-responsive.min.css" />
    <link type="text/css" rel="stylesheet" media="print" href="<?=base_url()?>assets/css/print.min.css" />
    <link type="text/css" rel="stylesheet" id="skin_color" href="<?=base_url()?>assets/css/theme/light.min.css" />

    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link href="<?=base_url()?>assets/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
</head>

<body>

    <!-- start: HEADER -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <!-- start: TOP NAVIGATION CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: RESPONSIVE MENU TOGGLER -->
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="clip-list-2"></span>
            </button>
                <!-- end: RESPONSIVE MENU TOGGLER -->
                <!-- start: LOGO -->
                <a class="navbar-brand" href="index.html">
                Sib<i class="fa fa-at"></i>ra
            </a>
                <!-- end: LOGO -->
            </div>
            <div class="navbar-tools">
                <!-- start: TOP NAVIGATION MENU -->
                <ul class="nav navbar-right">
                    <!-- start: TO-DO DROPDOWN -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <i class="clip-list-5"></i>
                            <span class="badge"> 12</span>
                        </a>
                        <ul class="dropdown-menu todo">
                            <li>
                                <span class="dropdown-menu-title"> You have 12 pending tasks</span>
                            </li>
                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;">Staff Meeting</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;"> New frontend layout</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-warning"> tommorow</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc">Staff Meeting</span>
                                                <span class="label label-warning"> tommorow</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> New frontend layout</span>
                                                <span class="label label-success"> this week</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-success"> this week</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> New frontend layout</span>
                                                <span class="label label-info"> this month</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-info"> this month</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;">Staff Meeting</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;"> New frontend layout</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-warning"> tommorow</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="view-all">
                                <a href="javascript:void(0)">
                                See all tasks <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end: TO-DO DROPDOWN-->
                    <!-- start: NOTIFICATION DROPDOWN -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <i class="clip-notification-2"></i>
                            <span class="badge"> 11</span>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li>
                                <span class="dropdown-menu-title"> You have 11 notifications</span>
                            </li>
                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-primary"><i class="fa fa-user"></i></span>
                                                <span class="message"> New user registration</span>
                                                <span class="time"> 1 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                                <span class="message"> New comment</span>
                                                <span class="time"> 7 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                                <span class="message"> New comment</span>
                                                <span class="time"> 8 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                                <span class="message"> New comment</span>
                                                <span class="time"> 16 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-primary"><i class="fa fa-user"></i></span>
                                                <span class="message"> New user registration</span>
                                                <span class="time"> 36 min</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-warning"><i class="fa fa-shopping-cart"></i></span>
                                                <span class="message"> 2 items sold</span>
                                                <span class="time"> 1 hour</span>
                                            </a>
                                        </li>
                                        <li class="warning">
                                            <a href="javascript:void(0)">
                                                <span class="label label-danger"><i class="fa fa-user"></i></span>
                                                <span class="message"> User deleted account</span>
                                                <span class="time"> 2 hour</span>
                                            </a>
                                        </li>
                                        <li class="warning">
                                            <a href="javascript:void(0)">
                                                <span class="label label-danger"><i class="fa fa-shopping-cart"></i></span>
                                                <span class="message"> Transaction was canceled</span>
                                                <span class="time"> 6 hour</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                                <span class="message"> New comment</span>
                                                <span class="time"> yesterday</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-primary"><i class="fa fa-user"></i></span>
                                                <span class="message"> New user registration</span>
                                                <span class="time"> yesterday</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-primary"><i class="fa fa-user"></i></span>
                                                <span class="message"> New user registration</span>
                                                <span class="time"> yesterday</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                                <span class="message"> New comment</span>
                                                <span class="time"> yesterday</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <span class="label label-success"><i class="fa fa-comment"></i></span>
                                                <span class="message"> New comment</span>
                                                <span class="time"> yesterday</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="view-all">
                                <a href="javascript:void(0)">
                                See all notifications <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end: NOTIFICATION DROPDOWN -->
                    <!-- start: MESSAGE DROPDOWN -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                            <i class="clip-bubble-3"></i>
                            <span class="badge"> 9</span>
                        </a>
                        <ul class="dropdown-menu posts">
                            <li>
                                <span class="dropdown-menu-title"> You have 9 messages</span>
                            </li>
                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt="" src="./assets/images/avatar-2.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Nicole Bell</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                        <span class="time"> Just Now</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt="" src="./assets/images/avatar-1.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Peter Clark</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                        <span class="time">2 mins</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt="" src="./assets/images/avatar-3.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Steven Thompson</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                        <span class="time">8 hrs</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt="" src="./assets/images/avatar-1.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Peter Clark</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                        <span class="time">9 hrs</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt="" src="./assets/images/avatar-5.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Kenneth Ross</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                        <span class="time">14 hrs</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="view-all">
                                <a href="pages_messages.html">
                                See all messages <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end: MESSAGE DROPDOWN -->
                    <!-- start: USER DROPDOWN -->
                    <li class="dropdown current-user">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <img src="assets/images/avatar-1-small.jpg" class="circle-img" alt="">
                            <span class="username">Peter Clark</span>
                            <i class="clip-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="pages_user_profile.html">
                                    <i class="clip-user-2"></i> &nbsp;My Profile
                                </a>
                            </li>
                            <li>
                                <a href="pages_calendar.html">
                                    <i class="clip-calendar"></i> &nbsp;My Calendar
                                </a>
                                <li>
                                    <a href="pages_messages.html">
                                        <i class="clip-bubble-4"></i> &nbsp;My Messages (3)
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="utility_lock_screen.html">
                                        <i class="clip-locked"></i> &nbsp;Lock Screen
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=site_url('login/logout')?>">
                                        <i class="clip-exit"></i> &nbsp;Log Out
                                    </a>
                                </li>
                        </ul>
                        </li>
                        <!-- end: USER DROPDOWN -->
                        <!-- start: PAGE SIDEBAR TOGGLE -->
                        <li>
                            <a class="sb-toggle" href="#"><i class="fa fa-outdent"></i></a>
                        </li>
                        <!-- end: PAGE SIDEBAR TOGGLE -->
                </ul>
                <!-- end: TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: TOP NAVIGATION CONTAINER -->
    </div>
    <!-- end: HEADER -->
    <!-- start: MAIN CONTAINER -->
    <div class="main-container">
        <div class="navbar-content">
            <!-- start: SIDEBAR -->
            <div class="main-navigation navbar-collapse collapse">
                <!-- start: MAIN MENU TOGGLER BUTTON -->
                <div class="navigation-toggler">
                    <i class="clip-chevron-left"></i>
                    <i class="clip-chevron-right"></i>
                </div>
                <!-- end: MAIN MENU TOGGLER BUTTON -->
                <!-- start: MAIN NAVIGATION MENU -->
                <ul class="main-navigation-menu">
                    <li>
                        <!--active open-->
                        <a href="<?=site_url('dashboard')?>">
                            <i class="clip-home-3"></i>
                            <span class="title"> Dashboard </span><span class="selected"></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-folder"></i>
                            <span class="title"> Berkas Perkara </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?=site_url('berkas/list')?>">
                                    <span class="title"> List Berkas </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('berkas/saya')?>" class="close-sidebar-left">
                                    <span class="title"> Ceklist Berkas </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('berkas/delegasi')?>" class="set-boxed-layout">
                                    <span class="title"> Delegasikan Berkas </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('berkas/pending')?>" class="set-footer-fixed">
                                    <span class="title"> Pending Berkas </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('berkas/laporan')?>">
                                    <span class="title"> Laporan </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-pencil"></i>
                            <span class="title"> Relaas </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?=site_url('relaas/list')?>">
                                    <span class="title"> Semua Panggilan </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('relaas/saya')?>">
                                    <span class="title"> Relaas Saya </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('relaas/delegasi')?>">
                                    <span class="title"> Berikan Relaas </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('relaas/Tabayun')?>">
                                    <span class="title"> Relaas Tabayun </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('relaas/pending')?>">
                                    <span class="title"> Relaas Pending </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('relaas/laporan')?>">
                                    <span class="title"> Laporan </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-cog-2"></i>
                            <span class="title"> Data Log</span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?=site_url('log/berkas')?>">
                                    <span class="title"> Log Berkas</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('log/relaas')?>">
                                    <span class="title"> Log Relaas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-user-2"></i>
                            <span class="title"> Seting User</span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?=site_url('user/list')?>">
                                    <span class="title"> List user</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=site_url('user/log')?>">
                                    <span class="title"> Log User</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- end: MAIN NAVIGATION MENU -->
            </div>
            <!-- end: SIDEBAR -->
        </div>

        <!-- start: PAGE -->
        <div class="main-content">
            <!-- start: PANEL CONFIGURATION MODAL FORM -->
            <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                            <h4 class="modal-title">Panel Configuration</h4>
                        </div>
                        <div class="modal-body">
                            Here will be a configuration form
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                            <button type="button" class="btn btn-primary">
                    Save changes
                </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- end: SPANEL CONFIGURATION MODAL FORM -->
            <div class="container">
                <!-- start: PAGE HEADER -->
                <!-- kontent dimari -->

                <?php echo $contents;?>

                <!-- End kontent dimari -->
                <!-- end: PAGE CONTENT-->
            </div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
    <!-- start: FOOTER -->
    <div class="footer clearfix">
        <div class="footer-inner">
            <script>
                document.write(new Date().getFullYear())
            </script> &copy; ramastudio.
        </div>
        <div class="footer-items">
            <span class="go-top"><i class="clip-chevron-up"></i></span>
        </div>
    </div>
    <!-- end: FOOTER -->
    <!-- start: RIGHT SIDEBAR -->
    <div id="page-sidebar">
        <a class="sidebar-toggler sb-toggle" href="#"><i class="fa fa-indent"></i></a>
        <div class="sidebar-wrapper">
            <ul class="nav nav-tabs nav-justified" id="sidebar-tab">
                <li class="active">
                    <a href="#users" role="tab" data-toggle="tab"><i class="fa fa-users"></i></a>
                </li>
                <li>
                    <a href="#favorites" role="tab" data-toggle="tab"><i class="fa fa-heart"></i></a>
                </li>
                <li>
                    <a href="#settings" role="tab" data-toggle="tab"><i class="fa fa-gear"></i></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="users">
                    <div class="users-list">
                        <h5 class="sidebar-title">On-line</h5>
                        <ul class="media-list">
                            <li class="media">
                                <a href="#">
                                    <i class="fa fa-circle status-online"></i>
                                    <img alt="..." src="assets/images/avatar-2.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Nicole Bell</h4>
                                        <span> Content Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <div class="user-label">
                                        <span class="label label-success">3</span>
                                    </div>
                                    <i class="fa fa-circle status-online"></i>
                                    <img alt="..." src="assets/images/avatar-3.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Steven Thompson</h4>
                                        <span> Visual Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <i class="fa fa-circle status-online"></i>
                                    <img alt="..." src="assets/images/avatar-4.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Ella Patterson</h4>
                                        <span> Web Editor </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <i class="fa fa-circle status-online"></i>
                                    <img alt="..." src="assets/images/avatar-5.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Kenneth Ross</h4>
                                        <span> Senior Designer </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <h5 class="sidebar-title">Off-line</h5>
                        <ul class="media-list">
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-6.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Nicole Bell</h4>
                                        <span> Content Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <div class="user-label">
                                        <span class="label label-success">3</span>
                                    </div>
                                    <img alt="..." src="assets/images/avatar-7.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Steven Thompson</h4>
                                        <span> Visual Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-8.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Ella Patterson</h4>
                                        <span> Web Editor </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-9.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Kenneth Ross</h4>
                                        <span> Senior Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-10.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Ella Patterson</h4>
                                        <span> Web Editor </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-5.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Kenneth Ross</h4>
                                        <span> Senior Designer </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="user-chat">
                        <div class="sidebar-content">
                            <a class="sidebar-back" href="#"><i class="fa fa-chevron-circle-left"></i> Back</a>
                        </div>
                        <div class="user-chat-form sidebar-content">
                            <div class="input-group">
                                <input type="text" placeholder="Type a message here..." class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="button">
                                    <i class="fa fa-chevron-right"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                        <ol class="discussion sidebar-content">
                            <li class="other">
                                <div class="avatar">
                                    <img src="assets/images/avatar-4.jpg" alt="">
                                </div>
                                <div class="messages">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                    </p>
                                    <span class="time"> 51 min </span>
                                </div>
                            </li>
                            <li class="self">
                                <div class="avatar">
                                    <img src="assets/images/avatar-1.jpg" alt="">
                                </div>
                                <div class="messages">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                    </p>
                                    <span class="time"> 37 mins </span>
                                </div>
                            </li>
                            <li class="other">
                                <div class="avatar">
                                    <img src="assets/images/avatar-4.jpg" alt="">
                                </div>
                                <div class="messages">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                    </p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="tab-pane" id="favorites">
                    <div class="users-list">
                        <h5 class="sidebar-title">Favorites</h5>
                        <ul class="media-list">
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-7.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Nicole Bell</h4>
                                        <span> Content Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <div class="user-label">
                                        <span class="label label-success">3</span>
                                    </div>
                                    <img alt="..." src="assets/images/avatar-6.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Steven Thompson</h4>
                                        <span> Visual Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-10.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Ella Patterson</h4>
                                        <span> Web Editor </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-2.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Kenneth Ross</h4>
                                        <span> Senior Designer </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-4.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Ella Patterson</h4>
                                        <span> Web Editor </span>
                                    </div>
                                </a>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img alt="..." src="assets/images/avatar-5.jpg" class="media-object">
                                    <div class="media-body">
                                        <h4 class="media-heading">Kenneth Ross</h4>
                                        <span> Senior Designer </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="user-chat">
                        <div class="sidebar-content">
                            <a class="sidebar-back" href="#"><i class="fa fa-chevron-circle-left"></i> Back</a>
                        </div>
                        <ol class="discussion sidebar-content">
                            <li class="other">
                                <div class="avatar">
                                    <img src="assets/images/avatar-4.jpg" alt="">
                                </div>
                                <div class="messages">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                    </p>
                                    <span class="time"> 51 min </span>
                                </div>
                            </li>
                            <li class="self">
                                <div class="avatar">
                                    <img src="assets/images/avatar-1.jpg" alt="">
                                </div>
                                <div class="messages">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                    </p>
                                    <span class="time"> 37 mins </span>
                                </div>
                            </li>
                            <li class="other">
                                <div class="avatar">
                                    <img src="assets/images/avatar-4.jpg" alt="">
                                </div>
                                <div class="messages">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                    </p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="tab-pane" id="settings">
                    <h5 class="sidebar-title">General Settings</h5>
                    <ul class="media-list">
                        <li class="media">
                            <div class="checkbox sidebar-content">
                                <label>
                                <input type="checkbox" value="" class="green" checked="checked">
                                Enable Notifications
                            </label>
                            </div>
                        </li>
                        <li class="media">
                            <div class="checkbox sidebar-content">
                                <label>
                                <input type="checkbox" value="" class="green" checked="checked">
                                Show your E-mail
                            </label>
                            </div>
                        </li>
                        <li class="media">
                            <div class="checkbox sidebar-content">
                                <label>
                                <input type="checkbox" value="" class="green">
                                Show Offline Users
                            </label>
                            </div>
                        </li>
                        <li class="media">
                            <div class="checkbox sidebar-content">
                                <label>
                                <input type="checkbox" value="" class="green" checked="checked">
                                E-mail Alerts
                            </label>
                            </div>
                        </li>
                        <li class="media">
                            <div class="checkbox sidebar-content">
                                <label>
                                <input type="checkbox" value="" class="green">
                                SMS Alerts
                            </label>
                            </div>
                        </li>
                    </ul>
                    <div class="sidebar-content">
                        <button class="btn btn-success">
                        <i class="icon-settings"></i> Save Changes
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: RIGHT SIDEBAR -->
    <div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                    <h4 class="modal-title">Event Management</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-light-grey">
                    Close
                </button>
                    <button type="button" class="btn btn-danger remove-event no-display">
                    <i class='fa fa-trash-o'></i> Delete Event
                </button>
                    <button type='submit' class='btn btn-success save-event'>
                    <i class='fa fa-check'></i> Save
                </button>
                </div>
            </div>
        </div>
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
    <script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.js"></script>
    <script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.resize.js"></script>
    <script src="assets/plugin/jquery.sparkline.min.js"></script>
    <script src="<?=base_url()?>assets/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="<?=base_url()?>assets/bower_components/jqueryui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="<?=base_url()?>assets/bower_components/moment/min/moment.min.js"></script>
    <script src="<?=base_url()?>assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="assets/js/min/index.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

    <script>
        jQuery(document).ready(function() {
            Main.init();
            Index.init();
        });
    </script>

</body>

</html>