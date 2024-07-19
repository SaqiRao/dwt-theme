<?php
class listing_category_meta {

	public function __construct() {
		if ( is_admin() ) {
			add_action( 'l_category_add_form_fields',  array( $this, 'dwt_listing_create_screen_fields'), 10, 1 );
			add_action( 'l_category_edit_form_fields', array( $this, 'dwt_listing_edit_screen_fields' ),  10, 2 );
			add_action( 'created_l_category', array( $this, 'save_data' ), 10, 1 );
			add_action( 'edited_l_category',  array( $this, 'save_data' ), 10, 1 );
		}
	}
	public function dwt_listing_create_screen_fields( $taxonomy ) {
		// Set default values.
		$category_icon = '';

		// Form fields.
		echo '<div class="form-field">
		<label for="category_icon">' . __( 'Category Icon', 'dwt-listing-framework' ) . '</label>
		<input type="text" id="category_icon" name="category_icon" placeholder="' . esc_attr__( 'icon-soccer', 'dwt-listing-framework' ) . '" value="' . esc_attr( $category_icon ) . '">
		<p class="description"><a href="http://listing.downtown-directory.com/theme-icons/" target="_blank">'. __('Check Theme Icons List.', 'dwt-listing-framework').'</a></p>
		</div>';
	}

	public function dwt_listing_edit_screen_fields( $term, $taxonomy ) {

		// Retrieve an existing value from the database.
		$category_icon = get_term_meta( $term->term_id, 'category_icon', true );
		// Set default values.
		if( empty( $category_icon ) ) $category_icon = '';
		echo '<tr class="form-field term-category_icon-wrap">
		<th scope="row">
		<label for="category_icon">' . __( 'Category Icons', 'dwt-listing-framework' ) . '</label>
		</th>
		<td>
		<input type="text" id="category_icon" name="category_icon" placeholder="' . esc_attr__( 'icon-soccer', 'dwt-listing-framework' ) . '" value="' . esc_attr( $category_icon ) . '">
		<p class="description"><a href="http://listing.downtown-directory.com/theme-icons/" target="_blank">'. __('Check Theme Icons List.', 'dwt-listing-framework').'</a></p>
		</td>
		</tr>';

	}

	public function save_data( $term_id ) {
		// Sanitize user input.
		$cat_icon = isset( $_POST[ 'category_icon' ] ) ? ( $_POST[ 'category_icon' ] ) : '';
		// Update the meta field in the database.
		update_term_meta( $term_id, 'category_icon', $cat_icon );
	}

}

new listing_category_meta;