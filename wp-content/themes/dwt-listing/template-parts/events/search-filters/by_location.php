<?php
$venue = '';
//selective
if (isset($_GET['by_location']) && $_GET['by_location'] != "") {
    $venue = $_GET['by_location'];
}
?>
<div class="col-md-4 col-xs-12 col-sm-4">
    <div class="location-filters">
        <label class="control-label"><?php echo esc_html__('By Location', 'dwt-listing'); ?></label>
        <div class="input-group">
            <div class="form-group has-icon has-clear">
                <input type="text" class="form-control" placeholder="<?php echo esc_html__('e.g. Event venues..', 'dwt-listing'); ?>"  name="by_location" id="by_location" value="<?php echo esc_attr($venue); ?>">
                <i class="detect-me fa fa-crosshairs"></i>
                <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
            </div>
            <span class="input-group-btn"><button id="get_locz" class="btn btn-default" type="button"><span class="fa fa-search"></span></button></span>
        </div>
    </div>
</div>