<?php
class form_fields_meta_boxes {

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
                'custom_form_fields',
                __('Listing Custom Fields', 'dwt-listing-framework'),
                array($this, 'render_metabox'),
                'l_form_fields',
                'advanced',
                'default'
        );
    }

    public function render_metabox($post) {
        /* Add nonce for security and authentication. */
        wp_nonce_field('custom_fields_nonce_action', 'fields_nonce');
        // Retrieve an existing value from the database.
        $field_type = get_post_meta($post->ID, 'd_field_type', true);
        $d_multi_check = get_post_meta($post->ID, 'd_multi_check', true);
        $d_multi_radio = get_post_meta($post->ID, 'd_multi_radio', true);
        $d_multi_drop_val = get_post_meta($post->ID, 'd_multi_drop_val', true);

        /* Set default values. */
        if (empty($field_type))
            $field_type = '';
        if (empty($d_multi_check))
            $d_multi_check = '';
        if (empty($d_multi_radio))
            $d_multi_radio = '';
        if (empty($d_multi_drop_val))
            $d_multi_drop_val = '';

        /* get object terms */
        $form_cats = wp_get_post_terms($post->ID, 'l_category', array("fields" => "ids"));
        /* get cats */
        $cats = dwt_listing_categories_fetch('l_category', 0);
        $cats_html = '';
        if (count((array) $cats) > 0) {
            foreach ($cats as $cat) {
                $selected = (in_array($cat->term_id, $form_cats)) ? 'checked="checked"' : '';
                $cats_html .= '<li><input class="custom-checkbox" type="checkbox" name="form_cats[]" ' . $selected . ' value= "' . $cat->term_id . '" /> <span>' . $cat->name . '</span></li>';
            }
        }


        $class = $class1 = $class2 = "hidden";
        if ($field_type == 'multiplecheck') {
            $class = "";
        }
        if ($field_type == 'radio') {
            $class1 = "";
        }
        if ($field_type == 'dropdownselect') {
            $class2 = "";
        }
        /* Form fields. */
        echo '<table class="form-table custom-admin-table fields">
		
		  <tr>
				<th><label for="field_type" class="field_type_label">' . __('Field Type', 'dwt-listing-framework') . '</label></th>
			<td>
				<select id="field_type" name="field_type" class="field_type_field">
					<option value="text" ' . selected($field_type, 'text', false) . '> ' . __('Text Field', 'dwt-listing-framework') . '
					<option value="multiplecheck" ' . selected($field_type, 'multiplecheck', false) . '> ' . __('Multi Checkboxes', 'dwt-listing-framework') . '
					<option value="radio" ' . selected($field_type, 'radio', false) . '> ' . __('Radio Buttons', 'dwt-listing-framework') . '
					<option value="dropdownselect" ' . selected($field_type, 'dropdownselect', false) . '> ' . __('Dropdowns', 'dwt-listing-framework') . '
				</select>
				<p class="description">' . __('Select field type', 'dwt-listing-framework') . '</p>
				</td>
			</tr>
			
			<tr id="custom_multi_ckeck" class="' . esc_attr($class) . '">
				<th><label for="mulit_check" class="mulit_check_label">' . __('Add Checkbox Values', 'dwt-listing-framework') . '</label></th>
				<td>
					<textarea name="multiplecheck" id="multiplecheck" rows="5" placeholder="' . __('Option 1|Option 2|Option 3|', 'dwt-listing-framework') . '"  > ' . esc_textarea($d_multi_check) . ' </textarea>
					<p>' . __('eg Option 1|Option 2|Option 3', 'dwt-listing-framework') . '</p>
				</td>
			</tr>
			
			<tr id="custom_radio_opt" class="' . esc_attr($class1) . '">
				<th><label for="radio_check" class="radio_check_label">' . __('Add Radio Values', 'dwt-listing-framework') . '</label></th>
				<td>
					<textarea name="radio" id="radio" rows="5" placeholder="' . __('Option 1|Option 2|Option 3|', 'dwt-listing-framework') . '"  > ' . esc_textarea($d_multi_radio) . '</textarea>
					<p>' . __('eg Option 1|Option 2|Option 3', 'dwt-listing-framework') . '</p>
				</td>
			</tr>
			
			<tr id="custom_select_opt" class="' . esc_attr($class2) . '">
				<th><label for="select_check" class="select_check_label">' . __('Select Options', 'dwt-listing-framework') . '</label></th>
				<td>
					<textarea name="dropdownselect" id="dropdownselect" rows="5" placeholder="' . __('Option 1|Option 2|Option 3|', 'dwt-listing-framework') . '"  > ' . esc_textarea($d_multi_drop_val) . ' </textarea>
					<p>' . __('eg Option 1|Option 2|Option 3', 'dwt-listing-framework') . '</p>
				</td>
			</tr>

			<tr>
				<th><label for="field_type_cat" class="field_type_cat">' . __('Select Category For Field', 'dwt-listing-framework') . '</label></th>
			<td><div class="category-based-features"><ul>' . $cats_html . '
			</ul></div>
			
			<button type="button" id="select_all_cats" class="button   select_all_cats">' . __('Select All', 'dwt-listing-framework') . '</button>
			<button type="button" id="unselect_all_cats" class="button  unselect_all_cats">' . __('Un Select', 'dwt-listing-framework') . '</button>
			</td>
			</tr>
			
		</table>';
    }

    public function save_metabox($post_id, $post) {

        // Add nonce for security and authentication.
        $nonce_name = ( isset($_POST['fields_nonce']) ) ? $_POST['fields_nonce'] : ' ';
        $nonce_action = 'custom_fields_nonce_action';

        // Check if a nonce is set.
        if (!isset($nonce_name))
            return;

        // Check if a nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Check if the user has permissions to save data.
        if (!current_user_can('edit_post', $post_id))
            return;

        // Check if it's not an autosave.
        if (wp_is_post_autosave($post_id))
            return;

        // Check if it's not a revision.
        if (wp_is_post_revision($post_id))
            return;

        // Sanitize user input.
        $field_type = isset($_POST['field_type']) ? sanitize_text_field($_POST['field_type']) : '';
        $multi_textfields = isset($_POST['post_title']) ? sanitize_textarea_field($_POST['post_title']) : '';
        $multi_check = isset($_POST['multiplecheck']) ? sanitize_textarea_field($_POST['multiplecheck']) : '';
        $multi_radio = isset($_POST['radio']) ? sanitize_textarea_field($_POST['radio']) : '';
        $multi_drop = isset($_POST['dropdownselect']) ? sanitize_textarea_field($_POST['dropdownselect']) : '';
        $field_cats = isset($_POST['form_cats']) ? ( $_POST['form_cats'] ) : '';

        if (count((array) $field_cats) > 0) {
            if ($field_type == 'text') {
                if (!empty($multi_textfields)) {
                    update_post_meta($post_id, 'd_field_type', $field_type);
                    update_post_meta($post_id, 'd_multi_textfields', $multi_textfields);
                }
            }
            if ($field_type == 'multiplecheck') {
                if (!empty($multi_check)) {
                    update_post_meta($post_id, 'd_field_type', $field_type);
                    update_post_meta($post_id, 'd_multi_check', $multi_check);
                }
            }
            if ($field_type == 'radio') {
                if (!empty($multi_radio)) {
                    update_post_meta($post_id, 'd_field_type', $field_type);
                    update_post_meta($post_id, 'd_multi_radio', $multi_radio);
                }
            }
            if ($field_type == 'dropdownselect') {
                if (!empty($multi_drop)) {
                    update_post_meta($post_id, 'd_field_type', $field_type);
                    update_post_meta($post_id, 'd_multi_drop_val', $multi_drop);
                }
            }
            // set cat terms
            wp_set_post_terms($post_id, $field_cats, 'l_category');

        }
    }

}

new form_fields_meta_boxes;