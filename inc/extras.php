<?php
    function excerpt_ellipsis($more) {
        return '...';
    }
    add_filter('excerpt_more', 'excerpt_ellipsis');

    function custom_excerpt_length( $length ) {
        return 40;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

    // Load More
    add_action( 'wp_ajax_zantimes_load_more_posts', 'zantimes_load_more_posts' );
    add_action( 'wp_ajax_nopriv_zantimes_load_more_posts', 'zantimes_load_more_posts' );
    function zantimes_load_more_posts() {
        $page = $_POST['page'] ? intval( $_POST['page'] ) : 0;
        $offset = $_POST["offset"];
		$ppp = $_POST["ppp"];
        $cat = $_POST['cat'];
        header("Content-Type: text/html");

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $ppp,
            'post_status'    => 'publish',
            'paged'          => $page,
            'offset' => $offset,
        );

        if ($cat) {
            $args['category__in'] = array($cat);
        }
        
        $the_query = new WP_Query($args);
        $max_page = $the_query->max_num_pages;
        ob_start();
        ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <?php $author_id = get_post_field( 'post_author', get_the_ID() ); ?>
            <div class="category__post-item">
                <a href="<?php echo get_the_permalink(); ?>" class="post-link">
                    <span class="">
                        <?php if ( has_post_thumbnail() ) : ?>
                                <?php echo get_the_post_thumbnail( get_the_ID(), 'medium' ); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-default.png" alt="placeholder" class="placeholder">
                        <?php endif; ?>
                    </span>
                    <div class="post-meta">
                        <?php 
                            $author_id = get_post_field( 'post_author', $post );
                            $author_name = get_the_author_meta('display_name', $author_id);
                            $zanTimeAuthorCF = get_field( 'zan_times_author', get_the_ID() );
                            $translated_author_name = pll__( $zanTimeAuthorCF );
                        ?>
                       <?php if ( ( pll_current_language() === 'en') && $zanTimeAuthorCF ) { ?>
                            <strong> <?php echo __('By: ', 'zantimes' ); ?></strong><?php echo $translated_author_name; ?>
                        <?php } ?>
                    </div>
                    <h5 class="post-title"><?php echo get_the_title(get_the_ID()); ?></h5>
                </a>
            </div>
        <?php endwhile;
        wp_reset_postdata();
        $content = ob_get_clean();
        echo json_encode(array('content' => $content, 'page' => $page, 'max_page' => $max_page));
        exit;
    }

    /**
 * ACF Load More Repeater
*/

// add action for logged in users
add_action('wp_ajax_my_repeater_show_more', 'my_repeater_show_more');
// add action for non logged in users
add_action('wp_ajax_nopriv_my_repeater_show_more', 'my_repeater_show_more');

function my_repeater_show_more() { 
	// make sure we have the other values
	if (!isset($_POST['post_id']) || !isset($_POST['offset'])) {
		return;
	}
	$show = 6; // how many more to show
	$start = $_POST['offset'];
	$end = $start+$show;
	$post_id = (int) $_POST['post_id'];

    $total = null;
    $teams = '';

	ob_start();
    if (has_blocks( $post_id )) {
        $blocks = parse_blocks( get_post_field( 'post_content', $post_id ) );
        foreach ( $blocks as $block ) {
            if ($block["blockName"] === 'acf/zantimes-teams') {
                $block_id = block( $innerBlock['attrs']['data'] );
                acf_setup_meta( $block['attrs']['data'], $block_id );
                $teams = get_field( 'zantimes_teams', $block_id );
            } elseif ( $block['blockName'] === 'core/group' ) {
                if (!empty($block['innerBlocks'])) {
                    foreach ($block['innerBlocks'] as $innerBlock) {
                        if ($innerBlock["blockName"] === 'acf/zantimes-teams') {
                            $block_id = acf_get_block_id( $innerBlock['attrs']['data'] );
                            acf_setup_meta( $innerBlock['attrs']['data'], $block_id );
                            $teams = get_field( 'zantimes_teams', $block_id );
                        }
                    }
                }
			} else {
                continue;
            }
        }

        if ($teams) {
			$total = count($teams);
			$count = 0;
			foreach ($teams as $team) {
				if ($count < $start) {
					$count++;
					continue;
				}
                $profile_img = $team['profile_image'] ? $team['profile_image']['url'] : get_template_directory_uri() . '/assets/images/img-default.png';
                $name = $team['name']; 
                $position = $team[ 'job' ];
				?>
                <div class="col-12 col-md-6 col-lg-4 zantimes-teams__column modal-trigger" data-toggle="modal" data-target="#<?php echo $count; ?>">
                    <?php if ( $profile_img ) : ?>
                        <img src="<?php echo $profile_img; ?>" alt="<?php echo __( 'Profile Image', 'zantimes' ); ?>" class="zantimes-teams__image">
                    <?php endif; ?>
                    <?php if ( $name ) : ?>
                        <h3 class="zantimes-teams__name"><?php echo $name; ?></h3>
                    <?php endif; ?>
                    <?php if ( $position ) : ?>
                        <p class="zantimes-teams__position"><?php echo $position; ?></p>
                    <?php endif; ?>
                </div>
                <?php 
				$count++;
				if ($count == $end) {
					break;
				}
			}
		}
    }

	$content = ob_get_clean();
	// check to see if we have shown the last item
	$more = false;
	if ($total > $count) {
		$more = true;
	}
	// output our 3 values as a json encoded array
	echo json_encode(array('content' => $content, 'more' => $more, 'offset' => $end));
	exit;
} // end function my_repeater_show_more

function zantimes_get_excerpt( $limit ){
    $excerpt = get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    return $excerpt;
}

function my_modify_search_query( $query ) {
    if ( $query->is_search && !is_admin() && function_exists('pll_current_language') ) {
        $query->set( 'lang', pll_current_language() );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'my_modify_search_query');

add_filter( 'wp_lazy_loading_enabled', '__return_false' );
// Translate Date to Farsi
function convertPostDateToPersian($postdate_m) {
    // Ensure the 'intl' extension is loaded.
    if (!class_exists('IntlDateFormatter')) {
        return 'Intl extension is not available.';
    }

    // Set the locale to Persian (Iran)
    $locale = 'fa_IR@calendar=persian';

    // Create formatter for the full date in Persian
    $formatterFull = new IntlDateFormatter(
        $locale,
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE,
        'Asia/Tehran',
        IntlDateFormatter::TRADITIONAL,
        'EEEE, d MMMM y'
    );

    // Convert the provided date to a timestamp
    $timestamp = strtotime($postdate_m);
    // Use the formatter to format the timestamp
    $persianDateFull = $formatterFull->format($timestamp);

    return $persianDateFull;
}

function convertEnglishNumbersToPersian($input) {
    $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    return str_replace($englishNumbers, $persianNumbers, $input);
}

function redirect_page() {
    if ( $_SERVER['REQUEST_URI'] == '/en/' ) {
		wp_redirect( "/" );
		exit();
	}
}
  
add_action( 'template_redirect', 'redirect_page' );