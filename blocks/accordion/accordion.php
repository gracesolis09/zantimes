<?php

/**
 * Accordion Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/
// Create id attribute
$id = 'zantimes-accordion-' . $block['id'];
$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-accordion',
        'id'    =>  $id
    ]
);
?>
<?php
if ( isset($block['data']['preview_image_accordion']) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/accordion.png" style="width:100%; height:auto;">';
else :
?>
    <!-- Accordion code here -->
    <?php if ( have_rows( 'zantimes_accordion_items' ) ) : ?>
        <div <?php echo $wrapper_attributes; ?>>
            <div class="container">
                <?php if( $heading = get_field( 'zantimes_accordion_heading' ) ): ?>
                    <h2 class="zantimes-accordion__heading pb-4"><?php echo $heading; ?></h2>
                <?php endif; ?>
                <?php while( have_rows( 'zantimes_accordion_items' ) ): the_row();  $count = get_row_index(); ?>
                    <div class="zantimes-accordion-item">
                        <div id="<?php echo esc_attr( $id ) . '_heading_' . $count; ?>" class="zantimes-accordion-item__heading" role="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $id ) . '_' . $count; ?>" aria-expanded="<?php echo $count === 0 ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $id ) . '_' . $count; ?>">
                            <?php echo get_sub_field( 'title' ); ?>
                        </div>
                        <div id="<?php echo esc_attr( $id ) . '_' . $count; ?>" aria-labelledby="<?php echo esc_attr( $id ) . '_heading_' . $count; ?>" class="collapse" data-bs-parent="#<?php echo esc_attr( $id ); ?>">
                            <div class="zantimes-accordion-item__body">
                                <?php echo get_sub_field( 'text' ); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php
endif;    
?>