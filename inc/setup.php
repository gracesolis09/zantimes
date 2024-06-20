<?php
function zantimes_enqueue_scripts() {
    $version = '1.5';
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/css/main.min.css', array(), $version);

    wp_enqueue_script( 'main-jquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), '', true );
    wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '', true );
    wp_enqueue_script( 'main-script', get_template_directory_uri() . '/assets/js/main.js', array(), '', true, $version );
    wp_localize_script( 'main-script', 'wpAjax', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );
    if ( is_single() ) {
        wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper.min.js', array(), '', true );
    }
    if( is_category() ) {
        wp_enqueue_style( 'featured-post-block-style', get_template_directory_uri() . '/blocks/featured-post/style.min.css', array(), true );
        wp_enqueue_style( 'newsletter-style', get_template_directory_uri() . '/blocks/newsletter/style.min.css', array(), true );
    }
    if ( has_block( 'acf/zantimes-logos' ) ) {
        wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.carousel.min.js', array(), '', true );
    }
}
add_action( 'wp_enqueue_scripts', 'zantimes_enqueue_scripts', 4 );


function zantimes_register_nav_menu() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'zantimes' ),
        'top_menu'     => __( 'Top Menu', 'zantimes' ),
        'footer' => __( 'Footer Menu', 'zantimes' ),
    ) );
}
add_action( 'after_setup_theme', 'zantimes_register_nav_menu', 0 );

/*
* Add ACF Options Page
*/
if( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' 	=> 'Theme Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ) );
}
/**
 * Theme Support
 */
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-logo' );
add_theme_support( 'align-wide' );
add_theme_support( 'editor-styles' );
add_editor_style( 'assets/css/custom-editor-style.css' );

// add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Allow SVG
 */
function zantimes_add_file_types_to_uploads( $file_types ) {
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge( $file_types, $new_filetypes );
    return $file_types;
}
add_filter('upload_mimes', 'zantimes_add_file_types_to_uploads');

function zantimes_add_block_group_inner( $block_content, $block ) {
    $tag_name                         = isset( $block['attrs']['tagName'] ) ? $block['attrs']['tagName'] : 'div';
	$group_with_inner_container_regex = sprintf(
		'/(^\s*<%1$s\b[^>]*wp-block-group(\s|")[^>]*>)(\s*<div\b[^>]*wp-block-group__inner-container(\s|")[^>]*>)((.|\S|\s)*)/U',
		preg_quote( $tag_name, '/' )
	);

	$replace_regex   = sprintf(
		'/(^\s*<%1$s\b[^>]*wp-block-group[^>]*>)(.*)(<\/%1$s>\s*$)/ms',
		preg_quote( $tag_name, '/' )
	);
	$updated_content = preg_replace_callback(
		$replace_regex,
		static function( $matches ) {
			return $matches[1] . '<div class="wp-block-group__inner-container">' . $matches[2] . '</div>' . $matches[3];
		},
		$block_content
	);
	return $updated_content;
}
add_filter( 'render_block_core/group', 'zantimes_add_block_group_inner', 10, 2 );

//Slugify
function slugify($text, string $divider = '-') {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
  
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
  
    // trim
    $text = trim($text, $divider);
  
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);
  
    // lowercase
    $text = strtolower($text);
  
    if (empty($text)) {
      return 'n-a';
    }
  
    return $text;
}

//get next/prev posts link
add_filter( 'next_posts_link_attributes', 'zantimes_posts_link_next_attributes' );
function zantimes_posts_link_next_attributes() {
    return 'class="zantimes-pagination__nav next"';
}

add_filter( 'previous_posts_link_attributes', 'zantimes_posts_link_prev_attributes');
function zantimes_posts_link_prev_attributes() {
    return 'class="zantimes-pagination__nav prev"';
}

//add admin script
function zantimes_add_admin_scripts( $hook ) {
    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {  
        wp_enqueue_script(  'customadmin-script', get_template_directory_uri().'/assets/js/admin.js', array(), '', true );
    }
}
add_action( 'admin_enqueue_scripts', 'zantimes_add_admin_scripts', 10, 1 );

add_theme_support( 'widgets' );

function zantimes_add_meta_for_twitter() {
    if(is_single()) {
        $tc_url    = get_permalink();
        $tc_title  = get_the_title();
        $tc_description   = get_the_excerpt();
        $tc_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium_large' );
        $tc_image_thumb  = $tc_image[0];
        ?>
        <meta name="twitter:card" value="summary_large_image" />
        <meta name="twitter:site" value="@ZanTimes" />
        <meta name="twitter:title" value="<?php echo $tc_title; ?>" />
        <meta name="twitter:description" value="<?php echo $tc_description; ?>" />
        <meta name="twitter:url" value="<?php echo $tc_url; ?>" />
        <?php if($tc_image) { ?>
            <meta name="twitter:image" value="<?php echo $tc_image_thumb . '?' . time(); ?>" />
        <?php 
        }
    }
}
add_action( 'wp_head', 'zantimes_add_meta_for_twitter' );

function zantimes_yoast_seo_opengraph_change_image_size() {
    return 'medium_large';
}
add_filter( 'wpseo_opengraph_image_size', 'zantimes_yoast_seo_opengraph_change_image_size' );
add_filter( 'wpseo_twitter_image_size', 'zantimes_yoast_seo_opengraph_change_image_size' );