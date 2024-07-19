<div class="col-sm-12 col-md-12 col-xs-12">
    <div class="custom-form-field">
        <label class="control-label"><?php echo esc_html__('Date','dwt-listing'); ?></label>
        <div class="row row-date-start-end">
            <div class="col-sm-5 col-md-5 col-xs-12 date-search">
                <input type="text" class="form-control " placeholder="<?php echo esc_html__('Start Date','dwt-listing'); ?>"  autocomplete="off" id="event_start" name="by_date_start_filter" value="">
            </div>
            <div class="col-sm-5 col-md-5 col-xs-12 date-search">
                <input type="text" class="form-control " placeholder="<?php echo esc_html__('End Date','dwt-listing'); ?>"  autocomplete="off" id="event_end" name="by_date_end_filter" value="">
            </div>
            <div class="col-sm-2 col-md-2 col-xs-12 date-search">
                <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
            <span class="input-group-btn"><button id="get_start_date_filter" class="btn btn-default start-end-filter" type="button"><span class="fa fa-search"></span></button></span>
            </div>
        </div>
    </div>
</div>