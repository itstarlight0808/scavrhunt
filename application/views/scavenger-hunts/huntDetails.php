<?php
    $huntId = $huntInfo->id;
    $huntname = $huntInfo->hunt_name;
    $schoolId = $huntInfo->school_id;
    $isactive = $huntInfo->is_active;
    $huntlogo = $huntInfo->hunt_logo;
    $huntlogo2 = $huntInfo->hunt_logo2;
    $typeId = $huntInfo->type_id;
    $deliveryId = $huntInfo->delivery_id;
    $startDay = $huntInfo->start_date;
    $startTime = $huntInfo->start_time;
    $endDay = $huntInfo->end_date;
    $endTime = $huntInfo->end_time;
    $maxTime = $huntInfo->max_time;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Hunt Details
        <small>Edit</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Hunt Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editHunt" action="<?php echo base_url() ?>updateHunt" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <img class="img-responsive" src="<?php echo base_url() . "assets/uploads/logo2/" . $huntlogo2; ?>" width="200px" height="200px"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="huntlogo">Header</label>
                                        <input accept="image/jpeg, image/png" autocomplete="off" type="file" tabindex="-1" class="form-control required" value="" id="huntlogo" name="huntlogo" maxlength="255" onchange="sethuntlogo(this);">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="huntname">Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $huntname; ?>" id="huntname" name="huntname" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <input type="checkbox" value="0" onclick="setHuntActive(this);" id="isactive" name="isactive">
                                        <label for="isactive">Active</label>    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="typeId">Types</label>
                                        <select id="typeId" name="typeId" class="form-control required">
                                        <?php
                                            foreach ($huntTypes as $record)
                                            {
                                        ?>
                                            <option value="<?php echo $record->id;?>"><?php echo $record->name;?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="deliveryId">Delivery</label>
                                        <select id="deliveryId" name="deliveryId" class="form-control required">
                                        <?php
                                            foreach ($huntDelivery as $record)
                                            {
                                        ?>
                                            <option value="<?php echo $record->id;?>"><?php echo $record->name;?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startDay">Start Day</label>
                                        <input type="text" class="form-control required" value="<?php echo $startDay; ?>" id="startDay" name="startDay" maxlength="255"/>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="startTime">Start Time</label>
                                        <input type="text" class="form-control required" value="<?php echo substr($startTime,0,5); ?>" id="startTime" name="startTime" maxlength="255"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endDay">End Day</label>
                                        <input type="text" class="form-control required" value="<?php echo $endDay; ?>" id="endDay" name="endDay" maxlength="255"/>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="endTime">End Time</label>
                                        <input type="text" class="form-control required" value="<?php echo substr($endTime,0,5); ?>" id="endTime" name="endTime" maxlength="255"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="schoolId">School</label>
                                        <select id="schoolId" name="schoolId" class="form-control required">
                                        <?php
                                            foreach ($schools as $record)
                                            {
                                        ?>
                                            <option value="<?php echo $record->id?>"><?php echo $record->sch_name?></option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maxTime">Maximum Time (Minutes)</label>
                                        <input type="number" class="form-control required" value="<?php echo $maxTime; ?>" id="maxTime" name="maxTime" min="1" max="60"/>
                                    </div>
                                </div>
                                
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <!--
                                        <input type="button" class="btn btn-success" value="Start Game" onclick="setStart();"/>
                                        -->
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group" align="right">
                                        <input type="hidden" value="<?php echo $huntId; ?>" name="huntId" id="huntId" />
                                        <input type="submit" class="btn btn-primary" value="Submit" />
                                        <input type="reset" class="btn btn-default" value="Cancel" onclick="goBack();"/>
                                    </div>
                                </div>
                            </div>
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
<script type="text/javascript">
    var typeId = "<?php echo $typeId;?>";
    var deliveryId = "<?php echo $deliveryId;?>";
    var schoolId = "<?php echo $schoolId;?>";
    var isactive = "<?php echo $isactive;?>";
    jQuery(document).ready(function(){
        $("#startDay").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#startTime").timepicker({
            timeFormat: 'HH:mm'
        });
        $("#endDay").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#endTime").timepicker({
            timeFormat: 'HH:mm'
        });

        $("#typeId").val(typeId);
        $("#deliveryId").val(deliveryId);
        $("#schoolId").val(schoolId);
        $("#isactive").val(isactive);
        if (isactive == "1")
            $("#isactive").attr("checked", "checked");
        else
            $("#isactive").removeAttr("checked");
    });

    function setHuntActive(obj)
    {
        if (obj.checked)
            obj.value = "1";
        else
            obj.value = "0"; 
    }

    function goBack()
    {
        location.href = "<?php echo base_url(); ?>manageHunt";
    }

    function setStart()
    {

    }
</script>