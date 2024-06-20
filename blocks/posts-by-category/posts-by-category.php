<?php

/**
 * Post by Category block Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/
$term = get_field('posts_category');
$term_name = $term->name;
$featured_posts = get_field('posts');

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-post-by-category'
    ]
);
?>
<?php
if ( isset( $block['data']['preview_posts_by_category'] ) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/posts-by-category.png" style="width:100%; height:auto;">';
else:
?>
<div <?php echo $wrapper_attributes; ?>>
    <div class="d-sm-flex justify-content-between zantimes-post-by-category__title">
        <?php if ( $term ) : ?>
            <h2><?php echo $term_name; ?></h2>
        <?php endif; ?>
        <a class="align-self-center" href="<?php echo get_term_link($term) ?>">
        <?php echo (pll_current_language() === 'en') ? __('See all', 'zantimes')." ".$term_name : __('See all', 'zantimes') ; ?> 
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/ionic-ios-arrow-round-forward.svg" /></a>
    </div>
    <?php if ( $featured_posts ) : ?>
        <div class="row">
            <?php $first_post = $featured_posts[0]; ?>
            <?php if ( $first_post ) : 
                $categories = get_the_category($first_post);
                // $first_cat_name = get_the_category($first_post)[0]->cat_name;
                // $first_cat_link = get_category_link( get_the_category($first_post)[0] )->term_id;
                $author_id = get_post_field( 'post_author', $first_post );
                $author_name = get_the_author_meta('display_name', $author_id);
                // Check the new ACF field for author
                $zanTimeAuthorCF = get_field( 'zan_times_author', $first_post );
                $translated_author_name = pll__($zanTimeAuthorCF);    
            ?>
                <div class="col-lg-7 col-md-12 bigger">
                    <a class="post-link" href="<?php echo get_the_permalink($first_post); ?>">
                        <?php echo wp_get_attachment_image( get_post_thumbnail_id($first_post), 'medium_large', '', ['class' => "featured-img"] ); ?>
                    </a>
                    <div class="post-meta mt-4">
                        <?php if (!empty($categories)) {
                            $category_name = $categories[0]->name;
                            $category_link = get_category_link( get_the_category($first_post)[0]->term_id );
                            if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' ) {
                                $sub_category_name = '';
                                foreach ( $categories as $category ) {
                                    if ( $category->category_parent > 0 ) {
                                        $sub_category_name = $category->name;
                                        $sub_category_id = $category->term_id;
                                        break; // Stop the loop once a sub-category is found
                                    }
                                }
                                if ( pll_current_language() === 'fa' ) {
                                    if ( $sub_category_name === 'پادکست' ) { 
                                        echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/podcast.svg" alt="Podcast"><strong>'. $sub_category_name .'</strong></a>';
                                    } else if ( $sub_category_name === 'ویدیو' ) {
                                        echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/video.svg" alt="Video"><strong>'. $sub_category_name .'</strong></a>'; 
                                    }
                                } else {
                                    if ( $sub_category_name === 'Podcast' ) {
                                        echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/podcast.svg" alt="Podcast"><strong>'. $sub_category_name .'</strong></a>';
                                    } else if ( $sub_category_name === 'Video' ) {
                                        echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/video.svg" alt="Video"><strong>'. $sub_category_name .'</strong></a>'; 
                                    }
                                }
                            }
                            if ( pll_current_language() === 'fa' ) {
                                if ( $category_name !== 'چندرسانه‌‌ای' ) {
                                    echo '<a href="'. $category_link .'">
                                        <strong>'. $category_name .'</strong>
                                    </a>';
                                }
                            } else {
                                if ( $category_name !== 'Multimedia' ) {
                                echo '<a href="'. $category_link .'">
                                        <strong>'. $category_name .'</strong>
                                    </a>';
                                }
                            }
                        } ?>
                        <?php if ( $zanTimeAuthorCF ) : ?>
                            <span> <?php echo $translated_author_name; ?></span>
                        <?php endif; ?>
                        <a class="post-link" href="<?php echo get_the_permalink($first_post); ?>">
                            <h4 class="post-title mb-3 mt-3"><?php echo get_the_title($first_post); ?></h4>
                        </a>
                    </div>
                    <p class="post-excerpt"><?php echo get_the_excerpt($first_post); ?><a href="<?php echo get_the_permalink($first_post); ?>" aria-label="Read <?php echo strip_tags(get_the_title($first_post)); ?>"><?php echo __('See more', 'zantimes'); ?></a></p>
                </div>
            <?php endif; ?>
            <div class="col-lg-5 col-md-12">
                <?php foreach (array_slice($featured_posts, 1) as $post_object) : 
                    $post = get_post($post_object->ID); 
                    setup_postdata($post);
                    $categories = get_the_category($post_object);
                    // $first_cat_name = get_the_category($post_object)[0]->cat_name;
                    // $first_cat_link = get_category_link($post_object)[0]->term_id;
                    $author_id = get_post_field( 'post_author', $post );
                    $author_name = get_the_author_meta('display_name', $author_id);
                    // Check the new ACF field for author
                    $zanTimeAuthorCF = get_field( 'zan_times_author', $post_object );
                    $translated_author_name = pll__($zanTimeAuthorCF);
                ?>
                    <div class="col-12 d-md-flex smaller">
                        <a href="<?php echo get_the_permalink($post_object); ?>">
                            <?php echo wp_get_attachment_image( get_post_thumbnail_id($post_object), 'medium', '', ['class' => "featured-img"] ); ?>
                        </a>
                        <div class="post-meta">
                            <?php if (!empty($categories)) {
                                $category_name = $categories[0]->name;
                                $category_link = get_category_link( get_the_category($post_object)[0]->term_id );
                                if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' ) {
                                    $sub_category_name = '';
                                    foreach ( $categories as $category ) {
                                        if ( $category->category_parent > 0 ) {
                                            $sub_category_name = $category->name;
                                            $sub_category_id = $category->term_id;
                                            break; // Stop the loop once a sub-category is found
                                        }
                                    }
                                    if ( pll_current_language() === 'fa' ) {
                                        if ( $sub_category_name === 'پادکست' ) { 
                                            echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/podcast.svg" alt="Podcast"><strong>'. $sub_category_name .'</strong></a>';
                                        } else if ( $sub_category_name === 'ویدیو' ) {
                                            echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/video.svg" alt="Video"><strong>'. $sub_category_name .'</strong></a>'; 
                                        }
                                    } else {
                                        if ( $sub_category_name === 'Podcast' ) {
                                            echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/podcast.svg" alt="Podcast"><strong>'. $sub_category_name .'</strong></a>';
                                        } else if ( $sub_category_name === 'Video' ) {
                                            echo '<a href="'. get_category_link( $sub_category_id ) .'"><img class="multimedia-icon" src="'. get_template_directory_uri() .'/assets/images/svg/video.svg" alt="Video"><strong>'. $sub_category_name .'</strong></a>'; 
                                        }
                                    }
                                }
                                if ( pll_current_language() === 'fa' ) {
                                    if ( $category_name !== 'چندرسانه‌‌ای' ) {
                                        echo '<a href="'. $category_link .'">
                                            <strong>'. $category_name .'</strong>
                                        </a>';
                                    }
                                } else {
                                    if ( $category_name !== 'Multimedia' ) {
                                    echo '<a href="'. $category_link .'">
                                            <strong>'. $category_name .'</strong>
                                        </a>';
                                    }
                                }
                            } ?>
                            <?php if ( $zanTimeAuthorCF ) : ?>
                                <span> <?php echo $translated_author_name; ?></span>
                            <?php endif; ?>
                            <a class="post-link" href="<?php echo get_the_permalink($post_object); ?>" aria-label="Read <?php echo get_the_title($post_object); ?>">
                                <h5 class="post-title mt-2"><?php echo get_the_title($post_object); ?></h5>
                            </a>
                        </div>
                    </div>
                <?php wp_reset_postdata(); endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <?php if ( $term ) : ?>
            <div class="row">
                <?php 
                    $args = array(
                    'posts_per_page' => 1, // Only fetch the first post
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $term->term_id,
                        ),
                    ),);

                    $first_post = get_posts($args);
                ?>
                <?php if ( $first_post ) : 
                    $categories = get_the_category($first_post[0]->ID);
                    $author_id = get_post_field( 'post_author', $first_post[0] );
                    $author_name = get_the_author_meta('display_name', $author_id);
                    // Check the new ACF field for author
                    $zanTimeAuthorCF = get_field( 'zan_times_author', $first_post[0] );
                    $translated_author_name = pll__($zanTimeAuthorCF);    
                ?>
                    <div class="col-lg-7 col-md-12 bigger <?php echo $term->term_id; ?>">
                        <a class="post-link" href="<?php echo get_the_permalink($first_post[0]); ?>">
                            <?php echo wp_get_attachment_image( get_post_thumbnail_id($first_post[0]), 'medium_large', '', ['class' => "featured-img"] ); ?>
                        </a>
                        <div class="post-meta mt-4">
                            <strong><?php echo $first_cat_name; ?></strong>
                            <?php if ( $categories ) : 
                                $category_name  = $categories[0]->name;
                                $category_link = get_category_link($categories[0]->term_id);
                            ?>
                                <?php if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' || $category_name === 'پادکست' ) {
                                    $sub_category_name = '';
                                    foreach ( $categories as $category ) {
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
                                    echo '<a href="'. $category_link .'">
                                        <strong>'. $category_name .'</strong>
                                    </a>';
                                }
                                ?>
                            <?php endif; ?>
                            <?php if ( $zanTimeAuthorCF ) : ?>
                                <span> <?php echo $translated_author_name; ?></span>
                            <?php endif; ?>
                            <a class="post-link" href="<?php echo get_the_permalink($first_post[0]); ?>">
                                <h4 class="post-title mb-3 mt-3"><?php echo get_the_title($first_post[0]); ?></h4>
                            </a>
                        </div>
                        <p class="post-excerpt"><?php echo get_the_excerpt($first_post[0]); ?><a href="<?php echo get_the_permalink($first_post[0]); ?>" aria-label="Read <?php echo get_the_title($first_post[0]); ?>"><?php echo __('See more', 'zantimes'); ?></a></p>
                    </div>
                <?php endif; ?>
                <?php 
                    $args = array(
                    'posts_per_page' => 3, 
                    'offset' => 1, // Except first post
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $term->term_id,
                        ),
                    ),);

                    $other_posts = get_posts($args);
                ?>
                <div class="col-lg-5 col-md-12">
                    <?php foreach ($other_posts as $post) :
                        setup_postdata($post);
                        $categories = get_the_category($post->ID);
                        // $category_link = get_category_link($post->ID)[0]->term_id;
                        $author_id = get_post_field( 'post_author', $post->ID );
                        $author_name = get_the_author_meta('display_name', $author_id);
                        // Check the new ACF field for author
                        $zanTimeAuthorCF = get_field( 'zan_times_author', $post->ID );
                        $translated_author_name = pll__($zanTimeAuthorCF);
                    ?>
                        <div class="col-12 d-md-flex smaller">
                            <a href="<?php echo get_the_permalink($post->ID); ?>">
                                <?php echo wp_get_attachment_image( get_post_thumbnail_id($post->ID), 'medium', '', ['class' => "featured-img"] ); ?>
                            </a>
                            <div class="post-meta">
                            <?php if ( $categories ) : 
                                $category_name  = $categories[0]->name;
                                $category_link = get_category_link($categories[0]->term_id);
                            ?>
                                <?php if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' || $category_name === 'پادکست' ) {
                                    $sub_category_name = '';
                                    foreach ( $categories as $category ) {
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
                                    echo '<a href="'. $category_link .'">
                                        <strong>'. $category_name .'</strong>
                                    </a>';
                                } 
                            endif; ?>
                                <?php if ( $zanTimeAuthorCF ) : ?>
                                    <span> <?php echo $translated_author_name; ?></span>
                                <?php endif; ?>
                                <a class="post-link" href="<?php echo get_the_permalink($post->ID); ?>" aria-label="Read <?php echo get_the_title($post->ID); ?>">
                                    <h5 class="post-title mt-2"><?php echo get_the_title($post->ID); ?></h5>
                                </a>
                            </div>
                        </div>
                    <?php wp_reset_postdata(); endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php   
endif;    
?>