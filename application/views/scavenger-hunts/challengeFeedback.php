<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Team Building | Scavenger Hunt</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/css/bootstrap.css" rel="stylesheet" type="text/css">
        <!-- Icon fonts -->
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/fonts/flaticons/flaticon.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/fonts/glyphicons/bootstrap-glyphicons.css" rel="stylesheet" type="text/css">
        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Paytone+One" rel="stylesheet">
        <!-- Style CSS -->
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/css/style.css" rel="stylesheet">
        <!-- Color Style CSS -->
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/styles/sweet.css" rel="stylesheet">
        <!-- CSS Plugins -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/pieceofcake/css/plugins.css">

        <!-- Own Style -->
        <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/css/challenge-ui.css" rel="stylesheet">

        <!-- Core JavaScript Files -->
        <script src="<?php echo base_url(); ?>assets/libs/pieceofcake/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/libs/pieceofcake/js/bootstrap.min.js"></script>
        <!-- Main Js -->
        <script src="<?php echo base_url(); ?>assets/libs/pieceofcake/js/main.js"></script>
        <!--Other Plugins -->
        <script src="<?php echo base_url(); ?>assets/libs/pieceofcake/js/plugins.js"></script>
        <!-- Prefix free CSS -->
        <script src="<?php echo base_url(); ?>assets/libs/pieceofcake/js/prefixfree.js"></script>

        <script src="<?php echo base_url(); ?>assets/libs/cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
        
    </head>
    <body id="page-top" data-spy="scroll" data-target=".navbar-custom">
        <nav class="navbar navbar-custom navbar-fixed-top"  id="navbar-custom">

        </nav>
        <!-- Preloader -->
        <div id="loading">
            <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object-load" id="object_one"></div>
                <div class="object-load" id="object_two"></div>
                <div class="object-load" id="object_three"></div>
            </div>
            </div>
        </div>
        <!-- /preloader -->

        <!-- Section Blog -->
        <section id="blog-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8 blog-home" id="hunt_area">
                        <div id="hunt_area_1">
                            <div class="row">
                                <div class="blog-post post-main">
                                    <h1><?php echo $curChallenge->chg_name; ?></h1>
                                    <div class="post-info">
                                        <!-- Post Comments -->
                                        <p><i class="fa fa-star-o"></i><?php echo $curChallenge->points;?> Points</p>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <p><i class="fa fa-star"></i><?php echo $chgResult->points;?> Points (Earned)</p>
                                    </div>
                                    <div class="post-info">
                                        <!-- Post Comments -->
                                        <p><i class="fa fa-users"></i><?php echo $teamName; ?></p>
                                    </div>
                                </div>
                                <div class="comments-block">
                                    <h3 class="text-center">Puzzle</h3>
                                    <!--
                                    <h5 class="text-center">(<?php echo $chgTypeName; ?>)</h5>
                                    -->
                                    <hr>
                                    <!-- Comment -->
                                    <div class="comment media">
                                        <?php
                                            $challengePage = $curChallenge->puzzle_page; 
                                            $challengePage = str_replace('href="assets', 'href="../assets', $challengePage);
                                            $challengePage = str_replace('<img class="img-responsive" src="assets', '<img class="img-responsive" src="../assets', $challengePage);
                                            echo $challengePage; 
                                        ?>
                                        <?php
                                            if ($curChallenge->chg_image2 != "")
                                            {
                                        ?>
                                        <!--
                                        <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/uploads/challenges/<?php echo $huntId;?>/<?php echo $curChallenge->chg_image2;?>" />
                                        -->
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-10 col-centered text-center">
                                    <div class="media comment-form">
                                        <form id="answerSubmit" name="answerSubmit" method="post" enctype="multipart/form-data">
                                            <h3 class="text-center">Your answer:</h3>
                                            <?php
                                                if (intval($curChallenge->chg_type_id) == 1)
                                                {
                                            ?>
                                            <!--
                                            <?php //echo $curChgNum+1; ?>
                                            -->
                                            <div class="form-group">
                                                <img class="img-rounded img-responsive" id="chgCaptured" name="chgCaptured" src="<?php echo $chgResult->chg_result; ?>"/>
                                            </div>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                            <div class="form-group">
                                                <h5 class="text-primary" style="text-align: center;"><?php echo $chgResult->chg_result;?></h5>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <!-- Footer -->
                <footer class="color-section">
                    <div class="container">
                        <div class="row margin-footer">
                            <!-- /col-lg-4 -->
                            <div class="col-md-12 text-center">
                                <p>Copyright © 2021 - 2022 / Designed by Jason Bock</p>
                                <!-- /container -->
                                <!-- Go To Top Link -->
                                <div class="page-scroll hidden-sm hidden-xs">
                                    <a href="#page-top" class="back-to-top"><i class="fa fa-angle-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </section>
    </body>
</html>
<script language="javascript">
    var gamecode = eval("<?php echo $gamecode; ?>");
    var playerId = eval("<?php echo $playerId; ?>");
    var huntId = eval("<?php echo $huntId; ?>");
    var teamId = eval("<?php echo $teamId; ?>");
    var chgId = eval("<?php echo $curChallenge->id; ?>");
    var cur_chg_num = eval("<?php echo $curChgNum; ?>");
    var cur_chg_type = eval("<?php echo $curChallenge->chg_type_id; ?>");

    $(document).ready(function(){
        
    });

    $(window).on('resize', function(){
        
    });
</script>