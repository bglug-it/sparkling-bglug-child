<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_filter('widget_text', 'do_shortcode');

function sparkling_featured_slider() {
  if ( is_front_page() && of_get_option( 'sparkling_slider_checkbox' ) == 1 ) {
    echo '<div class="container">';
      echo '<div class="flexslider">';
        echo '<ul class="slides">';

          $count = of_get_option( 'sparkling_slide_number' );
          $slidecat =of_get_option( 'sparkling_slide_categories' );

          $query = new WP_Query( array( 'cat' =>$slidecat,'posts_per_page' =>$count ) );
          if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();

            echo '<li><a href="'. get_permalink() .'">';
              if ( (function_exists( 'has_post_thumbnail' )) && ( has_post_thumbnail() ) ) :
                echo get_the_post_thumbnail();
              endif;

                echo '<div class="flex-caption">';
                    if ( get_the_title() != '' ) echo '<h2 class="entry-title">'. get_the_title().'</h2>';
                    if ( get_the_excerpt() != '' ) echo '<div class="excerpt">' . get_the_excerpt() .'</div>';
                echo '</div>';
                echo '</a></li>';
                endwhile;
              endif;

        echo '</ul>';
      echo ' </div>';
    echo ' </div>';
  }
} /* end sparkling_featured_slider */


function sparkling_header_menu() {
  if ( is_front_page() ) {
    echo '<div onclick="location.href=\'/\';" class="pull-left vivus" style="cursor: pointer; cursor: hand; padding: 10px 0; height: 70px; width: 150px;" id="bglogo"></div>';
    echo '<script>
    var logo = new Vivus("bglogo", {
        type: "async",
        duration: 80,
        file: "'. get_bloginfo('stylesheet_directory') .'/images/full-logo.svg"
      }, function (obj) {
        obj.el.classList.add("finished");
    });
    </script>';
  } else {
    echo '<a href="/" class="pull-left"><img style="padding: 10px 0; height: 70px; width: 150px;" id="bglogo" src="'. get_bloginfo('stylesheet_directory') .'/images/full-logo.svg"></img></a>';
  }


  // display the WordPress Custom Menu if available
  wp_nav_menu(array(
    'menu'              => 'primary',
    'theme_location'    => 'primary',
    'depth'             => 2,
    'container'         => 'div',
    'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
    'menu_class'        => 'nav navbar-nav',
    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
    'walker'            => new wp_bootstrap_navwalker()
  ));
} /* end sparkling_header_menu */

add_action('wp_enqueue_scripts', 'load_javascript_files');
function load_javascript_files() {
  wp_register_script('vivus.js', get_bloginfo('stylesheet_directory').'/js/vivus.min.js', array('jquery'), true );
  wp_enqueue_script('vivus.js');
}

?>
