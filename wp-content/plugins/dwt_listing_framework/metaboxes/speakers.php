<?php
    function wporg_add_custom_speakers() {
        $screens = [ 'post', 'speakers' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'wporg_box_id',                 
                'Add Speaker Information',     
                'wporg_custom_speakers_html',  
                $screen                            
            );
        }
    }
    
    add_action( 'add_meta_boxes', 'wporg_add_custom_speakers' );


    //getting post meta

    function wporg_custom_speakers_html( $post ) {    ?>
            <input type="hidden" id="listing_nonce" name="listing_nonce" value="234a1906ec"><input type="hidden" name="_wp_http_referer" value="/dwt-listing/wp-admin/post-new.php?post_type=listing">        <div id="dwt_listing_loading" class="loading"></div>
            <table class="form-table ">
                <tbody>
                <?php
                $events_speakers_profession = $events_speakers_contact = $events_speakers_web_url = $events_speakers_email = $events_speakers_fb_url = $events_speakers_twitter_url =
                $events_speakers_linkedin_url = $events_speakers_youtube_url = $events_speakers_insta_url = $events_speakers_whatsapp = '';
               
                $events_speakers_profession =  get_post_meta($post->ID, 'dwt_listing_event_speaker_profession', true);
                $events_speakers_contact =  get_post_meta($post->ID, 'dwt_listing_event_speaker_contact', true);
                $events_speakers_web_url =  get_post_meta($post->ID, 'dwt_listing_event_speaker_website_url', true);
                $events_speakers_email =  get_post_meta($post->ID, 'dwt_listing_event_speaker_email_address', true);
                $events_speakers_fb_url =  get_post_meta($post->ID, 'dwt_listing_event_speaker_facebook_url', true);
                $events_speakers_twitter_url =  get_post_meta($post->ID, 'dwt_listing_event_speaker_twitter_url', true);
                $events_speakers_linkedin_url =  get_post_meta($post->ID, 'dwt_listing_event_speaker_linkedin_url', true);
                $events_speakers_youtube_url =  get_post_meta($post->ID, 'dwt_listing_event_speaker_youtube_url', true);
                $events_speakers_insta_url =  get_post_meta($post->ID, 'dwt_listing_event_speaker_insta_url', true);
                $events_speakers_whatsapp =  get_post_meta($post->ID, 'dwt_listing_event_speaker_whatsapp', true);
                ?>
                    <tr id="additional_fields" class="none">
                        <th><label><?php echo esc_html__('Additional Fields','dwt-listing-framework');?></label></th>
                        <td>
                            <div class="additional_custom_fields"><div class="category-based-features"> </div></div>
                        </td>
                    </tr>

                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Profession','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_profession" name="speaker_profession" placeholder="<?php echo esc_attr__('Profession','dwt-listing-framework');?>" value="<?php echo esc_attr($events_speakers_profession);?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Contact Number','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_contact" name="speaker_contact" placeholder="<?php echo esc_attr__('+99 3331 234567','dwt-listing-framework');?>" value="<?php echo esc_attr($events_speakers_contact);?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Website URL','dwt-listing-framework');?><?php echo esc_html__('Website URL','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_website_url" name="speaker_website_url" placeholder="<?php echo esc_attr__('https://www.yourdomain.com/','dwt-listing-framework');?>" value="<?php echo esc_attr($events_speakers_web_url);?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('','dwt-listing-framework');?>Email Address</label></th>
                        <td>
                            <input type="text" id="speaker_email_address" name="speaker_email_address" placeholder="<?php echo esc_attr__('xyx@abc.com','dwt-listing-framework');?>" value="<?php echo esc_attr($events_speakers_email);?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Facebook','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_facebook_url" name="speaker_facebook_url" placeholder="" value="<?php echo esc_attr($events_speakers_fb_url);?>">
                            <p class="description"><?php echo esc_html__('Facebook URL','dwt-listing-framework');?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Twitter','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_twitter_url" name="speaker_twitter_url" placeholder="" value="<?php echo esc_attr($events_speakers_twitter_url);?>">
                            <p class="description"><?php echo esc_html__('Twitter URL','dwt-listing-framework');?></p>
                        </td>
                    </tr>
                
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Linked IN','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_linkedin_url" name="speaker_linkedin_url" placeholder="" value="<?php echo esc_attr($events_speakers_linkedin_url);?>">
                            <p class="description"><?php echo esc_html__('Linked IN URL','dwt-listing-framework');?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Youtube URL','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_youtube_url" name="speaker_youtube_url" placeholder="" value="<?php echo esc_attr($events_speakers_youtube_url);?>">
                            <p class="description"><?php echo esc_html__('Youtube URL','dwt-listing-framework');?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('Instagram URL','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_insta_url" name="speaker_insta_url" placeholder="" value="<?php echo esc_attr($events_speakers_insta_url);?>">
                            <p class="description"><?php echo esc_html__('Instagram URL','dwt-listing-framework');?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label class="claimer_contact_label"><?php echo esc_html__('WhatsApp Number','dwt-listing-framework');?></label></th>
                        <td>
                            <input type="text" id="speaker_whatsapp" name="speaker_whatsapp" placeholder="" value="<?php echo esc_attr($events_speakers_whatsapp);?>">
                            <p class="description"><?php echo esc_html__('WhatsApp Number','dwt-listing-framework');?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        
            <?php   
    }

    function wporg_save_speakers_postdata( $post_id ) {
        global $post; 
        if (isset($post-> post_type) && $post-> post_type != 'speakers'){
            return;
        }
        $speaker_profession = isset($_POST['speaker_profession']) ? sanitize_text_field($_POST['speaker_profession']) : '';
        $speaker_contact_number = isset($_POST['speaker_contact']) ? sanitize_text_field($_POST['speaker_contact']) : '';
        $speaker_website = isset($_POST['speaker_website_url']) ? sanitize_text_field($_POST['speaker_website_url']) : '';
        $speaker_email_address = isset($_POST['speaker_email_address']) ? sanitize_text_field($_POST['speaker_email_address']) : '';
        $speaker_fb = isset($_POST['speaker_facebook_url']) ? sanitize_text_field($_POST['speaker_facebook_url']) : '';
        $speaker_twitter = isset($_POST['speaker_twitter_url']) ? sanitize_text_field($_POST['speaker_twitter_url']) : '';
        $speaker_linkedin = isset($_POST['speaker_linkedin_url']) ? sanitize_text_field($_POST['speaker_linkedin_url']) : '';
        $speaker_youtube_url = isset($_POST['speaker_youtube_url']) ? sanitize_text_field($_POST['speaker_youtube_url']) : '';
        $speaker_insta_url = isset($_POST['speaker_insta_url']) ? sanitize_text_field($_POST['speaker_insta_url']) : '';
        $speaker_whatsapp_number = isset($_POST['speaker_whatsapp']) ? sanitize_text_field($_POST['speaker_whatsapp']) : '';

        // Update the meta field in the database.
        update_post_meta($post_id, 'dwt_listing_event_speaker_profession', $speaker_profession);
        update_post_meta($post_id, 'dwt_listing_event_speaker_contact', $speaker_contact_number);
        update_post_meta($post_id, 'dwt_listing_event_speaker_website_url', $speaker_website);
        update_post_meta($post_id, 'dwt_listing_event_speaker_email_address', $speaker_email_address);
        update_post_meta($post_id, 'dwt_listing_event_speaker_facebook_url', $speaker_fb);
        update_post_meta($post_id, 'dwt_listing_event_speaker_twitter_url', $speaker_twitter);
        update_post_meta($post_id, 'dwt_listing_event_speaker_linkedin_url', $speaker_linkedin);
        update_post_meta($post_id, 'dwt_listing_event_speaker_youtube_url', $speaker_youtube_url);
        update_post_meta($post_id, 'dwt_listing_event_speaker_insta_url', $speaker_insta_url);
        update_post_meta($post_id, 'dwt_listing_event_speaker_whatsapp', $speaker_whatsapp_number);
   
    }
    add_action( 'save_post', 'wporg_save_speakers_postdata' );