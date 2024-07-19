<div class="with_sidebar amenties_ajax"></div>
<?php
$number = '';
$number = 10;
if (!empty($term_ID)) {
    $terms = dwt_listing_categories_fetch('l_category', $term_ID);

    if (count((array) $terms) > 0 && !is_wp_error($terms)) {
        // make selective
        $my_class = $amenties = $selective = '';
        $my_class = 'in';
        if (isset($_GET['amenties']) && is_array($_GET['amenties'])) {
            $amenties = $_GET['amenties'];
        }
        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }
        ?>

        <div class="listing-widget amenties">
            <span class="amen-head"><?php echo esc_html($instance['title']); ?></span>
            <div id="amenties-dropdown"  class="collapse <?php echo esc_attr($my_class); ?>">
                <ul>
        <?php
        $hidden_after = $number;
        $show_readmore = false;
        foreach ($terms as $term) {
            if ($amenties != "") {
                $selective = (in_array($term->term_id, $amenties)) ? 'checked="checked"' : '';
            }
            ?>
                        <li>
                            <input id="<?php echo esc_attr($term->slug); ?>"  <?php echo esc_attr($selective); ?> name="amenties[]" value="<?php echo esc_attr($term->term_id); ?>" type="checkbox" class="custom-checkbox">
                            <label for="<?php echo esc_attr($term->slug); ?>"> <?php echo esc_attr($term->name); ?> </label>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

        <?php if ($show_readmore) { ?>
                    <a href="javascript:void(0)" class="show-more-button"><i class="ti-angle-down"></i></a>
                    <?php } ?>
            </div>
            <div class="form-group">
                <input id="d_getfilters" class="btn btn-theme btn-block" type="button" value="<?php echo esc_html__('Search', 'dwt-listing'); ?>">
            </div> 
        </div>
            <?php
            }
        }
        ?>