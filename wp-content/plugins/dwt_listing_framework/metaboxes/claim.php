<?php
class claim_meta_boxes
{

    public function __construct()
    {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }
    }

    public function init_metabox()
    {
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);
    }

    public function add_metabox()
    {
        add_meta_box(
            'claim_history', __('Detial About Claim', 'dwt-listing-framework'), array($this, 'render_metabox'), 'l_claims', 'advanced', 'default'
        );
    }

    public function render_metabox($post)
    {
        /* Add nonce for security and authentication. */
        wp_nonce_field('claim_nonce_action', 'claim_nonce');
        /* Retrieve an existing value from the database. */
        $claimer_contact = get_post_meta($post->ID, 'd_listing_claimer_contact', true);
        $claimed_by = $author_id = $post->post_author;
        $claimer_author_name = get_the_author_meta('display_name', $claimed_by);
        $claim_detials = get_post_meta($post->ID, 'd_listing_claimer_msg', true);
        $claim_status = get_post_meta($post->ID, 'd_listing_claim_status', true);
        /* Set default values. */
        if (empty($claimer_contact))
            $claimer_contact = '';
        if (empty($claimed_by))
            $claimed_by = '';
        if (empty($claimer_author_name))
            $claimer_author_name = '';
        if (empty($claim_detials))
            $claim_detials = '';
        if (empty($claim_status))
            $claim_status = '';
        /* Form fields. */
        echo '<table class="form-table ">
		<tr>
				<th><label for="claimed_by" class="claimed_by_label">' . __('Claimed By', 'dwt-listing-framework') . '</label></th>
				<td>
				 <select id="claimed_by" name="claimed_by" class="claim_status_field">
					<option value=' . esc_attr__($claimed_by) . '> ' . (esc_attr__($claimer_author_name)) . '
				</select>
					<p class="description">' . __('Claimed Author Name.', 'dwt-listing-framework') . '</p>
				</td>
			</tr>
			<tr>
				<th><label for="claim_detials" class="claim_detials_label">' . __('Claim Detials', 'dwt-listing-framework') . '</label></th>
				<td>
					<textarea name="claim_detials" id="claim_detials" rows="10" placeholder="' . __('Additional proof to expedite your claim approval...', 'dwt-listing-framework') . '"  >' . esc_attr__($claim_detials) . '</textarea>
				</td>
			</tr>
		<tr>
				<th><label for="claim_status" class="claim_status_label">' . __('Claim Status', 'dwt-listing-framework') . '</label></th>
			<td>
				<select id="claim_status" name="claim_status" class="claim_status_field">
					<option value="pending" ' . selected($claim_status, 'pending', false) . '> ' . __('Pending', 'dwt-listing-framework') . '
					<option value="approved" ' . selected($claim_status, 'approved', false) . '> ' . __('Approved', 'dwt-listing-framework') . '
					<option value="decline" ' . selected($claim_status, 'decline', false) . '> ' . __('Decline', 'dwt-listing-framework') . '
				</select>
				<p class="description">' . __('Status for current claim', 'dwt-listing-framework') . '</p>
				</td>
			</tr>
			<tr>
				<th><label for="claimer_contact" class="claimer_contact_label">' . __('Claimer Contact', 'dwt-listing-framework') . '</label></th>
				<td>
					<input type="text" id="claimer_contact" name="claimer_contact" class="claimer_contact_field" placeholder="" value="' . esc_attr__($claimer_contact) . '">
					<p class="description">' . __('Claimer contact number', 'dwt-listing-framework') . '</p>
				</td>
			</tr>

		</table>';
    }

    public function save_metabox($post_id, $post)
    {
        /* Add nonce for security and authentication. */
        $nonce_name = (isset($_POST['claim_nonce'])) ? $_POST['claim_nonce'] : ' ';
        $nonce_action = 'claim_nonce_action';

        /* Check if a nonce is set.*/
        if (!isset($nonce_name))
            return;

        /* Check if a nonce is valid. */
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        /* Check if the user has permissions to save data. */
        if (!current_user_can('edit_post', $post_id))
            return;

        /* Check if it's not an autosave. */
        if (wp_is_post_autosave($post_id))
            return;

        /* Check if it's not a revision. */
        if (wp_is_post_revision($post_id))
            return;
        /* Sanitize user input. */
        $claimed_by = isset($_POST['claimed_by']) ? sanitize_text_field($_POST['claimed_by']) : '';
        $claim_remarks = isset($_POST['claim_detials']) ? sanitize_text_field($_POST['claim_detials']) : '';
        $claimer_final_status = isset($_POST['claim_status']) ? $_POST['claim_status'] : '';
        $claimer_contact_no = isset($_POST['claimer_contact']) ? sanitize_text_field($_POST['claimer_contact']) : '';

        /* Update the meta field in the database. */
        update_post_meta($post_id, 'd_listing_claimer_msg', $claim_remarks);
        update_post_meta($post_id, 'd_listing_claim_status', $claimer_final_status);
        update_post_meta($post_id, 'd_listing_claimer_contact', $claimer_contact_no);
    }

}

new claim_meta_boxes;