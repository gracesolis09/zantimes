<?php

/**
 * Teams Template.
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
*/
$items_per_page = get_field( 'zantimes_teams_items_per_page' );
$offset = get_field( 'zantimes_teams_offset' ) ? get_field( 'zantimes_teams_offset' ) : 0;
$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'zantimes-teams js-team-grid'
    ]
);
?>
<?php
if ( isset( $block['data']['preview_image_teams'] ) ) :
    echo '<img src="'. get_template_directory_uri() .'/assets/images/blocks-preview/teams.png" style="width:100%; height:auto;">';
else :
    if ( have_rows( 'zantimes_teams' ) ) :
?>
    <div <?php echo $wrapper_attributes; ?>>
        <div class="js-zantimes-teams-wrapper">
            <div class="row teams-row">
                <?php $count = 0; while ( have_rows( 'zantimes_teams' ) && ( $count < 6 ) ) : the_row(); $total = count(get_field('zantimes_teams')); ?>
                    <?php $profile_img = get_sub_field( 'profile_image' )['url']; 
                        $profile_img = $profile_img ? $profile_img : get_template_directory_uri() . '/assets/images/img-default.png';
                        $name = get_sub_field( 'name' ); 
                        $position = get_sub_field( 'job' );
                    ?>
                        <div class="col-12 col-md-6 col-lg-4 zantimes-teams__column modal-trigger" data-toggle="modal" data-target="#<?php echo $count; ?>">
                            <?php if ( $profile_img ) : ?>
                                <img src="<?php echo $profile_img; ?>" alt="<?php echo __( 'Profile Image', 'zantimes' ); ?>" class="zantimes-teams__image">
                            <?php endif; ?>
                            <?php if ( $name ) : ?>
                                <h3 class="zantimes-teams__name"><?php echo $name; ?></h3>
                            <?php endif; ?>
                            <?php if ( $position ) : ?>
                                <p class="zantimes-teams__position"><?php echo $position; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php $count++; endwhile; reset_rows('zantimes_teams'); ?>
            </div>
            <button onclick="my_repeater_show_more()" class="btn-outline js-load-more" <?php if ($total < $count) { ?> style="display: none;"<?php } ?>><?php echo __( 'More team', 'zantimes'); ?></button>
        </div>
    </div>

    <?php $count = 0; while ( have_rows( 'zantimes_teams' ) ) : the_row(); 
        $profile_img = get_sub_field( 'profile_image' )['url']; 
        $profile_img = $profile_img ? $profile_img : get_template_directory_uri() . '/assets/images/img-default.png';
        $name = get_sub_field( 'name' ); 
        $name_slug = slugify( $name );
        $position = get_sub_field( 'job' );
        $modal_content = get_sub_field( 'modal_content' );
    ?>                
    <?php if( $modal_content ): ?>
        <!-- Modal -->
        <div class="modal fade zantimes-teams__modal" id="<?php echo $count; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-md-down" role="document">
                <div class="modal-content container">
                <div class="modal-header">
                    <button type="button" class="js-close-modal close" data-dismiss="modal" aria-label="Close" data-close="#<?php echo $count; ?>">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <?php if ( $profile_img ) : ?>
                            <img src="<?php echo $profile_img; ?>" alt="<?php echo __( 'Profile Image', 'zantimes' ); ?>" class="zantimes-teams__image">
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <h2 class="mb-2"><strong><?php echo $name; ?></strong></h2>
                        <h3><strong><?php echo $position; ?></strong></h3>
                        <?php echo $modal_content; ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    <?php endif; ?>    
    <?php $count++; endwhile; endif;
endif;    
?>

<!-- Repeater JS -->
<script type="text/javascript">
	var my_repeater_field_post_id = <?php echo get_the_ID(); ?>;
	var my_repeater_field_offset = <?php echo $items_per_page + $offset ?>;
	var my_repeater_field_nonce = '<?php echo wp_create_nonce('my_repeater_field_nonce'); ?>';
	var my_repeater_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
	var my_repeater_more = true;
	
	function my_repeater_show_more() {
		
		// make ajax request
		jQuery.post(
			my_repeater_ajax_url, {
				// this is the AJAX action we set up in PHP
				'action': 'my_repeater_show_more',
				'post_id': my_repeater_field_post_id,
				'offset': my_repeater_field_offset,
				'nonce': my_repeater_field_nonce
			},
			function (json) {
				// add content to container
				// this ID must match the containter 
				// you want to append content to
				jQuery('.teams-row').append(json['content']);
				// update offset
				my_repeater_field_offset = json['offset'];
				// see if there is more, if not then hide the more link
				if (!json['more']) {
					// this ID must match the id of the show more link
					jQuery('.js-load-more').css('display', 'none');
				}

                jQuery('.modal-trigger').on('click', function(e) {
                    e.preventDefault();
                    var modalId = jQuery(this).attr('data-target');
                    jQuery(modalId).modal('show');
                });

                jQuery('[data-dismiss="modal"]').on('click', function(e) {
                    e.preventDefault();
                    var modalId = jQuery$(this).attr('data-close');
                    jQuery(modalId).modal('hide');
                });
			},
			'json'
		);
	}
	
</script>