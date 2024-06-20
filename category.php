<?php
get_header();
$term_id= get_queried_object_id();

$recent = get_posts(array(
    'post_type'   => 'post',
    'numberposts' => 1, 
    'fields' => 'ids',
    'cat' => $term_id,
))[0];

if ( $recent ) :
    $title = get_the_title($recent);
    $excerpt = get_the_excerpt($recent);
    $post_url = get_the_permalink($recent);
    $author_id = get_post_field( 'post_author', $recent );
    $post_image =  get_the_post_thumbnail_url( $recent, 'large');
    $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';
?> 

<?php 
//Style
echo "<style>.zantimes-featured-post__post-image:after { background-image: url('". $post_image ."')}</style>";
?>
    <div class="zantimes-featured-post reverse-mobile alignfull ">
        <div class="container">
            <div class="row align-items-center category__latest-post">
                <div class="col-lg-6 pe-lg-5 zantimes-featured-post__post-details">
                    <div>
                        <?php
                            $author_name = get_the_author();
                            // Check the new ACF field for author
                            $zanTimeAuthorCF = get_field('zan_times_author', get_the_ID());
                            $translated_author_name = pll__($zanTimeAuthorCF);
                        ?> 
                        <div class="post-meta">
                            <div class="zantimes-tagline">
                                <?php $categories = get_the_category(get_the_ID());
                                if (!empty($categories)) {
                                    $category_name = $categories[0]->name;
                                    // Loop through each category and display its name
                                    if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' || $category_name === 'پادکست' ) { 
                                        $sub_category_name = '';
                                        foreach ( $categories as $category ) {
                                            // Check if the category is a sub-category (has a parent)
                                            if ( $category->category_parent > 0 ) {
                                                $sub_category_name = $category->name;
                                                $sub_category_id = $category->term_id;
                                                break; // Stop the loop once a sub-category is found
                                            }
                                        }
                                        if ( pll_current_language() === 'fa' ) {
                                            if ( $sub_category_name === 'پادکست' || $category_name === 'پادکست' ) { 
                                                echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/podcast.svg" alt="Podcast"><strong>'. $sub_category_name .'</strong></a>'; 
                                            } else if ( $sub_category_name === 'ویدیو' ) {
                                                echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/video.svg" alt="Video"><strong>'. $sub_category_name .'</strong></a>'; 
                                            }
                                        } else {
                                            if ( $sub_category_name === 'Podcast' || $category_name === 'پادکست' ) {
                                                echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/podcast.svg" alt="Podcast"><strong>'. $sub_category_name .'</strong></a>'; 
                                            } else if ( $sub_category_name === 'Video' ) {
                                                echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/video.svg" alt="Video"><strong>'. $sub_category_name .'</strong></a>'; 
                                            }
                                        }
                                    }
                                    if ( $category_name !== 'Multimedia' && $category_name !== 'چندرسانه‌‌ای' && $category_name !== 'پادکست' ) {
                                        echo "<a href='". get_category_link( get_the_category($featured_post)[0]->term_id ) ."'><strong>" . $category_name . "</strong></a>"; 
                                    }
                                } ?>
                            </div>
                            <?php if ( $zanTimeAuthorCF ) : ?>
                                <span> <?php echo $translated_author_name; ?></span>
                            <?php endif; ?>
                        </div> 
                        <a href="<?php echo $post_url; ?>" class="text-black text-decoration-none" aria-label="<?php echo __( 'Read more about this post', 'zantimes' ); ?>"><h1 class="h3 mb-4"><?php echo $title ?></h1></a>
                        <p><?php echo $excerpt; ?></p>
                        <div class="read-more">
                            <a class="btn-primary" href="<?php echo $post_url; ?>" aria-label="Read <?php echo $title ?> "> 
                                <?php $categories = get_the_category(get_the_ID());
                                if (!empty($categories)) {
                                    $category_name = $categories[0]->name;
                                    if ( $category_name === 'Multimedia' ) {
                                        $sub_category_name = '';
                                        foreach ( $categories as $category ) {
                                            // Check if the category is a sub-category (has a parent)
                                            if ( $category->category_parent > 0 ) {
                                                $sub_category_name = $category->name;
                                                break; // Stop the loop once a sub-category is found
                                            }
                                        }
                                        if ( $sub_category_name === 'Podcast' ) {
                                            echo pll__( 'Listen now' ); 
                                        } else if ( $sub_category_name === 'Video' ) {
                                            echo pll__( 'Watch now' ); 
                                        }
                                    }
                                    if ( $category_name !== 'Multimedia' ) {
                                        echo pll__( 'Read more' );     
                                    } 
                                } ?>
                            </a>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-6 zantimes-featured-post__post-image">
                    <img class="featured-img" src="<?php echo $post_image; ?>" />
                </div> 
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $the_query = new WP_Query(array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'cat' => $term_id,
        'post__not_in'   => array($recent),
        'paged'          => $paged
    ));
?>
<?php if ( $the_query->have_posts() ) : ?>
    <div class="container pb-5">
        <div class="row category__wrapper mt-5 pt-5">
            <div class="category__posts js-archive-blogs aos-fade-up aos-init aos-animate">
                <?php while( $the_query->have_posts() ): $the_query->the_post(); ?>
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
                                    // Check the new ACF field for author
                                    $zanTimeAuthorCF = get_field( 'zan_times_author', get_the_ID() );
                                    $translated_author_name = pll__($zanTimeAuthorCF);
                                ?>
                                <?php if ( ( pll_current_language() === 'en') && $zanTimeAuthorCF ) { ?>
                                    <strong> <?php echo __('By: ', 'zantimes' ); ?></strong><?php echo $translated_author_name; ?>
                                <?php } ?>
                            </div>
                            <h5 class="post-title mb-0"><?php echo get_the_title(get_the_ID()); ?></h5>
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            
            <?php if ( $the_query->max_num_pages > 1 ) : ?>
                <div class="zantimes-blogs__loadmore-wrapper text-center">
                    <a href="#" class="btn-primary js-archive-blogs-load-more" data-cat="<?php echo $term_id; ?>"  data-posts-per-page="9"><?php echo __( 'Load more', 'zantimes' ); ?></a>
                    <span class="zantimes-loader">
                        <span class="zantimes-loader__inner"></span>
                    </span>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php else : ?>
        <div class="container py-5"> <?php echo __( 'No Post To Show.', 'zantimes'); ?> </div>
<?php endif; ?>

<!-- Newsletter -->
<?php
    $bg_image =  get_field( 'zantimes_newsletter_bg_image', 'option' );
    $bg_image = $bg_image ? 'background-image:url('.$bg_image.');' : '';
    $title = get_field( 'zantimes_newsletter_heading', 'option' );
?>
<div class="zantimes-newsletter" style="<?php echo $bg_image; ?>">
    <div class="container">
        <div class="zantimes-newsletter__wrapper">
            <?php if ( $title && get_field( 'zantimes_newsletter_form', 'option' ) ) : ?>
                <h2 class="zantimes-newsletter__heading">
                    <?php echo $title; ?>
                </h2>
                <div class="zantimes-newsletter__form"><?php echo get_field( 'zantimes_newsletter_form', 'option' ); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
     //Category load more
    var page = 0;
    var ppp = 9;
    var totalpage = <?php echo $the_query->max_num_pages; ?> - 1;
    jQuery(function($) {
        $('.js-archive-blogs-load-more').on('click', function (e) {
            e.preventDefault();
            var cat = '',
                button = $(this);
            if (typeof $(this).data('cat') !== 'undefined') {
                cat = $(this).data('cat');
            }

            var loader = $('.js-archive-blogs-load-more').siblings('.zantimes-loader');
            $(loader).css('display', 'inline-block');
            $(this).hide();
            // page++;

            $.ajax({
                url: wpAjax.ajaxUrl,
                data: {
                    action: 'zantimes_load_more_posts',
                    cat: cat,
                    offset: (page * ppp) + 10,
                    ppp: ppp
                },
                type: 'post',
                dataType: 'json',
                success: function (posts) {
                    $(loader).css('display', 'none');
                    
                    if(posts === '') {
                        $('.js-archive-blogs-load-more').hide();
                    } else {
                        $('.js-archive-blogs').append(posts.content);
                    }
                    page++;
                    if ( page == totalpage ) {
                        $(".js-archive-blogs-load-more").hide();
                        // $(loader).css('display', 'none');
                    } else {
                        $('.js-archive-blogs-load-more').show();
                    }
                }
            });
        });
    });
</script>
<?php get_footer(); ?>