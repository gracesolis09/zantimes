<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>
    <div class="container">
        <div class="row h-100 py-5 my-5 text-center justify-content-center align-items-center">
            <div class="col-12">
                <h2><?php echo __( 'Page Not Found', 'zantimes' ); ?></h2>
                <p class="mb-4"><?php echo __( "The page you are looking for doesn't exist or has been moved.", 'zantimes' ); ?></p>
                <a href="<?php echo home_url();?>" class="btn-primary"><?php echo __( 'Return Home', 'zantimes' ); ?></a>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
