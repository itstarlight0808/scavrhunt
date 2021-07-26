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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <style>
            .active3{
                color: white;
                background-color: green;
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
                        <button class="btn btn-primary" id="btn_gamecode">Get game code for hunt</button>
                        &nbsp;&nbsp;&nbsp;
                        <label id="lbl_gamecode"></label>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>

<script language="javascript">
    var teamId = eval("<?php echo $teamId; ?>");
    jQuery(document).ready(function(){
        $('#roomTable').on('click', '.clickable-row', function(event) {
            //$(this).addClass('active3').siblings().removeClass('active3');
        });

        $("#btn_gamecode").click(function(){
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
        });
    });

</script>