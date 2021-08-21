<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Team Building | Room Assignment</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/common.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/FE_common.js"></script>
        <style>
            .active3{
                color: white;
                background-color: green;
            }
            .gamecode-div {
                background: #2a5ff3;
                color: white;
                padding: 8px;
                width: 210px;
                border-radius: 4px;
                font-size: 16px;
                box-shadow: -2px 3px 7px black;
            }
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="assignedroom-box">
            <div class="login-box-body" style="overflow-x:auto;">
                <div class="row">
                    <div class="col-md-12">
                        <h1><p class="login-box-msg">Room Assignment</p></h1>
                        <table class="table table-bordered table-responsive table-hover" id="roomTable">
                            <tr>
                                <th>No</th>
                                <th>Player Name</th>
                                <th>Team Name</th>
                                <th>Captain</th>
                                <th>Room No</th>
                                <th>Game Link</th>
                            </tr>
                            <?php
                            if(!empty($roomMates))
                            {
                                foreach($roomMates as $k => $record)
                                {
                            ?>
                            <tr class="clickable-row" id="<?php echo $record["id"]?>">
                                <td><?php echo ($k + 1) ?></td>
                                <td><?php echo $record["playername"] ?></td>
                                <td><?php echo $record["teamname"] ?></td>
                                <td><?php echo $record["captain"] ?></td>
                                <td><?php echo $record["roomno"] ?></td>
                                <td><a href="<?php echo $record['gamelink'] ?>" target="_blank"><?php echo $record['gamelink'] ?></a></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                        <div class="gamecode-div">
                            Game Code&nbsp;&nbsp;&nbsp;
                            <label id="lbl_gamecode"></label>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>

<script language="javascript">
    displayCounter("<?php echo $hunt_status ?>", <?php echo $remainTime ?>, <?php echo json_encode($huntInfo) ?>);

    var teamId = eval("<?php echo $teamId; ?>");
    $(document).ready(function(){
        var post_url = "<?php echo base_url(); ?>getHuntGameCode";
        $.post(
            post_url, 
            {
                teamId: teamId
            }, 
            function(res)
            {
                $("#lbl_gamecode").text(res);
            }
        );


        $('#roomTable').on('click', '.clickable-row', function(event) {
            //$(this).addClass('active3').siblings().removeClass('active3');
        });
    });

</script>