<?= $this->extend("admin/admin_master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="block-heading" style="padding-left: 130px;">
                <div class="main-text h2">
                    Welcome back, <?php echo user()->first_name.' '.user()->last_name;?>
                </div>
            </div>
            <div class="block-heading" style="padding-left: 130px;padding-right: 130px;">
                <div class="" id="successMessage">
                    <?= view('App\Auth\_message_block') ?>
                </div>
            </div>
            
            <div class="block-content-outer">
                <div class="block-content-inner">
                    <div class="mailbox">
                        <div class="row">
                            <div class="col-md-1 col-lg-1">
                            </div>
                            <div class="col-md-10 col-lg-10">
                                <div class="mailbox-container mailbox-message-compose"> <!-- NOTE TO READER: Accepts the following class(es) "minimal-view" -->
                                    <form role="form" id="message-compose" action="<?php echo base_url();?>/admin/send_an_email" method="post">
                                        <div class="form-group email-recepient-main-container">
                                            <label for="email-recepient-main">To: </label>
                                            <span class="pull-right text-right">
                                                    <a href="#" id="add-cc" class="">Add Cc</a>
                                                    <a href="#" id="add-bcc" class="">Add Bcc</a>
                                                </span>
                                            <span class="email_invalid">Invalid Email</span>
                                            <select id="email-recepient-main" type="text" name="receiver[]" class="form-control users email-recepient
                                                        email-recepient-main chosen-select" multiple="multiple" required>
                                                <!-- <option selected="" disabled>Select Email</option> -->
                                                <?php foreach($users as $user):?>
                                                    <option value="<?php echo $user['id'];?>"> <?php echo $user['first_name'].' '.$user['last_name'];?> <?php echo "(".$user['email'].")";?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group email-recepient-cc-container">
                                            <label for="email-recepient-cc">Cc: </label> <a href="#" id="remove-cc" class="pull-right">Remove Cc</a>
                                            <select id="email-recepient-cc" type="text" name="cc_recipient[]" class="form-control users email-recepient
                                                        email-recepient-main chosen-select email-recepient-cc" multiple="multiple">
                                                <!-- <option selected="" disabled></option> -->
                                                <?php foreach($users as $user):?>
                                                    <option value="<?php echo $user['id'];?>">
                                                        <?php echo $user['first_name'].' '.$user['last_name'];?>
                                                        <?php echo "(".$user['email'].")";?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group email-recepient-bcc-container">
                                            <label for="email-recepient-bcc">Bcc: </label> <a href="#" id="remove-bcc" class="pull-right">Remove Bcc</a>
                                            <select id="email-recepient-bcc" type="text" name="bcc_recipient[]"
                                                    class="form-control users email-recepient email-recepient-main chosen-select email-recepient-bcc" multiple="multiple" >
                                                <!-- <option selected="" disabled></option> -->
                                                <?php foreach($users as $user):?>
                                                    <option value="<?php echo $user['id'];?>">
                                                        <?php echo $user['first_name'].' '.$user['last_name'];?>
                                                        <?php echo "(".$user['email'].")";?>
                                                    </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group email-subject-container">
                                            <label for="email-subject">Subject</label>
                                            <input id="email-subject" onkeyup="limitwords()" type="text" placeholder="Enter Email's subject here" class="form-control email-subject" name="subject">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-group email-body-container">
                                            <textarea id="email-body" class="form-control email-body" rows="8" name="message" required></textarea>
                                            <div class="row">
                                                <div class="msg-signature col-md-8">
                                                    <div class="signature-text">
                                                        <?php echo $signature[0]['signature'];?>
                                                    </div>
                                                    <?php if(!empty($signature['image'])): ?>
                                                        <div class="signature-img">
                                                            <img id="signature-image" src="<?php echo $super_admin_folder['signature_web_path'].$signature['image'];?>" alt="Signature Image">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4 file_attachments">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="message-compose-contols-right">
                                            <input type="submit" id="send-email" class="btn btn-primary btn-sm" value="Send Email">
                                            <button data-toggle="modal" data-target="#server_files" type="button"><span class="glyphicon glyphicon-paperclip"></span></button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="server_files" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="heading"><strong>Select Files</strong></span>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            </div>
            <div id="modalBody" class="modal-body">
                <span>Double click to Select</span>
                <div class="example">
                    <div id="fileTreeDemo_2" class="demo"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= script_tag('js/file_tree/jqueryFileTree.js') ?>

<script type="text/javascript">
    function limitwords(){
        var num_words = $("input#email-subject").val().trim().split(/\s+/).length;
        if(num_words > 20){
            $(".error").show();
            $(".error").text("Subject should be less than 20 words").css('color', 'red');
            $("#send-email").attr("disabled", true);
        }else{
            $(".error").hide();
            $('#send-email').removeAttr("disabled");
        }
    }

    $(document).ready( function() {
        $(".email-recepient-main").select2({
            width: 'resolve' // need to override the changed default
        });
        $('#server_files #fileTreeDemo_2').fileTree({
                root: '<?php echo $_SERVER['DOCUMENT_ROOT']?>/uploads/',
                script: '<?php echo base_url()?>mailbox/connectors',
                folderEvent: 'dblclick',
                expandSpeed: 750,
                collapseSpeed: 750,
                multiFolder: false
            },
            function(file) {
                $('#server_files').modal('toggle');
                file_name = file.substring(file.lastIndexOf('/')+1);
                $('.file_attachments ul').append('<li><span class="glyphicon glyphicon-file"></span><span>' + file_name + '</span><a class="delete_button" onclick="delete_file(this)"><span class="glyphicon glyphicon-remove-circle"></span></a><input type="hidden" value="'+file+'" name="attachments[]"></li>');
            });


                $(".email-recepient-main-container .bootstrap-tagsinput").css('display','none');
                $(".email-recepient-main-container #email-recepient-main").attr('name','receiver[]').attr('required','true');
                $("#email_recepient_main_chosen").css('display','inline-block');
                $(".email-recepient-main-container .public_user").css('display','none').removeAttr('name').removeAttr('required');
                $(".email-recepient-main-container .email_invalid").css('display','none');
                $("#send-email").removeAttr('disabled');



        $(".mailbox-mobile-menu-control").click(function(){
            $("#mailbox-menu-actual").slideToggle();
        });


    });
    function delete_file(obj){
        $(obj).parent().remove();
    }

    function validate() {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email = $(".email-recepient-main-container .public_user").val();
        if(email.length>0){
            result = regex.test(email);
            if(result == true){
                $(".email-recepient-main-container .email_invalid").css('display','none');
                $("#send-email").removeAttr('disabled');
            }else{
                $(".email-recepient-main-container .email_invalid").css('display','inline-block');
                $("#send-email").attr('disabled', true);
            }
        }
    }

    /* Handles Show/Hide Cc/Bcc */
    $("#add-cc").on("click", function(e){
        $(".email-recepient-cc-container").slideToggle(300);
        $(this).fadeToggle(300);
        e.preventDefault();
    });
    $("#remove-cc").on("click", function(e){
        $(".email-recepient-cc-container").slideToggle(300);
        $("#add-cc").fadeToggle(300);
        e.preventDefault();
    });

    $("#add-bcc").on("click", function(e){
        $(".email-recepient-bcc-container").slideToggle(300);
        $(this).fadeToggle(300);
        e.preventDefault();
    });
    $("#remove-bcc").on("click", function(e){
        $(".email-recepient-bcc-container").slideToggle(300);
        $("#add-bcc").fadeToggle(300);
        e.preventDefault();
    });

</script>
<?= script_tag('js/optional/misc/typeahead.bundle.min.js') ?>
<?= script_tag('js/optional/ckeditor/adapters/jquery.js') ?>
<?= script_tag('js/optional/ckeditor/ckeditor.js') ?>
<?= script_tag('js/demo-files/pages-mailbox.js') ?>
<?= script_tag('js/optional/bootstrap-tagsinput.min.js') ?>
<?= script_tag('js/docsupport/init.js') ?>
<?= script_tag('js/docsupport/prism.js') ?>
<?= script_tag('js/chosen.jquery.js') ?>


<script>
    $("#email-body").ckeditor();
</script>
<?= $this->endSection()?>