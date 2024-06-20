<?php
/**
 * The template for displaying search results pages
 *
 */

get_header(); ?>
    <div class="wp-block-group">
        <div class="container">
            <div class="section-article-posts__heading mb-3 pb-3">
                <h2 class="text-center"> <?php echo __( 'Search results for: ', 'zantimes' ), get_search_query(); ?></h2>
            </div>
            <?php if ( have_posts() ) : ?>
                <div>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $featured_image = $featured_image ? $featured_image : get_template_directory_uri() . '/assets/images/img-default.png';
                            $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                            $alt_image = $thumbnail_id ? get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) : 'featured image';
                        ?>
                        <div class="post-row">
                            <a href="<?php echo get_the_permalink(); ?>" class="post-row__image">
                                <img src="<?php echo $featured_image; ?>" alt="<?php echo $alt_image; ?>" />
                            </a>
                            <div class="post-row__info">
                                <div class="post-row__meta small">
                                    <?php if ( pll_current_language() === 'fa' ) : ?>
                                        <?php
                                            $postdate_d = get_the_date('d');
                                            $postdate_m = get_the_date('M');
                                            $postdate_y = get_the_date('Y');
                                        ?> 
                                        <span><?php echo single_post_fa_date($postdate_m, $postdate_d, $postdate_y);?> </span>
                                    <?php else : ?>
                                        <span> <?php echo get_the_date(); ?> </span>
                                    <?php endif; ?>
                                    <?php $cat = get_the_category()[0]; ?>
                                    <?php if ($cat) : ?>
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="post-row__category"><?php echo $cat->name; ?></a>
                                    <?php endif; ?>
                                </div>
                                <h4><a href="<?php echo get_the_permalink(); ?>" class="post-row__title"><?php echo get_the_title(); ?></a></h4>
                                <p><?php echo zantimes_get_excerpt( 270 ); ?><br><a href="<?php echo get_the_permalink(); ?>"><?php echo __( 'Read more', 'zantimes' ) ?></a></p>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_query(); ?>
                </div>
                <div class="zantimes-pagination">
                    <?php echo get_previous_posts_link( '<img src="'. get_template_directory_uri() .'/assets/images/svg/arrow-down.svg" alt="arrow left" />' ); ?>
                    <span class="zantimes-pagination__text"><?php echo '<span class="js-current-page">'.( get_query_var('paged') ? get_query_var('paged') : 1 ).'</span> ' . __( 'of', 'zantimes' ) . ' ' . $wp_query->max_num_pages; ?></span>
                    <?php echo get_next_posts_link( '<img src="'. get_template_directory_uri() .'/assets/images/svg/arrow-down.svg" alt="arrow right" />', $wp_query->max_num_pages ); ?>
                </div>
                <?php else : ?>
                    <div class="text-center">
                        <h4><?php echo __( 'No result found.', 'zantimes'); ?></h4>
                    </div>
            <?php endif; ?>
        </div>
    </div>
<?php
get_footer();
