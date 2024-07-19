<?php
global $dwt_listing_options;
$speaker_id = get_the_ID();
$profile = new dwt_listing_profile();

//user info
$user_id = get_post_field('post_author', $speaker_id);
$get_user_dp = $get_user_url = $get_user_name = $get_loc = $contact_num = $get_profile_contact = $get_profile_email = '';
$get_user_dp = dwt_listing_listing_owner($speaker_id, 'dp');
$get_user_url = dwt_listing_listing_owner($speaker_id, 'url');
$get_user_name = dwt_listing_listing_owner($speaker_id, 'name');
$get_loc = dwt_listing_listing_owner($speaker_id, 'location');
$get_profile_contact = dwt_listing_listing_owner($speaker_id, 'contact');
$get_profile_email = dwt_listing_listing_owner($speaker_id, 'email');

// speaker data
$speaker_data = $profile->get_speaker_by_id($speaker_id);
$speaker_profession = isset($speaker_data['profession']) ? $speaker_data['profession'] : '';
$speaker_type = isset($speaker_data['type']) ? ucfirst($speaker_data['type']) : '';
$speaker_contact = isset($speaker_data['contact']) ? $speaker_data['contact'] : '';
$speaker_website = isset($speaker_data['website']) ? $speaker_data['website'] : '';
$speaker_email = isset($speaker_data['email']) ? $speaker_data['email'] : '';
$speaker_fb = isset($speaker_data['facebook']) ? $speaker_data['facebook'] : '';
$speaker_tw = isset($speaker_data['twitter']) ? $speaker_data['twitter'] : '';
$speaker_in = isset($speaker_data['linkedin']) ? $speaker_data['linkedin'] : '';
$speaker_yt = isset($speaker_data['youtube']) ? $speaker_data['youtube'] : '';
$speaker_insta = isset($speaker_data['instagram']) ? $speaker_data['instagram'] : '';
$speaker_wa = isset($speaker_data['whatsapp']) ? $speaker_data['whatsapp'] : '';
$questions = get_post_meta($speaker_id, 'dwt_listing_event_speaker_questions', true);
?>
<section class="single-post single-detail-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xs-12 col-md-8 col-sm-8">
                <div class="list-detail">
                    <div class="event-title-box">
                        <div class="list-heading">
                            <h2><?php echo get_the_title($speaker_id); ?></h2>
                        </div>
                    </div>
                    <?php get_template_part('template-parts/events/event-detial/modern/slider'); ?>
                    <div class="panel-group" id="accordion_listing_detial" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default panel-event-desc">
                                <div class="panel-heading">
                                    <h4 class="panel-title"> <a href="javascript:void(0)"> <i
                                                class=" ti-file "></i><?php echo esc_html__('Profession', 'dwt-listing'); ?>
                                        </a> </h4>
                                </div>
                                <div class="panel-collapse">
                                    <div class="panel-body">
                                        <?php echo esc_html__($speaker_profession, 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php if (isset($dwt_listing_options['dwt_add_speaker_skills_switch']) && $dwt_listing_options['dwt_add_speaker_skills_switch'] == 1) {
                            $speaker_skills = get_post_meta($speaker_id, 'dwt_listing_event_speaker_skills', true);
                            ?>
                            <div class="panel panel-default panel-event-desc">
                                <div class="panel-heading">
                                    <h4 class="panel-title"> <a href="javascript:void(0)"> <i
                                                class=" ti-notepad "></i><?php echo esc_html__('Skills', 'dwt-listing'); ?>
                                        </a> </h4>
                                </div>
                                <div class="panel-collapse">
                                    <div class="panel-body">
                                        <?php
                                        if (is_array($speaker_skills) && !empty($speaker_skills)) {
                                            $skills_string = '';
                                            foreach ($speaker_skills as $skill) {
                                                $skills_string .= esc_html(ucfirst($skill)) . ', ';
                                            }
                                            $skills_string = rtrim($skills_string, ', ');
                                            echo $skills_string;
                                        } else {
                                            echo esc_html__('No skills found', 'dwt-listing');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!--adding FAQs section -->
                        <?php
                            if (isset($dwt_listing_options['dwt_add_speaker_faqs_switch']) && $dwt_listing_options['dwt_add_speaker_faqs_switch'] == 1) {
                                if (isset($questions) && $questions != '') {

                                    ?>   
                                
                                    <div class="panel panel-default eventz-comments">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-comment-alt"></i><?php echo esc_html__('Frequently Asked Questions', 'dwt-listing'); ?></a> </h4>
                                        </div>
                                        <div class="panel-collapse">
                                            <div class="panel-body"> 
                                                <div class="single-blog blog-detial">
                                                    <div class="accordion_for_question">
                                                            <!--adding questions and answers sections--->
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                            <div class="accordion-item">
                                                                <?php
                                                                $count = 1;
                                                                if (is_array($questions) || is_object($questions)) {
                                                                    foreach ($questions as $ques) { ?>
                                                                    <?php $count++; ?>
                                                                    <h6 class="accordion-header" id="flush-headingOne">
                                                                        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseOne<?php echo $count; ?>" aria-expanded="false" aria-controls="flush-headingOne">
                                                                            <b><?php echo esc_html('Question:', 'dwt-listing'); ?> </b><?php echo $ques['question']; ?><i class="ti-arrow-circle-down"></i>
                                                                        </button>
                                                                    </h6>
                                                                    <div id="flush-collapseOne<?php echo $count; ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                                                                        <div class="accordion-body"><b> <?php echo esc_html('Answer:', 'dwt-listing'); ?></b> <?php echo $ques['answer']; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                } ?>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php } }?>
                            <!--adding FAQs section -->

                        <?php if (is_singular('events')) { ?>
                            <div class="events-post-navigation">
                                <div class="nav-links">
                                    <div class="nav-previous">
                                        <?php previous_post_link('%link', esc_html__('Previous Event', 'dwt-listing')); ?>
                                    </div>
                                    <div class="nav-next">
                                        <?php next_post_link('%link', esc_html__('Next Event', 'dwt-listing')); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="sidebar-panels">
                    <div class="panel panel-default side-event">
                        <div class="panel-heading">
                            <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-server"></i>
                                    <?php echo esc_html__('Speaker Information', 'dwt-listing'); ?> </a> </h4>
                        </div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                                <ul class="widget-listing-details">
                                    <?php if ($speaker_contact != "") { ?>
                                        <li> <span> <img
                                                    src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/phone.png'); ?>"
                                                    alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span> <span><a
                                                    href="tel:<?php echo $speaker_contact; ?>"><?php echo $speaker_contact; ?></a></span>
                                        </li>
                                    <?php } ?>
                                    <?php if ($speaker_email != "") { ?>
                                        <li> <span> <img
                                                    src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/email.png'); ?>"
                                                    alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span> <span> <a
                                                    href="mailto:<?php echo $speaker_email; ?>"><?php echo $speaker_email; ?></a></span>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    if (isset($dwt_listing_options['dwt_add_speaker_type_switch']) && $dwt_listing_options['dwt_add_speaker_type_switch'] == 1) {
                                        if ($speaker_type != "") { ?>
                                            <li id="speaker_type" data-toggle="tooltip" data-placement="top"
                                                title="<?php echo esc_html__('Speaker Type', 'dwt-listing'); ?>">
                                                <span> <img
                                                        src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/database.png'); ?>"
                                                        alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span>
                                                <span> <a href="#speaker_type"><?php echo $speaker_type; ?></a></span>
                                            </li>
                                        <?php }
                                    } ?>
                                    <?php
                                    if (isset($dwt_listing_options['dwt_add_speaker_education_switch']) && $dwt_listing_options['dwt_add_speaker_education_switch'] == 1) {
                                        $speaker_edu = get_post_meta($speaker_id, 'dwt_listing_event_speaker_edu', true);
                                        if ($speaker_edu != "") { ?>
                                            <li id="speaker_education" data-toggle="tooltip" data-placement="top"
                                                title="<?php echo esc_html__('Education', 'dwt-listing'); ?>">
                                                <span> <img
                                                        src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/medal.png'); ?>"
                                                        alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span>
                                                <span> <a href="#speaker_type"><?php echo $speaker_edu; ?></a></span>
                                            </li>
                                        <?php }
                                    } ?>
                                    <?php if ($speaker_website != "") { ?>
                                        <li data-toggle="tooltip" data-placement="top"
                                            title="<?php echo esc_html__('Speaker Website', 'dwt-listing'); ?>">
                                            <span> <img
                                                    src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/click.png'); ?>"
                                                    alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span>
                                            <span> <a href="<?php echo $speaker_website; ?>"
                                                    target="_blank"><?php echo $speaker_website; ?></a></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                                <?php
                                if (true) {
                                    ?>
                                    <ul class="social-media-event ">
                                        <?php if ($speaker_fb != "") { ?>
                                            <li><a target="_blank" href="<?php echo esc_url($speaker_fb); ?>"><i
                                                        class="ti-facebook"></i></a></li>
                                        <?php } ?>
                                        <?php if ($speaker_tw != "") { ?>
                                            <li><a target="_blank" href="<?php echo esc_url($speaker_tw); ?>"><i
                                                        class="ti-twitter"></i></a></li>
                                        <?php } ?>
                                        <?php if ($speaker_website != "") { ?>
                                            <li><a target="_blank" href="<?php echo esc_url($speaker_website); ?>"><i
                                                        class="ti-google"></i></a></li>
                                        <?php } ?>
                                        <?php if ($speaker_in != "") { ?>
                                            <li><a target="_blank" href="<?php echo esc_url($speaker_in); ?>"><i
                                                        class="ti-linkedin"></i></a></li>
                                        <?php } ?>
                                        <?php if ($speaker_yt != "") { ?>
                                            <li><a target="_blank" href="<?php echo esc_url($speaker_yt); ?>"><i
                                                        class="ti-youtube"></i></a></li>
                                        <?php } ?>
                                        <?php if ($speaker_insta != "") { ?>
                                            <li><a target="_blank" href="<?php echo esc_url($speaker_insta); ?>"><i
                                                        class=" ti-instagram"></i></a></li>
                                        <?php } ?>
                                        <?php if ($speaker_wa != "") { ?>
                                            <li> <a target="_blank"
                                                    href="https://api.whatsapp.com/send?phone=<?php echo ($speaker_wa); ?>"><i
                                                        class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (is_active_sidebar('dwt_listing_events_speakers-sidebar')) { ?>
                    <?php dynamic_sidebar('dwt_listing_events_speakers-sidebar'); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>