<?php

/**
 * Hero Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/
$bg_image = get_field('zantimes_hero_bg_image')['url'];
$bg_image = $bg_image ? 'background: url('.$bg_image.');' : '';

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-hero ',
    ]
);
?>
<?php
if ( isset( $block['data']['preview_image_hero'] ) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/hero.png" style="width:100%; height:auto;">';
else :
?>
    <div <?php echo $wrapper_attributes; ?> style="<?php echo $bg_image; ?>">
        <div class="container">
            <div class="row zantimes-hero__wrapper">
                <div class="col-12 col-md-12 col-lg-6">
                    <?php if ( $tagline = get_field( 'zantimes_hero_tagline' ) ) : ?>
                        <div class="zantimes-hero__tagline"><?php echo $tagline; ?></div>
                    <?php endif; ?>
                    <?php if ( $title = get_field( 'zantimes_hero_heading' ) ) : ?>
                        <h1 class="zantimes-hero__heading mb-0">
                            <?php echo $title; ?>
                        </h1>
                    <?php endif; ?>
                    <?php if ( $btn = get_field( 'zantimes_hero_button') ) : 
                        $btn_url = $btn['url'];
                        $btn_title = $btn['title'];
                        $btn_target = $btn['target'] ? $btn['target'] : '_self';
                    ?>  
                        <a class="btn-primary" href="<?php echo esc_url( $btn_url ); ?>" target="<?php echo esc_attr( $btn_target ); ?>"><?php echo esc_html( $btn_title ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
endif;    
?>