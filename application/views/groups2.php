<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Group Management
      </h1>
    </section>
    <section class="content">
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
                
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Institution/College<br>/University</th>
                        <th>Number of players<br>in your group</th>
                        <th>On the same<br> device?</th>
                        <th>Team Name</th>
                        <th>Captain</th>
                        <th>Other Members</th>
                    </tr>
                    <?php
                    if(!empty($groups))
                    {
                        foreach($groups as $record)
                        {
                    ?>
                    <tr id="<?php echo $record["id"] ?>">
                        <td style="vertical-align:middle;"><?php echo $record["email"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["fullname"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["stdId"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["schoolname"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["playerscount"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["samedevice"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["teamname"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["captain"] ?></td>
                        <td style="vertical-align:middle;"><?php echo $record["members"] ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<!--
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
-->
<script type="text/javascript">
    var schoolId = "<?php echo $schoolId?>";
    jQuery(document).ready(function(){
        jQuery('#schoolId').val(schoolId);
        jQuery('#schoolId').change(function (e) {
            e.preventDefault();
            jQuery("#searchList").attr("action", baseURL + "groupListing");
            jQuery("#searchList").submit();
        });
    });
</script>
