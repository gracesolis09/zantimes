<?php

/**
 * Logos Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/
$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-logos',
        'id'    =>  $block['anchor']
    ]
);
?>
<?php
if ( $block['data']['preview_image_logos'] ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/preview-logos.png" style="width:100%; height:auto;">';
else :
?>
    
    <div <?php echo $wrapper_attributes; ?>>
        <?php if ( $tagline = get_field( 'zantimes_logos_tagline' ) ) : ?>
            <div class="zantimes-logos__tagline"><?php echo $tagline; ?></div>
        <?php endif; ?>
        <div class="js-zantimes-logo-slider">
            <?php if ( have_rows( 'zantimes_logos' ) ) : ?>
                <?php while( have_rows( 'zantimes_logos' ) ): the_row(); 
                    $logo_img = get_sub_field( 'zantimes_logo_image' ); 
                    $logo_link = get_sub_field( 'zantimes_logo_link' );
                    if ( $logo_img ) :
                        $logo_img_url = $logo_img['url'];
                        $logo_img_alt = $logo_img['alt'];
                        $logo_img_wid = $logo_img['width'];
                        $logo_img_hei = $logo_img['height'];
                ?>
                    <div class="zantimes-logos__block" tabindex="-1">
                        <?php if ( $logo_link ) :
                            $link_url = $logo_link['url'];
                            $link_target = $logo_link['target'] ? $logo_link['target'] : '_self';
                        ?>
                            <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                        <?php else : ?>
                            <span>
                        <?php endif; ?>
                                <img class="skip-lazy" width="<?php echo $logo_img_wid; ?>" height="<?php echo $logo_img_hei; ?>" src="<?php echo esc_url($logo_img_url); ?>" alt="<?php echo esc_attr($logo_img_alt); ?>">
                        <?php if ( $logo_link ) : ?>
                            </a>
                        <?php else : ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
endif;    
?>