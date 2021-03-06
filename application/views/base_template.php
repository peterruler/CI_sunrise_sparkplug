<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 14.06.14
 * Time: 19:58
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="peter ruler"/>
    <title>Codeigniter CRUD generation with twitter bootstrap</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome.css'); ?>"/>
    <link href="<?php echo base_url('assets/styles.css'); ?>" rel="stylesheet"/>
    <script src="/../../bower_components/modernizr/dist/modernizr.js"></script>
</head>
<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <!-- Fixed navbar -->
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <a class="sr-only" href="#content">Skip to main content</a>

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Project name</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><a href="./">Default</a></li>
                            <li><a href="../navbar-static-top/">Static top</a></li>
                            <li><a href="../navbar-fixed-top/">Fixed top</a></li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <!--/.container-fluid -->
            </div>
            <!--/.navbar -->
            <div style="overflow-x:scroll;overflow-y:visible;" class="col-xl-12">
                <?php
                    echo $crud_html;
                ?>
            </div>
            <!-- /col-xl-12 -->
        </div>
        <!-- /col-xl-12 -->
    </div>
    <!-- /row -->
</div>
<!-- /container -->
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID -->
<script>
    /*<!--
     (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
     (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
     m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
     })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

     ga('create', 'UA-XXXXX-X');
     ga('send', 'pageview');
     -->*/
</script>
<!--[if lt IE 9]>
<script src="/../../bower_components/es5-shim/es5-shim.js"></script>
<script src="/../../bower_components/json3/lib/json3.min.js"></script>
<![endif]-->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script src="<?php echo base_url('bower_components/jquery/dist/jquery.js'); ?>"></script>
<!--
<script src="<?php //echo base_url('bower_components/jquery-ui/ui/jquery-ui.js'); ?>"></script>
-->
<script src="<?php echo base_url('bower_components/lodash/dist/lodash.js'); ?>"></script>
<script src="<?php echo base_url('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/scripts.js'); ?>"></script>
<script src="/../../bower_components/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({selector: 'textarea'});
</script>
</body>
</html>