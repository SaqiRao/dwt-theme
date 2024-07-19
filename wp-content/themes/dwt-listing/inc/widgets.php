<?php
add_action('widgets_init', function() {
    register_widget('dwt_listing_blog_posts');
});
if (!class_exists('dwt_listing_blog_posts')) {

    class dwt_listing_blog_posts extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            // Instantiate the parent object
            parent::__construct(false, 'DWT Recent Blog Posts');
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            global $post;
            if ($instance['dwt_listing_post_no'] == "") {
                $instance['dwt_listing_post_no'] = 5;
            }
            $args = array('post_type' => 'post', 'posts_per_page' => $instance['dwt_listing_post_no'], 'orderby' => 'date', 'order' => 'DESC');
            $recent_posts = get_posts($args);
            ?>
            <div class="widget">
                <div class="widget-heading">
                    <h4 class="panel-title"><?php echo esc_html($instance['title']); ?></h4>
                </div>
                <div class="recent-ads">
                    <?php foreach ($recent_posts as $recent_post): ?>
                        <div class="recent-ads-list">
                            <div class="recent-ads-container">
                                <?php
                                if (has_post_thumbnail($recent_post->ID)):
                                    $get_img_src = '';
                                    $get_img_src = dwt_listing_get_feature_image($recent_post->ID, 'dwt_listing_recent-posts');
                                    ?>
                                    <div class="recent-ads-list-image">
                                        <a href="#" class="recent-ads-list-image-inner">
                                            <img src="<?php echo esc_url($get_img_src[0]); ?>" alt="<?php echo esc_html(get_the_title($recent_post->ID)); ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>	   
                                <div class="recent-ads-list-content">
                                    <h3 class="recent-ads-list-title">
                                        <a href="<?php echo esc_url(get_the_permalink($recent_post->ID)); ?>"><?php echo esc_html(get_the_title($recent_post->ID)); ?></a>
                                    </h3>
                                    <ul class="recent-ads-list-location">
                                        <?php
                                        $category = '';
                                        $category = get_the_category($recent_post->ID);
                                        if (!empty($category)) {
                                            ?>
                                            <li><a href="<?php echo esc_url(get_category_link($category[0]->cat_ID)); ?>"><?php echo '' . $category[0]->cat_name; ?></a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>	  
                </div>
            </div>
            <?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('DWT Listing Recent Blog Posts', 'dwt-listing');
            }
            if (isset($instance['dwt_listing_post_no'])) {
                $dwt_listing_post_no = $instance['dwt_listing_post_no'];
            } else {
                $dwt_listing_post_no = 5;
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('dwt_listing_post_no')); ?>">
                    <?php esc_html__('How many posts to diplay:', 'dwt-listing'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('dwt_listing_post_no')); ?>" name="<?php echo esc_attr($this->get_field_name('dwt_listing_post_no')); ?>" type="text" value="<?php echo esc_attr($dwt_listing_post_no); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['dwt_listing_post_no'] = (!empty($new_instance['dwt_listing_post_no']) ) ? strip_tags($new_instance['dwt_listing_post_no']) : '';
            return $instance;
        }

    }

    // Recent Posts
}



// Featured Listing Widget
add_action('widgets_init', function() {
    register_widget('dwt_listing_events_widgets');
});
if (!class_exists('dwt_listing_events_widgets')) {

    class dwt_listing_events_widgets extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            $widget_ops = array(
                'classname' => 'dwt_listing_events_widgets',
                'description' => __('for events.', 'dwt-listing'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('DWT Listing Events Widget', 'dwt-listing'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            global $dwt_listing_options;
            $title = '';
            if ($instance['title'] != "") {
                $title = '<h4>' . esc_html($instance['title']) . '</h4>';
            }

            $max_ads_1 = '';
            if (!empty($instance['max_ads_1'])) {
                $max_ads_1 = $instance['max_ads_1'];
            }
            ?>

            <div class="widget">
                <div class="widget-heading">
                    <h4 class="panel-title"><?php echo esc_html($instance['title']); ?></h4>
                </div>
                <div class="list-boxes">
                    <div class="widget-margin">
                        <?php
                        $current_event_id = '';
                        $current_event_id = get_the_ID();
                        $args = array(
                            'post_type' => 'events',
                            'post_status' => 'publish',
                            'posts_per_page' => $max_ads_1,
                            'post__not_in' => array($current_event_id),
                            'meta_query' => array(
                                array(
                                    'key' => 'dwt_listing_event_status',
                                    'value' => '1',
                                    'compare' => '='
                                ),
                            ),
                            'orderby' => 'date',
                            'order' => 'DESC',
                        );
                        $results = new WP_Query($args);
                        if ($results->have_posts()) {
                            $layout_type = '_widget';
                            $eventz = new dwt_listing_events();
                            while ($results->have_posts()) {
                                $results->the_post();
                                $event_id = get_the_ID();
                                $function = "dwt_listing_event_type$layout_type";
                                echo '' . $fetch_listingz = $eventz->$function($event_id);
                            }
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            $max_ads_1 = '';
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Related Events', 'dwt-listing');
            }
            if (!empty($instance['max_ads_1'])) {
                $max_ads_1 = $instance['max_ads_1'];
            } else {
                $max_ads_1 = 5;
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_ads_1')); ?>" >
                    <?php echo esc_html__('Max # of Events:', 'dwt-listing'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_ads_1')); ?>" name="<?php echo esc_attr($this->get_field_name('max_ads_1')); ?>" type="number" value="<?php echo esc_attr($max_ads_1); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['max_ads_1'] = (!empty($new_instance['max_ads_1']) ) ? strip_tags($new_instance['max_ads_1']) : '';
            return $instance;
        }

    }

    // Events Listing
}

// Recent Listings
add_action('widgets_init', function() {
    register_widget('dwt_listing_recent_listings');
});
if (!class_exists('dwt_listing_recent_listings')) {

    class dwt_listing_recent_listings extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            // Instantiate the parent object
            parent::__construct(false, 'DWT Recent Listings');
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            $total = '';
            if ($instance['dwt_listing_post_no'] == "") {
                $total = $instance['dwt_listing_post_no'];
            }
            $args = array('post_type' => 'listing', 'post_status' => 'publish', 'posts_per_page' => $instance['dwt_listing_post_no'], 'orderby' => 'date', 'order' => 'DESC');
            $media = $categories = '';
            $results = new WP_Query($args);
            if ($results->have_posts()) {
                ?>
                <div class="widget">
                    <div class="widget-heading">
                        <h4 class="panel-title"><?php echo esc_html($instance['title']); ?></h4>
                    </div>
                    <div class="recent-ads">
                        <?php
                        while ($results->have_posts()) {
                            $results->the_post();
                            $listing_id = get_the_ID();
                            //get media
                            $media = dwt_listing_fetch_listing_gallery($listing_id);
                            //listing category
                            $categories = dwt_listing_listing_assigned_cats($listing_id, '');
                            ?>
                            <div class="recent-ads-list">
                                <div class="recent-ads-container">
                                    <div class="recent-ads-list-image">
                                        <a href="<?php echo esc_url(get_the_permalink($listing_id)); ?>" class="recent-ads-list-image-inner"><img src="<?php echo dwt_listing_return_listing_idz($media, 'dwt_listing_recent-posts'); ?>" class="img-responsive" alt="<?php echo get_the_title($listing_id); ?>"></a>
                                    </div>
                                    <div class="recent-ads-list-content">
                                        <h3 class="recent-ads-list-title">
                                            <a href="<?php echo esc_url(get_the_permalink($listing_id)); ?>"><?php echo get_the_title($listing_id); ?></a>
                                        </h3>
                                        <ul class="recent-ads-list-location">

                                            <li><?php echo '' . ($categories); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('DWT Recent Listings', 'dwt-listing');
            }
            if (isset($instance['dwt_listing_post_no'])) {
                $dwt_listing_post_no = $instance['dwt_listing_post_no'];
            } else {
                $dwt_listing_post_no = 5;
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'dwt-listing'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('dwt_listing_post_no')); ?>">
                    <?php esc_html__('How many listings to diplay:', 'dwt-listing'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('dwt_listing_post_no')); ?>" name="<?php echo esc_attr($this->get_field_name('dwt_listing_post_no')); ?>" type="text" value="<?php echo esc_attr($dwt_listing_post_no); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['dwt_listing_post_no'] = (!empty($new_instance['dwt_listing_post_no']) ) ? strip_tags($new_instance['dwt_listing_post_no']) : '';
            return $instance;
        }

    }

    // Recent Posts
}