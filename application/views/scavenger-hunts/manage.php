<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Hunts
        <small>Search, Copy, Edit, Delete, Create</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addHunt"><i class="fa fa-plus"></i>Create a New Hunt</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Hunt List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>manageHunt" method="POST" id="searchList">
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
                                    <!--
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                    -->
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12" id="schoolsDiv" style="overflow:auto;">
                <table class="table table-striped table-bordered table-responsive table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>Header</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Delivery</th>
                        <th>School</th>
                        <th>Active/<br>Deactive</th>
                        <th>Start Day/Time</th>
                        <th>End Day/Time</th>
                        <th>Maximum Time</th>
                        <th>Hunt Link</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($huntInfos))
                    {
                        foreach($huntInfos as $record)
                        {
                    ?>
                    <tr>
                        <td><img src="<?php echo base_url() . "assets/uploads/logo2/" . $record["headerImg"] ?>" class="img-responsive" width="100px" height="100px"/></td>
                        <td><?php echo $record["huntname"] ?></td>
                        <td><?php echo $record["typename"] ?></td>
                        <td><?php echo $record["deliveryname"] ?></td>
                        <td><?php echo $record["schoolname"] ?></td>
                        <td><?php $str_active = (intval($record["isactive"]) == 1) ? "Active" : "Deactive"; echo $str_active;?></td>
                        <td><?php echo $record["startDay"] . "<br>" . $record["startTime"] ?></td>
                        <td><?php echo $record["endDay"] . "<br>" . $record["endTime"] ?></td>
                        <td><?php echo $record["maxTime"] ?></td>
                        <td><?php echo base_url() . "gotoHunt/?hunt=" . $record["id"];?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'gotoHuntDetails/'.$record["id"]; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'copyHunt/'.$record["id"]; ?>" title="Copy"><i class="fa fa-copy"></i></a>
                            <a class="btn btn-sm btn-danger" title="Delete" onclick="deleteHunt(<?php echo $record['id']; ?>)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Header</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Delivery</th>
                        <th>School</th>
                        <th>Active/<br>Deactive</th>
                        <th>Start Day/Time</th>
                        <th>End Day/Time</th>
                        <th>Maximum Time</th>
                        <th>Hunt Link</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </tfoot>
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
            jQuery("#searchList").attr("action", baseURL + "manageHunt/" + jQuery('#schoolId').val());
            jQuery("#searchList").submit();
        });
    
        var subtitle = "Hunt Management";

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

    function deleteHunt(huntId)
    {
        if (!confirm("Are you sure to delete this hunt game?"))
            return;
        location.href = "<?php echo base_url().'deleteHunt/'; ?>" + huntId;
    }
</script>