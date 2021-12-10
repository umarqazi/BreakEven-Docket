<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url()?>/settings" type="button" class="btn btn-primary btn-md" id="back_to_estimate" title="Back to Estimate Page">
            <i class="fa fa-arrow-left fa-fw"></i>Back to Settings
        </a>
    </div>
</div>
<div class="" id="successMessage">
    <?= view('App\Auth\_message_block') ?>
</div>
<h2 class="signature-heading">Signature</h2>
<form method="post" action="<?= route_to('update_signature'); ?>" enctype="multipart/form-data">
    <div class="form-group email-body-container">
        <textarea id="job_templates" class="form-control signature-body" name="signature_body" rows="100" required><?php echo $signature; ?></textarea>
    </div>
    <div class="form-group signature-images">
        <label for="signature-image"><h2>Signature Image</h2></label>
        <div class="clearfix"></div>

        <?php if (!empty($signature['image'])){?>
            <img src="<?php echo $signature_folder['mailbox_web_path'].$signature['image'];?>" class="signature-image"
                 alt="Upload Image" id="image_preview" style="height:150px; max-width:250px;">
        <?php }?>

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
<script>
    var rootPath = '<?php echo $_SERVER['DOCUMENT_ROOT'];?>';
    var connector = '<?php echo base_url()?>mailbox/connectors?>';
</script>
<?= script_tag('js/file_tree/jqueryFileTree.js') ?>
<?= script_tag('js/required/mailbox.js') ?>
<?= script_tag('js/demo-files/pages-mailbox.js') ?>
<?= script_tag('js/optional/ckeditor/ckeditor.js') ?>
<?= script_tag('js/optional/ckeditor/adapters/jquery.js') ?>
<?= script_tag('js/optional/misc/typeahead.bundle.min.js') ?>
<?= script_tag('js/optional/bootstrap-tagsinput.min.js') ?>
<?= $this->endSection()?>