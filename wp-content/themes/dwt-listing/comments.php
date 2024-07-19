<?php
if (post_password_required())
    return;
if (get_comments_number() > 0) {
    ?>
    <div class="blog-section"> 
        <div class="blog-heading">
            <h2><?php echo dwt_listing_get_comments(); ?></h2>
            <hr>
        </div>
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'callback' => 'dwt_listing_comments_list',
                'avatar_size' => '40'
            ));
            ?>
        </ol>
    </div>
<?php } ?>
<?php
if (!comments_open()) {
    
} else {
    ?>
    <div class="blog-section review-form">
        <div class="blog-heading">
            <h2><?php echo esc_html__('leave your comment', 'dwt-listing'); ?></h2>
            <hr>
        </div>
        <?php
        $req = '*';
        $comment_args = array(
            'class_submit' => 'btn btn-theme',
            'title_reply' => '',
            'cancel_reply_link' => esc_html__('Cancel Reply', 'dwt-listing'),
            'fields' => apply_filters('comment_form_default_fields', array(
                /* Name Field Setting Goes Here */
                'author' => ' <div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label for="author">'
                . esc_html__('Name', 'dwt-listing') . ( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
                '<input type="text" required placeholder="' . esc_html__('Your Good Name', 'dwt-listing') . '" id="author" class="form-control" name="author" size="30"/></div></div> <!-- End col-sm-6 -->',
                /* Email Field Setting Goes Here */
                'email' => ' <div class="col-md-6 col-sm-12"><div class="form-group"><label for="email">'
                . esc_html__('Email', 'dwt-listing') . ( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
                '<input type="email" required placeholder="' . esc_html__('Your Email Please', 'dwt-listing') . '" id="email" class="form-control" name="email" size="30" /></div></div></div> <!-- End col-sm-6 -->',
            )),
            /* Comment Textarea Setting Goes Here */
            'comment_field' => ' <div><div class="form-group"><label for="url">'
            . esc_html__('Comments:', 'dwt-listing') . ( $req ? '<span class="required">*</span>' : '' ) . '</label></div></div>' .
            '<div class=" class="col-md-12 col-sm-12""><div class="form-group"><textarea class="form-control" id="comment" name="comment" required cols="45" rows="7" aria-required="true" ></textarea></div></div> <!-- End col-sm-6 -->',
            'comment_notes_after' => '',
        );
        comment_form($comment_args);
        ?>
    </div>
<?php } ?>