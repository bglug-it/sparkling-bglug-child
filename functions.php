<?php


//////////////////// add style.css to css for the page /////////////////////////
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


//////////////////// add the vivus js (to animate logos) ///////////////////////
add_action('wp_enqueue_scripts', 'load_javascript_files');
function load_javascript_files() {
  wp_register_script('vivus.js', get_bloginfo('stylesheet_directory').'/js/vivus.min.js', array('jquery'), true );
  wp_enqueue_script('vivus.js');
}


//////////////////// execute shortcodes in widget text /////////////////////////
add_filter('widget_text', 'do_shortcode');


//////////////////// put something at the beginning of the main ////////////////
register_sidebar( array (
    'name'          => 'Home Main Loop',
    'id'            => 'home_main_loop',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
) );

function home_loop_start( $query ) {
  if ( is_front_page() ) {
    if ( is_active_sidebar('home_main_loop') ) {
      dynamic_sidebar('home_main_loop');
    }
  }
}

add_action( 'loop_start', 'home_loop_start' );


//////////////////// disable sparkling slider //////////////////////////////////
if ( ! function_exists( 'sparkling_featured_slider' ) ) :
function sparkling_featured_slider() { }
endif;


//////////////////// display the logo in the header menu ///////////////////////
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
}


//////////////////// load font-awesome ///////////////////////
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');
function enqueue_font_awesome() {
  wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css');
}


//////////////////// super-lightweight share buttons (requires font-awesome) ///////////////////////
add_filter ('the_content', 'append_sharebox');
function append_sharebox($content) {
  if(is_single()) {
    $content .= file_get_contents(__DIR__ . '/sharebox.html');
  }
  return $content;
}


?>
