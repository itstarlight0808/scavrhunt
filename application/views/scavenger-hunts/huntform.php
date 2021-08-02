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
                    <div class="col-md-8 blog-home" id="hunt_area">
                        <div id="hunt_area_1">
                            <div class="row">
                                <div class="blog-post post-main">
                                    <h1><?php echo $curChallenge->chg_name; ?></h1>
                                    <div class="post-info">
                                        <!-- Post Comments -->
                                        <p><i class="fa fa-star-o"></i><?php echo $curChallenge->points;?> Points</p>
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
                                            <h3 class="text-center">Leave your answer:</h3>
                                            <?php
                                                if (intval($curChallenge->chg_type_id) == 1)
                                                {
                                            ?>
                                            <!--
                                            <?php //echo $curChgNum+1; ?>
                                            -->
                                            <div class="form-group">
                                                <img class="img-rounded img-responsive" id="chgCaptured" name="chgCaptured" style="display:none;"/>
                                                <br>
                                                <div id="mycam"></div>    
                                                <a class="browse_btn flat-button orange-flat-button btn btn-warning2 btn-lg" onclick="take_snapshot()">
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                    Capture
                                                </a>
                                                <a class="browse_btn flat-button orange-flat-button btn btn-warning2 btn-lg" onclick="reset_webcam()">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                    Reset
                                                </a>
                                                <input type="hidden" id="image_captured" name="image_captured" class="image-tag" value="">
                                            </div>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                            <div class="form-group">
                                                <input type="text" id="inp_answer" name="inp_answer" class="form-control input-field" placeholder="Leave your answer" style="text-align:center;"/>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                            <a class="btn" id="btn_submit_1" onclick="submit_answer()">
                                                <div class="btn-line"></div>
                                                <div class="btn-line btn-line-shift"></div>
                                                Submit
                                            </a>
                                            <input type="hidden" id="inp_cur_chg_num" name="inp_cur_chg_num" value="<?php echo $curChgNum; ?>" />
                                            <input type="hidden" id="inp_cur_chg_type" name="inp_cur_chg_type" value="<?php echo $curChallenge->chg_type_id; ?>" />
                                        </form>
                                    </div>
                                </div>
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
                            <div class="leaderboard-container">
                                <h5><span>LEADERBOARD</span></h5>
                                <div style="text-align:left">
                                    <?php
                                        for($i=0; $i<count($leaderBoard); $i++){ 
                                            $one = $leaderBoard[$i];
                                            echo "<div>
                                                    <span>
                                                        $i. $one->team_name .... $one->points
                                                    </span>
                                                </div>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
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
    var chg_count = eval("<?php echo $chgCount; ?>");
    var cur_chg_num = eval("<?php echo $curChgNum; ?>");
    var cur_chg_type = eval("<?php echo $curChallenge->chg_type_id; ?>");

    $(document).ready(function(){
        for (var i=1; i<=chg_count; i++)
        {
            $("#chg_num_" + i).text(i);
        }
        if (cur_chg_type == 1)
        {
            set_webcam();
        }
    });

    $(window).on('resize', function(){
        //set_webcam();
    });

    function take_snapshot() {
        Webcam.snap(function(data_uri){
            $("#chgCaptured").attr("src", data_uri);
            $("#image_captured").val(data_uri);
            $("#mycam").hide();
            $("#chgCaptured").show();
        } );
    }

    function reset_webcam() {
        $("#chgCaptured").hide();
        $("#mycam").show();
    }

    function set_webcam()
    {
        cam_width = $("#hunt_area").width();
        cam_height = Math.floor(cam_width*3/4);

        Webcam.set({
            width: cam_width,
            height: cam_height,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach('#mycam');
    }

    function submit_answer()
    {
        var imageCaptured = $("#image_captured").val();
        var inpAnswer = $("#inp_answer").val();

        if (imageCaptured == "" || inpAnswer == "")
        {
            alert("Please submit a photo or an answer.");
            return;
        }

        var post_url = "<?php echo base_url(); ?>submitHuntAnswer";
        $.post(
            post_url, 
            {
                playerId: playerId,
                teamId: teamId,
                huntId: huntId,
                challengeId: chgId,
                imageCaptured: imageCaptured,
                inpAnswer: inpAnswer
            }, 
            function(res)
            {
                //if (res == "success")
                    gotoNextChallenge();       
            }
        );
        
    }

    function gotoNextChallenge()
    {
        $("#inp_cur_chg_num").val(cur_chg_num + 1);
        var form = $("form#answerSubmit");
        if (cur_chg_num < chg_count - 1)
        {
            form.attr("action", "<?php echo base_url(); ?>gotoHuntGame/?gc=" + gamecode);        
        }
        else
        {
            form.attr("action", "<?php echo base_url(); ?>endHuntGame/?gc=" + gamecode);
        }
        form.submit();
    }

    function viewFeedback(chgNum)
    {
        window.open("<?php echo base_url(); ?>viewFeedback/?gc=" + gamecode + "&cn=" + chgNum);
    }

</script>