<?php
global $dwt_listing_options;
	$event_id	=	get_the_ID();
	//user dp
	$get_user_dp = dwt_listing_listing_owner($event_id,'dp');
	//user dp
	$get_user_url = dwt_listing_listing_owner($event_id,'url');
	//
	$get_user_name = dwt_listing_listing_owner($event_id,'name');



    $get_user_name = dwt_listing_listing_owner($event_id,'name');

?>
<div class="col-md-8 col-sm-7 col-xs-12">
<div class="entry-content">
        <div class="event-title-zone">
            <h3><?php echo get_the_title($event_id); ?> </h3>
            <div class="modern-version-block-info">
                <div class="post-author">
                    <a href="<?php echo esc_url($get_user_url); ?>"><img src="<?php echo esc_url($get_user_dp); ?>" alt="<?php echo get_the_title($event_id); ?>"></a> <?php echo esc_html__('By','dwt-listing'); ?> <a href="<?php echo esc_url($get_user_url); ?>"><?php echo esc_attr($get_user_name); ?></a>
                    <span class="spliator">ــ</span><?php echo esc_html__('Last Update on ','dwt-listing'); ?> <?php the_modified_date(get_option( 'date_format'), '<a href="javascript:void(0)">', '</a>'); ?>
                    <?php
					if( function_exists('pvc_get_post_views') )
					{
					 echo '<span class="spliator">ــ</span>'.esc_html__("Views ", 'dwt-listing').'  '.dwt_listing_number_format_short(pvc_get_post_views( $event_id)) .'';
					}
					?>
                </div>
            </div>
        </div>
        <h4><?php echo esc_html__('Description','dwt-listing'); ?></h4>
        <?php the_content(); ?>
        <?php
        $event_type = get_post_meta($event_id, 'dwt_listing_event_type', true);
        $share_webinar_link = get_post_meta($event_id, 'dwt_listing_share_webinar_link', true);

        if (isset($dwt_listing_options['dwt_event_type_switch']) && $dwt_listing_options['dwt_event_type_switch'] == 1) {
            if (isset($event_type) && $event_type == 'webinar') {
                if ($share_webinar_link == 'yes') { ?>
                    <div>
                        <h4><?php echo esc_html__('Webinar Link', 'dwt-listing'); ?></h4>
                            <?php $webinar_link = get_post_meta($event_id, 'dwt_listing_webinar_link', true); ?>
                            <button type="button" id="copy_webinar_link" class="btn btn-info" data-webinar-link="<?php echo esc_attr(isset($webinar_link) ? $webinar_link : ''); ?>">
                                <i class="ti-files"></i><?php echo esc_html(' Copy Link', 'dwt-listing') ?>
                            </button>
                    </div>
                <?php }
             }
        } ?>
    </div>
</div>