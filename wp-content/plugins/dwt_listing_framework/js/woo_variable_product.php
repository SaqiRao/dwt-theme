<?php
function dwt_listing_varibale_product_js()
{
?>
    <script type="text/javascript">
 (function($) {
	"use strict";
       	/* Woo Variable Products */
$('.shop_variation').on('change', function()
{
	var res = '';
	var get_var	=	'';
	$( ".shop_variation" ).each(function() {
		var val	=	$( this ).val();
		get_var	= get_var + val.replace(/\s+/g, '') + '_';
	});
	if( $('#' + get_var ).length > 0 )
	{
		var res	=	$('#' + get_var ).val();
		var arr = res.split("-");
		var sale_price	=	arr[0];
		if( sale_price == "0" )
        {
			$('#new_sale_price').html('');
			$("#v_msg").css("display", "block");
		}
		else
		{
			$("#v_msg").css("display", "none");
			$('#new_sale_price').html( '<?php echo get_woocommerce_currency_symbol(); ?>' + sale_price );
		}

	}
});
       
})( jQuery );
    </script>
<?php	
}
add_action( 'wp_footer', 'dwt_listing_varibale_product_js', 111 );