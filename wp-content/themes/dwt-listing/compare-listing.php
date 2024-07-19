<?php
global $listing_comparison_variable;
if(in_array('dwt_listing_framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
?>    
<div id="compare-toolbox" class="">
    
<div class="panel">
<div class="panel-heading">
<span class="panel-icon">
<i class="fas fa-random"></i>
</span>
<span class="panel-title"><?php echo $listing_comparison_variable("mw_compare_heading"); ?></span>
</div>
<div class="panel-body ">  
    <div class="dynamic_compare">
        <?php
         $comparison_ids = array();
         
         if(!empty($_SESSION['compare_listings']) && is_array($_SESSION['compare_listings']) && count($_SESSION['compare_listings']) > 0)
         {
            foreach ($_SESSION['compare_listings'] as $compare_id)
            {
                 $comparison_ids[] = $compare_id;
            }
            // query
            $args = array(  
                'post_type' => 'listing',
                'post_status' => 'publish',
                'posts_per_page' => 3,
                'post__in'=> $comparison_ids,
                 'fields' => 'ids',
                'orderby' => 'date', 
                'order' => 'DESC',
            );
             $results = new WP_Query( $args );
             $page_link = '#';
             if ( $results->have_posts() )
             {
                 $page_link = dwt_framwork_get_link('page-compare.php');
                 $all_idz = '';
                 $i = 1;
                 while ( $results->have_posts() ) 
                 {
                     $results->the_post();
                     $dwt_listing_id = get_the_ID();
                     $all_idz = dwt_listing_fetch_listing_gallery($dwt_listing_id);
                     if ($i == 2 || $i == 3){ echo'<div class="vsbox">vs</div>'; }
                     echo '<div class="compare-listings-box">
                          <a href="javascript:void(0)" class="remove_compare_list" data-property-id="'.esc_attr($dwt_listing_id).'"><i class="fas fa-times"></i></a>
                          <a class="clr-black" href="'.esc_url(get_the_permalink($dwt_listing_id)).'"> <img class="img-fluid" src="'.esc_url(dwt_listing_return_listing_idz($all_idz,'dwt_listing_about_image_for_comparison')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
                        </div>';
                     $i++;
                 }
                 echo '<div class="compare-action-btns">
                    <a class="btn btn-theme btn-block btn-custom-sm" href="'.esc_url($page_link).'">'.esc_html__('Compare','dwt-listing').'</a>
                    <a class="btn btn-warning btn-block btn-custom-sm clear-all-compare">'.esc_html__('Clear All','dwt-listing').'</a>
                 </div>
                 ';
             }
             wp_reset_postdata(); 
         }
         
        ?>
    </div>
</div>
</div>
</div>
<?php
}