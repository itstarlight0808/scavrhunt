<head>
    <meta http-equiv="refresh" content="60">
    <style>
        #roomTable, #roomTable2{
            background-color: darkblue;
            color: white;
        }
        #roomTable tbody tr td:hover{
            background-color: white;
            color: darkblue;
            border: 3px solid white;
        }
        #roomTable2 tbody tr td:hover{
            background-color: white;
            color: darkblue;
            border: 3px solid white;
        }
        #myTable tbody tr td, #roomTable tbody tr td{
            vertical-align: middle;
        }
    </style>
</head>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i><span id="roomTitle"><?php echo $roomTitle; ?></span>
      </h1>
    </section>
    <section class="content">
        <div class="row"><!--   -->
            <div class="col-md-10 col-xs-10" id="roomsDiv" style="overflow-x:auto;overflow-y:scroll;">
                <table class="table table-striped table-bordered table-responsive" style="color:#666666;">
                    <tbody>
                        <tr>
                            <td style="vertical-align:middle;" align="right"><div style="width:30px;height:30px;background-color:#eeee00;"></div></td>
                            <td style="vertical-align:middle;"><h4>Started</h4></td>
                        
                            <td style="vertical-align:middle;" align="right"><div style="width:30px;height:30px;background-color:darkblue;"></div></td>
                            <td style="vertical-align:middle;"><h4>Vacant</h4></td>
                        
                            <td style="vertical-align:middle;" align="right"><div style="width:30px;height:30px;background-color:orange;"></div></td>
                            <td style="vertical-align:middle;"><h4>Occupied</h4></td>
                        
                            <td style="vertical-align:middle;" align="right"><div style="width:30px;height:30px;background-color:olive;"></div></td>
                            <td style="vertical-align:middle;"><h4>Solo Room</h4></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered table-sm table-responsive table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Player</th>
                        <th>School</th>
                        <th>Team</th>
                        <th>On the<br>same<br>device?</th>
                        <th>Room</th>
                        <th>Actually<br>Logged In</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($zoomRooms))
                    {
                        foreach($zoomRooms as $record)
                        {
                    ?>
                    <tr class="table-row">
                        <td><?php echo $record["logged_in"] ?></td>
                        <td><?php echo $record["player_name"] ?></td>
                        <td><?php echo $record["sch_name"] ?></td>
                        <td><?php echo $record["team_name"] . " -> " . $record["team_size"] ?></td>
                        <td><?php echo $record["samedevice"] ?></td>
                        <td><?php echo $record["room_no"] ?></td>
                        <td style="text-align:center;">
                        <?php
                            $ch = "";
                            if (intval($record["status_id2"]) == 2)
                                $ch = "checked";
                        ?>
                            <input type="checkbox" id="pInfo_<?php echo $record['id']?>_7" value="<?php echo $record["status_id2"];?>" <?php echo $ch;?> onchange="changePlayerStatus(<?php echo $record['id']?>, this.value);"/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info" onclick="showMoveDialog(<?php echo $record['id']?>);">Move</button>
                            <input type="hidden" id="pInfo_<?php echo $record['id']?>_1" value="<?php echo $record['player_name'] ?>"/>
                            <input type="hidden" id="pInfo_<?php echo $record['id']?>_2" value="<?php echo $record['team_name'] ?>"/>
                            <input type="hidden" id="pInfo_<?php echo $record['id']?>_3" value="<?php echo $record['captain'] ?>"/>
                            <input type="hidden" id="pInfo_<?php echo $record['id']?>_4" value="<?php echo $record['room_no'] ?>"/>
                            <input type="hidden" id="pInfo_<?php echo $record['id']?>_5" value="<?php echo $record['status_id'] ?>"/>
                            <input type="hidden" id="pInfo_<?php echo $record['id']?>_6" value="<?php echo $record['school_id'] ?>"/>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Date/Time</th>
                        <th>Player</th>
                        <th>School</th>
                        <th>Team</th>
                        <th>On the<br>same<br>device?</th>
                        <th>Room</th>
                        <th>Actually<br>Logged In</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-2 col-xs-2">
                <table class="table table-bordered table-responsive" id="roomTable" style="border-radius:10px 10px 0px 0px;">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:center;"><h4>Rooms</h4></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    for ($i=0; $i<25; $i++)
                    {
                ?>
                    <tr>
                        <td id="room_<?php echo $accountId;?>_<?php echo ($i*2+1);?>" style="cursor:pointer;text-align:center;" onclick="showPlayers(<?php echo ($i*2+1);?>, <?php echo $roomSchoolIds[$i*2];?>, <?php echo $roomStatusIds[$i*2];?>);">
                            <h4><?php echo ($i*2+1);?></h4>
                        </td>
                        <td id="room_<?php echo $accountId;?>_<?php echo ($i*2+2);?>" style="cursor:pointer;text-align:center;" onclick="showPlayers(<?php echo ($i*2+2);?>, <?php echo $roomSchoolIds[$i*2+1];?>, <?php echo $roomStatusIds[$i*2+1];?>);">
                            <h4><?php echo ($i*2+2);?></h4>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
                </table>
            </div>
        </div>
        <div id="roommatesModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title"></h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive table-hover" id="playersTable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Date/Time</th>
                            <th>Player</th>
                            <th>School</th>
                            <th>Team</th>
                            <th>On the<br>same<br>device?</th>
                            <th>Captain</th>
                        </tr>
                        </thead>
                        <tbody id="playersBody">
                        
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div style="float:left;" id="divHelp">
                            <input type="checkbox" id="chkHelp" name="chkHelp" class="form-check-input" style="margin-right:10px;" value="0"/><span id="lblHelp">Help needed</span>
                            <button type="button" class="btn btn-secondary" id="btnSetHelp" style="margin-left:10px;">OK</button>
                        </div>
                        <input type="hidden" id="curRoomNo" name="curRoomNo" value=""/>
                        <input type="hidden" id="curSchoolId1" name="curSchoolId1" value=""/>
                        <input type="hidden" id="curStatusId1" name="curStatusId1" value=""/>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnSetVacant">Set Vacant</button>
                        <button type="button" class="btn btn-danger" id="btnSetSoloClosed">Set Closed</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="movePlayerModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title"></h2>
                        <h3 class="modal-title modal-title2"></h3>
                        <h3 class="modal-title modal-title3"></h3>
                        <h3 class="modal-title modal-title4"></h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive" id="roomTable2">
                        <tbody id="roomBody2">
                        <?php
                        for ($i=0; $i<10; $i++)
                        {
                        ?>
                            <tr>
                            <?php
                                for ($j=0; $j<5; $j++)
                                {
                                    $idx = $i*5+$j;
                                    $ss = "cursor:pointer;width:20%;height:100px;"; 
                                    if ($roomTeams[$idx]["status_id"] == 2)
                                        $ss .= "background-color:orange;";
                                    if ($roomTeams[$idx]["status_id"] == 3)
                                        $ss .= "background-color:olive;";
                                    if ($roomTeams[$idx]["status_id"] == 4)
                                        $ss .= "background-color:#eeee00;";
                                    if ($roomTeams[$idx]["status_id"] == 6)
                                        $ss .= "background-color:red;";
                            ?>
                                <td style="<?php echo $ss;?>" onclick="confirmToMove(<?php echo $roomTeams[$idx]['id'] ?>, <?php echo $roomTeams[$idx]['status_id'] ?>, <?php echo $idx+1 ?>, <?php echo $roomTeams[$idx]['school_id'] ?>);">
                                    <div style="text-align:center"><h3><?php echo $idx+1 ?></h3></div>
                                    <div style="text-align:center"><h4><?php echo $roomTeams[$idx]["sch_name"] ?></h4></div>
                                    <div style="text-align:center">
                                    <?php echo $roomTeams[$idx]["teams"] ?>
                                    </div>
                                </td>
                            <?php
                                }
                            ?>
                            </tr>
                        <?php
                        }    
                        ?>
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="curRoomNo2" name="curRoomNo2" value=""/>
                        <input type="hidden" id="curPlayerId" name="curPlayerId" value=""/>
                        <input type="hidden" id="curStatusId2" name="curStatusId2" value=""/>
                        <input type="hidden" id="curSchoolId2" name="curSchoolId2" value=""/>
                        <!--
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnSetMoving">Move</button>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    var selPlayerId = 0;
    var occupiedToSolo = 0;
    var soloToOccupied = 0;
    var soloToVacant = 0;
    
    var accountId = "<?php echo $accountId;?>";
    var accountNo = "<?php echo $accountNo;?>";
    var occupiedRooms = "<?php echo $occupiedRooms;?>";
    var occupiedStatus = "<?php echo $occupiedStatus;?>";
    var playersNew = "<?php echo $newPlayers;?>";

    jQuery(document).ready(function(){
        var subtitle = jQuery("#roomTitle").html();
        jQuery('#myTable').DataTable({
            "iDisplayLength": -1,
            "aaSorting": [[ 0, "desc" ]],
            lengthMenu: [500, 250, 100, 50, 25, 10],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    title: subtitle,
                    download: 'open',
                    orientation:'landscape'
                },
                {
                    text: 'Clear All Room Data',
                    action: function ( e, dt, node, config ) {
                        clearAllRoomData();
                    }
                }
            ] 
        });
        jQuery('.dataTables_length').addClass('bs-select');

        if (occupiedRooms != "")
        {
            var arr_rooms = occupiedRooms.split("^");
            var arr_status = occupiedStatus.split("^");
            var room_id = "";
            for (var i=0; i<arr_rooms.length; i++)
            {
                room_id = "#room_" + accountId + "_" + arr_rooms[i];
                if (eval(arr_status[i]) == 2)
                    jQuery(room_id).css("backgroundColor", "orange");
                if (eval(arr_status[i]) == 3)
                    jQuery(room_id).css("backgroundColor", "olive");
                if (eval(arr_status[i]) == 4)
                    jQuery(room_id).css("backgroundColor", "#eeee00");
                if (eval(arr_status[i]) == 6)
                    jQuery(room_id).css("backgroundColor", "red");
            }   
        }

        var el = $('#roomsDiv');
        var originalelpos = el.offset().top; // take it where it originally is on the page
        el.css("height", ($(window).height() - 100) + "px");
        //var el2 = $('#roomTable');
        //alert(el2.offset().top + el2.height());

        //run on scroll
        $(window).scroll(function () {
            var el = $('#roomsDiv'); // important! (local)
            var elpos = el.offset().top; // take current situation
            var windowpos = $(window).scrollTop();
            //var finaldestination = windowpos;
            var finaldestination = 0;
            if (windowpos <= originalelpos)
                finaldestination = 0;
            else
            {
                finaldestination = windowpos - originalelpos + 20;
            }
            
            el.stop().animate({ 'top': finaldestination }, 1000);
        });

        $("#btnSetHelp").click(function(){
            if ($("#chkHelp").is(':checked'))
                $("#chkHelp").val("1");
            else
                $("#chkHelp").val("0");
            $("#roommatesModal").modal('hide');
            var post_url = "<?php echo base_url(); ?>setRoomNeedHelp";
            $.post(post_url, {accountId: accountId, roomNo: $("#curRoomNo").val(), chkHelp: $("#chkHelp").val()}, function(res){
                location.href="<?php echo base_url() ?>zoomRoomListing/" + accountId + "/" + accountNo;
            });
        });

        $("#btnSetVacant").click(function(){
            if (!confirm("Are you sure to set this room vacant?"))
                return;
            $("#roommatesModal").modal('hide');

            var post_url = "<?php echo base_url(); ?>setRoomVacant";

            /*var roomId = "#room_" + accountId + "_" + $("#curRoomNo").val();
            $(roomId).css("color", "white");*/
            $.post(post_url, {accountId: accountId, roomNo: $("#curRoomNo").val()}, function(res){
                location.href="<?php echo base_url() ?>zoomRoomListing/" + accountId + "/" + accountNo;
            });
        });

        $("#btnSetSoloClosed").click(function(){
            if (!confirm("Are you sure to set this solo room closed?"))
                return;
            $("#roommatesModal").modal('hide');

            var post_url = "<?php echo base_url(); ?>setSoloRoomClosed";
            $.post(post_url, 
                {
                    accountId: accountId, 
                    roomNo: $("#curRoomNo").val(),
                    schoolId: $("#curSchoolId1").val(),
                    statusId: $("#curStatusId1").val()
                }, function(res){
                location.href="<?php echo base_url() ?>zoomRoomListing/" + accountId + "/" + accountNo;
            });
        });
        if (playersNew != "")
        {
            alert("New player(s) \"" + playersNew + "\" arrived!");
        }
    });

    function clearAllRoomData()
    {
        if (!confirm("Are you sure to clear all the room data of the day?"))
            return;
        var post_url = "<?php echo base_url(); ?>clearAllRoomData";
        $.post(post_url, {accountId: accountId}, function(res){
            location.href="<?php echo base_url() ?>zoomRoomListing/" + accountId + "/" + accountNo;
        });
    }

    function changePlayerStatus(playerId, statusId2)
    {
        selPlayerId = playerId;
        var post_url = "<?php echo base_url(); ?>changePlayerStatus";
        $.post(post_url, 
            {
                playerId: playerId, 
                statusId2: statusId2
            }, function(res){
                $("#pInfo_" + selPlayerId + "_7").val(eval(res));
        });
    }

    function confirmToMove(roomId, statusId, roomNo, schoolId)
    {
        occupiedToSolo = 0;
        soloToOccupied = 0;
        soloToVacant = 0;
        
        var curPlayerId = eval($("#curPlayerId").val());
        var curRoomNo = eval($("#curRoomNo2").val());
        var curSchoolId = eval($("#curSchoolId2").val());
        var curStatusId = eval($("#curStatusId2").val());

        if (roomNo == curRoomNo)
        {
            alert("You select the current room. Please select the other room.");
            return;
        }
        
        if (schoolId != 0 && schoolId != curSchoolId)
        {
            alert("You are not allowed to move the room of the other school players. Please select the other room.");
            return;
        }

        if (statusId == 2 && curStatusId == 3)
        {
            soloToOccupied = 1;
        }

        if (statusId == 2 && curStatusId == 0)
        {
            soloToOccupied = 1;
        }

        if (statusId == 3 && curStatusId == 0)
        {
            soloToOccupied = 1;
        }

        if (statusId == 3 && curStatusId == 2)
        {
            if (!confirm("Is he a solo player or does he belongs to a double team?"))
                return;
            occupiedToSolo = 1;
        }

        if (statusId == 1 && roomId == 0 && curStatusId == 2)
        {
            //alert("He belongs to a team that has more than 3 players. He is not allowed to move to a vacant room.");
            if (!confirm("Is he a solo player?"))
                return;
            occupiedToSolo = 1;
        }

        if (statusId == 1 && roomId == 0 && curStatusId == 3)
        {
            soloToVacant = 1;
        }

        if (statusId == 1 && roomId == 0 && curStatusId == 0)
        {
            soloToVacant = 1;
        }

        movePlayer(curPlayerId, curRoomNo, roomNo, curSchoolId, schoolId);
        
    }

    function movePlayer(curPlayerId, curRoomNo, roomNo, curSchoolId, schoolId)
    {
        if (!confirm("Are you sure to move this player to the specified room?"))
            return;
        $("#movePlayerModal").modal('hide');
        var post_url = "<?php echo base_url(); ?>movePlayer";
        $.post(post_url, 
            {
                accountId: accountId, 
                playerId: curPlayerId, 
                curRoomNo: curRoomNo, 
                roomNo: roomNo, 
                curSchoolId: curSchoolId, 
                schoolId: schoolId,
                occupiedToSolo: occupiedToSolo, 
                soloToOccupied: soloToOccupied, 
                soloToVacant: soloToVacant
            }, function(res){
            occupiedToSolo = 0;
            soloToOccupied = 0;
            soloToVacant = 0;
            location.href="<?php echo base_url() ?>zoomRoomListing/" + accountId + "/" + accountNo;
        });
    }

    function showMoveDialog(playerId)
    {
        var playerName = $("#pInfo_" + playerId + "_1").val();
        var teamName = $("#pInfo_" + playerId + "_2").val();
        var captain = $("#pInfo_" + playerId + "_3").val();
        var roomNo = $("#pInfo_" + playerId + "_4").val();
        var statusId = $("#pInfo_" + playerId + "_5").val();
        var schoolId = $("#pInfo_" + playerId + "_6").val();
        $("#curPlayerId").val(playerId);
        if (roomNo == 'X')
            roomNo = 0;
        $("#curRoomNo2").val(roomNo);
        $("#curStatusId2").val(statusId);
        $("#curSchoolId2").val(schoolId);
        $("#movePlayerModal .modal-title").html("Selected Player: " + playerName);
        $("#movePlayerModal .modal-title2").html("Team: " + teamName);
        $("#movePlayerModal .modal-title3").html("Captain: " + captain);
        $("#movePlayerModal .modal-title4").html("Current Room: " + roomNo);
        $("#movePlayerModal").modal('show');
    }

    function showPlayers(roomNo, schoolId, statusId)
    {
        //alert(accountId + " -> " + roomNo + " -> " + schoolId + " -> " + statusId);
        if (eval(statusId) >= 2)
        {
            $("#btnSetSoloClosed").show();
            if (eval(statusId) >= 4)
            {
                $("#btnSetSoloClosed").attr("disabled", "disabled");
            }
            else
            {
                $("#btnSetSoloClosed").removeAttr("disabled");
            }
        }
        else
        {
            $("#btnSetSoloClosed").hide();
        }

        if (eval(statusId) >= 4)
        {
            $("#divHelp").show();
        }
        else
        {
            $("#divHelp").hide();
        }
        
        getRoommates(roomNo);
        if (eval(statusId) == 4)
            $("#roommatesModal .modal-title").html("Players in Room " + roomNo + " (Started)");
        else
            $("#roommatesModal .modal-title").html("Players in Room " + roomNo);
        
        if (eval(statusId) == 6)
        {
            $("#chkHelp").prop('checked', true);
            $("#chkHelp").val("1");
        }
        else
        {
            $("#chkHelp").prop('checked', false);
            $("#chkHelp").val("0");
        }

        $("#curRoomNo").val(roomNo);
        $("#curSchoolId1").val(schoolId);
        $("#curStatusId1").val(statusId);
        
        $("#roommatesModal").modal('show');
    }

    function getRoommates(roomNo)
    {
        var response;
        var post_url = "<?php echo base_url(); ?>getSameRoomPlayers";
           
        /*$.ajax({
            type: "POST",
            url: post_url,
            data: {accountId: accountId, roomNo: roomNo},
            dataType: "json",
            async: false
        }).done(function(result){
        });*/

        $.post(post_url, {accountId: accountId, roomNo: roomNo}, function(res){
            var objs = JSON.parse(res);
            var strBody = "";
            if (objs.length == 0)
            {
                $("#btnSetVacant").attr("disabled", "disabled");
                $("#btnSetSoloClosed").attr("disabled", "disabled");
            }
            else
            {
                $("#btnSetVacant").removeAttr("disabled");
            }
            for (var i=0; i<objs.length; i++)
            {
                //console.log(objs[i]);
                strBody += "<tr id=\"" + objs[i].id + "\">";
                strBody += "<td>" + (i+1) + "</td>";
                strBody += "<td>" + objs[i].logged_in + "</td>";
                strBody += "<td>" + objs[i].player_name + "</td>";
                strBody += "<td>" + objs[i].sch_name + "</td>";
                strBody += "<td>" + objs[i].team_name + " -> " + objs[i].team_size + "</td>";
                strBody += "<td>" + objs[i].samedevice + "</td>";
                strBody += "<td>" + objs[i].captain + "</td>";
                strBody += "</tr>";
            }
            $("#playersBody").html(strBody);
        });
        
    }
</script>
