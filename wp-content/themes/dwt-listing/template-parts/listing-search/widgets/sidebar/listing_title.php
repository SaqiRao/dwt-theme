<?php
$by_title = '';
//selective
if (isset($_GET['by_title']) && $_GET['by_title'] != "") {
    $by_title = $_GET['by_title'];
}
?>
<div class="form-group dwt-for-side">
    <div class="typeahead__container">
        <div class="typeahead__field">
            <div class="typeahead__query">
                <input name="by_title" value="<?php echo ($by_title); ?>" autocomplete="off" type="search" class="for_search_pages form-control specific_search" placeholder="<?php echo esc_html__('What Are You Looking For?', 'dwt-listing'); ?>">
            </div>
            <div class="typeahead__button dwt-search-s">
                <button type="button" id="get_title">
                    <span class="typeahead__search-icon"><i class="fa fa-search"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>