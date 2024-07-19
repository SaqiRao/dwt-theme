<?php
/*  Create Database Table */
class fl_db_tables
{
    public static function fl_create_db_tables()
    { 
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        $tablename = 'dwt_listing_events_tickets'; 
        $main_sql_create = 'CREATE TABLE IF NOT EXISTS ' . $tablename . '(
            `id` int (11) NOT NULL AUTO_INCREMENT,
            `timestamp` datetime ,
            `no_of_tickets` VARCHAR  (30),
            `tickets_price` VARCHAR  (30),
            `extra_service_price` VARCHAR  (500),
            `event_user_name` VARCHAR (30),
            `event_grand_total` VARCHAR  (30),
            `admin_commission` VARCHAR  (30),
            `currency` VARCHAR  (30),
            `event_id` int (11),
            `event_name` VARCHAR  (1000),
            `event_date` VARCHAR  (30),
            `event_tickets_status` VARCHAR (30),
            `total_number_of_tickets` VARCHAR (30),

        PRIMARY KEY (id)

        ) ;';    
            maybe_create_table( $wpdb->prefix . $tablename, $main_sql_create );
                
        }
}
$dbtable = new fl_db_tables();

$dbtable -> fl_create_db_tables();