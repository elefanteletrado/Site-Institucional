<?php
global $cupid_data;

$option_id = 1;
$option = get_option( 'ext_contact_type_item_' . $option_id );
?>
<section class="el-section-contact">
    <h1><?php echo $cupid_data['el_section_contact_title']; ?></h1>
    <p>
        <?php echo $cupid_data['el_phone']; ?><br />
        <?php echo $cupid_data['social-email-link']; ?>
    </p>
    <form class="form-contact" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
        <input type="hidden" name="action" value="ext_contact_save">
        <input type="hidden" name="subject" value="7">
        <div class="el-section-contact-form row">
            <div class="col-lg-offset-2 col-lg-4 col-md-offset-1 col-md-5 col-sm-6 col-xs-12">
                <label for="contsct-name" class="sr-only"><?php echo $cupid_data['el_section_contact_input_name']; ?></label>
                <input class="form-control" id="contsct-name" name="name" type="text" maxlength="100" required placeholder="<?php echo $cupid_data['el_section_contact_input_name']; ?>:">
                <label for="contsct-email" class="sr-only"><?php echo $cupid_data['el_section_contact_input_email']; ?></label>
                <input class="form-control" id="contsct-email" name="email" type="email" maxlength="100" required placeholder="<?php echo $cupid_data['el_section_contact_input_email']; ?>:">
                <label for="contsct-phone" class="sr-only"><?php echo $cupid_data['el_section_contact_input_phone']; ?></label>
                <input class="form-control" id="contsct-phone" name="phone" type="tel" maxlength="20" required oninput="onInputTel(this)" placeholder="<?php echo $cupid_data['el_section_contact_input_phone']; ?>:">
                <label for="contsct-school" class="sr-only"><?php echo $cupid_data['el_section_contact_input_school']; ?></label>
                <input class="form-control" id="contsct-school" name="school" type="text" maxlength="100" required placeholder="<?php echo $cupid_data['el_section_contact_input_school']; ?>:">
            </div>
            <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                <label for="contact-message" class="sr-only"><?php echo $cupid_data['el_section_contact_input_message']; ?></label>
                <textarea class="form-control" id="contact-message" name="message" placeholder="<?php echo $cupid_data['el_section_contact_input_message']; ?>:" required></textarea>
            </div>
        </div>
        <?php if(!empty($option['active_captcha'])): ?>
            <div style="width: 235px; height: 70px; margin: auto;">
                <div class="g-recaptcha" id="recaptcha-contact-section"></div>
            </div>
        <?php endif; ?>
        <div class="el-buttons">
            <button type="submit" class="el-btn-outline"><?php echo $cupid_data['el_section_contact_button_send']; ?></button>
        </div>
    </form>
</section>