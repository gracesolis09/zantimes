<?php

/**
 * Post Grid Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-post-grid'
    ]
);
?>
<?php
if ( isset( $block['data']['preview_post_grid'] ) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/post-grid.png" style="width:100%; height:auto;">';
else :
?>
    <div <?php echo $wrapper_attributes; ?>>
        <?php $featured_posts = get_field('posts_to_show'); ?>
        <?php if( $featured_posts && get_field( 'show_3_latest_posts' ) == false ) : ?>
            <div class="row">
                <?php foreach( $featured_posts as $post ):
                    // $category = get_the_category($post)[0]->cat_name;
                    $categories =  get_the_category($post);
                    $author_id = get_post_field( 'post_author', $post );
                    ?>
                    <div class="col-lg-4 col-md-12 zantimes-post-grid__col">
                        <a href="<?php echo get_the_permalink($post); ?>">
                            <?php echo wp_get_attachment_image( get_post_thumbnail_id($post), 'medium', '', ['class' => "featured-img"] ); ?>
                        </a>
                            <div class="post-meta">
                                <!-- <?php if($category){ echo "<a href='". get_category_link( get_the_category($featured_post)[0]->term_id ) ."'><strong>" . $category . "</strong></a>"; }?> -->
                                <?php
                                if (!empty($categories)) {
                                    // Loop through each category and display its name
                                    $category_name = $categories[0]->name;
                                    
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
                                    $author_name = get_the_author_meta('display_name', $author_id);
                                    // Check the new ACF field for author
                                    $zanTimeAuthorCF = get_field( 'zan_times_author', $post );
                                    $translated_author_name = pll__($zanTimeAuthorCF);
                                ?>
                                <?php if ( $zanTimeAuthorCF ) : ?>
                                    <span> <?php echo $translated_author_name; ?></span>
                                <?php endif; ?>
                            </div>

                        <a class="post-link" href="<?php echo get_the_permalink($post); ?>" aria-label="Read <?php echo get_the_title($post); ?>">
                            <h5 class="post-title mb-0"><?php echo get_the_title($post); ?></h5>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php else : ?>
            <div class="row">
                <?php
               $post = new WP_Query(array(
                'posts_per_page' => 3,
                'post_status' => 'publish',
                // 'suppress_filters' => true,
                'orderby' => 'date',
                'order' => 'DESC', // Order by date in ascending order
                'offset' => 1 // Skip the latest post
            ));
            
                ?>
                <?php if ( $post->have_posts() ) : ?>
                    <?php while ( $post->have_posts() ) : $post->the_post();
                        // $category = get_the_category($post->ID)[0]->cat_name;
                        $categories = get_the_category($post->ID);
                        $author_id = get_post_field( 'post_author', $post->ID );
                    ?>
                        <div class="col-lg-4 col-md-12 zantimes-post-grid__col">
                            <a href="<?php echo get_the_permalink($post->ID); ?>">
                                <?php echo wp_get_attachment_image( get_post_thumbnail_id($post->ID), 'medium', '', ['class' => "featured-img"] ); ?>
                            </a>
                            <div class="post-meta">
                                <?php
                                 if (!empty($categories)) {
                                     // Loop through each category and display its name
                                     $category_name = $categories[0]->name;
                                     
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
                                        echo "<a href='". get_category_link( get_the_category($post->ID)[0]->term_id ) ."'><strong>" . $category_name . "</strong></a>"; 
                                    }
                                 } ?>
                                <?php 
                                    $author_name = get_the_author_meta('display_name', $author_id);
                                    // Check the new ACF field for author
                                    $zanTimeAuthorCF = get_field( 'zan_times_author', get_the_ID() );
                                    $translated_author_name = pll__($zanTimeAuthorCF);
                                ?>
                                <?php if ( $zanTimeAuthorCF ) : ?>
                                    <span> <?php echo $translated_author_name; ?></span>
                                <?php endif; ?>
                            </div>
                            <a class="post-link" href="<?php echo get_the_permalink($post->ID); ?>" aria-label="Read <?php echo get_the_title($post->ID); ?>">
                                <h5 class="post-title mb-0"><?php echo get_the_title($post->ID); ?></h5>
                            </a>
                        </div>
                <?php endwhile; endif;?>
            </div>
        <?php endif; ?>
    </div>
    <?php
endif;    
?>