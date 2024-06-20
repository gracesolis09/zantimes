<?php

/**
 * Icon Text Block Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

if ( ! empty( get_field( 'zantimes_icontext_columns' ) ) ) {
    $cols_class .= ' zantimes-icontext--' . get_field( 'zantimes_icontext_columns' ) . 'cols';
}


$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-icontext' . $cols_class
    ]
);
?>
<?php
if ( isset($block['data']['preview_image_icontext']) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/icontext.png" style="width:100%; height:auto;">';
else :
    if( have_rows( 'zantimes_icontext_blocks' ) ) :
?>
    <div <?php echo $wrapper_attributes; ?>>
        <?php while( have_rows( 'zantimes_icontext_blocks' ) ) : the_row(); ?>
            <div class="zantimes-icontext__block">
                <div class="zantimes-icontext__block-img">
                    <?php if ( $icon = get_sub_field( 'zantimes_icontext_blocks_icon' ) ) {
                        echo wp_get_attachment_image( $icon, 'full', "", ["class" => "zantimes-icontext__block-icon"] );    
                    } ?>
                </div>
                <div class="zantimes-icontext__block-content">
                    <?php if( $title = get_sub_field( 'zantimes_icontext_blocks_title' ) ) : ?>
                        <h4 class="zantimes-icontext__block-title" style="color:<?php echo get_field( 'zantimes_icontext_content_color' ); ?>"><?php echo $title; ?></h4>
                    <?php endif; ?>
                    <?php if( $text = get_sub_field( 'zantimes_icontext_blocks_text' ) ) : ?>
                        <div class="zantimes-icontext__block-text" style="color:<?php echo get_field( 'zantimes_icontext_content_color' ); ?>"><?php echo $text; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div> 
    <?php endif; ?>
<?php
endif;    
?>