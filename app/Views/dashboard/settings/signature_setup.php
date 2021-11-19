<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url()?>/settings" type="button" class="btn btn-primary btn-md" id="back_to_estimate" title="Back to Estimate Page">
            <i class="fa fa-arrow-left fa-fw"></i>Back to Settings
        </a>
    </div>
</div>

<div class="row invoice_signature">
    <div class="signature_wrapper">
        <div class="heading"><strong id="modalTitle"><?php echo user()->first_name.' '.user()->last_name?>'s Signature</strong></div>
        <div>
            <?php if(!empty($signature) && file_exists('uploads/signature_images/'.$signature)){ ?>
                <?= img('uploads/signature_images/'.$signature) ?>
                <button type="button" class="btn btn-info view_signature" data-toggle="modal" data-target="#signature_modal">Update Signature</button>
            <?php }else{?>
                <button type="button" class="btn btn-info view_signature" data-toggle="modal" data-target="#signature_modal">Create Signature</button>
            <?php }?>
        </div>
    </div>
</div>


<div id="signature_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="modalBody" class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <div class="row">
                    <div class="signature_wrapper">
                        <div class="heading">Signature</div>
                        <div id="sig"></div>
                        <div class="clearfix"></div>
                        <button id="clear" class="btn btn-default">Clear</button>
                        <button type="button" id ="svg" class="btn btn-default">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var saveSignatureUrl = '<?php echo base_url()?>/save_signature';
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?= script_tag('js/required/signature.js') ?>
<?= script_tag('js/jquery.signature.js') ?>
<?= $this->endSection()?>