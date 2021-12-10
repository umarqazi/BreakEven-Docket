<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<div class="col-lg-12">
<?= script_tag('js/demo-files/pages-mailbox.js') ?>
<?= script_tag('js/optional/ckeditor/ckeditor.js') ?>
<?= script_tag('js/optional/ckeditor/adapters/jquery.js') ?>
<?= script_tag('js/optional/misc/typeahead.bundle.min.js') ?>
<?= script_tag('js/optional/bootstrap-tagsinput.min.js') ?>

	<h2>Signature</h2>
	<form method="post" action="<?php echo base_url()?>/admin/update_signature" enctype="multipart/form-data">
		<div class="form-group email-body-container">
			<textarea id="job_templates" class="form-control signature-body" name="signature" rows="100" required><?= isset($signature[0]['signature']) ? $signature[0]['signature'] : '' ?></textarea>
		</div>
        <input type="hidden" name="signature_id" value="<?= (isset($signature[0]['id'])) ? $signature[0]['id'] : '' ?>" >
		<div class="form-group signature-images">
			<label for="signature-image"><h2>Signature Image</h2></label>
			<div class="clearfix"></div>

			<?php //if (!empty($signature['image'])){?>
				<!-- <img src="<?php //echo $super_admin_folder['signature_web_path'].$signature['image'];?>" class="signature-image" alt="Upload Image" id="databaseImage"> -->
			<?php //}?>

		</div>
		<div class="errors">
			<p id="error1" style="display:none; color:#FF0000;">
				Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
			</p>
			<p id="error2" style="display:none; color:#FF0000;">
				Maximum File Size Limit is 5MB.
			</p>
			<p id="error3" style="display:none; color:#FF0000;">
				Max Width Must Be 1024px And Max Height Must Be 768px
			</p>
		</div>
		<div class="fileUpload">
			<label class="btn btn-default btn-file">
				Browse <input id="fileupload" type="file" name="userfile" style="display: none;">
			</label>
			<input type="submit" class="btn btn-info btn-xs edit-button update_signature" value="Update Signature">
		</div>
	</form>
</div>

<script>
    $("#job_templates").ckeditor();
    var a=0;
    $('#fileupload').bind('change', function() {
        var ext = $('#fileupload').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error1').slideDown("slow");
            $('#error2').slideUp("slow");
            $('#error3').slideUp("slow");
            $("#fileupload").val('');
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 5000000){
                $('#error2').slideDown("slow");
                $('#error1').slideUp("slow");
                $('#error3').slideUp("slow");
                $("#fileupload").val('');
            }else{
                var file = $(this)[0].files[0];
                img = new Image();
                img.src = URL.createObjectURL(file);
                img.onload = function(){
                    if(this.width <= 1024 && this.height <= 768){
                        $('#error1').slideUp("slow");
                        $('#error2').slideUp("slow");
                        $('#error3').slideUp("slow");
                        var reader = new FileReader();
                        reader.onload = function(){
                            var output = document.getElementById('image_preview');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(file);
                    }else{
                        $('#error1').slideUp("slow");
                        $('#error2').slideUp("slow");
                        $('#error3').slideDown("slow");
                        $("#fileupload").val('');
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection()?>