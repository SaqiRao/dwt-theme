<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$all_speakers = $profile->get_speaker_type($user_id);
$count_organizers = 0;
$count_speakers = 0;

$all_speaker = array();

foreach ($all_speakers as $speaker) {
    if (isset($speaker['type'])) {
        if ($speaker['type'] === 'organizer') {
            $count_organizers++;
        } elseif ($speaker['type'] === 'speaker') {
            $count_speakers++;
        }
    }
}
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo esc_html__('Speakers Overview', 'dwt-listing'); ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-blue text-blue">
                    <span class="icon "><i class="lnr lnr-mic"></i></span>
                    <p>
                        <span class="number"><?php echo $count_speakers; ?></span>
                        <span class="title"><?php echo esc_html__('Total Speakers', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-ame text-ame">
                    <span class="icon "><i class="lnr lnr-calendar-full"></i></span>
                    <p>
                        <span class="number"><?php echo $count_organizers; ?></span>
                        <span class="title"><?php echo esc_html__('Total Organizers', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>