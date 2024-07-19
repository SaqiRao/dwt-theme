<?php
// Users custom fields
add_action('show_user_profile', 'dwt_listing_extra_profile_fields');
add_action('edit_user_profile', 'dwt_listing_extra_profile_fields');

function dwt_listing_extra_profile_fields($user)
{
    ?>
    <h3><?php echo esc_html__('Package Information', 'dwt-listing-framework'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label><?php echo esc_html__('Package Name', 'dwt-listing-framework'); ?></label></th>
            <td>
                <?php
                if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
                    $package_id = '';
                    if (get_user_meta($user->ID, 'd_user_package_id', true) != "") {
                        $package_id = get_user_meta($user->ID, 'd_user_package_id', true);
                    }
                    $args = array(
                        'post_type' => 'product',
                        'tax_query' => array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'product_type',
                                'field' => 'slug',
                                'terms' => 'dwt_listing_pkgs'
                            ),
                            array(
                                'taxonomy' => 'product_type',
                                'field' => 'slug',
                                'terms' => 'subscription'
                            ),
                        ),
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'order' => 'DESC',
                        'orderby' => 'date'
                    );
                    $packages = new WP_Query($args);
                    if ($packages->have_posts()) {
                        ?>
                        <select class="admin-select" name="select_page">
                            <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                            <?php
                            while ($packages->have_posts()) {
                                $packages->the_post();
                                ?>
                                <option value="<?php echo get_the_ID(); ?>" <?php if ($package_id == get_the_ID()) {
                                    echo 'selected';
                                } ?>><?php echo get_the_title(); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" name="package_id" value="<?php echo esc_attr($package_id); ?>">
                        <?php
                        wp_reset_postdata();
                    }
                }
                ?>
                <br/><br/>
                <p class="description"><?php echo esc_html__('User selected package', 'dwt-listing-framework'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'dwt_listing_my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'dwt_listing_my_save_extra_profile_fields');

function dwt_listing_my_save_extra_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id))
        return false;
    if (isset($_POST['select_page']) && $_POST['select_page'] != "") {
        dwt_listing_store_user_package_admin($user_id, $_POST['select_page']);
    } else {
        update_user_meta($user_id, 'd_user_package_id', '');
    }
}