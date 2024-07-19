<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID();
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$current_user = get_current_user_id();
$event_id = get_the_ID();
$user_name = $profile->user_info->user_login;

?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/event', 'stats'); ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Received Tickets & Amount', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="amount_in_wallet">
                        <h3><?php echo esc_html__('Total Amount in Wallet:', 'dwt-listing'); ?></h3>
                        <?php
                        $currency_symbol = get_woocommerce_currency_symbol();
                        $amount_in_wallet = get_user_meta($current_user, 'dwt_listing_user_wallet_amount', true);
                        if ($amount_in_wallet != '') { ?>
                        <?php } else {
                            $amount_in_wallet = 0;
                            ?>

                            <?php
                        }
                        ?>
                        <h3><?php echo esc_html($currency_symbol . (float) $amount_in_wallet); ?></h3>

                        <div class="create_payout_button">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal"
                                data-whatever="@mdo"><?php echo esc_html__('Create Payout', 'dwt-listing'); ?></button>
                        </div>
                    </div>
                    <div class="events_payouts">
                        <div class="payout_modale">
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header payout_modale_header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <?php echo esc_html__('Make Payout', 'dwt-listing'); ?></h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="payout_form">
                                                <div class="form-group">
                                                    <label for="payout_amount"
                                                        class="col-form-label"><?php echo esc_html__('Payout Amount', 'dwt-listing') . '(' . get_woocommerce_currency_symbol() . ')'; ?></label>
                                                    <input type="number" class="form-control" id="payout_amount"
                                                        name="enter_payout_amount" min='1' required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text"
                                                        class="col-form-label"><?php echo esc_html__('Message:', 'dwt-listing'); ?></label>
                                                    <textarea class="form-control" id="message-text"
                                                        name="message_for_payout" required></textarea>
                                                    <input type="hidden" name="users_name" id="user_name"
                                                        value="<?php echo esc_attr__($user_name); ?> " />
                                                </div>
                                                <div class="payout_form_buttons">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"><?php echo esc_html__('Close', 'dwt-listing'); ?></button>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="payout_button"><?php echo esc_html__('Send Payout', 'dwt-listing'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <?php
        $query_args = array(
            'post_type' => 'payouts',
            'posts_per_page' => -1,
            'paged' => $paged,
            'author' => get_current_user_id(),
        );
        $loop = new WP_Query($query_args);
        ?>
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Payouts History', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive dwt-admin-tabelz">
                        <table class="dwt-admin-tabelz-panel table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo esc_html__('Message', 'dwt-listing'); ?></th>
                                    <th><?php echo esc_html__('Amount', 'dwt-listing'); ?></th>
                                    <th><?php echo esc_html__('Payout Status', 'dwt-listing'); ?></th>
                                    <th><?php echo esc_html__('Date', 'dwt-listing'); ?></th>
                                </tr>
                            </thead>
                            <?php
                            while ($loop->have_posts()):
                                $loop->the_post();
                                $the_id = get_the_ID();
                                $payout_message = get_post_meta($the_id, 'dwt_listing_payout_message', true);
                                $payout_amount = get_post_meta($the_id, 'dwt_listing_payout_amount', true);
                                $payout_status = get_post_meta($the_id, 'payout_status', true);
                                if ($payout_status == "1") {
                                    $payout_status = esc_html__('processd', 'dwt-listing');
                                } else {
                                    $payout_status = esc_html__('Pending', 'dwt-listing');
                                }
                                $payout_date = get_post_meta($the_id, 'dwt_listing_payout_date', true);
                                ?>
                                <tbody>
                                    <tr>
                                        <td> <?php echo esc_attr__($payout_message); ?></td>
                                        <td> <?php echo esc_attr__($payout_amount); ?></td>
                                        <td> <?php echo esc_attr__($payout_status); ?></td>
                                        <td> <?php echo esc_attr__($payout_date); ?></td>
                                    </tr>
                                </tbody>
                                <?php
                                wp_reset_postdata();
                            endwhile;
                            ?>
                        </table>
                    </div>
                    <div class="admin-pagination">
                        <?php echo dwt_listing_listing_pagination($loop); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>