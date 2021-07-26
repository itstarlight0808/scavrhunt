<?php
$schoolId = $schoolInfo->id;
$schoolname = $schoolInfo->sch_name;
$schoollogo = $schoolInfo->sch_logo;
$schoollogo2 = $schoolInfo->sch_logo2;
$schooladdr = $schoolInfo->sch_address;
$zoomAccountId = $schoolInfo->zoom_account_id;
$isactive = $schoolInfo->is_active;
$stdIdRequired = $schoolInfo->std_id_required;
$schooldetails = $schoolInfo->sch_details;
//$schoolLinkId = $schoolInfo->sch_link_id;
$zoomlink = $schoolInfo->zoom_link;
$videoId = $schoolInfo->video_id;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> School Management
        <small>Add / Edit School</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter School Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>updateSchool" method="post" id="editschool" enctype="multipart/form-data">
                        <div class="box-body">
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <img class="img-responsive" src="<?php echo base_url(). "assets/uploads/logo/" . $schoollogo2; ?>" width="200px" height="200px"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="schoollogo">School Logo</label>
                                        <input type="file" class="form-control required" value="" id="schoollogo" name="schoollogo" maxlength="255">
                                        <input type="hidden" value="<?php echo $schoolId; ?>" name="schoolId" id="schoolId" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="schoolname">School Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $schoolname; ?>" id="schoolname" name="schoolname" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="schooladdr">School Address</label>
                                        <input type="text" class="form-control" value="<?php echo $schooladdr; ?>" id="schooladdr" name="schooladdr" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="accountId">Zoom Account</label>
                                        <select id="accountId" name="accountId" class="form-control required">
                                        <?php
                                            foreach ($allZoomAccounts as $record)
                                            {
                                        ?>
                                            <option value="<?php echo $record->id?>"><?php echo $record->account_name?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <br>
                                        <input type="checkbox" value="0" onclick="setSchoolActive(this);" id="isactive" name="isactive">
                                        <label for="isactive">Active</label>
                                        <br>
                                        <input type="checkbox" value="0" onclick="setStudentIdRequired(this);" id="stdIdRequired" name="stdIdRequired">
                                        <label for="isactive">Student ID Required</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="schooldetails">School Details</label>
                                        <input type="text" class="form-control" value="<?php echo $schooldetails; ?>" id="schooldetails" name="schooldetails" maxlength="255"/>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="schoolLinkId">School ID</label>
                                        <input type="text" class="form-control required" value="<?php echo $schoolLinkId; ?>" id="schoolLinkId" name="schoolLinkId" maxlength="255"/>
                                    </div>
                                </div>
                                -->
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="zoomlink">Target Page</label>
                                        <input type="text" class="form-control required" value="<?php echo $zoomlink; ?>" id="zoomlink" name="zoomlink" maxlength="255"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="videoId">Video ID</label>
                                        <input type="text" class="form-control" value="<?php echo $videoId; ?>" id="videoId" name="videoId" maxlength="255"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Cancel" onclick="goBack();"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editSchool.js" type="text/javascript"></script>
<script language="javascript">
    var zoomAccountId = "<?php echo $zoomAccountId;?>";
    var isactive = "<?php echo $isactive;?>";
    var stdIdRequired = "<?php echo $stdIdRequired;?>";

    jQuery(document).ready(function(){
        $("#accountId").val(zoomAccountId);
        $("#isactive").val(isactive);
        $("#stdIdRequired").val(stdIdRequired);
        if (isactive == "1")
            $("#isactive").attr("checked", "checked");
        else
            $("#isactive").removeAttr("checked");
        if (stdIdRequired == "1")
            $("#stdIdRequired").attr("checked", "checked");
        else
            $("#stdIdRequired").removeAttr("checked");
    });

    function setSchoolActive(obj)
    {
        if (obj.checked)
            obj.value = "1";
        else
            obj.value = "0"; 
    }

    function setStudentIdRequired(obj)
    {
        if (obj.checked)
            obj.value = "1";
        else
            obj.value = "0"; 
    }

    function goBack()
    {
        location.href = "<?php echo base_url(); ?>schoolListing";
    }
    
</script>