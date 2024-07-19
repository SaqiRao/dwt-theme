<?php
// Our custom post type function
function create_posttype_event_speakers()
{

    register_post_type(
        'speakers',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Event Speakers'),
                'singular_name' => __('Event Speaker')
            ),
            'supports' => array('title', 'editor', 'thumbnail', ),
            'key' => 'dwt_listing_author',
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'event_speakers'),
            'show_in_rest' => true,
        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype_event_speakers');
function create_event_speakers_posttype($post_id)
{

    global $post;

    if (isset($_POST['profession'])) {
        update_post_meta($post_id, 'speaker_profession', $_POST['speaker_profession']);
    }
    if (isset($_POST['speaker_contact'])) {
        update_post_meta($post_id, 'speaker_contact', $_POST['speaker_contact']);
    }
    if (isset($_POST['speaker_website_url'])) {
        update_post_meta($post_id, 'speaker_website_url', $_POST['speaker_website_url']);
    }
    if (isset($_POST['speaker_email_address'])) {
        update_post_meta($post_id, 'speaker_email_address', $_POST['speaker_email_address']);
    }
    if (isset($_POST['speaker_facebook_url'])) {
        update_post_meta($post_id, 'speaker_facebook_url', $_POST['speaker_facebook_url']);
    }
    if (isset($_POST['speaker_twitter_url'])) {
        update_post_meta($post_id, 'speaker_twitter_url', $_POST['speaker_twitter_url']);
    }
    if (isset($_POST['speaker_linkedin_url'])) {
        update_post_meta($post_id, 'speaker_linkedin_url', $_POST['speaker_linkedin_url']);
    }
    if (isset($_POST['speaker_youtube_url'])) {
        update_post_meta($post_id, 'speaker_youtube_url', $_POST['speaker_youtube_url']);
    }
    if (isset($_POST['order_status'])) {
        update_post_meta($post_id, 'order_status', $_POST['order_status']);
    }
    if (isset($_POST['speaker_whatsapp'])) {
        update_post_meta($post_id, 'speaker_whatsapp', $_POST['speaker_whatsapp']);
    }
    // Add image upload handling
    if (isset($_POST['speaker_image_id'])) {
        update_post_meta($post_id, 'speaker_image_id', absint($_POST['speaker_image_id']));
    }
    // Add speaker type handling
    if (isset($_POST['speaker_type'])) {
        update_post_meta($post_id, 'speaker_type', sanitize_text_field($_POST['speaker_type']));
    }
    if (isset($_POST['speaker_instagram_url'])) {
        update_post_meta($post_id, 'speaker_instagram_url', $_POST['speaker_instagram_url']);
    }
    if (isset($_POST['speaker_questions'])) {
        update_post_meta($post_id, 'speaker_questions', $_POST['speaker_questions']);
    }
}
add_action('save_post', 'create_event_speakers_posttype');


add_filter('manage_speakers_posts_columns', function ($columns) {

    $columns['title'] = __('Speaker Name', 'dwt-listing-framework');
    $columns['profession'] = __('Profession', 'dwt-listing-framework');
    $columns['whatsapp'] = __('Whatsapp', 'dwt-listing-framework');
    $columns['web_address'] = __('Web Url', 'dwt-listing-framework');
    $columns['email'] = __('Email', 'dwt-listing-framework');
    $columns['facebook'] = __('Facebook', 'dwt-listing-framework');
    $columns['twitter'] = __('Twitter', 'dwt-listing-framework');
    $columns['linkedin'] = __('Linkedin', 'dwt-listing-framework');
    $columns['youtube'] = __('Youtube', 'dwt-listing-framework');
    $columns['instagram']  =   __('Instagram', 'dwt-listing-framework');
    $columns['type']  =   __('Type', 'dwt-listing-framework');
    $columns['image']  =   __('Image', 'dwt-listing-framework');
    $columns['questions']  =   __('Questions', 'dwt-listing-framework');

    unset ($columns['date']);
    // unset( $columns['title'] );

    return $columns;

});
add_action('manage_speakers_posts_custom_column', function ($column_key, $event_speaker_post) {
    if ($column_key == 'title') {
        echo get_post_meta($event_speaker_post, 'dwt_event_speaker_name', true);
    }
    if ($column_key == 'profession') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_profession', true);
    }
    if ($column_key == 'whatsapp') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_whatsapp', true);
    }
    if ($column_key == 'web_address') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_website_url', true);
    }
    if ($column_key == 'email') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_email_address', true);
    }
    if ($column_key == 'facebook') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_facebook_url', true);
    }
    if ($column_key == 'twitter') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_twitter_url', true);
    }
    if ($column_key == 'linkedin') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_linkedin_url', true);
    }
    if ($column_key == 'youtube') {
        echo get_post_meta($event_speaker_post, 'dwt_listing_event_speaker_youtube_url', true);
    }
    if ($column_key == 'instagram'){
        echo get_post_meta( $event_speaker_post, 'dwt_listing_event_speaker_instagram_url', true );   
    }
    if ($column_key == 'type'){
        echo get_post_meta( $event_speaker_post, 'dwt_listing_event_speaker_type', true );   
    }
    if ($column_key == 'image'){
        echo get_post_meta( $event_speaker_post, 'dwt_listing_event_speaker_image_id', true );   
    }
    if ($column_key == 'questions'){
        echo get_post_meta( $event_speaker_post, 'dwt_listing_event_speaker_questions', true );   
    }

}, 10, 2, );