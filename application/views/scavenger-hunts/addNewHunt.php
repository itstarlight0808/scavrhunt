<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Create a Scavenger Hunt
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
                    <form role="form" id="addHunt" action="<?php echo base_url() ?>insertHunt" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/hunt-logo.png" width="200px" height="200px"/>
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
                                        <input type="text" class="form-control required" value="<?php echo set_value('huntname'); ?>" id="huntname" name="huntname" maxlength="255">
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
                                        <label for="typeId">Type</label>
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
                                        <input type="text" class="form-control required" value="" id="startDay" name="startDay" maxlength="255"/>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="startTime">Start Time</label>
                                        <input type="text" class="form-control required" value="" id="startTime" name="startTime" maxlength="255"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endDay">End Day</label>
                                        <input type="text" class="form-control required" value="" id="endDay" name="endDay" maxlength="255"/>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="endTime">End Time</label>
                                        <input type="text" class="form-control required" value="" id="endTime" name="endTime" maxlength="255"/>
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
                                        <input type="number" class="form-control required" value="" id="maxTime" name="maxTime" min="1" max="60"/>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer" align="right">
                            <input type="submit" class="btn btn-primary" value="Create" />
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

<script language="javascript">
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
        
    });

    function setSchoolLogo(obj)
    {
        
    }

    function goBack()
    {
        location.href = "<?php echo base_url(); ?>manageHunt";
    }

    function setHuntActive(obj)
    {
        if (obj.checked)
            obj.value = "1";
        else
            obj.value = "0"; 
    }
</script>