<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Manage Challenges
        <small>Search, Copy, Edit, Delete, Create</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addChallenge/<?php echo $huntId; ?>"><i class="fa fa-plus"></i>Create a New Challenge</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Challenge List</h3>
                    </div><!-- /.box-header -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12" id="schoolsDiv" style="overflow:auto;">
                <table class="table table-striped table-bordered table-responsive table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Points</th>
                        <!--
                        <th>Puzzle Page</th>
                        <th>Image</th>
                        -->
                        <th>Type</th>
                        <th>Link</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($challenges))
                    {
                        foreach($challenges as $k => $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $k+1; ?></td>
                        <td><?php echo $record["challengename"] ?></td>
                        <td><?php echo $record["description"] ?></td>
                        <td><?php echo $record["points"] ?></td>
                        <!--
                        <td><?php echo $record["puzzlepage"] ?></td>
                        <td>
                            <?php
                                if ($record["challengeImage"] != ""){
                            ?>
                            <img src="<?php echo base_url() . "assets/uploads/challenges/" . $huntId . "/" . $record["challengeImage"] ?>" class="img-responsive" width="100px" height="100px"/>
                            <?php
                                }
                            ?>
                        </td>
                        -->
                        <td><?php echo $record["challengetype"] ?></td>
                        <td><?php echo $record["challengelink"] ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'gotoChallengeDetails/'.$record["id"]; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'copyChallenge/'.$record["id"]; ?>" title="Copy"><i class="fa fa-copy"></i></a>
                            <a class="btn btn-sm btn-danger" title="Delete" onclick="deleteChallenge(<?php echo $record['id']; ?>)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Points</th>
                        <!--
                        <th>Puzzle Page</th>
                        <th>Image</th>
                        -->
                        <th>Type</th>
                        <th>Link</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        var subtitle = "Challenge Management";

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

    function deleteChallenge(challengeId)
    {
        if (!confirm("Are you sure to delete this challenge?"))
            return;
        location.href = "<?php echo base_url().'deleteChallenge/'; ?>" + challengeId;
    }
</script>