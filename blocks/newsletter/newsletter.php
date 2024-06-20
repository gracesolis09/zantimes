<?php

/**
 * Newsletter Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

$bg_image =  get_field( 'zantimes_newsletter_bg_image', 'option' );
$bg_image = $bg_image ? 'background-image:url('.$bg_image.');' : '';
$title = get_field( 'zantimes_newsletter_heading', 'option' );

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-newsletter alignfull',
        'id'    =>  isset($block['anchor'])
    ]
);
?>
<?php
if ( isset($block['data']['preview_image_newsletter']) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/newsletter.png" style="width:100%; height:auto;">';
else :
?>
    <div id="<?php echo esc_attr( $block['anchor'] ); ?>" <?php echo $wrapper_attributes; ?> style="<?php echo $bg_image; ?>">
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

    <?php
endif;    
?>