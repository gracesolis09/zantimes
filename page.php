<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header();
?>
    <div class="container">
        <?php if ( get_the_content() ) : ?>
            <?php the_content(); ?>
        <?php else: ?> 
            <div class="default-page__wrapper alignfull justify-content-center align-items-center">
                <div class="container">
                    <div class="default-page__wrapper-content">
                        <h1 class="mb-0"><?php echo get_the_title(); ?></h1>
                    </div>
                </div>
            </div>
            <div class="content py-5">
                <?php echo __( "This page is empty.", 'zantimes' ); ?>
            </div>
        <?php endif; ?>
    </div>
<?php
get_footer();