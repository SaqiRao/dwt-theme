<?php
/* Template Name: Listing Compare */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */
?>
<?php
 get_header();
 $stock_id= "";
 $img_link= "";
if(in_array('dwt_listing_framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{  
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
                  if ( $results->have_posts() )
         {
             while ( $results->have_posts()) 
             {
                 $results->the_post();
                 $mw_id = get_the_ID();
                 //price
                //  $get_all_prices =  maxwheels_framework_fetch_price($mw_id);
                //  if(!empty($get_all_prices))
                //  {
                //       $final_price = $get_all_prices;
                //  }
                //  else
                //  {
                //      $final_price = '---';
                //  }

                 //gallery
                 $all_idz = dwt_listing_fetch_listing_gallery($mw_id);
                 if(!empty($all_idz) && is_array($all_idz))
                 {
                     $img_link .='<td class="border-top-0 w-25"> <div class="compare-img-box"> <a class="clr-black" href="'.esc_url(get_the_permalink($mw_id)).'"><img class="img-fluid" src="'.esc_url(dwt_listing_return_listing_idz($all_idz,'dwt_listing_woo-thumb')).'" alt="'.esc_attr(get_post_meta($all_idz, '_wp_attachment_image_alt', TRUE)).'"></a>
                     <div class="compare-title">
                     <a href="'.esc_url(get_the_permalink($mw_id)).'"><h1>'.get_the_title($mw_id).'</h1></a></div>
                     </div>
                     </td>';
                 }
                
               print_r($img_link);

				 //category
         $listing_cat =dwt_listing_listing_assigned_cats($mw_id);
         print_r($listing_cat);
         $compare_date="";
    	    $compare_date=get_the_date(get_option('date_format'),$mw_id);
          print_r($compare_date);
          $menu_all="";
         
                            
                                                
    
        // $category="";
				// // $object_terms = wp_get_object_terms($mw_id, 'mw-category', array('fields' => 'all_with_object_id', 'parent' => 0 ));
				//  if(!empty($listing_cat) && !is_wp_error($listing_cat) && is_array($listing_cat) && count($listing_cat) > 0)
				//  {
				// 	foreach ($listing_cat as $the_status)
				// 	{
				// 		$category.='<td class="off-make"><a class="my-cats" href="'.esc_url($search_page)."?category=".$the_status->slug.'">'.esc_html( $the_status->name ).'</a></td>';
            
        //   }
				//  }
				//  else
				//  {
				// 	  $category.='<td>---</td>';
				//  } 
				
				
                 //id
				 $stock_id.='<td>'.esc_html($mw_id).'</td>';    
                
               // features
                //  $features_list = array();
                //  $features_list = wp_get_object_terms($mw_id,array('mw-features'), array('orderby'=>'name','order'=> 'ASC'));
                //  if(!empty($features_list) && is_array($features_list) && count($features_list) > 0)
                //  {
                //      if (!is_wp_error($features_list))
                //      {
                //          $features_html .= '<td><ul class="custom-list">';   
                //          $anem_img = $img_atts = $image_id =  $feature_img = '';
                //          foreach( $features_list as $features )
                //          {
                //             $features_html .= '<li>
                //                <i class="fas fa-check-circle"></i> <span>'.esc_html($features->name).'</span>
                //             </li>';
                //          }
                //          $features_html .= '</ul></td>';   
                //      }
                //  }
             }
         }
         wp_reset_postdata(); 
       //  require trailingslashit(get_template_directory()) . 'template-parts/compare/compare-detial.php';
      // require trailingslashit(get_template_directory()) . 'template-parts\listing-detial\menu\menu.php';
     //require trailingslashit(get_template_directory()) . 'template-parts/compare/compare-listing-details.php';
     }
     else
     {
       echo "Your Listing is already set";
       $_SESSION = array(); 
       unset($_SESSION['compare_listings']);
     }
}
?>
<?php get_footer(); ?>