<?php
/**
 * Two Column Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/

$image_position = get_field( 'zantimes_two_column_option' );
$image = get_field( 'zantimes_two_column_image' );
$image_size = get_field( 'zantimes_two_column_image_size' );
$min_height =  get_field( 'zantimes_two_column_min_height' ) ? 'min-height:' . get_field( 'zantimes_two_column_min_height' ) . 'px' : '';
$contentPosition =  ( 'left' === $image_position ) ? 'right' : 'left';
$isReverse = get_field( 'zantimes_two_column_reverse' ) ? 'reverse-mobile' : '';

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-two-column ' . $isReverse . ' ' . $image_position
    ]
);
?>
<?php
if ( isset( $block['data']['preview_image_two_column'] ) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/two-column.png" style="width:100%; height:auto;">';
else :
?>
    <div <?php echo $wrapper_attributes; ?>>
        <?php if ( 'left' === $image_position ) : ?>
            <div class="zantimes-two-column__col zantimes-two-column__col--bg <?php echo $image_size; ?>" style="<?php echo $min_height; ?>">
                <?php if ( $image ) : ?>
                    <?php echo wp_get_attachment_image( $image['ID'], 'full', "", ["class" => "zantimes-two-column__col--bg-image"]); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="zantimes-two-column__col zantimes-two-column__col--content <?php echo $contentPosition . " " . $image_size . "-offset"; ?>">
            <InnerBlocks />
        </div>
        <?php if ( 'right' === $position ) : ?>
            <div class="zantimes-two-column__col zantimes-two-column__col--bg <?php echo $image_size; ?>" style="<?php echo $min_height; ?>">
                <?php if ( $image ) : ?>
                    <?php echo wp_get_attachment_image( $image['ID'], 'full', "", ["class" => "zantimes-two-column__col--bg-image"]); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>