<?php
class listing_location_meta {

    public function __construct() {
        if (is_admin()) {
            add_action('l_location_add_form_fields', array($this, 'dwt_listing_create_location_fields'), 10, 1);
            add_action('l_location_edit_form_fields', array($this, 'dwt_listing_edit_location_fields'), 10, 2);
            add_action('created_l_location', array($this, 'save_data'), 10, 1);
            add_action('edited_l_location', array($this, 'save_data'), 10, 1);
            add_action('admin_enqueue_scripts', array($this, 'load_wp_media_files'), 10, 1);
            add_action('admin_footer', array($this, 'add_script'), 10, 1);
        }
    }

    public function load_wp_media_files() {
        wp_enqueue_media();
    }

    public function dwt_listing_create_location_fields($taxonomy) {
        ?>
        <div class="form-field term-group">
            <label for="location_term_meta_img"><?php _e('Image', 'hero-theme'); ?></label>
            <input type="hidden" id="location_term_meta_img" name="location_term_meta_img" class="custom_media_url" value="">
            <div id="loc-image-wrapper"></div>
            <p>
                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'hero-theme'); ?>" />
                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'hero-theme'); ?>" />
            </p>
        </div>
        <?php
    }

    public function dwt_listing_edit_location_fields($term, $taxonomy) {
        ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="location_term_meta_img"><?php _e('Image', 'hero-theme'); ?></label>
            </th>
            <td>
                    <?php $image_id = get_term_meta($term->term_id, 'location_term_meta_img', true); ?>
                <input type="hidden" id="location_term_meta_img" name="location_term_meta_img" value="<?php echo $image_id; ?>">
                <div id="loc-image-wrapper">
        <?php if ($image_id) { ?>
            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
        <?php } ?>
                </div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'hero-theme'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'hero-theme'); ?>" />
                </p>
            </td>
        </tr>
        <?php
    }

    public function save_data($term_id) {
        if (isset($_POST['location_term_meta_img']) && '' !== $_POST['location_term_meta_img']) {
            $image = $_POST['location_term_meta_img'];
            update_term_meta($term_id, 'location_term_meta_img', $image);
        } else {
            update_term_meta($term_id, 'location_term_meta_img', '');
        }
    }

    public function add_script() {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                function dwt_term_meta_up(button_class) {
                    var _custom_meta = true,
                            _attach_id = wp.media.editor.send.attachment;
                    $('body').on('click', button_class, function (e) {
                        var button_id = '#' + $(this).attr('id');
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = $(button_id);
                        _custom_meta = true;
                        wp.media.editor.send.attachment = function (props, attachment) {
                            if (_custom_meta) {
                                $('#location_term_meta_img').val(attachment.id);
                                $('#loc-image-wrapper').html('<img class="custom_meta_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                $('#loc-image-wrapper .custom_meta_image').attr('src', attachment.url).css('display', 'block');
                            } else {
                                return _attach_id.apply(button_id, [props, attachment]);
                            }
                        }
                        wp.media.editor.open(button);
                        return false;
                    });
                }
                dwt_term_meta_up('.ct_tax_media_button.button');
                $('body').on('click', '.ct_tax_media_remove', function () {
                    $('#location_term_meta_img').val('');
                    $('#loc-image-wrapper').html('<img class="custom_meta_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                });
            });
        </script>
    <?php
    }

}

new listing_location_meta;