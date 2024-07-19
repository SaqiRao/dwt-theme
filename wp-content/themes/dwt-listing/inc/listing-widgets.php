<?php
// Listing Categories widget
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_cats_search');
});
if (!class_exists('dwt_listing_listing_cats_search')) {

    class dwt_listing_listing_cats_search extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_cats_search',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search Categories', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            $term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
            $queried_object = get_queried_object();
            if (!empty($queried_object) && count((array) $queried_object) > 0) {
                $term_id = $queried_object->term_id;
                $tax_name = $queried_object->taxonomy;
                if (!empty($term_id)) {
                    $term_idz = get_term_by('id', $term_id, $tax_name);
                    $term_ID = $term_idz->term_id;
                }
            }
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/categories.php';
            }
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Categories', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Categories widget
}

// Listing Title Search Widget
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_title_search');
});
if (!class_exists('dwt_listing_listing_title_search')) {

    class dwt_listing_listing_title_search extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_title_search',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search By Title', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/listing_title.php';
            }

        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Search By Title', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}


// Listing Search By Amenties  
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_amenties_search');
});
if (!class_exists('dwt_listing_listing_amenties_search')) {

    class dwt_listing_listing_amenties_search extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_amenties_search',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search By Amenties', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            $term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
            $queried_object = get_queried_object();
            if (!empty($queried_object) && count((array) $queried_object) > 0) {
                $term_id = $queried_object->term_id;
                $tax_name = $queried_object->taxonomy;
                if (!empty($term_id)) {
                    $term_idz = get_term_by('id', $term_id, $tax_name);
                    $term_ID = $term_idz->term_id;
                }
            }
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/amenties.php';
            }
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Search By Amenties', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}


// Listing By Price
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_by_price');
});
if (!class_exists('dwt_listing_listing_by_price')) {

    class dwt_listing_listing_by_price extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_by_price',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search By Price Type', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/price_type.php';
            }
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Listing Search By Price Type', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}


// Listing Business Status Open Closed
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_open_closed');
});
if (!class_exists('dwt_listing_listing_open_closed')) {

    class dwt_listing_listing_open_closed extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_open_closed',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search By Open Closed', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/business_status.php';
            }
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Search By Status', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}


// Listing Street Location
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_streent_location');
});
if (!class_exists('dwt_listing_listing_streent_location')) {

    class dwt_listing_listing_streent_location extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_streent_location',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search By Street Address', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/street_address.php';
            }
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Listing By Street Address', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}


// Listing Rated As
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_rated_as');
});
if (!class_exists('dwt_listing_listing_rated_as')) {

    class dwt_listing_listing_rated_as extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_rated_as',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search By Rating', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/ratings.php';
            }
        }
        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Search By Rating', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}

// Listing Country Location
add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_custom_location');
});
if (!class_exists('dwt_listing_listing_custom_location')) {

    class dwt_listing_listing_custom_location extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_custom_location',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search Custom Location', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            if ($layout_type == 'sidebar') {
                require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/custom_locations.php';
            }
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Search By Custom Location', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

    // Listing Title Search Widget
}


// Advertisement  Widget
add_action('widgets_init', function () {
    register_widget('dwt_listing_advertisement_slots');
});
if (!class_exists('dwt_listing_advertisement_slots')) {

    class dwt_listing_advertisement_slots extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_advertisement_slots',
                'description' => __('for search and single listing & sidebar.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('DWT Listing Ad Slots', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            $ad_code = $instance['ad_code'];
            global $dwt_listing_options;
            if ($instance['title'] != "") {
                echo '<h4>' . esc_html($instance['title']) . '</h4>';
            }
            ?>
            <div class="advertizing-slots">
                <?php echo "" . $ad_code; ?>
            </div>
            <?php
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Advertisement', 'dwt-listing');
            }
            $ad_code = '';
            if (isset($instance['ad_code'])) {
                $ad_code = $instance['ad_code'];
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('ad_code')); ?>">
                    <?php echo esc_html__('Code:', 'dwt-listing'); ?>
                </label>
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('ad_code')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('ad_code')); ?>"
                    type="text"><?php echo esc_attr($ad_code); ?></textarea>
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['ad_code'] = (!empty($new_instance['ad_code'])) ? $new_instance['ad_code'] : '';
            return $instance;
        }

    }

    // Advertisement
}


// Featured Listing Widget
add_action('widgets_init', function () {
    register_widget('dwt_listing_featured_listing_sopt');
});
if (!class_exists('dwt_listing_featured_listing_sopt')) {

    class dwt_listing_featured_listing_sopt extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_featured_listing_sopt',
                'description' => __('for search and single listing & sidebar.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('DWT Featured Listings', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            $max_ads = $instance['max_ads'];
            global $dwt_listing_options;
            $title = '';

            if (is_page_template('page-authors.php')) {
                if ($instance['title'] != "") {
                    $title = '<div class="widget-heading"><h4 class="panel-title">' . esc_html($instance['title']) . '</h4></div>';
                    $s_div = '<div class="extra-sp">';
                    $end_div = '</div>';
                }
            } else {
                if ($instance['title'] != "") {
                    $title = '<h4>' . esc_html($instance['title']) . '</h4>';
                    $s_div = '';
                    $end_div = '';
                }
            }
            $no_white = '';
            if (dwt_listing_text('dwt_listing_lp_style') == 'elegent') {
                $no_white = 'no-white';
            }
            ?>
            <div class="<?php echo esc_attr($no_white); ?> widget papular-listing-72">
                <?php
                echo '' . $title;
                echo $s_div
                    ?>
                <?php
                $custom_location = '';
                if (dwt_listing_countires_cookies() != "") {
                    $custom_location = array(
                        array(
                            'taxonomy' => 'l_location',
                            'field' => 'term_id',
                            'terms' => dwt_listing_countires_cookies(),
                        ),
                    );
                }
                $args = array(
                    'post_type' => 'listing',
                    'post_status' => 'publish',
                    'posts_per_page' => $max_ads,
                    'tax_query' => array(
                        $custom_location,
                    ),
                    'meta_query' => array(
                        array(
                            'key' => 'dwt_listing_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'dwt_listing_listing_status',
                            'value' => '1',
                            'compare' => '='
                        ),
                    ),
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $results = new WP_Query($args);
                $business_hours_status = $media = $get_user_dp = $get_user_url = $categories = $status_type = $ratings = '';
                if ($results->have_posts()) {
                    while ($results->have_posts()) {
                        $results->the_post();
                        $listing_id = get_the_ID();
                        //get media
                        $media = dwt_listing_fetch_listing_gallery($listing_id);
                        //user dp
                        $get_user_dp = dwt_listing_listing_owner($listing_id, 'dp');
                        //user dp
                        $get_user_url = dwt_listing_listing_owner($listing_id, 'url');
                        //listing category
                        $categories = dwt_listing_listing_assigned_cats($listing_id, 'grid1');
                        //Business Hours
                        if (dwt_listing_business_hours_status($listing_id) != "") {
                            $status_type = dwt_listing_business_hours_status($listing_id);
                            if ($status_type == 0) {
                                $business_hours_status = '<div class="timing"> <span class="closed">' . esc_html__('Closed', 'dwt-listing') . '</span></div>';
                            } else if ($status_type == 2) {
                                $business_hours_status = '<div class="timing"> <span class="always-opened">' . esc_html__('Always Open', 'dwt-listing') . '</span></div>';
                            } else {
                                $business_hours_status = '<div class="timing"> <span class="opened">' . esc_html__('Open Now', 'dwt-listing') . '</span></div>';
                            }
                        }
                        //Ratings
                        if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                            $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                            if (isset($get_percentage) && count((array) $get_percentage['ratings']) > 0 && count((array) $get_percentage['rated_no_of_times']) > 0) {
                                $ratings = '<div class="ratings elegent">' . $get_percentage['total_stars'] . ' <i class="rating-counter">' . $get_percentage['average'] . '</i></div>';
                            }
                        }
                        ?>
                        <div class="listing-item">
                            <div class="listing-img"><a href="<?php echo get_the_permalink($listing_id); ?>" class="post-img"><img
                                        src="<?php echo dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids'); ?>"
                                        class="img-responsive" alt="<?php echo get_the_title($listing_id); ?>"></a>
                                <div class="profile-avtar">
                                    <a href="<?php echo esc_url($get_user_url); ?>"><img src="<?php echo esc_url($get_user_dp); ?>"
                                            class="img-responsive" alt="<?php echo get_the_title($listing_id); ?>"></a>
                                </div>
                                <?php echo '' . ($business_hours_status); ?>
                                <div class="listing-details">
                                    <?php echo '' . ($categories); ?>
                                    <h4>
                                        <a href="<?php echo get_the_permalink($listing_id); ?>">
                                            <?php echo dwt_listing_words_count(get_the_title(), $dwt_listing_options['grid_title_limit']); ?>
                                        </a>
                                    </h4>
                                    <?php echo '' . $ratings; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                wp_reset_postdata();
                echo $end_div;
                ?>
            </div>
            <!-- Featured Ads -->
            <?php
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Featured Listings', 'dwt-listing');
            }
            if (isset($instance['max_ads'])) {
                $max_ads = $instance['max_ads'];
            } else {
                $max_ads = 5;
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_ads')); ?>">
                    <?php echo esc_html__('Max # of Listings:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_ads')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('max_ads')); ?>" type="text"
                    value="<?php echo esc_attr($max_ads); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['max_ads'] = (!empty($new_instance['max_ads'])) ? strip_tags($new_instance['max_ads']) : '';
            return $instance;
        }

    }

    // Featured Listing
}


add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_tags_search');
});
if (!class_exists('dwt_listing_listing_tags_search')) {

    class dwt_listing_listing_tags_search extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_tags_search',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search Tags', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            $term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
            $queried_object = get_queried_object();
            if (!empty($queried_object) && count((array) $queried_object) > 0) {
                $term_id = $queried_object->term_id;
                $tax_name = $queried_object->taxonomy;
                if (!empty($term_id)) {
                    $term_idz = get_term_by('id', $term_id, $tax_name);
                    $term_ID = $term_idz->term_id;
                }
            }
            require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/l_tags.php';
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Filter by Tags', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }
    }
    // Categories widget
}










/************************************adding my ow widget here */









add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_reservations');
});
if (!class_exists('dwt_listing_listing_reservations')) {

    class dwt_listing_listing_reservations extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_reservations',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search Tags', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            $term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
            $queried_object = get_queried_object();
            if (!empty($queried_object) && count((array) $queried_object) > 0) {
                $term_id = $queried_object->term_id;
                $tax_name = $queried_object->taxonomy;
                if (!empty($term_id)) {
                    $term_idz = get_term_by('id', $term_id, $tax_name);
                    $term_ID = $term_idz->term_id;
                }
            }
            require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/l_tags.php';
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Filter by Tags', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }
    }
    // Categories widget
}




add_action('widgets_init', function () {
    register_widget('dwt_listing_listing_reservations');
});
if (!class_exists('dwt_listing_listing_reservations')) {

    class dwt_listing_listing_reservations extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'dwt_listing_listing_reservations',
                'description' => __('Only for search page.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Listing Search Tags', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $dwt_listing_options;
            $layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
            $term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
            $queried_object = get_queried_object();
            if (!empty($queried_object) && count((array) $queried_object) > 0) {
                $term_id = $queried_object->term_id;
                $tax_name = $queried_object->taxonomy;
                if (!empty($term_id)) {
                    $term_idz = get_term_by('id', $term_id, $tax_name);
                    $term_ID = $term_idz->term_id;
                }
            }
            require trailingslashit(get_template_directory()) . 'template-parts/listing-search/widgets/' . $layout_type . '/l_tags.php';
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Filter by Tags', 'dwt-listing');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }
    }
    // Categories widget
}


function register_appointment_system_widget()
{
    register_widget('appointment_widget');
}
add_action('widgets_init', 'register_appointment_system_widget');
class appointment_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'appointment_widget',
            // widget name
            __('DWT Appointment System Widget', ' dwt-listing'),
            // widget description
            array(
                'description' => __('DWT Appointment System Widget', 'dwt-listing'),
            )
        );
    }
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        //if title is present
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        //output
        ?>
        <?php
        $listing_id = get_the_ID();
        global $current_user;
        wp_get_current_user();
        // $meeting_type = get_post_meta($listing_id, 'meeting_type');
        // print_r($meeting_type);
        // if ( is_user_logged_in() ) { 
        //     $listing_title= $current_user->user_login;   
        // } 
        //    else { wp_loginout(); }


        ?>

        <?php
        global $dwt_listing_options;

        // print_r($dwt_listing_options['dwt_listing_booking_reservation']);
        if (isset($dwt_listing_options['dwt_listing_booking_reservation']) && $dwt_listing_options['dwt_listing_booking_reservation'] == 1) {

            global $dwt_listing_options;
            $table_price = get_post_meta($listing_id, 'price_of_table', true);

            //global $table_price;
            $type_of_ads = get_post_meta($listing_id, 'type_of_ads', true);
            $is_appointment_allowd = get_post_meta($listing_id, 'dwt_listing_reservation_day', true);
            if ($is_appointment_allowd && $is_appointment_allowd = 1) {

                $check_business_hours = get_post_meta($listing_id, 'dwt_listing_is_hours_allow', true);
                if (isset($check_business_hours) && $check_business_hours != '1') {
                } else {
                    if (isset($dwt_listing_options['dwt_listing_booking_reservation']) && $dwt_listing_options['dwt_listing_booking_reservation'] == 1) {

                        $listing_reservation_type = get_post_meta($listing_id, 'listings_reservations', true);
                        $restricted_days = get_post_meta($listing_id, 'restricted_days', true);
                        $post_author = get_post_field('post_author', $listing_id);
                        if (!is_user_logged_in()) { ?>
                            <div class="make_appointment">
                                <i class="ti-calendar"></i>
                                <span>
                                    <?php echo esc_html__('Make an Appointment', 'dwt-listing'); ?>
                                </span>
                            </div>
                            <div class="alert custom-alert custom-alert--warning" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Login To Make An Appointment', 'dwt-listing'); ?>
                                        </h6>

                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="utf_box_widget reservation_section">
                                <div class="reservation-form">
                                    <div class="reservation-head">

                                        <div class="billing-icon">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                        </div>
                                        <div class="billing-head">
                                            <h4>
                                                <?php echo esc_html__('Reservation Information', 'dwt-listing'); ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="reservation-form-body">
                                        <form id="reservation_information">
                                            <div class="form-group">
                                                <label for="inputfirstname">
                                                    <?php echo esc_html__('Your Name', 'dwt-listing'); ?>
                                                </label>
                                                <input name="reserver_name" required class="form-control" type="text" id="inputfirstname"
                                                    autocomplete="off" placeholder="<?php echo esc_attr('Your Name', 'dwt-listing'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputmobnumber">
                                                    <?php echo esc_html__('Mobile Number', 'dwt-listing'); ?>
                                                </label>
                                                <input name="reserver_number" required class="form-control" type="number" id="inputmobnumber"
                                                    autocomplete="off" placeholder="<?php echo esc_attr('Mobile Number', 'dwt-listing'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    <?php echo esc_html__('Email', 'dwt-listing'); ?>
                                                </label>
                                                <input name="reserver_email" required type="email" class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp" autocomplete="off">
                                                <small id="emailHelp" class="form-text text-muted">
                                                    <?php echo esc_html__("We'll never share your email with anyone else.", 'dwt-listing'); ?>
                                                </small>
                                            </div>

                                            <input type="hidden" value="<?php echo $listing_id; ?>" name="reserverID" id="reserverID">
                                            <input type="hidden" value="<?php echo $type_of_ads; ?>" name="type_of_ads" id="type_of_ads">
                                            <input type="hidden" value="<?php echo $table_price; ?>" name="table_price" id="table_price">
                                            <input type="hidden" value="<?php echo get_the_title($listing_id); ?>" name="listing_title">
                                            <input type="hidden" value="" name="booking-date" id="booking-date">
                                            <input type="hidden" value="" name="booking-slot" id="booking-slot">
                                            <?php
                                            if (!is_user_logged_in()) {
                                                return $response = array('success' => false, 'data' => '', 'message' => __("You need to logged in", "dwt-listing"));
                                                echo esc_html__('Please log in to add a reservation', 'dwt-listing');
                                            } else {
                                                ?>

                                                <br>
                                                <?php
                                                $meeting_type = get_post_meta($listing_id, 'meeting_type');

                                                if (isset($meeting_type[0]) && $meeting_type[0] == 'both') {
                                                    ?>
                                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                                        <label for="reservationType" class="pull-left">Select Meeting Type:</label>
                                                        <div class="dropdown pull-left">
                                                            <select class="form-control" id="appointment_reservationType">
                                                                <option value="physical_meeting">
                                                                    <?php echo esc_html__('Physical Meeting', 'dwt-listing'); ?>
                                                                </option>
                                                                <option value="virtual_meeting">
                                                                    <?php echo esc_html__('Virtual Meeting', 'dwt-listing'); ?>
                                                                </option>
                                                            </select>
                                                            <?php $id = get_the_ID(); ?>
                                                            <input type="hidden" id="listing_id" value="<?php echo $id; ?>">
                                                        </div>
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <?php //echo ($meeting_type[0]); ?>
                                                    <input type="hidden" id="listing_app_meeting_type" value="<?php echo $meeting_type[0]; ?>">
                                                <?php } ?>

                                                <button class="btn btn-primary" id="submit_reservation">
                                                    <?php echo esc_attr('Submit', 'dwt-listing'); ?>
                                                </button>
                                                <button class="btn btn-primary" type="button" id="cancel_reservation">
                                                    <?php echo esc_html__('Cancel', 'dwt-listing'); ?>
                                                </button>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>

                                <form id="hotel_reservation_form" class="reserve_my_table">
                                    <h3>
                                        <div class="booking-icon">
                                            <i class="fa fa-calendar"></i>
                                            <?php echo esc_html__('Reserve Table', 'dwt-listing'); ?>
                                        </div>
                                        <?php
                                        if (isset($table_price) && $table_price != '') {
                                            ?>
                                            <div class="price">
                                                <span>
                                                    <?php echo esc_html__($table_price); ?>
                                                    <?php echo esc_html__(get_woocommerce_currency_symbol()); ?><small>
                                                        <?php echo esc_html__('/person', 'dwt-listing') ?>
                                                    </small>
                                                </span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </h3>

                            </div>
                            <div class="row hotel_booking_form">
                                <br>
                                <div class="col-lg-12 col-md-12 select_date_box">
                                    <input type="hidden" value="<?php echo esc_attr($restricted_days) ?>" id="restricted_days">
                                    <div class="input-group" data-provide="datepicker" id="calender-booking" value="">
                                        <input class="form-control" type="hidden" id="booking-day" name="reservation_day">
                                        <input class="form-control" name="reserved_listing" type="hidden" id="ad_id"
                                            value="<?php echo get_the_ID(); ?>">
                                        <input class="form-control" name="disabled_dates" type="hidden" id="disabled_date"
                                            value="<?php echo get_the_ID(); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="selected_options" id="booking_time">
                                        <select class="form-select form-select-time-slot" id="form_select_timeslot" name="select_time_slot"
                                            aria-label="Default select example">
                                            <option selected>
                                                <?php echo esc_html__('Please Select a Date First', 'dwt-listing') ?>
                                            </option>
                                            <!-- <option><strong>
                                                    <?php echo esc_html__('8:00 AM -  8:30 AM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('8:30 AM -  9:00 AM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('9:00 AM -  9:30 AM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('9:30 AM -  10:00 AM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('10:00 AM - 10:30 AM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('13:00 PM - 13:30 PM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('13:30 PM - 14:00 PM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('14:00 PM - 14:30 PM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('15:00 PM - 15:30 PM', 'dwt-listing'); ?>
                                                </strong></option>
                                            <option><strong>
                                                    <?php echo esc_html__('16:00 PM - 16:30 PM', 'dwt-listing'); ?>
                                                </strong></option> -->
                                        </select>
                                    </div>
                                    <div>
                                    </div>
                                    <input type="hidden" id="select_time" name="select_time_hidden" value="<?php echo ""; ?>">
                                    <input type="hidden" id="pre_booked_days" name="pre_booked_days" value="<?php echo ""; ?>">


                                    </form>
                                <?php }
                    }
                }
            } ?>
                </div>

                <?php
                echo __('', 'dwt-listing');
                echo $args['after_widget'];
        }
    }
    public function form($instance)
    {
        if (isset($instance['title']))
            $title = $instance['title'];
        else
            $title = __('', 'dwt-listing');
        ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">
                        <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                    </label>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                        name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </p>
                <?php
    }
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
