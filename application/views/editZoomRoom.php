<?php

$roomId = $zoomRoomInfo->id;
$accountId = $zoomRoomInfo->zoom_account_id;
$accountname = $zoomRoomInfo->account_name;
$roomno = $zoomRoomInfo->room_no;
$statusId = $zoomRoomInfo->status_id;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Zoom Room Management
        <small>Add / Edit Zoom Account</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Zoom Room Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>updateZoomRoom" method="post" id="editZoomRoom" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="accountname">Zoom Account</label>
                                        <input type="text" class="form-control" id="accountname" readonly="readonly" value="<?php echo $accountname; ?>" name="accountname" maxlength="256">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Room No</label>
                                        <input type="text" class="form-control required digits" id="roomno" readonly="readonly" value="<?php echo $roomno; ?>" name="roomno" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="statusId">Zoom Link</label>
                                        <input type="text" class="form-control" id="statusId" placeholder="Zoom Link" name="statusId" value="<?php echo $statusId; ?>" maxlength="256">
                                        <input type="hidden" value="<?php echo $roomId; ?>" name="roomId" id="roomId" />    
                                        <input type="hidden" value="<?php echo $accountId; ?>" name="accountId" id="accountId" />
                                    </div>
                                    
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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

<script src="<?php echo base_url(); ?>assets/js/editZoomRoom.js" type="text/javascript"></script>