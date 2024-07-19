<?php
$street_address = '';
//selective
if (isset($_GET['street_address']) && $_GET['street_address'] != "") {
    $street_address = $_GET['street_address'];
} else {
    $user_city_location = isset($_COOKIE['user_city_location_custom']) ? $_COOKIE['user_city_location_custom'] : '';
    $street_address = $user_city_location;
}
?>
<div class="input-group">
    <div class="form-group has-feedback has-clear">
        <input type="text" class="form-control" placeholder="<?php echo esc_html($instance['title']); ?>"
               name="street_address" id="address_location" value="<?php echo esc_attr($street_address); ?>">
        <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
    </div>
    <span class="input-group-btn"><button id="l_loc" class="btn btn-default" type="button"><span
                    class="fa fa-search"></span></button></span>
</div>