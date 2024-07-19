<?php global $dwt_listing_options;?>
<div class="floating-elements">
<?php
// Edit Listing
get_template_part( 'template-parts/listing-detial/sticky-buttons/edit', 'listing');

// Rearrange Images
get_template_part( 'template-parts/listing-detial/sticky-buttons/rearrange', 'images');

// mark as featured listing
get_template_part( 'template-parts/listing-detial/sticky-buttons/mark-as', 'featured');
?>
</div>