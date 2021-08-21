<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Scavenger Hunt</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/dist/css/common.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/js/FE_common.js" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
            .error_Msg{ 
                color:#fa4b2a; 
                padding-left: 10px; 
            } 
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="entryform-box">
            <div class="login-box-body">
            <h1><p class="login-box-msg" id="entryTitle">Player entry form for </p></h1>
                <form method="post" id="entry_form" name="entry_form" novalidate>
                    <div class="form-group has-feedback">
                        <label for="email">Email (School/Institution/Company email address preferred)<span style="color:red;">*</span></label>
                        <input type="email" id="email" class="form-control" placeholder="Email" name="email" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <p class="error_Msg" id="email_error"> 
                            Error! Email should only look like xyz@abc.com.
                        </p>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="fullname">Your Name (full name)<span style="color:red;">*</span></label>
                        <input type="text" id="fullname" class="form-control" placeholder="Your Full Name" name="fullname" required />
                        <span class="glyphicon glyphicon-tag form-control-feedback"></span>
                        <p class="error_Msg" id="name_error"> 
                            Error! Please input your full name.
                        </p>
                    </div>
                    <div class="form-group has-feedback" id="stdId_info">
                        <label for="studentId">Student ID Number<span style="color:red;">*</span></label>
                        <input type="text" id="studentId" class="form-control" placeholder="Student ID Number (enter 0 if not required)" name="studentId" required />
                        <span class="glyphicon glyphicon-tag form-control-feedback"></span>
                        <p class="error_Msg" id="std_id_error"> 
                            Error! A student ID can contain only digits.
                        </p>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="selSchoolId">Institution/College/University<span style="color:red;">*</span></label>
                        <select id="selSchoolId" class="form-control" onchange="setEntryTitle();">
                        <?php
                            foreach ($allSchools as $record)
                            {
                                if ($curSchoolId == intval($record->id))
                                    $strSelected = "selected";
                                else
                                    $strSelected = "";
                        ?>
                            <option value="<?php echo $record->id?>" <?php echo $strSelected?>><?php echo $record->sch_name?></option>
                        <?php
                            }
                        ?>
                        </select>
                        <input type="hidden" id="schoolId" name="schoolId" value="<?php echo $curSchoolId; ?>"/>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="playersId">
                            Number of players in your group<span style="color:red;">*</span><br>
                            <p style="color:grey;">Your group can have a maximum of 10 players in Zoom. To allow for room for everybody the minimum group size is 3. We will pair up smaller groups. If you have fewer than 8 players, we may add solo players to your team.</p>
                        </label>
                        <select id="playersId" name="playersId" class="form-control" onchange="getTeamInfo(this.value);">
                            <option value="1" selected>Solo Player looking for a team</option>
                            <option value="2">2 Players</option>
                            <option value="3">3 Players</option>
                            <option value="4">4 Players</option>
                            <option value="5">5 Players</option>
                            <option value="6">6 Players</option>
                            <option value="7">7 Players</option>
                            <option value="8">8 Players</option>
                            <option value="9">9 Players</option>
                            <option value="10">10 Players</option>
                        </select>
                    </div>
                    <div id="team_info">
                        <div class="form-group has-feedback">
                            <label for="samedevice">
                                Are all you players on the team located together? (Yes if you are in the same room playing on the same computer or device; No if players are joining Zoom using different devices or in different locations)<span style="color:red;">*</span><br>
                            </label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    &nbsp;&nbsp;&nbsp;<input type="radio" class="form-check-input" name="samedevice" value="1">&nbsp;&nbsp;&nbsp;Altogether
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    &nbsp;&nbsp;&nbsp;<input type="radio" class="form-check-input" name="samedevice" value="0" checked>&nbsp;&nbsp;&nbsp;Zoom
                                </label>
                            </div>
                        </div>
                        
                        <div id="noteam_div" class="form-group has-feedback">
                            <label for="teamname">Team Name<span style="color:red;">*</span></label>
                            <input type="text" id="teamname" class="form-control" placeholder="Team Name" name="teamname" required />
                            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
                            <p class="error_Msg" id="teamname_error"> 
                                Error! Please input your team name.
                            </p>
                        </div>
                        
                        <!--
                        <div id="team_div" class="form-group has-feedback">
                            <label for="teamname">Team Name<span style="color:red;">*</span></label>
                            <select id="teamId" name="teamId" class="form-control">
                                <option value="0" selected></option>
                            </select>
                        </div>
                        -->
                        
                        <div class="form-group has-feedback">
                            <label for="teamcaptain">Team Captain<span style="color:red;">*</span></label>
                            <input type="text" id="teamcaptain" class="form-control" placeholder="Team Captain" id="teamcaptain" name="teamcaptain" required />
                            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
                            <p class="error_Msg" id="teamcaptain_error"> 
                                Error! Please input the name of the team captain.
                            </p>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="teammembers_group">Names of other players on your team.</label>
                            <!--
                            <textarea class="form-control" id="teammembers" name="teammembers" required></textarea>
                            -->
                            <div id="teammembers_group" style="width:100%">
                            </div>
                            <p class="error_Msg" id="teammembers_error"> 
                                Error! Please input at least one name of your team members.
                            </p>
                            <input type="hidden" id="teammembers" name="teammembers" value=""/>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="center">
                            <input id="btn_submit" type="button" class="btn btn-primary btn-block btn-flat" value="Submit Form" style="width:30%;"/>
                        </div><!-- /.col -->
                    </div>
                </form>
                
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
    </body>
</html>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script language="javascript">
    var stdIdRequired = "<?php echo $stdIdRequired; ?>";
    var arrStdIdRequired = [];                            
    jQuery(document).ready(function(){
        $('.error_Msg').hide();
        jQuery("#team_info").hide();
        if (stdIdRequired == "")
            jQuery("#stdId_info").hide();
        else
        {
            arrStdIdRequired = stdIdRequired.split("^");
            setEntryTitle();
        }

        jQuery("#btn_submit").click(function(){
            var e = e || event;
            var form = $("form#entry_form");
            var email = $("#email").val();
            var regex_email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (regex_email.test(email))
            {
                $('#email_error').hide();
            }
            else
            {
                $('#email_error').show();
                e.preventDefault();
                return; 
            }

            var fullname = $("#fullname").val();
            if (fullname != "")
            {
                $('#name_error').hide();
            }
            else
            {
                $('#name_error').show();
                e.preventDefault();
                return; 
            }

            var idx = $("#selSchoolId option:selected").index();
            if (arrStdIdRequired[idx] != 0)
            {
                var studentId = $('#studentId').val();
                /*var regex_id = /^[0-9]+$/;
                if (regex_id.test(studentId))
                {
                    $('#std_id_error').hide();
                }
                else
                {
                    $('#std_id_error').show();
                    e.preventDefault();
                    return; 
                }*/
            }

            var playerCount = $("#playersId option:selected").val();
            if (playerCount > 1)
            {
                var teamname = $('#teamname').val();
                if (teamname != "")
                {
                    $('#teamname_error').hide();
                }
                else
                {
                    $('#teamname_error').show();
                    e.preventDefault();
                    return;
                }

                var teamcaptain = $('#teamcaptain').val();
                if (teamcaptain != "")
                {
                    $('#teamcaptain_error').hide();
                }
                else
                {
                    $('#teamcaptain_error').show();
                    e.preventDefault();
                    return;
                }

                var oneMember = false;
                var hasComma = false;
                for (var i=0; i<playerCount - 1; i++)
                {
                    var teammember_id = "#teammember" + (i+1);
                    if ($(teammember_id).val() != "")
                    {
                        oneMember = true;   
                        break;
                    }
                }
                
                if (oneMember == true)
                {
                    $('#teammembers_error').hide();
                }
                else
                {
                    $('#teammembers_error').show();
                    e.preventDefault();
                    return;
                }
                
                var arr_teammembers = [];
                var teammembers = "";
                for (var i=0; i<playerCount - 1; i++)
                {
                    var teammember_id = "#teammember" + (i+1);
                    arr_teammembers.push($(teammember_id).val());
                }
                teammembers = arr_teammembers.join();
                $("#teammembers").val(teammembers);
            }
            
            let result;
            $.ajax({
                url : "<?php echo base_url(); ?>canRegisterForHunt",
                type : 'post',
                async : false,
                data : {schoolId : $("#selSchoolId").val()},
                success : function(res) {
                    res = JSON.parse(res);
                    result = res;
                },
                error : function(res, err) {
                    console.log(err);
                }
            });
            if(!result.status){
                displayError(result.msg);
                return;
            }

            form.attr("action", "<?php echo base_url(); ?>searchTeam/1");
            form.submit();
        });
    });

    function getTeamInfo(playersNum)
    {
        var playerCount = eval(playersNum);
        if (playerCount == 1)
        {   
            jQuery("#team_info").hide();
        }
        else
        {
            jQuery("#team_info").show();
            jQuery("#teammembers_group").html("");
            var teammembers_group="";
            for (var i=0; i<playerCount - 1; i++)
            {
                teammembers_group += 'Player ' + (i+1) + ': ';
                teammembers_group += '<input id="teammember' + (i+1) + '" type="text" class="form-control" placeholder="Name" name="teammember' + (i+1) + '" required />';
                teammembers_group += '<br>';
            }
            jQuery("#teammembers_group").html(teammembers_group);
        }
    }

    function setEntryTitle()
    {
        $("#entryTitle").text("Player entry form for " + $("#selSchoolId option:selected").text());
        var idx = $("#selSchoolId option:selected").index();
        if (arrStdIdRequired[idx] == 0)
            jQuery("#stdId_info").hide();
        else
            jQuery("#stdId_info").show();
        $("#schoolId").val($("#selSchoolId").val());
    }

</script>