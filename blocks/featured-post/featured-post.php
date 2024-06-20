<?php

/**
 * Featured Post Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

$featured_post = get_field('featured_post');
$featured_category = get_field('featured_category');
$title = get_the_title($featured_post);
$excerpt = get_the_excerpt($featured_post);
$post_url = get_the_permalink($featured_post);
$categories = get_the_category($featured_post);
$author_id = get_post_field( 'post_author', $featured_post );
$isReverse = get_field( 'zantimes_featured_post_reverse_on_mobile' ) ? 'reverse-mobile' : '';
$backgroundImage = get_field('background_image') ? 'background-image: url('. get_field('background_image') .'); background-size: cover; background-repeat: no-repeat;' : '';
$textColorStyle = get_field( 'light_text_color' ) ? 'text-color-light' : '';
$block_style = get_field('featured_post_style');

//Button Style
$block_content_style = get_field('light_text_color');
if( $block_content_style ) {
    $block_btn_style = 'btn-white-border';
} else {
    $block_btn_style = 'btn-primary';
}

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-featured-post ' . $isReverse . ' ' . $textColorStyle
    ]
);
?>
<?php
if ( isset( $block['data']['preview_featured_post'] ) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/featured-post.png" style="width:100%; height:auto;">';
else :

?>
    <div <?php echo $wrapper_attributes; ?> style="<?php echo $backgroundImage; ?>">
        <div class="container">
            <div class="row align-items-center">
                <?php if ( !empty( $featured_post ) ) : ?>
                    <?php if ( 'right' === $block_style ) : ?>
                        <div class="col-lg-6 pe-lg-5 zantimes-featured-post__post-details">
                            <div>
                                <div class="post-meta">
                                    <?php if (!empty($categories)) {
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
                                    <?php 
                                        $author_id = get_post_field( 'post_author', $featured_post );
                                        $author_name = get_the_author_meta('display_name', $author_id);
                                        // Check the new ACF field for author
                                        $zanTimeAuthorCF = get_field( 'zan_times_author', $featured_post );
                                        $translated_author_name = pll__($zanTimeAuthorCF);
                                    ?>
                                    <?php if ( $zanTimeAuthorCF ) : ?>
                                        <span> <?php echo $translated_author_name; ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo $post_url; ?>" aria-label="<?php echo $title; ?>"><h3><?php echo $title; ?></h3></a>
                                <p><?php echo wp_trim_words( $excerpt, 60, '...' ); ?></p>
                                <div class="read-more">
                                    <a class='<?php echo $block_btn_style; ?>' href="<?php echo $post_url; ?>" aria-label="<?php echo __( 'Read more about this post', 'zantimes' ); ?>"> 
                                        <?php if (!empty($categories)) {
                                            $category_name = $categories[0]->name;
                                            // Loop through each category and display its name
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
                            <?php $post_image = get_the_post_thumbnail_url($featured_post, 'large');
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';    
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <!-- <?php if ( $post_image = get_field( 'use_selected_posts_featured_image' ) ) : 
                                $post_image = get_the_post_thumbnail_url($featured_post, 'large');
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <?php elseif ( get_field( 'featured_image' ) ) : 
                                $post_image = get_field( 'featured_image' );
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <?php else : 
                                $post_image = get_the_post_thumbnail_url($featured_post, 'large');
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';    
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <?php endif; ?> -->
                        </div> 
                    <?php else : ?>
                        <div class="col-lg-6 zantimes-featured-post__post-image">
                            <?php $post_image = get_the_post_thumbnail_url($featured_post, 'large');
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';    
                            ?>
                            <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <!-- <?php if ( $post_image = get_field( 'use_selected_posts_featured_image' ) ) : 
                                $post_image = get_the_post_thumbnail_url($featured_post, 'large');
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <?php elseif ( get_field( 'featured_image' ) ) : 
                                $post_image = get_field( 'featured_image' );
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <?php else : 
                                $post_image = get_the_post_thumbnail_url($featured_post, 'large');
                                $post_image = $post_image ? $post_image : get_template_directory_uri() . '/assets/images/img-default.png';    
                            ?>
                                <img class="featured-img" src="<?php echo $post_image; ?>" />
                            <?php endif; ?> -->
                        </div> 
                        <div class="col-lg-6 ps-lg-5 zantimes-featured-post__post-details">
                            <div>
                                <div class="post-meta">
                                    <?php if (!empty($categories)) {
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
                                    <?php 
                                        $author_id = get_post_field( 'post_author', $featured_post );
                                        $author_name = get_the_author_meta('display_name', $author_id);
                                        // Check the new ACF field for author
                                        $zanTimeAuthorCF = get_field( 'zan_times_author', $featured_post );
                                        $translated_author_name = pll__($zanTimeAuthorCF);
                                    ?>
                                    <?php if ( $zanTimeAuthorCF ) : ?>
                                        <span> <?php echo $translated_author_name; ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo $post_url; ?>" aria-label="<?php echo $title; ?>"><h3><?php echo $title; ?></h3></a>
                                <p><?php echo wp_trim_words( $excerpt, 60, '...' ); ?></p>
                                <div class="read-more">
                                    <a class='<?php echo $block_btn_style; ?>' href="<?php echo $post_url; ?>" aria-label="<?php echo __( 'Read more about this post', 'zantimes' ); ?>"> 
                                        <?php if (!empty($categories)) {
                                            $category_name = $categories[0]->name;
                                            // Loop through each category and display its name
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
                    <?php endif; ?>

                <?php else : ?>
                    <?php $args = array(
                        'post_type' => 'post', // Note: The correct parameter is 'post_type', not 'posts_type'
                        'post_status' => 'publish',
                        'numberposts' => 1 // If you want to get only the most recent post
                    ); 
                    // Add tax_query only if $featured_category is not empty
                    if (!empty($featured_category)) {
                        $args['tax_query'] = array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'term_id',
                                'terms' => $featured_category,
                                'include_children' => false
                            )
                        );
                    } 
                    $recent = get_posts($args)[0]; ?>
                    <?php if ( $recent ) : 
                        $featured_image = get_the_post_thumbnail_url($recent->ID, 'large');
                        $image = $featured_image ? $featured_image : get_template_directory_uri() . '/assets/images/img-default.png';
                        $recent_categories = get_the_category($recent->ID);
                        $recent_author_id = get_post_field( 'post_author', $recent->ID );  
                        $recent_post_url = get_the_permalink($recent->ID);
                        $recent_post_title = get_the_title($recent->ID);
                        $recent_post_excerpt = get_the_excerpt($recent->ID);    
                    ?>
                        <?php if ( 'right' === $block_style ) : ?>
                            <div class="col-lg-6 pe-lg-5 zantimes-featured-post__post-details">
                                <div>
                                    <div class="post-meta">
                                        <?php
                                        if (!empty($recent_categories)) {
                                            $category_name = $recent_categories[0]->name;
                                            // Loop through each category and display its name
                                            if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' || $category_name === 'پادکست' ) {
                                                $sub_category_name = '';
                                                foreach ( $recent_categories as $category ) {
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
                                                echo "<a href='". get_category_link( get_the_category($recent)[0]->term_id ) ."'><strong>" . $category_name . "</strong></a>"; 
                                            }
                                        } ?>
                                        <?php 
                                            $author_name = get_the_author_meta('display_name', $recent_author_id);
                                            // Check the new ACF field for author
                                            $zanTimeAuthorCF = get_field( 'zan_times_author',  $recent->ID );
                                            // $translated_author_name = pll__($zanTimeAuthorCF);
                                        ?>
                                        <?php if ($zanTimeAuthorCF ) : ?>
                                            <span> <?php echo $zanTimeAuthorCF; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php echo $recent_post_url; ?>" aria-label="<?php echo $recent_post_title; ?>"><h3><?php echo $recent_post_title; ?></h3></a>
                                    <p><?php echo wp_trim_words( $recent_post_excerpt, 60, '...' ); ?></p>
                                    <div class="read-more">
                                        <a class='<?php echo $block_btn_style; ?>' href="<?php echo $recent_post_url; ?>" aria-label="<?php echo __( 'Read more about this post', 'zantimes' ); ?>">
                                            <?php if (!empty($recent_categories)) {
                                                $category_name = $recent_categories[0]->name;
                                                // Loop through each category and display its name
                                                if ( $category_name === 'Multimedia' ) {
                                                    $sub_category_name = '';
                                                    foreach ( $recent_categories as $category ) {
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
                                <img class="img-fluid" src="<?php echo $image; ?>" />
                            </div> 
                        <?php else : ?>
                            <div class="col-lg-6 zantimes-featured-post__post-image">
                                <img class="img-fluid" src="<?php echo $image; ?>" />
                            </div> 
                            <div class="col-lg-6 pe-lg-5 zantimes-featured-post__post-details">
                                <div>
                                    <div class="post-meta">
                                        <?php
                                        if (!empty($recent_categories)) {
                                            $category_name = $recent_categories[0]->name;
                                            // Loop through each category and display its name
                                            if ( $category_name === 'Multimedia' || $category_name === 'چندرسانه‌‌ای' || $category_name === 'پادکست' ) {
                                                $sub_category_name = '';
                                                foreach ( $recent_categories as $category ) {
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
                                                echo "<a href='". get_category_link( get_the_category($recent)[0]->term_id ) ."'><strong>" . $category_name . "</strong></a>"; 
                                            }
                                        } ?>
                                        <?php 
                                            $author_name = get_the_author_meta('display_name', $recent_author_id);
                                            // Check the new ACF field for author
                                            $zanTimeAuthorCF = get_field( 'zan_times_author',  $recent->ID );
                                            // $translated_author_name = pll__($zanTimeAuthorCF);
                                        ?>
                                        <?php if ($zanTimeAuthorCF ) : ?>
                                            <span> <?php echo $zanTimeAuthorCF; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php echo $recent_post_url; ?>" aria-label="<?php echo $recent_post_title; ?>"><h3><?php echo $recent_post_title; ?></h3></a>
                                    <p><?php echo wp_trim_words( $recent_post_excerpt, 20, '...' ); ?></p>
                                    <div class="read-more">
                                        <a class='<?php echo $block_btn_style; ?>' href="<?php echo $recent_post_url; ?>" aria-label="<?php echo __( 'Read more about this post', 'zantimes' ); ?>">
                                            <?php if (!empty($recent_categories)) {
                                                $category_name = $recent_categories[0]->name;
                                                // Loop through each category and display its name
                                                if ( $category_name === 'Multimedia' ) {
                                                    $sub_category_name = '';
                                                    foreach ( $recent_categories as $category ) {
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
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>