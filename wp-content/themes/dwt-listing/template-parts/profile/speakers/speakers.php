<?php
global $dwt_listing_options;
$paged = 1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$all_speakers = $profile->get_all_speakers($user_id, $paged);
$count = $profile->get_speaker_count($user_id);
$permalink = get_the_permalink();
?>

<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/speaker', 'stats'); ?>
    <div class="panel panel-headline">
        <div class="panel-heading">

            <h2>Event Speakers/Organizers</h2>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive dwt-admin-tabelz">
                        <?php if ($count > 0) { ?>
                            <table class="dwt-admin-tabelz-panel table-hover my-order-history">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <?php if(isset ($dwt_listing_options['dwt_add_speaker_type_switch']) && $dwt_listing_options['dwt_add_speaker_type_switch'] == 1){ ?>
                                        <th>Type</th>
                                        <?php } ?>
                                        <th>Profession</th>
                                        <th>Edit</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($all_speakers as $speaker):
                                        $media = dwt_listing_fetch_speaker_gallery($speaker['id']);
                                        ?>
                                        <tr>
                                            <td><span class="admin-listing-img"><a
                                                        href="<?php echo get_the_permalink($speaker['id']); ?>">
                                                        <img class="img-responsive"
                                                            src="<?php echo dwt_listing_return_event_idz($media, 'dwt_listing_user-dp'); ?>"
                                                            alt="<?php echo get_the_title($speaker['id']); ?>"></a></span>
                                            </td>
                                            <td><?php echo esc_html($speaker['name']); ?></td>
                                            <?php if(isset ($dwt_listing_options['dwt_add_speaker_type_switch']) && $dwt_listing_options['dwt_add_speaker_type_switch'] == 1){ ?>
                                            <td><?php echo esc_html(ucfirst($speaker['type'])); ?></td>
                                            <?php } ?>
                                            <td><?php echo esc_html(ucfirst($speaker['profession'])); ?></td>
                                            <td>
                                                <?php
                                                $speaker_edit_url = dwt_listing_set_url_params_multi($permalink, array('listing-type' => 'create-speaker', 'edit_speaker' => esc_attr($speaker['id'])));
                                                ?>
                                                <a class="tool-tip" title="<?php echo esc_attr__('Edit', 'dwt-listing'); ?>"
                                                    href="<?php echo esc_url(dwt_listing_page_lang_url_callback($speaker_edit_url)); ?>"><i
                                                        class="ti-pencil-alt"></i></a>
                                            </td>
                                            <td>
                                                <span class="action-icons active">
                                                    <a href="<?php echo esc_url(get_permalink($speaker['id'])); ?>"
                                                        class="label label-info tool-tip"
                                                        title="<?php echo esc_html__('View Speaker', 'dwt-listing'); ?>"> <i
                                                            class="lnr lnr-menu"></i></a>
                                                    <a class="tool-tip delete-my-speaker"
                                                        title="<?php echo esc_attr__('Delete', 'dwt-listing'); ?>"
                                                        href="javascript:void(0)"
                                                        data-speaker-id="<?php echo esc_attr($speaker['id']); ?>"><i
                                                            class="ti-trash text-danger"></i></a>
                                                </span>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p><strong>No Speakers found...</strong></p><?php } ?>
                        <!-- <div class="admin-pagination">
                            <?php echo dwt_listing_listing_pagination($all_speakers); ?>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>