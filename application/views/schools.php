<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> School Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addSchool"><i class="fa fa-plus"></i>Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">School List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>schoolListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <select id="accountId" name="accountId" class="form-control input-sm pull-right" style="width: 200px;">
                                        <option value="0" selected>All</option>
                                    <?php
                                        foreach ($allZoomAccounts as $record)
                                        {
                                    ?>
                                        <option value="<?php echo $record->id?>"><?php echo $record->account_name?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                    <span class="pull-right" style="text-align:right;"><h5>Zoom Accounts&nbsp;:&nbsp;</h5></span>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12" id="schoolsDiv" style="overflow-x:auto;overflow-y:scroll;">
                <table class="table table-striped table-bordered table-responsive table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Zoom Account</th>
                        <th>Active/<br>Deactive</th>
                        <th>Target Page</th>
                        <th>Video ID</th>
                        <th>Subdomain</th>
                        <th>School Link</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($schools))
                    {
                        foreach($schools as $record)
                        {
                    ?>
                    <tr>
                        <td><img src="<?php echo base_url() . "assets/uploads/logo/" . $record->sch_logo2 ?>" class="img-responsive" width="100px" height="100px"/></td>
                        <td><?php echo $record->sch_name ?></td>
                        <td><?php echo $record->sch_address ?></td>
                        <td><?php echo $record->account_name ?></td>
                        <td><?php $str_active = ($record->is_active == "1") ? "Active" : "Deactive"; echo $str_active;?></td>
                        <td><?php echo $record->zoom_link ?></td>
                        <td><?php echo $record->video_id ?></td>
                        <td><?php echo $record->subdomains ?></td>
                        <td><?php echo CUSTOM_SCHOOL_URL . $record->id ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editSchool/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteSchool" href="#" data-userid="<?php echo $record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
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
<!--
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
-->
<script type="text/javascript">
    var accountId = "<?php echo $accountId?>";
    jQuery(document).ready(function(){

        jQuery('#accountId').change(function (e) {
            e.preventDefault();
            var cur_zoom_account = jQuery(this).val();
            jQuery("#searchList").attr("action", baseURL + "schoolListing");
            jQuery("#searchList").submit();
        });
        
        jQuery('#accountId').val(accountId);

        jQuery('.deleteSchool').click(function(){
            var schoolId = $(this).data("userid"),
			hitURL = baseURL + "deleteSchool",
			currentRow = $(this);
		
            var confirmation = confirm("Are you sure to delete this school?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { schoolId : schoolId } 
                }).done(function(data){
                    console.log(data);
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("School successfully deleted"); }
                    else if(data.status = false) { alert("School deletion failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });

        var subtitle = "School Management";
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
