<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Team Building | Scavenger Hunt</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!--
    <script src="<?php echo base_url(); ?>assets/libs/code.jquery.com/jquery-3.5.1.js"></script>
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-4.5.2/js/bootstrap.min.js"></script>
    -->
    <!--
    <script src="<?php echo base_url(); ?>assets/libs/cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
    -->

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

    <style>
        /* Style the tab */
        .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #bda3fa;
        color : white;
        }

        /* Style the buttons inside the tab */
        .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            color : #9a72fa;
            background-color : white;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            color : white;
            background-color : #8855ff;
        }

        /* Style the tab content */
        .tabcontent {
        height:600px;
        overflow-y:auto;
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
        }

        #navbar-custom{
            background-color: #b4230d;
        }
    </style>
</head>
<!--
<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
    <nav class="navbar navbar-custom navbar-fixed-top"  id="navbar-custom">

    </nav>
</body>
-->
<body>
    <section id="blog-main" style="width:96%;margin:0px auto;">
        <div class="row">
            <div class="col-md-12" align="center">
                <h1>Judging</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="tab" id="chgTabbar">
                    <button class="tablinks" onclick="openChallengeTab(event, 'divChgPhotos')">Photo/Video</button>
                    <button class="tablinks" onclick="openChallengeTab(event, 'divChgOthers')">Other</button>
                </div>
                <div id="divChgPhotos" class="tabcontent">
                    <table class="table table-bordered table-responsive table-hover">
                    <thead>
                        <td style="width:10%;"><h6>No</h6></td>
                        <td><h6>Information</h6></td>
                    </thead>
                    <tbody style="cursor:pointer;">
                    <?php
                        $k = 1;
                        foreach ($chgPhotoVideos as $record)
                        {
                            $puzzle_page = $record->puzzle_page;
                            $puzzle_page = str_replace('href="assets', 'href="../../assets', $puzzle_page);
                            $puzzle_page = str_replace('<img class="img-responsive" src="assets', '<img class="img-responsive" src="../../assets', $puzzle_page);
                    ?>
                        <tr onclick='getSubmittedAnswer(<?php echo $huntId; ?>, <?php echo $gamecodeId; ?> , <?php echo $record->id; ?>, <?php echo $record->chg_type_id; ?>, "<?php echo $record->description; ?>", <?php echo intval($record->points); ?>)'>
                            <td><h3><?php echo $k; ?></h3></td>
                            <td>
                                <h5>Description:</h5>
                                <h6><?php echo $record->description; ?></h6>
                                <h5>Puzzle Page:</h5>
                                <h6><?php echo $puzzle_page; ?></h6>
                                <h5>Challenge Link:</h5>
                                <h6><?php echo $record->chg_link; ?></h6>
                            </td>
                        </tr>
                    <?php
                            $k++;
                        }
                    ?>
                    </tbody>
                    </table>
                </div>
                <div id="divChgOthers" class="tabcontent">
                <table class="table table-bordered table-responsive table-hover">
                    <thead>
                        <td style="width:10%;"><h6>No</h6></td>
                        <td><h6>Information</h6></td>
                    </thead>
                    <tbody style="cursor:pointer;">
                    <?php
                        $k = 1;
                        foreach ($chgOthers as $record)
                        {
                            $puzzle_page = $record->puzzle_page;
                            $puzzle_page = str_replace('href="assets', 'href="../../assets', $puzzle_page);
                            $puzzle_page = str_replace('<img class="img-responsive" src="assets', '<img class="img-responsive" src="../../assets', $puzzle_page);
                    ?>
                        <tr onclick='getSubmittedAnswer(<?php echo $huntId; ?>, <?php echo $gamecodeId; ?>, <?php echo $record->id; ?>, <?php echo $record->chg_type_id; ?>, "<?php echo $record->description; ?>", <?php echo intval($record->points); ?>)'>
                            <td><h3><?php echo $k; ?></h3></td>
                            <td>
                                <h5>Description:</h5>
                                <h6><?php echo $record->description; ?></h6>
                                <h5>Puzzle Page:</h5>
                                <h6><?php echo $puzzle_page; ?></h6>
                                <h5>Answer:</h5>
                                <h6><?php echo $record->puzzle_answer; ?></h6>
                                <h5>Challenge Link:</h5>
                                <h6><?php echo $record->chg_link; ?></h6>
                            </td>
                        </tr>
                    <?php
                            $k++;
                        }
                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Submitted Answers Of </h3>
                <h3 id="selChgDesc"></h3>
                <table class="table table-bordered table-responsive table-hover">
                <thead>
                    <td style="width:10%;vertical-align:middle;"><h6>No</h6></td>
                    <td style="width:20%;"><h6>Team Name</h6></td>
                    <td style="vertical-align:middle"><h6>Submitted Answer</h6></td>
                </thead>
                <tbody id="tbl_submitted">
                </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
<script language="javascript">
$(document).ready(function(){
    $(".tablinks").first().click();
});
function openChallengeTab(evt, divTabName)
{
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    $(evt.target).addClass("active");
    document.getElementById(divTabName).style.display = "block";
    //evt.currentTarget.className += " active";
}
function getSubmittedAnswer(huntId, gamecodeId, chgId, chgTypeId, chgDescription, chgMaxPoints)
{
    var str_body = "";
    $("#selChgDesc").text(chgDescription + " ( " + chgMaxPoints + " Points )");
    var post_url = "<?php echo base_url(); ?>getChallengeAnswers";
    $.post(
        post_url, 
        {
            huntId: huntId,
            gamecodeId : gamecodeId,
            challengeId: chgId
        }, 
        function(res)
        {
            var result = JSON.parse(res);
            
            for (var i=0; i<result.length; i++)
            {
                str_body += '<tr>';
                str_body += '<td><h6>' + (i+1) + '</h6></td>';
                str_body += '<td>';
                str_body += '<h4>' + result[i].teamname + '</h4>';
                str_body += '<h6>Points: </h6>';
                str_body += '<input type="number" id="pt_' + result[i].id +
                                    '" value="' + result[i].points + 
                                    '" style="width:80%;" min="1" max=' + chgMaxPoints +
                                    " " + (result[i].judge_status?'disabled':'')+'/>';
                str_body += '<br>';
                if(!result[i].judge_status)
                    str_body += '<button class="btn btn-info" onclick="saveChallengePoints(' + result[i].id + ')"><i class="fa fa-save"></i> Save</button>';
                else
                    str_body += '<div style="margin-top:20px"><i class="fa fa-check-circle judged-icon">Judged</i></div>';
                str_body += '</td>';
                str_body += '<td>';
                if (chgTypeId == 1)
                    str_body += '<div><img class="img-rounded img-responsive" src="' + result[i].answer + '"/></div>';
                else
                    str_body += '<h6>' + result[i].answer + '</h6>';
                str_body += '</td>';
                str_body += '</tr>';
            }
            $("#tbl_submitted").html(str_body);
        }
    );
}

function saveChallengePoints(chgResultId)
{
    let el = $("#pt_" + chgResultId);
    let points = $(el).val();
    let maxPoints = $(el).attr("max");
    if(points > maxPoints){
        alert(`Points should be ${maxPoints} at most!`);
        return;
    }
    let post_url = "<?php echo base_url(); ?>saveChallengePoints";
    $.post(
        post_url, 
        {
            chgResultId: chgResultId,
            points: points
        }, 
        function(res)
        {
            let container = $("#tbl_submitted button").parent();
            $(container).find("button").remove();
            $(container).append('<div style="margin-top:20px"><i class="fa fa-check-circle judged-icon">Judged</i></div>');
        }
    );
}
</script>