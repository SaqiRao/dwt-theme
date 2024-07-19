<?php
class events_meta_boxes {

    public function __construct() {

        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }
    }

    public function init_metabox() {

        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);
    }

    public function add_metabox() {

        add_meta_box(
                'events_meta_fields', __('Events Fields', 'dwt-listing-framework'), array($this, 'render_metabox'), 'events', 'advanced', 'default'
        );
    }

    public function render_metabox($post) {
        // Add nonce for security and authentication.
        wp_nonce_field('events_nonce_action', 'events_nonce');

        $event_id = $post->ID;
        $listing_lattitude = dwt_listing_text('dwt_listing_default_lat');
        $listing_longitide = dwt_listing_text('dwt_listing_default_long');
        $ip_type = dwt_listing_text('dwt_geo_api_settings');

        // Retrieve an existing value from the database.
        $event_contact = get_post_meta($event_id, 'dwt_listing_event_contact', true);
        $event_email = get_post_meta($event_id, 'dwt_listing_event_email', true);
        $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
        $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
        $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
        if (get_post_meta($event_id, 'dwt_listing_event_lat', true) != "") {
            $listing_lattitude = get_post_meta($event_id, 'dwt_listing_event_lat', true);
        }
        if (get_post_meta($event_id, 'dwt_listing_event_long', true) != "") {
            $listing_longitide = get_post_meta($event_id, 'dwt_listing_event_long', true);
        }
        $event_fb = get_post_meta($event_id, 'dwt_event_fb', true);
        $event_tw = get_post_meta($event_id, 'dwt_event_tw', true);
        $event_google = get_post_meta($event_id, 'dwt_event_google', true);
        $event_in = get_post_meta($event_id, 'dwt_event_in', true);
        $event_youtube = get_post_meta($event_id, 'dwt_event_youtube', true);
        $event_insta = get_post_meta($event_id, 'dwt_event_insta', true);
        $event_whatsapp = get_post_meta($event_id, 'dwt_event_whatsapp', true);

        // Set default values.
        if (empty($event_contact))
            $event_contact = '';
        if (empty($event_email))
            $event_email = '';
        if (empty($event_start_date))
            $event_start_date = '';
        if (empty($event_end_date))
            $event_end_date = '';
        if (empty($event_venue))
            $event_venue = '';
        if (empty($event_fb))
            $listing_fb = '';
        if (empty($event_tw))
            $listing_tw = '';
        if (empty($event_youtube))
            $listing_youtube = '';
        if (empty($event_insta))
            $listing_insta = '';
        if (empty($event_whatsapp))
            $event_whatsapp = '';
        if (empty($event_google))
            $listing_google = '';
        if (empty($event_in))
            $listing_in = '';
        if (empty($category_id))
            $category_id = '';
        $event_cat = '';
        $gallery_thumbs = '';
        //Listing Categories
        //event term
        $term_list = wp_get_post_terms($event_id, 'l_event_cat', array("fields" => "ids"));
        if (!empty($term_list)) {
            $event_cat = $term_list[0];
        }
        $cats = dwt_listing_categories_fetch('l_event_cat', 0);
        $cats_html = '';
        foreach ($cats as $cat) {
            $selected = '';
            if ($cat->term_id == $event_cat) {
                $selected = 'selected="selected"';
            }
            $cats_html .= '<option value="' . $cat->term_id . '" ' . $selected . '>' . $cat->name . '</option>';
        }


        //for listing images
        $query = $results = $meta = $meta_html = '';
        if (get_post_meta($event_id, 'downotown_event_arrangement_', true) != "") {
            $meta = get_post_meta($event_id, 'downotown_event_arrangement_', true);
            if ($meta != "") {
                $results = explode(',', $meta);
            } else {
                global $wpdb;
                $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $event_id . "'";
                $results = $wpdb->get_results($query, OBJECT);
            }
            if (count((array) $results) > 0) {
                $meta_html .= '<ul class="dwt_listing_gallery">';
                foreach ($results as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $thumb_imgs = wp_get_attachment_image_src($mid, 'dwt_listing_recent-posts');

                    $meta_html .= '<li><div class="dwt_listing_gallery_container"><span class="dwt_event_delete_icon">
				 <img id="' . esc_attr($mid) . '" src="' . esc_url($thumb_imgs[0]) . '" alt="' . esc_html__('image not found', 'dwt-listing-framework') . '" /></span></div></li>';
                }
                $meta_html .= '</ul>';
            }
        }
        ?>	
        <table class="form-table ">
            <tr>
                <th><label class="claimed_by_label"><?php echo esc_html__('Event Gallery', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input id="dwt_listing_event_idz" type="hidden" name="dwt_listing_event_idz" value="<?php echo esc_attr($meta); ?>" />
                    <span id="dwt_listing_gall_render_event"><?php echo $meta_html; ?></span>
                    <input id="dwt_listing_event_button" class="button button-primary button-large" type="button" value="<?php echo esc_attr__('Event Images', 'dwt-listing-framework'); ?>" />
                </td>
            </tr>
            <tr>
                <th><label class="claimed_by_label"><?php echo esc_html__('Select Category', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Event Category', 'dwt-listing-framework'); ?>" id="event_cat"  name="event_cat" class="admin-select">
                        <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $cats_html; ?>
                    </select>
                    <p class="description"><?php echo esc_html__('Select event category', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>

            <tr>
                <th><label class="claimer_contact_label"><?php echo esc_html__('Phone Number', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_number" name="event_number" placeholder="<?php echo esc_attr__('+99 3331 234567', 'dwt-listing-framework'); ?>" value="<?php echo $event_contact; ?>">

                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo esc_html__('Contact Email', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_email" name="event_email" placeholder="<?php echo esc_html__('abc@xyz.com', 'dwt-listing-framework'); ?>" value="<?php echo $event_email; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo esc_html__('Event Start Date', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input  name="event_start_date" type="text" id="event_start" data-time-format='hh:ii aa' value="<?php echo $event_start_date; ?>">
                    <p class="description"><?php echo esc_html__('Select event start date.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr >
                <th><label class="claimer_contact_label"><?php echo esc_html__('Event End Date', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input  name="event_end_date" type="text" id="event_end" data-time-format='hh:ii aa' value="<?php echo $event_end_date; ?>">
                    <p class="description"><?php echo esc_html__('Select event end date.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr class="get-loc">
                <th><label class="claimer_contact_label"><?php echo esc_html__('Event Location', 'dwt-listing'); ?></label></th>
                <td>
                    <input type="text" id="address_location" name="event_venue" placeholder="<?php echo dwt_listing_text('dwt_listing_list_google_loc_place'); ?>" value="<?php echo $event_venue; ?>">
                    <i class="detect-me fa fa-crosshairs"></i>
                    <p class="description"><?php echo esc_html__('Location of your event.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo esc_html__('Map', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <div id="submit-map-open"></div>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo esc_html__('Latitude', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="d_latt" name="event_lat" placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place'); ?>" value="<?php echo $listing_lattitude; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo esc_html__('Longitude', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="d_long" name="event_long" placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place'); ?>" value="<?php echo $listing_longitide; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Facebook', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_fb" name="event_fb" placeholder="" value="<?php echo $event_fb; ?>">
                    <p class="description"><?php echo __('Your facebook URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Twitter', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_tw" name="event_tw" placeholder="" value="<?php echo $event_tw; ?>">
                    <p class="description"><?php echo __('Your Twitter URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Google Plus', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_google" name="event_google" placeholder="" value="<?php echo $event_google; ?>">
                    <p class="description"><?php echo __('Your Google Plus URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Linked IN', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_in" name="event_in" placeholder="" value="<?php echo $event_in; ?>">
                    <p class="description"><?php echo __('Your Linked IN URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Youtube URL', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_youtube" name="event_youtube" placeholder="" value="<?php echo $event_youtube; ?>">
                    <p class="description"><?php echo __('Your Youtube URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Instagram URL', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_insta" name="event_insta" placeholder="" value="<?php echo $event_insta; ?>">
                    <p class="description"><?php echo __('Your Instagram URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('WhatsApp Number', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="event_whatsapp" name="event_whatsapp" placeholder="" value="<?php echo $event_whatsapp; ?>">
                    <p class="description"><?php echo __('Your WhatsApp Number', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <input type="hidden" id="admin_ip_type" value="<?php echo $ip_type; ?>">
        </table>
        <?php
    }

    public function save_metabox($post_id, $post) {

        global $wpdb;
        // Add nonce for security and authentication.
        $nonce_name = ( isset($_POST['events_nonce']) ) ? $_POST['events_nonce'] : ' ';
        $nonce_action = 'events_nonce_action';
        $event_id = $post_id;

        // Check if a nonce is set.
        if (!isset($nonce_name))
            return;

        // Check if a nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Check if the user has permissions to save data.
        if (!current_user_can('edit_posts', $event_id))
            return;

        // Check if it's not an autosave.
        if (wp_is_post_autosave($event_id))
            return;

        // Check if it's not a revision.
        if (wp_is_post_revision($event_id))
            return;
        // Sanitize user input.
        $images_idz = '';
        $event_cat = isset($_POST['event_cat']) ? sanitize_text_field($_POST['event_cat']) : '';
        $event_contact = isset($_POST['event_number']) ? sanitize_text_field($_POST['event_number']) : '';
        $event_email = isset($_POST['event_email']) ? sanitize_text_field($_POST['event_email']) : '';
        $event_start_date = isset($_POST['event_start_date']) ? sanitize_text_field($_POST['event_start_date']) : '';
        $event_end_date = isset($_POST['event_end_date']) ? sanitize_text_field($_POST['event_end_date']) : '';
        $event_venue = isset($_POST['event_venue']) ? sanitize_text_field($_POST['event_venue']) : '';
        $listing_lattitude = isset($_POST['event_lat']) ? sanitize_text_field($_POST['event_lat']) : '';
        $listing_longitide = isset($_POST['event_long']) ? sanitize_text_field($_POST['event_long']) : '';
        $event_fb = isset($_POST['event_fb']) ? sanitize_text_field($_POST['event_fb']) : '';
        $event_tw = isset($_POST['event_tw']) ? sanitize_text_field($_POST['event_tw']) : '';
        $event_google = isset($_POST['event_google']) ? sanitize_text_field($_POST['event_google']) : '';
        $event_in = isset($_POST['event_in']) ? sanitize_text_field($_POST['event_in']) : '';
        $event_youtube = isset($_POST['event_youtube']) ? sanitize_text_field($_POST['event_youtube']) : '';
        $event_insta = isset($_POST['event_insta']) ? sanitize_text_field($_POST['event_insta']) : '';
        $event_whatsapp = isset($_POST['event_whatsapp']) ? sanitize_text_field($_POST['event_whatsapp']) : '';

        // Update the meta field in the database.
        update_post_meta($event_id, 'dwt_listing_event_status', '1');
        update_post_meta($event_id, 'dwt_listing_event_contact', $event_contact);
        update_post_meta($event_id, 'dwt_listing_event_email', $event_email);
        update_post_meta($event_id, 'dwt_listing_event_start_date', $event_start_date);
        update_post_meta($event_id, 'dwt_listing_event_end_date', $event_end_date);
        update_post_meta($event_id, 'dwt_listing_event_venue', $event_venue);
        update_post_meta($event_id, 'dwt_listing_event_lat', $listing_lattitude);
        update_post_meta($event_id, 'dwt_listing_event_long', $listing_longitide);
        wp_set_post_terms($event_id, $event_cat, 'l_event_cat');
        update_post_meta($event_id, 'dwt_event_fb', $event_fb);
        update_post_meta($event_id, 'dwt_event_tw', $event_tw);
        update_post_meta($event_id, 'dwt_event_google', $event_google);
        update_post_meta($event_id, 'dwt_event_in', $event_in);
        update_post_meta($event_id, 'dwt_event_youtube', $event_youtube);
        update_post_meta($event_id, 'dwt_event_insta', $event_insta);
        update_post_meta($event_id, 'dwt_event_whatsapp', $event_whatsapp);
        //images
        $images_idz = $_POST['dwt_listing_event_idz'];
        if (!empty($images_idz) && count((array) $images_idz) > 0) {
            update_post_meta($event_id, 'downotown_event_arrangement_', $images_idz);
        } else {
            update_post_meta($event_id, 'downotown_event_arrangement_', $images_idz);
        }
    }

}

new events_meta_boxes;

//Assign events

add_action('add_meta_boxes', 'dwt_listing_assign_events');

function dwt_listing_assign_events() {
    add_meta_box('dwt_listing_assign_events_to', __('Assign Events to Authors', 'dwt-listing-framework'), 'dwt_listing_render_events_html', 'events', 'side', 'high');
}

function dwt_listing_render_events_html($post) {
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_events', 'meta_box_nonce_events');
    $users = get_users(array('fields' => array('display_name', 'ID')));
    ?>
    <table class="form-table">
        <td>
            <select id="listing_author"  name="listing_author_name" class="admin-select-full">
                <option value=""> <?php echo esc_html__('Select author', 'dwt-listing-framework'); ?></option>
                <?php
                if (!empty($users) && count((array) $users) > 0) {
                    foreach ($users as $user) {
                        ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" <?php if ($post->post_author == $user->ID) echo 'selected'; ?>>
                            <?php echo esc_html($user->display_name); ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
            <p class="description"><?php echo __('Assign listing to any other author', 'dwt-listing-framework'); ?></p>
        </td>
    </table>
    <?php
}

// Saving Metabox data 
add_action('save_post', 'dwt_listing_save_for_events');

function dwt_listing_save_for_events($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

// if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_events']) || !wp_verify_nonce($_POST['meta_box_nonce_events'], 'my_meta_box_nonce_events'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts'))
        return;

    // Make sure your data is set before trying to save it
    if (isset($_POST['listing_author_name'])) {
        $my_post = array(
            'ID' => $post_id,
            'post_author' => $_POST['listing_author_name'],
        );
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'dwt_listing_save_for_events');
        // update the post, which calls save_post again
        wp_update_post($my_post);
        // re-hook this function
        add_action('save_post', 'dwt_listing_save_for_events');
    }
}