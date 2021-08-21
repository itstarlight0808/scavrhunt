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
            <div>
                <?php echo $huntInfo->sch_name." - ".$huntInfo->hunt_name; ?>
            </div>
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
                    <div class="col-md-8 blog-home" id="hunt_area">
                        <div id="hunt_area_1">
                            <div class="row">
                                <div class="blog-post post-main">
                                    <h1>Hunt Game End</h1>
                                    <div class="post-info">
                                        <!-- Post Comments -->
                                        <p><i class="fa fa-star-o"></i><?= $totalPoints->points ?> Points in total</p>
                                    </div>
                                    <div class="post-info">
                                        <!-- Post Comments -->
                                        <p><i class="fa fa-users"></i><?php echo $teamName; ?></p>
                                    </div>
                                </div>
                                <div class="team-leaderboard-container">
                                    <table class="team-leaderboard-table">
                                        <tr>
                                            <th>Challenge Name</th>
                                            <th>Expected Points</th>
                                            <th>Earned points</th>
                                            <th>Judged</th>
                                        </tr>
                                        <?php
                                            for($i=0; $i<count($teamLeaderBoard); $i++){
                                                $one = $teamLeaderBoard[$i];
                                                $judge_icon = $one->status_id==2 ? "<i class='fa fa-check-circle judged-icon'></i>" : "<i class='fa fa-exclamation-circle awaiting-judge-icon'></i>";
                                                echo "<tr>
                                                        <td>$one->chg_name</td>
                                                        <td align='center'>$one->points</td>
                                                        <td align='center'>$one->earned_points</td>
                                                        <td align='center'>$judge_icon</td>
                                                     </tr>";
                                            }
                                        ?>
                                    </table>
                                </div>
                                <div class="comments-block">
                                    <h3 class="text-center"></h3>

                                    <hr>
                                    <!-- Comment -->
                                    <div class="comment media">

                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Column -->
                    <div class="sidebar col-md-4">
                        <div class="well">
                            <h3 class="text-center">Challenges</h3>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <ul class="list-unstyled">
                                        <?php
                                            for ($i=0; $i<$chgCount; $i+=2)
                                            {
                                                if ($i < $curChgNum)
                                                {
                                        ?>
                                        <li class="challenge-number challenge-past" onclick="viewFeedback(<?php echo $i; ?>);">
                                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/game-door2-open.png"/>
                                            <span class="solved" id="chg_num_<?php echo $i+1; ?>"></span>
                                        </li>
                                        <?php
                                                }
                                                else if ($i == $curChgNum)
                                                {
                                        ?>
                                        <li class="challenge-number challenge-current">
                                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/game-door2-closed.png"/>
                                            <span class="not-solved" id="chg_num_<?php echo $i+1; ?>"></span>
                                        </li>
                                        <?php
                                                }
                                                else
                                                {
                                        ?>
                                        <li class="challenge-number">
                                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/game-door2-closed.png"/>
                                            <span class="not-solved" id="chg_num_<?php echo $i+1; ?>"></span>
                                        </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <ul class="list-unstyled">
                                        <?php
                                            for ($i=1; $i<$chgCount; $i+=2)
                                            {
                                                if ($i < $curChgNum)
                                                {
                                        ?>
                                        <li class="challenge-number challenge-past" onclick="viewFeedback(<?php echo $i; ?>);">
                                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/game-door2-open.png"/>
                                            <span class="solved" id="chg_num_<?php echo $i+1; ?>"></span>
                                        </li>
                                        <?php
                                                }
                                                else if ($i == $curChgNum)
                                                {
                                        ?>
                                        <li class="challenge-number challenge-current">
                                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/game-door2-closed.png"/>
                                            <span class="not-solved" id="chg_num_<?php echo $i+1; ?>"></span>
                                        </li>
                                        <?php
                                                }
                                                else
                                                {
                                        ?>
                                        <li class="challenge-number">
                                            <img class="img-rounded img-responsive" src="<?php echo base_url(); ?>assets/images/game-door2-closed.png"/>
                                            <span class="not-solved" id="chg_num_<?php echo $i+1; ?>"></span>
                                        </li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="color-section">
                    <div class="row">
                        <!-- /col-lg-4 -->
                        <div class="col-md-12 text-center">
                            <p style="margin:10px;">Copyright © 2021 Virtual Escape Attractions, LLC.</p>
                            <!-- /container -->
                            <!-- Go To Top Link -->
                            <div class="page-scroll hidden-sm hidden-xs">
                                <a href="#page-top" class="back-to-top"><i class="fa fa-angle-up"></i></a>
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
    var chg_count = eval("<?php echo $chgCount; ?>");
    var cur_chg_num = eval("<?php echo $curChgNum; ?>");

    $(document).ready(function(){
        for (var i=1; i<=chg_count; i++)
        {
            $("#chg_num_" + i).text(i);
        }
    });

    $(window).on('resize', function(){
        
    });
    
    function viewFeedback(chgNum)
    {
        window.open("<?php echo base_url(); ?>viewFeedback/?gc=" + gamecode + "&cn=" + chgNum);
    }

</script>