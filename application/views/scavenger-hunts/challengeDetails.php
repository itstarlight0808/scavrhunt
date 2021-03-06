<?php
    $huntId = $challengeInfo->hunt_id;
    $challengeName = $challengeInfo->chg_name;
    $challengeDescription = $challengeInfo->description;
    $challengePage = $challengeInfo->puzzle_page;
    $challengeAnswer = $challengeInfo->puzzle_answer;
    //$multiAnswer = $challengeInfo->multi_answer;
    $challengePoints = $challengeInfo->points;
    $typeId = $challengeInfo->chg_type_id;
    //$challengeImage = $challengeInfo->chg_image;
    //$challengeImage2 = $challengeInfo->chg_image2;
    $challengeLink = $challengeInfo->chg_link;

    $challengePage = str_replace('href="assets', 'href="../assets', $challengePage);
    $challengePage = str_replace('<img class="img-responsive" src="assets', '<img src="../assets', $challengePage);
?>
<head>
    <script src="<?php echo base_url(); ?>assets/libs/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/tinymce/jquery.tinymce.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
</head>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Challenge Details
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Challenge Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editChallenge" name="editChallenge" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="challengeName">Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $challengeName; ?>" id="challengeName" name="challengeName" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="challengePoints">Point Value</label>
                                        <input type="number" class="form-control required" value="<?php echo $challengePoints; ?>" id="challengePoints" name="challengePoints" min="1" max="10000"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="challengeDescription">Description</label>
                                        <input type="text" class="form-control required" value="<?php echo $challengeDescription; ?>" id="challengeDescription" name="challengeDescription" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="typeId">Type</label>
                                        <select id="typeId" name="typeId" class="form-control required">
                                        <?php
                                            foreach ($challengesTypes as $record)
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
                                        <div id="allow_photo">
                                            <br>
                                            <input type="checkbox" id="allowPhoto" name="allowPhoto" value="0">&nbsp;&nbsp;&nbsp;Allow Upload
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="photo_upload_area">
                                <div class="col-md-6">                                
                                    <div class="form-group"><!-- -->
                                        <img class="img-responsive" id="challengeLogo" name="challengeLogo" width="320px" height="240px"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div id="photo_type">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="rd_photo1" name="rd_photo" value="1" checked onclick="showImageUploadForm();"/>
                                                <label class="form-check-label" for="rd_photo1">File Upload</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="rd_photo2" name="rd_photo" value="2" onclick="showLiveCaptureForm();"/>
                                                <label class="form-check-label" for="rd_photo2">Live Capture</label>
                                            </div>
                                            <input type="hidden" id="photoType" name="photoType" value="1"/>
                                        </div>
                                        <br>
                                        <label>Image for Challenge</label>
                                        <input accept="image/jpeg, image/png" autocomplete="off" type="file" tabindex="-1" class="form-control required" value="" id="challengeImage" name="challengeImage" maxlength="255"/>
                                        <br>
                                        <p id="uploadedUri" class="text-success"></p>
                                        <br>
                                        <input type="button" id="btn_photo_upload" class="btn btn-success" value="Upload Photo" onClick="photo_upload()"/>
                                        <br>
                                        <br>
                                        <div id="captureControls">
                                            <input type="button" class="btn btn-info" value="Take Snapshot" onClick="take_snapshot()"/>
                                            <input type="hidden" name="imageCaptured" class="image-tag" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="photo_captured">
                                <div class="col-md-12">
                                    <div id="my_camera"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="chgPuzzlePage">Puzzle Page</label>
                                        <textarea id="chgPuzzlePage" name="chgPuzzlePage"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="answer_area">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="challengeAnswer">Answer</label>
                                        <input type="text" class="form-control" value="<?php echo $challengeAnswer; ?>" id="challengeAnswer" name="challengeAnswer" placeholder="If there are multiple answers, please separate them by comma(,)." maxlength="255"/>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-4">                                
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="rd_single" name="multiAnswer" value="0"/>
                                        <label class="form-check-label" for="rd_single">Single</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="rd_multi" name="multiAnswer" value="1"/>
                                        <label class="form-check-label" for="rd_multi">Multiple</label>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="challengeLink">Link</label>
                                        <input type="text" class="form-control required" value="<?php echo $challengeLink; ?>" id="challengeLink" name="challengeLink" maxlength="255"/>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer" align="right">
                            <input type="hidden" id="challengeId" name="challengeId" value="<?php echo $challengeId;?>"/>
                            <input type="hidden" id="challengePage" name="challengePage" value=""/>
                            <input type="button" class="btn btn-primary" id="btn_submit" value="Update"/>
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
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
</div>

<script language="javascript">
    var huntId = eval("<?php echo $huntId; ?>");
    var cam_width = 0, cam_height = 0;
    var cur_photo_type = 1;
    var chgPuzzlePage = '<?php echo str_replace("'", "\'", $challengePage);?>';
    //var multiAnswer = eval("<?php //echo $multiAnswer; ?>");
    var typeId = eval("<?php echo $typeId;?>");
    var uploadImageName = "";
    jQuery(document).ready(function(){
        tinymce.init({
            selector: '#chgPuzzlePage',
            height: 400,
            menubar: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat image link | help',
            setup: function(editor){
                editor.on('init', function(e){
                    editor.setContent(chgPuzzlePage);
                });
            }
        });

        // Prevent jQuery UI dialog from blocking focusin
        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
                e.stopImmediatePropagation();
            }
        });

        cam_width = Math.floor($("#editChallenge").width()) - 20;
        cam_height = Math.floor(cam_width*3/4);
        
        $("#challengeImage").change(function(){
            readImageURL(this);
        });
        $("#typeId").val(typeId);
        
        Webcam.set({
            width: cam_width,
            height: cam_height,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
    
        Webcam.attach('#my_camera');

        $("#typeId").change(function(){
            showPhotoForm();
            showAnswerArea();
        });
        showPhotoForm();
        showAnswerArea();
        
        $("#allowPhoto").change(function(){
            var chkPhoto = eval($("#allowPhoto").val());
            if (chkPhoto == 0)
                chkPhoto = 1;
            else
                chkPhoto = 0;
            $("#allowPhoto").val(chkPhoto);
            showPhotoForm();
        });

        $("#btn_submit").click(function(){
            var type_id = eval($("#typeId").val());
            var chgAnswer = $("#challengeAnswer").val();
            if (type_id > 1 && chgAnswer == "")
            {
                alert("You should type an answer.");
                return;
            }
            var chgPage = tinymce.get("chgPuzzlePage").getContent();
            $("#challengePage").val(chgPage);
            var form = $("form#editChallenge");
            form.attr("action", "<?php echo base_url(); ?>updateChallenge");
            form.submit();
        });

        /*if (multiAnswer == 0)
        {
            $("#rd_single").attr("checked", true);
        }
        else
        {
            $("#rd_multi").attr("checked", true);
        }*/
    });

    function showAnswerArea()
    {
        var type_id = eval($("#typeId").val());
        if (type_id == 1)
            $("#answer_area").hide();
        else
            $("#answer_area").show();
    }

    function showPhotoForm()
    {
        var type_id = eval($("#typeId").val());
        if (type_id == 1)
        {
            $("#allow_photo").hide();
            $("#photo_type").show();
            $("#photo_upload_area").show();
            if (cur_photo_type == 1)
            {
                $("#challengeImage").show();
                $("#captureControls").hide();
                $("#photo_captured").hide();
            }
            else
            {
                $("#challengeImage").hide();
                $("#captureControls").show();
                $("#photo_captured").show();
            }
        }
        else if (type_id == 2)
        {
            $("#allow_photo").show();
            var chkPhoto = eval($("#allowPhoto").val());
            if (chkPhoto == 0)
            {
                $("#photo_type").hide();
                $("#photo_upload_area").hide();
                $("#photo_captured").hide();
            }
            else
            {
                $("#photo_type").show();
                $("#photo_upload_area").show();
                if (cur_photo_type == 1)
                {
                    $("#challengeImage").show();
                    $("#captureControls").hide();
                    $("#photo_captured").hide();
                }
                else
                {
                    $("#challengeImage").hide();
                    $("#captureControls").show();
                    $("#photo_captured").show();
                }
            }
        }
        else
        {

        }
    }

    function showImageUploadForm()
    {
        cur_photo_type = 1;
        $("#challengeImage").show();
        $("#captureControls").hide();
        $("#photo_captured").hide();
        $("#photoType").val(cur_photo_type);
    }

    function showLiveCaptureForm()
    {
        cur_photo_type = 2;
        $("#challengeImage").hide();
        $("#captureControls").show();
        $("#photo_captured").show();
        $("#photoType").val(cur_photo_type);
    }

    function goBack()
    {
        location.href = "<?php echo base_url(); ?>manageChallenges/<?php echo $huntId; ?>";
    }

    function readImageURL(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            uploadImageName = input.files[0].name;
            reader.onload = function(e) 
            {
                $('#challengeLogo').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    function take_snapshot() 
    {
        Webcam.snap( function(data_uri) {
            uploadImageName = "";
            $(".image-tag").val(data_uri);
            $("#challengeLogo").attr("src", data_uri);
        } );
    }

    function photo_upload()
    {
        var imgUri = "";
        if (cur_photo_type == 1)
        {
            imgUri = $("#challengeLogo").attr("src");
        }
        else
        {
            imgUri = $(".image-tag").val();
        }
        
        if (imgUri.length == 0)
        {
            alert("Please select an image file.");
            return;    
        }

        var post_url = "<?php echo base_url(); ?>uploadChallengeImage";
        $.post(post_url, 
            {
                huntId: huntId,
                uploadFileName: uploadImageName,
                imgUri: imgUri
            }, 
            function(res)
            {
                $("#uploadedUri").html(res);
            }
        );        
    }

</script>