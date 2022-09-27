<?php
/* Blocks category */
function rk_block_categories($categories, $post)
{
  $categories[] = array(
    array(
      'slug' => 'custom',
      'title' => 'Custom prvky',
      'icon' => NULL
    ),
  );
  return $categories;
}
add_filter('block_categories_all', 'rk_block_categories', 10, 2);

/* Remove patterns */
function rk_remove_patterns()
{
  remove_theme_support('core-block-patterns');
}
add_action('after_setup_theme', 'rk_remove_patterns');

/* Filter default blocks */
function rk_allowed_block_types($allowed_block_types, $post)
{
  $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();

  $allowed_blocks = [
    'core/column',
    'core/columns',
    'core/heading',
    'core/html',
    'core/image',
    'core/video',
    'core/list',
    'core/paragraph',
    'core/spacer',
    'core/subhead',
    'core/table',
    'core/text-columns',
    'core/group',
  ];

  foreach ($block_types as $key => $val) {
    if (strpos($key, 'acf/') !== false || in_array($key, $allowed_blocks)) {
      $blocks[] = $key;
    }
  }

  return $blocks;
}
add_filter('allowed_block_types_all', 'rk_allowed_block_types', 10, 2);


/* Add custom blocks */
add_action('acf/init', 'rk_acf_init_block_types');
function rk_acf_init_block_types() {  
    if( function_exists('acf_register_block_type') ) {
      foreach (glob(__DIR__.'/../blocks/*.php') as $filename) {
        $contents = file_get_contents($filename);

        preg_match('/title: (.*)/', $contents, $block_title);
        preg_match('/icon: (.*)/', $contents, $block_icon);
        preg_match('/post_types: (.*)/', $contents, $block_post_types);
        preg_match('/supports: (.*)/', $contents, $block_supports);
        preg_match('/not_supports: (.*)/', $contents, $block_not_supports);

        $args = array(
          'name'              => sanitize_title($block_title[1]),
          'title'             => $block_title[1],
          'render_template'   => $filename,
          'category'          => 'custom',
          'icon'              => !empty($block_icon) ? $block_icon[1] : 'screenoptions',          
        );

        if(!empty($block_post_types)) {
          $args['post_types'] = explode(',', $block_post_types[1]);
        }

        if(!empty($block_supports)) {
          foreach(explode(',', $block_supports[1]) as $item) {
            $args['supports'][$item] = true;
          }
        }

        if(!empty($block_not_supports)) {
          foreach(explode(',', $block_not_supports[1]) as $item) {
            $args['supports'][$item] = false;
          }
        }
       
        acf_register_block_type($args);
      }
    }
}


// Edit core blocks
function rk_core_blocks_admin() {
  wp_enqueue_script(
      'rk_core_blocks',
      get_stylesheet_directory_uri() . '/js/core_blocks.js',
      array( 'wp-blocks', 'wp-element', 'wp-edit-post', 'wp-dom' ),
      filemtime( get_stylesheet_directory() . '/js/core_blocks.js' )
  );
}
add_action( 'enqueue_block_editor_assets', 'rk_core_blocks_admin' );


function rk_core_blocks_wrapper( $block_content, $block ) {

  if ( $block['blockName'] === 'acf/button' || $block['blockName'] === 'acf/button-back' ) {
    if( $block["attrs"]["align"] == "center" ) {
      $content = '<div class="flex justify-center">';
      $content .= $block_content;
      $content .= '</div>';
      
      return $content;
    }
  }

  if ( $block['blockName'] === 'core/table' ) {
    $content = '<div class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8">';
    $content .= $block_content;
    $content .= '</div>';
    
    $content = str_replace('<table>','<table class="text-xxs sm:text-xs md:text-base table-fixed border-b-[3px] border-black-900 sm:border-b-0 sm:border-t-2">',$content);

    $content = str_replace('<tr>','<tr class="flex flex-col sm:table-row border-t-[3px] border-black-900 sm:border-t-0 py-6 sm:py-0 text-center sm:text-left">',$content);  

    $content = str_replace('<td>','<td class="md:py-4 sm:border-b-2 border-black-900 align-top ">',$content);
      
    return $content;
  }

  if ( $block['blockName'] === 'core/image' ) {
    $content = '<div class="max-w-screen-3xl !mx-auto px-4">';
    $content .= $block_content;
    $content .= '</div>';

    if( $block["attrs"]["align"] == "center" ) {
      $content = str_replace('aligncenter','aligncenter !mx-auto',$content);
    }
      
    return $content;
  }
  
  if ( $block['blockName'] === 'core/paragraph' ) {
    $block_content = str_replace('<p class="','<p class="px-4 sm:px-6 lg:px-8 text-xs md:text-sm max-w-[70ch] mx-auto mb-4 ', $block_content);

    $block_content = str_replace('<p style="','<p class="px-4 sm:px-6 lg:px-8 text-xs md:text-sm max-w-[70ch] mx-auto mb-4" style="', $block_content);

    $block_content = str_replace('<p>','<p class="px-4 sm:px-6 lg:px-8 text-xs md:text-sm max-w-[70ch] mx-auto mb-4">',$block_content);
  }
  
  if ( $block['blockName'] === 'core/heading' ) {
    
    if( $block['attrs']['level'] === 1 ) {
      $block_content = str_replace('<h1 class="','<h1 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 tracking-tight sm:tracking-wide text-lgx sm:text-xl xl:text-1xl 3xl:text-2xl ',$block_content);
      
      $block_content = str_replace('<h1 style="','<h1 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 tracking-tight sm:tracking-wide text-lgx sm:text-xl xl:text-1xl 3xl:text-2xl" style="', $block_content);

      $block_content = str_replace('<h1>','<h1 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 tracking-tight sm:tracking-wide text-lgx sm:text-xl xl:text-1xl 3xl:text-2xl">',$block_content);     
    }
    
    if( $block['attrs']['level'] === 2 || empty($block['attrs']['level']) ) {
      $block_content = str_replace('<h2 class="','<h2 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 tracking-tight sm:tracking-wide text-lgx sm:text-xl xl:text-1xl 3xl:text-2xl ',$block_content);  

      $block_content = str_replace('<h2 style="','<h2 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 tracking-tight sm:tracking-wide text-lgx sm:text-xl xl:text-1xl 3xl:text-2xl" style="', $block_content);

      $block_content = str_replace('<h2>','<h2 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 tracking-tight sm:tracking-wide text-lgx sm:text-xl xl:text-1xl 3xl:text-2xl">',$block_content);    
    }
    
    if( $block['attrs']['level'] === 3 ) {
      $block_content = str_replace('<h3 class="','<h3 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 text-sm sm:text-base lg:text-lg xl:text-xl ',$block_content);

      $block_content = str_replace('<h3 style="','<h3 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 text-sm sm:text-base lg:text-lg xl:text-xl" style="', $block_content);

      $block_content = str_replace('<h3>','<h3 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 text-sm sm:text-base lg:text-lg xl:text-xl">',$block_content);      
    }
    
    if( $block['attrs']['level'] === 4 ) {
      $block_content = str_replace('<h4 class="','<h4 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 text-xs sm:text-base lg:text-lg ',$block_content); 

      $block_content = str_replace('<h4 style="','<h4 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 text-xs sm:text-base lg:text-lg" style="', $block_content);

      $block_content = str_replace('<h4>','<h4 class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 text-xs sm:text-base lg:text-lg">',$block_content);    
    }
    
    if( $block['attrs']['level'] === 5 ) {
      $block_content = str_replace('<h5 class="','<h5 class="px-4 sm:px-6 lg:px-8 text-xs md:text-sm lg:text-base xl:text-lg max-w-[70ch] ',$block_content); 

      $block_content = str_replace('<h5 style="','<h5 class="px-4 sm:px-6 lg:px-8 text-xs md:text-sm lg:text-base xl:text-lg max-w-[70ch]" style="', $block_content);

      $block_content = str_replace('<h5>','<h5 class="px-4 sm:px-6 lg:px-8 text-xs md:text-sm lg:text-base xl:text-lg max-w-[70ch]">',$block_content);   
    }
    
    return $block_content;
  }
  
  if ( $block['blockName'] === 'core/columns' ) {
    $content = str_replace('wp-block-columns','wp-block-columns max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8', $block_content);
    
    return $content;
  }
  
  if ( $block['blockName'] === 'core/column' ) {
    $content = str_replace('px-4 sm:px-6 lg:px-8','', $block_content);

    $content = str_replace('max-w-screen-3xl mx-auto','', $content);
    
    return $content;
  }

  return $block_content;
}

add_filter( 'render_block', 'rk_core_blocks_wrapper', 10, 2 );

