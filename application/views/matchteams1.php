<!DOCTYPE html>

<style>
    .active2{
        color: white;
        background-color: orange;
    }
</style>

<div class="content-wrapper">
    <div class="selteam-box">
        <div class="login-box-body">
            <h1><p class="login-box-msg">Select a matching team</p></h1>
            <form method="post" id="selteam_form" name="selteam_form" novalidate>
                <table class="table table-bordered" id="teamTable">
                    <tr>
                        <th>Team Name</th>
                        <th>Captain</th>
                        <th>Members</th>
                        <th class="text-center"></th>
                    </tr>
                    <?php
                    if(count($matchTeams) > 0)
                    {
                        foreach($matchTeams as $record)
                        {
                    ?>
                    <tr class="clickable-row">
                        <td><?php echo $record->team_name ?></td>
                        <td><?php echo $record->captain ?></td>
                        <td><?php echo $record->members ?></td>
                        <td>
                            <input type="radio" name="rd_team" value="<?php echo $record->id ?>"/>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    if(count($matchTeams) > 0)
                    {
                    ?>
                    <tr class="clickable-row active2">
                        <td colspan="3">None of these are my team</td>
                        <td>
                            <input type="radio" name="rd_team" value="0" checked/>
                        </td>
                    </tr>
                    <?php
                    }else{
                    ?>
                    <tr class="clickable-row active2">
                        <td colspan="4">No matching teams</td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <div class="row">
                    <div class="col-md-12 col-xs-12" align="center">
                        <input id="btn_hardersearch" type="button" class="btn btn-primary btn-flat" value="Search Harder" style="width:30%;"/>
                        <?php
                        if(count($matchTeams) > 0)
                        {
                        ?>
                        <input id="btn_submit" type="button" class="btn btn-primary btn-flat" value="Select This Team" style="width:30%;"/>
                        <?php
                        }
                        ?>
                        <input id="btn_stopsearch" type="button" class="btn btn-primary btn-flat" value="Stop Search" style="width:30%;"/>
                        
                        <input type="hidden" id="fullname" name="fullname" value="<?php echo $fullname; ?>"/>
                        <input type="hidden" id="playerId" name="playerId" value="<?php echo $playerId; ?>"/>
                        <input type="hidden" id="selTeamId" name="selTeamId" value=""/>
                        <input type="hidden" id="schoolId" name="schoolId" value="<?php echo $schoolId; ?>"/>
                        <input type="hidden" id="teamname" name="teamname" value="<?php echo $teamname; ?>"/>
                        <input type="hidden" id="playersNum" name="playersNum" value="<?php echo $playersNum; ?>"/>
                        <input type="hidden" id="samedevice" name="samedevice" value="<?php echo $samedevice; ?>"/>
                        <input type="hidden" id="teamcaptain" name="teamcaptain" value="<?php echo $teamcaptain; ?>"/>
                        <input type="hidden" id="teammembers" name="teammembers" value="<?php echo $teammembers; ?>"/>
                        <input type="hidden" id="loggedbefore" name="loggedbefore" value="<?php echo $loggedbefore; ?>"/>
                    </div><!-- /.col -->
                </div>
            </form>
        </div>
    </div>
</div>
<script language="javascript">
    jQuery(document).ready(function(){
        /*$('#teamTable').on('click', '.clickable-row', function(event) {
            $(this).addClass('active2').siblings().removeClass('active2');
        });*/

        $('#teamTable tr').click(function (event) {
            if (event.target.type !== 'radio') {
                $(':radio', this).trigger('click');
            }
        });

        $("input[type='radio']").change(function (e) {
            e.stopPropagation();
            $('#teamTable tr').removeClass("active2");        
            if ($(this).is(":checked")) {
                $(this).closest('tr').addClass("active2");
            }     
        });

        jQuery("#btn_submit").click(function(){
            $("#selTeamId").val($("input[type='radio']:checked").val());
            var form = $("form#selteam_form");
            form.attr("action", "<?php echo base_url(); ?>selectTeam");
            form.submit();
        });

        jQuery("#btn_hardersearch").click(function(){
            var form = $("form#selteam_form");
            form.attr("action", "<?php echo base_url(); ?>searchTeam/2");
            form.submit();
        });

        jQuery("#btn_stopsearch").click(function(){
            $("#selTeamId").val('0');
            var form = $("form#selteam_form");
            form.attr("action", "<?php echo base_url(); ?>selectTeam");
            form.submit();
        });
    });
</script>