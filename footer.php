
  </main>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3 col-xl-4 footer__wrapper footer__wrapper--logo">
          <?php if ( pll_current_language() === 'fa' ) : ?>
            <a class="fa-logo" href="<?php echo home_url();?>" aria-label="Go to home page">
              <img class="custom-logo" alt="zantimes logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/logo-farsi-footer-icon.svg" alt="zantimes logo">
              <span>زن‌تایمز</span>
            </a>
          <?php else : ?>
            <?php if ( $footer_logo = get_field( 'zantimes_footer_logo', 'option' ) ) : ?>
              <?php if ( $footer_logo ) :
                $path_info = pathinfo( get_attached_file( $footer_logo ) );
                $extension = $path_info['extension'];
              ?>
                <a href="<?php echo home_url(); ?>" aria-label="Zantimes footer logo">
                  <?php
                      $svg = @file_get_contents(wp_get_attachment_image_url($footer_logo, 'full'));
                      if ( 'svg' === $extension && $svg !== FALSE ) {
                        echo $svg;
                      } else {
                        echo wp_get_attachment_image( $footer_logo, 'full', "", ["class" => "footer__logo-image"] );
                      }
                  ?>
                </a>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
          <p><?php echo get_field( 'zantimes_footer_text', 'option' ); ?></p>
        </div>
        <div class="col-12 col-lg-9 col-xl-8 ms-lg-auto d-lg-flex justify-content-evenly d-block">
          <div class="footer__menu--column">
            <div class="footer__heading"><?php echo __( 'Categories', 'zantimes' ); ?></div>
            <ul class="footer__menu">
              <?php
                wp_nav_menu(
                  array(
                  'theme_location'  => 'footer',
                  'container'       => '',
                  'items_wrap'      => '%3$s',
                  'fallback_cb'     => '__return_false'
                  )
                );
              ?>
            </ul>
          </div>
          <div class="footer__menu--column">
            <div class="footer__heading"><?php echo __( 'Zan Times', 'zantimes' ); ?></div>
            <ul class="footer__menu">
              <?php
                wp_nav_menu(
                  array(
                  'theme_location'  => 'top_menu',
                  'container'       => '',
                  'items_wrap'      => '%3$s',
                  'fallback_cb'     => '__return_false'
                  )
                );
              ?>
            </ul>
            <?php if ( have_rows( 'zantimes_social_media', 'option' ) ) : ?>
              <div class="social-media">
                  <?php while ( have_rows( 'zantimes_social_media', 'option' ) ) : the_row(); 
                    $social_link = get_sub_field( 'zantimes_sm_link', 'option');  
                    $social_icon = get_sub_field( 'zantimes_sm_icon', 'option' );
                    if ( $social_icon && $social_link ) : 
                  ?>
                    <a href="<?php echo $social_link; ?>" target="_blank" aria-label="Footer Social Icons" class="social-media__link">
                      <?php echo wp_get_attachment_image( $social_icon, 'full' ); ?>
                    </a>
                  <?php endif; endwhile; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="footer__bottom">
        <?php echo get_field( 'zantimes_footer_copyright', 'option' ); ?>
      </div>
    </div>
  </footer>
  <?php wp_footer(); ?>
  <?php if ( has_block( 'acf/zantimes-newsletter' ) ) {
    echo get_field( 'zantimes_newsletter_scripts', 'option' ); 
  } ?>
  </body>
</html>