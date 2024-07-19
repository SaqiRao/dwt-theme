<?php
	$by_title = '';
	//selective
	if( isset( $_GET['by_title'] ) && $_GET['by_title'] != "" )
	{
		$by_title = $_GET['by_title'];
	}
?>
<div class="col-md-4 col-xs-12 col-sm-4">
	<div class="custom-form-field">
              <label class="control-label"><?php echo esc_html__('Title','dwt-listing'); ?></label>
              <div class="input-group">
            <div class="form-group has-icon has-clear">
              <input type="text" class="form-control " placeholder="<?php echo esc_html__('Seach by title','dwt-listing'); ?>"  autocomplete="off" name="by_title" value="<?php echo esc_attr($by_title); ?>">
              <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
            </div>
              <span class="input-group-btn"><button id="get_title" class="btn btn-default" type="button"><span class="fa fa-search"></span></button></span>
        </div>
    </div>
</div>