<?= $this->extend("master")?>
<?= $this->section("content")?>
<div class="row">
    <div class="col-md-12">
        <div class="block">

            <div class="block-heading">
                <div class="main-text h2">
                    CONTACT US
                </div>
            </div>

            <div class="block-content-outer">
                <div class="block-content-inner">
                    <div class="mailbox">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="container-fluid">
                                    <form role="form" id="message-compose"
                                          action="<?php echo base_url();?>mailbox/send_an_contact"
                                          method="post">

                                        <div class=" form-group contact-style">
                                            <input class="form-control " placeholder="Email Address"
                                                   type="email" name="email" required="required">
                                        </div>


                                        <div class="form-group email-subject-container  contact-style">
                                            <input id="subject" type="text" placeholder="Subject "
                                                   class="form-control email-subject"
                                                   name="subject" required >
                                        </div>

                                        <div class="form-group email-body-container  contact-style">
                                            <textarea id="email-body" class="form-control email-body" rows="8" name="message" required></textarea>

                                        </div>
                                </div>

                                <div class="message-compose-contols-right">
                                    <input type="submit" id="send-email" class="btn btn-primary btn-sm" value="Send Request">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url();?>application/assets/js/required/mailbox.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>application/assets/js/optional/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>application/assets/js/optional/ckeditor/adapters/jquery.js"></script>
    <?= $this->endSection()?>
