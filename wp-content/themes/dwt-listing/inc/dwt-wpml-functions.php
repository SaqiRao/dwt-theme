<?php
/* ========*******=========
 * All WPML THEME FuNCTIONS
 =========*******========= */

/*
 * set category link in shortcodes
 * according to current language.
 */
if ( !function_exists( 'dwt_cat_link_page' ) ) {

  function dwt_cat_link_page( $url ) {
    $url = $url;
    if ( function_exists( 'icl_object_id' ) ) {
      $url = esc_url( remove_query_arg( 'lang', $url ) );
      $url = $url . '?lang=' . ICL_LANGUAGE_CODE;
    }
    return $url;
  }

}

/*
 * @param $object_id integer|string|array The ID/s of the objects to check and return
 * @param $type the object type: post, page, {custom post type name}, nav_menu, nav_menu_item, category, tag etc.
 * @return string or array of object ids
 */
if ( !function_exists( 'dwt_listing_translate_object_id' ) ) {

  function dwt_listing_translate_object_id( $object_id, $type ) {
    $current_language = apply_filters( 'wpml_current_language', NULL );
    // if array
    if ( is_array( $object_id ) ) {
      $translated_object_ids = array();
      foreach ( $object_id as $id ) {
        $translated_object_ids[] = apply_filters( 'wpml_object_id', $id, $type, true, $current_language );
      }
      return $translated_object_ids;
    } // if string
    elseif ( is_string( $object_id ) ) {
        // check if we have a comma separated ID string
        $is_comma_separated = strpos( $object_id, "," );
        if ( $is_comma_separated !== FALSE ) {
          // explode the comma to create an array of IDs
          $object_id = explode( ',', $object_id );
          $translated_object_ids = array();
          foreach ( $object_id as $id ) {
            $translated_object_ids[] = apply_filters( 'wpml_object_id', $id, $type, true, $current_language );
          }
          // make sure the output is a comma separated string (the same way it came in!)
          return implode( ',', $translated_object_ids );
        } // if we don't find a comma in the string then this is a single ID
        else {
          return apply_filters( 'wpml_object_id', intval( $object_id ), $type, true, $current_language );
        }
      } // if int
    else {
      return apply_filters( 'wpml_object_id', $object_id, $type, true, $current_language );
    }
  }

}

/* == check page language url for wpml  == */
if ( !function_exists( 'dwt_listing_page_lang_url_callback' ) ) {

  function dwt_listing_page_lang_url_callback( $page_url = '' ) {
    global $sitepress;
    if ( function_exists( 'icl_object_id' ) && $page_url != '' ) {
      $page_url = apply_filters( 'wpml_permalink', $page_url, ICL_LANGUAGE_CODE, true );
    }
    return $page_url;
  }

}

/* == get current page id for redirect in  wpml == */
if ( !function_exists( 'dwt_listing_language_page_id_callback' ) ) {

  function dwt_listing_language_page_id_callback( $page_id = '' ) {
    global $sitepress;
    if ( function_exists( 'icl_object_id' ) && function_exists( 'wpml_init_language_switcher' ) && $page_id != '' && is_numeric( $page_id ) ) {
      $language_code = $sitepress->get_current_language();
      $lang_page_id = icl_object_id( $page_id, 'page', false, $language_code );
      if ( $lang_page_id <= 0 ) {
        $lang_page_id = $page_id;
      }
      return $lang_page_id;
    } else {
      return $page_id;
    }
  }

}

/* == set url params for wpml == */
if ( !function_exists( 'dwt_listing_set_url_param' ) ) {

  function dwt_listing_set_url_param( $dwt_listing = '', $key = '', $value = '' ) {
    if ( $dwt_listing != '' ) {
      $dwt_listing = add_query_arg( array( $key => $value ), $dwt_listing );
      $dwt_listing = dwt_listing_page_lang_url_callback( $dwt_listing );
    }
    return $dwt_listing;
  }

}

/* if parameter are multiple like 4 */
if ( !function_exists( 'dwt_listing_set_url_params_multi' ) ) {

  function dwt_listing_set_url_params_multi( $dwt_listing = '', $wpml_url_params ) {
    if ( $dwt_listing != '' ) {
      $dwt_listing = add_query_arg( ( $wpml_url_params ), $dwt_listing );
      $dwt_listing = dwt_listing_page_lang_url_callback( $dwt_listing );
    }
    return $dwt_listing;
  }

}

/*  wpml ( display result within all language or only current language.) */
if ( !function_exists( 'dwt_listing_wpml_show_all_posts_callback' ) ) {

  function dwt_listing_wpml_show_all_posts_callback( $query_args = array(), $option_name = 'dwt_listing_options', $option_key_name = 'dwt_listing_display_post' ) {
    global $sitepress;
    $dwt_listing_show_posts = false;
    //if (function_exists('icl_object_id') && $query_args != '' && $dwt_listing_show_posts) { comment on 13-aug-2020
    if ( !is_admin() ) {
      if ( function_exists( 'icl_object_id' ) && $query_args != '' ) {
        if ( class_exists( 'Redux' ) ) {
          $dwt_listing_show_posts = Redux::get_option( $option_name, $option_key_name );
        }
        if ( $dwt_listing_show_posts == true ) {
          do_action( 'dwt_listing_wpml_terms_filters' );
          dwt_reset_wpml_taxonomy_data();
          $query_args[ 'suppress_filters' ] = $dwt_listing_show_posts;
        }
      }
    }
    return $query_args;
  }

}

/* reset taxonomy data. */
if ( !function_exists( 'dwt_reset_wpml_taxonomy_data' ) ) {

  function dwt_reset_wpml_taxonomy_data() {
    global $sitepress;
    remove_filter( 'get_terms_args', array( $sitepress, 'get_terms_args_filter' ), 10 );
    remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
    remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ), 10 );
  }

}

/* wpml function for duplicate post in all language or in current language. */
add_action( 'dwt_listing_duplicate_posts_lang_wpml', 'dwt_listing_duplicate_posts_lang', 10, 4 );

function dwt_listing_duplicate_posts_lang( $org_post_id = 0, $pst_nme = '', $theme_option_ky = 'dwt_listing_options', $wpml_duplicate_post = 'dwt_listing_duplicate_post' ) {
  global $sitepress;
  $dwt_duplicate_post = false;
  if ( class_exists( 'Redux' ) ) {
    $dwt_duplicate_post = Redux::get_option( $theme_option_ky, $wpml_duplicate_post );
  }
  if ( function_exists( 'icl_object_id' ) && $org_post_id != 0 && $dwt_duplicate_post ) {
    $language_details_original = $sitepress->get_element_language_details( $org_post_id, "post_'.$pst_nme.'" );
    if ( !class_exists( 'TranslationManagement' ) ) {
      include( ABSPATH . 'wp-content/plugins/sitepress-multilingual-cms/inc/translation-management/translation-management.class.php' );
    }
    foreach ( $sitepress->get_active_languages() as $lang => $details ) {
      if ( $lang != $language_details_original->language_code ) {
        $iclTranslationManagement = new TranslationManagement();
        $iclTranslationManagement->make_duplicate( $org_post_id, $lang );
      }
    }
  }
}

/* wpml functions for framwork */
/* Duplicate post from backend */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
  $dwt_listing_duplicate_posts = false;
  if ( class_exists( 'Redux' ) ) {
    $dwt_listing_duplicate_posts = Redux::get_option( 'dwt_listing_options', 'dwt_listing_duplicate_post' );
  }
  if ( $dwt_listing_duplicate_posts ) {
    add_action( 'wp_insert_post', 'post_duplicate_on_publish' );

    function post_duplicate_on_publish( $post_id ) {
      $post = get_post( $post_id );
      if ( $post->post_type == 'listing' || $post->post_type == 'events' ) {
        /* don't save for autosave */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
          return $post_id;
        }
        /* dont save for revisions */
        if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
          return $post_id;
        }
        /* we need this to avoid recursion see add_action at the end */
        remove_action( 'wp_insert_post', 'post_duplicate_on_publish' );
        /* make duplicates if the post being saved */
        /* #1. itself is not a duplicate of another or */
        /* #2. does not already have translations */
        $is_translated = apply_filters( 'wpml_element_has_translations', '', $post_id, $post->post_type );
        if ( !$is_translated ) {
          do_action( 'wpml_admin_make_post_duplicates', $post_id );
        }
        /* must hook again - see remove_action further up */
        add_action( 'wp_insert_post', 'post_duplicate_on_publish' );
      }
    }

  }
}

/* include hidden value for language parameter */
if ( !function_exists( 'dwt_listing_form_lang_field_callback' ) ) {

  function dwt_listing_form_lang_field_callback( $echo = false ) {
    global $sitepress;
    $hidden_lang_html = '';
    if ( class_exists( 'SitePress' ) ) {
      if ( function_exists( 'icl_object_id' ) ) {
        if ( $sitepress->get_setting( 'language_negotiation_type' ) == 3 ) {
          $hidden_lang_html = '<input name="lang" id="lang" type="hidden" value="' . ICL_LANGUAGE_CODE . '">';
        }
      }
    }
    if ( $echo ) {
      echo dwt_listing_returnEcho( $hidden_lang_html );
    } else {
      return $hidden_lang_html;
    }
  }

}

/*
 * show record in all language.
 * related to specific taxonomy.
 * related to specific custom tags.
 * related to specific custom region.
 * 1 => if display all post switch ON.
 * 2 => if WPML is active.
 */
if ( !function_exists( 'dwt_listing_show_taxonomy_all' ) ) {

  function dwt_listing_show_taxonomy_all( $taxo_id, $taxo_nme ) {
    global $sitepress;
    $dwt_listing_show_posts = false;
    if ( class_exists( 'Redux' ) ) {
      $dwt_listing_show_posts = Redux::get_option( 'dwt_listing_options', 'dwt_listing_display_post' );
    }
    if ( function_exists( 'icl_object_id' ) && $dwt_listing_show_posts ) {
      $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
      $taxo = array();
      foreach ( $languages as $val ) {
        $taxo[] = apply_filters( 'wpml_object_id', $taxo_id, $taxo_nme, FALSE, $val[ 'code' ] );
      }
      //return original id if only one language.
      return $taxo;
    } else {
      return $taxo_id;
    }
  }

}

/* custom language switcher */
if ( !function_exists( 'dwt_listing_language_switcher' ) ) {

  function dwt_listing_language_switcher() {
    if ( function_exists( 'icl_object_id' ) ) {
      $lang_link = '';
      $languages = icl_get_languages( 'skip_missing=0&orderby=code' );
      $final_img = esc_url( trailingslashit( get_template_directory_uri() ) . 'assets/images/translation.png' );
      $lang_name = esc_html__( 'All Languages', 'dwt-listing' );
      if ( !empty( $languages ) ) {
        ?>
<ul class="list-inline">
  <li class="dropdown location-selector"> <span class="loc"><?php echo $lang_name; ?></span> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"
                           data-close-others="true" aria-expanded="false"> <img src="<?php echo esc_url($final_img); ?>" alt="<?php echo esc_attr($lang_name); ?>"/> </a>
    <ul class="dropdown-menu pull-right " style="display: none;">
      <?php
      foreach ( $languages as $lang ) {
        if ( $lang[ 'active' ] ) {
          $lang_link = "javascript:void(0)";
        } else {
          $lang_link = esc_url( $lang[ 'url' ] );
        }
        ?>
      <li> <a href="<?php echo $lang_link; ?>" class="top-lang-selection"> <img src="<?php echo $lang['country_flag_url']; ?>" alt=""> <span><?php echo icl_disp_language($lang['native_name']); ?></span> </a> </li>
      <?php } ?>
    </ul>
  </li>
</ul>
<?php
}
}
}

}


/* ========*******=========
 * All WPML API FuNCTIONS
 =========*******========= */

/* wpml get language code for app */

function dwt_app_languages() {
  global $sitepress;
  if ( function_exists( 'icl_object_id' ) ) {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    $langs = array();
    if ( !empty( $languages ) ) {
      foreach ( $languages as $lng ) {
        $langs[ $lng[ 'code' ] ] = esc_html__( $lng[ 'display_name' ], 'dwt-listing-api' );
      }
    }
    return $langs;
  }
}

/*
 * get language details
 */

function get_language_details( $code = '' ) {
  global $sitepress;
  $lang_details = array();
  if ( function_exists( 'icl_object_id' ) ) {
    $all_languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    foreach ( $all_languages as $key => $each_lang ) {
      if ( $code == $key ) {
        //$languages = $each_lang;
        $lang_details[ 'code' ] = $each_lang[ 'code' ];
        $lang_details[ 'native_name' ] = $each_lang[ 'native_name' ];
        $lang_details[ 'english_name' ] = $each_lang[ 'translated_name' ];
        $lang_details[ 'lang_flag' ] = $each_lang[ 'country_flag_url' ];
        break;
      }
    }
    return $lang_details;
  }
}

/*
 * Change App Direction
 */
if ( !function_exists( 'dwtAPI_app_direction_callback' ) ) {
  function dwtAPI_app_direction_callback( $app_dir = 'ltr' ) {
    if ( function_exists( 'icl_object_id' ) ) {
      if ( apply_filters( 'wpml_is_rtl', NULL ) ) {
        $app_dir = 'rtl';
      } else {
        $app_dir = 'ltr';
      }
    }
    return $app_dir;
  }
}