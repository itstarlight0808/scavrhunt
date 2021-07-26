<head>
    <meta http-equiv="refresh" content="60">
</head>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Group Management
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Group List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>groupListing" method="POST" id="searchList">
                                <div class="input-group">
                            
                                    <select id="schoolId" name="schoolId" class="form-control input-sm pull-right" style="width: 200px;">
                                        <option value="0" selected>All</option>
                                    <?php
                                        foreach ($allSchools as $record)
                                        {
                                    ?>
                                        <option value="<?php echo $record->id?>"><?php echo $record->sch_name?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                    <span class="pull-right" style="text-align:right;"><h5>Schools&nbsp;:&nbsp;</h5></span>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                </div>
            </div>
        </div>
                
        <div class="row">
            <div class="col-md-12" style="overflow:auto;">
                <table class="table table-striped table-bordered table-sm table-responsive table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Institution/College<br>/University</th>
                        <th>Number of players<br>in your group</th>
                        <th>On the same<br> device?</th>
                        <th>Team Name</th>
                        <th>Captain</th>
                        <th>Other Members</th>
                        <th>Room No</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($groups))
                    {
                        foreach($groups as $record)
                        {
                    ?>
                    <tr id="<?php echo $record["id"] ?>">
                        <td style="vertical-align:middle;"><?php echo $record["logged_in"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["email"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["fullname"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["stdId"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["schoolname"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["playerscount"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["samedevice"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["teamname"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["captain"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["members"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["roomno"] ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
            
    </section>
</div>

<script type="text/javascript">
    var schoolId = "<?php echo $schoolId?>";
    jQuery(document).ready(function(){
        jQuery('#schoolId').val(schoolId);
        jQuery('#schoolId').change(function (e) {
            e.preventDefault();
            jQuery("#searchList").attr("action", baseURL + "groupListing");
            jQuery("#searchList").submit();
        });

        var subtitle = "Group Management";
        jQuery('#myTable').DataTable({
            dom: 'lBfrtip',
            buttons: [{
                extend: 'csv',
                text: 'Export to CSV',
				title: subtitle,
				download: 'open',
				orientation:'landscape'
            }]
        });
        jQuery('.dataTables_length').addClass('bs-select');
    });
</script>
