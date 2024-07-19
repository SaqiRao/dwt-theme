<?php
class dwt_listing_packages {

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
                'dwt_l_packages', __('For Packages', 'dwt-listing-framework'), array($this, 'render_metabox'), 'product', 'normal', 'high' );
    }

    public function render_metabox($post) {
        // Retrieve an existing value from the database.
        $package_type = get_post_meta($post->ID, 'package_type', true);
        $package_expiry = get_post_meta($post->ID, 'package_expiry', true);

        $listing_expiry = get_post_meta($post->ID, 'listing_expiry', true);

        $regular_listing = get_post_meta($post->ID, 'regular_listing', true);
        $featured_listing = get_post_meta($post->ID, 'featured_listing', true);
        $featured_listing_expiry = get_post_meta($post->ID, 'featured_listing_expiry', true);
        $video_listing = get_post_meta($post->ID, 'video_listing', true);
        $website_link = get_post_meta($post->ID, 'website_link', true);
        $no_of_images = get_post_meta($post->ID, 'no_of_images', true);
        $price_range = get_post_meta($post->ID, 'price_range', true);
        $business_hours = get_post_meta($post->ID, 'business_hours', true);
        $allow_tags = get_post_meta($post->ID, 'allow_tags', true);
        $bump_listing = get_post_meta($post->ID, 'bump_listing', true);
        $make_package_featured = get_post_meta($post->ID, 'make_package_featured', true);
        $allow_coupon_code = get_post_meta($post->ID, 'allow_coupon_code', true);
        $create_event = get_post_meta($post->ID, 'create_event', true);

        // Set default values.
        if (empty($package_type))
            $package_type = '';
        if (empty($package_expiry))
            $package_expiry = '';
        /* ==== */
        if (empty($listing_expiry))
            $listing_expiry = '';
        /* ==== */
        if (empty($regular_listing))
            $regular_listing = '';
        if (empty($featured_listing))
            $featured_listing = '';
        if (empty($featured_listing_expiry))
            $featured_listing_expiry = '';
        if (empty($video_listing))
            $video_listing = '';
        if (empty($website_link))
            $website_link = '';
        if (empty($no_of_images))
            $no_of_images = '';
        if (empty($price_range))
            $price_range = '';
        if (empty($business_hours))
            $business_hours = '';
        if (empty($allow_tags))
            $allow_tags = '';
        if (empty($bump_listing))
            $bump_listing = '';
        if (empty($make_package_featured))
            $make_package_featured = '';
        if (empty($allow_coupon_code))
            $allow_coupon_code = '';
        if (empty($create_event))
            $create_event = '';
        ?>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Package Type', 'dwt-listing-framework'); ?> <span class="required">*</span></label>
        <?php echo esc_html__("Select package type whether it's a paid package or free", 'dwt-listing-framework'); ?></p>
            <select class="select" name="package_type" tabindex="-1" aria-hidden="true">
                <option value="free" <?php selected($package_type, 'free', true); ?>><?php echo esc_html__('Free', 'dwt-listing-framework'); ?></option>
                <option value="paid" <?php selected($package_type, 'paid', true); ?>><?php echo esc_html__('Paid', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Package Expiry', 'dwt-listing-framework'); ?> <span class="required">*</span></label>
        <?php echo esc_html__("Expiry in days, -1 means never expired unless used it.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="package_expiry" value="<?php echo esc_attr($package_expiry); ?>" placeholder="<?php echo esc_html__("Number of days eg 60.", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>

        <!--listing expiry-->
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Listing Expiry', 'dwt-listing-framework'); ?> <span class="required">*</span></label>
        <?php echo esc_html__("Expiry in days, -1 means never expired unless used it.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="listing_expiry" value="<?php echo esc_attr($listing_expiry); ?>" placeholder="<?php echo esc_html__("Number of days eg 20.", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>

        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Regular Listing', 'dwt-listing-framework'); ?> </label>
        <?php echo esc_html__("Total number of regular listings.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="regular_listing" value="<?php echo esc_attr($regular_listing); ?>" placeholder="<?php echo esc_html__("eg 10", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Featured Listing', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Total number of featured listings.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="featured_listing" value="<?php echo esc_attr($featured_listing); ?>" placeholder="<?php echo esc_html__("eg 5", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Featured For', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Expiry in days, -1 means never expired unless used it.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="featured_listing_expiry" value="<?php echo esc_attr($featured_listing_expiry); ?>" placeholder="<?php echo esc_html__("number of days eg 7", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Video Listing', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Want to give user an option to post video link during ad listing.", 'dwt-listing-framework'); ?></p>
            <select class="select" name="video_listing" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($video_listing, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($video_listing, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Website Link', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Want to give user an option to post web link during ad listing.", 'dwt-listing-framework'); ?></p>
            <select class="select" name="website_link" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($website_link, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($website_link, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('No of Images', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("No of image during post a listing.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="no_of_images" value="<?php echo esc_attr($no_of_images); ?>" placeholder="<?php echo esc_html__("5", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Price Range', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Want to give user an option to select pricing range.", 'dwt-listing-framework'); ?></p>
            <select class="select" name="price_range" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($price_range, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($price_range, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Business Hours', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Want to give user an option to select business hours.", 'dwt-listing-framework'); ?></p>
            <select class="select" name="business_hours" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($business_hours, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($business_hours, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Allow Tags', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Want to give user an option to post tags during listing.", 'dwt-listing-framework'); ?></p>
            <select class="select" name="allow_tags" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($allow_tags, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($allow_tags, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Bump Up Listing', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Total number of bump up listings.", 'dwt-listing-framework'); ?></p>
            <div class="input-wrap">
                <input class="text" name="bump_listing" value="<?php echo esc_attr($bump_listing); ?>" placeholder="<?php echo esc_html__("eg 3", 'dwt-listing-framework'); ?>" type="text">
            </div>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Make Package Featured', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Do you want to highlight this package.", 'dwt-listing-framework'); ?></p>
            <select class="select" name="make_package_featured" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($make_package_featured, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($make_package_featured, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Allow Coupon Code', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Allow coupon code option while listing.", 'dwt-listing-framework'); ?> </p>
            <select class="select" name="allow_coupon_code" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($allow_coupon_code, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($allow_coupon_code, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <div class="custom-meta-fields required">
            <p class="label">
                <label><?php echo esc_html__('Create Event', 'dwt-listing-framework'); ?></label>
        <?php echo esc_html__("Allow events option while listing.", 'dwt-listing-framework'); ?> </p>
            <select class="select" name="create_event" tabindex="-1" aria-hidden="true">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                <option value="yes" <?php selected($create_event, 'yes', true); ?>><?php echo esc_html__('Yes', 'dwt-listing-framework'); ?></option>
                <option value="no" <?php selected($create_event, 'no', true); ?>><?php echo esc_html__('No', 'dwt-listing-framework'); ?></option>
            </select>
        </div>
        <?php
    }

    public function save_metabox($post_id, $post) {
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
        $package_type = isset($_POST['package_type']) ? sanitize_text_field($_POST['package_type']) : '';
        $package_expiry = isset($_POST['package_expiry']) ? sanitize_text_field($_POST['package_expiry']) : '';
        $listing_expiry = isset($_POST['listing_expiry']) ? sanitize_text_field($_POST['listing_expiry']) : '';
        $regular_listing = isset($_POST['regular_listing']) ? sanitize_text_field($_POST['regular_listing']) : '';
        $featured_listing = isset($_POST['featured_listing']) ? sanitize_text_field($_POST['featured_listing']) : '';
        $featured_listing_expiry = isset($_POST['featured_listing_expiry']) ? sanitize_text_field($_POST['featured_listing_expiry']) : '';
        $video_listing = isset($_POST['video_listing']) ? sanitize_text_field($_POST['video_listing']) : '';
        $website_link = isset($_POST['website_link']) ? sanitize_text_field($_POST['website_link']) : '';
        $no_of_images = isset($_POST['no_of_images']) ? $_POST['no_of_images'] : '';
        $price_range = isset($_POST['price_range']) ? sanitize_text_field($_POST['price_range']) : '';
        $business_hours = isset($_POST['business_hours']) ? $_POST['business_hours'] : '';
        $allow_tags = isset($_POST['allow_tags']) ? sanitize_text_field($_POST['allow_tags']) : '';
        $bump_listing = isset($_POST['bump_listing']) ? sanitize_text_field($_POST['bump_listing']) : '';
        $make_package_featured = isset($_POST['make_package_featured']) ? sanitize_text_field($_POST['make_package_featured']) : '';
        $allow_coupon_code = isset($_POST['allow_coupon_code']) ? $_POST['allow_coupon_code'] : '';
        $create_event = isset($_POST['create_event']) ? sanitize_text_field($_POST['create_event']) : '';
        // Update the meta field in the database.
        update_post_meta($post_id, 'package_type', $package_type);
        update_post_meta($post_id, 'package_expiry', $package_expiry);
        update_post_meta($post_id, 'listing_expiry', $listing_expiry);
        update_post_meta($post_id, 'regular_listing', $regular_listing);
        update_post_meta($post_id, 'featured_listing', $featured_listing);
        update_post_meta($post_id, 'featured_listing_expiry', $featured_listing_expiry);
        update_post_meta($post_id, 'video_listing', $video_listing);
        update_post_meta($post_id, 'website_link', $website_link);
        update_post_meta($post_id, 'no_of_images', $no_of_images);
        update_post_meta($post_id, 'price_range', $price_range);
        update_post_meta($post_id, 'business_hours', $business_hours);
        update_post_meta($post_id, 'allow_tags', $allow_tags);
        update_post_meta($post_id, 'bump_listing', $bump_listing);
        update_post_meta($post_id, 'make_package_featured', $make_package_featured);
        update_post_meta($post_id, 'allow_coupon_code', $allow_coupon_code);
        update_post_meta($post_id, 'create_event', $create_event);
    }
}

new dwt_listing_packages;

class dwt_listing_packages_inapp {
		public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox1' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox1' ) );
		}
	}
	public function init_metabox1() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox_inapp'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox_featured_inapp' ), 10, 2 );
	}
	public function add_metabox_inapp() {
		add_meta_box(
			'package_inapp',
			__( 'In App Packages Keys', 'dwt-listing-framework' ),
			array( $this, 'render_metabox_in_app' ),
			'product',
			'side',
			'high'
		);
	}
	
	public function render_metabox_in_app( $post )
	{
		// Add nonce for security and authentication.
		wp_nonce_field( 'listing_nonce_action1', 'listing_nonce1' );
		$product_id = $post->ID;
		
		// Retrieve an existing value from the database.
		$for_android	= get_post_meta($product_id, 'in_app_dwt_android', true);
		$for_ios    	= get_post_meta($product_id, 'in_app_dwt_ios', true);
		
		// Set default values.
		if( empty( $for_android ) ) $for_android = '';
		if( empty( $for_ios ) ) $for_ios = '';
		// Form fields.
		echo '<table class="form-table for-packgesz">
		<tr>
				<td>
				<ul class="admin-ul for-featured">
					<li>
						<div class="custom-meta-fields required">
          <p class="label">
            <label>'. esc_html__( 'Android Package ID', 'dwt-listing-framework' ).'</label>
            </p>
          	<div class="input-wrap">
                <input class="text" name="for_android" value="'.esc_attr($for_android).'" placeholder="'.esc_html__( "#12345", 'dwt-listing-framework' ).'" type="text">
            </div>
		</div><br>
					</li>
					<li>
						<div class="custom-meta-fields required">
          <p class="label">
            <label>'. esc_html__( 'IOS Package ID', 'dwt-listing-framework' ).'</label>
           </p>
          	<div class="input-wrap">
                <input class="text" name="for_ios" value="'.esc_attr($for_ios).'" placeholder="'.esc_html__( "#12345", 'dwt-listing-framework' ).'" type="text">
            </div>
		</div>
					</li>
				</ul>
				</td>
			</tr>
		</table>';
	}
	public function save_metabox_featured_inapp( $post_id, $post )
	{
		// Add nonce for security and authentication.
		$nonce_name = ( isset($_POST['listing_nonce1']) ) ? $_POST['listing_nonce1'] : ' ';
		$nonce_action = 'listing_nonce_action1';
		$product_id = $post_id;

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $product_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $product_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $product_id ) )
			return;
			
		$for_android 	= isset( $_POST[ 'for_android' ] ) ? sanitize_text_field( $_POST[ 'for_android' ] ) : '';
		$for_ios 		= isset( $_POST[ 'for_ios' ] ) ? sanitize_text_field( $_POST[ 'for_ios' ] ) : '';
		
		// Update the meta field in the database.
		update_post_meta($product_id, 'in_app_dwt_android', $for_android);
		update_post_meta($product_id, 'in_app_dwt_ios', $for_ios);	
	}
}
new dwt_listing_packages_inapp;