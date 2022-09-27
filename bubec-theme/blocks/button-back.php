<?php
/**
 * title: Button back
 * icon: button 
 * 
*/

$name = basename(__FILE__, '.php');

$id = $name.'-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = 'block-button';

if( !empty($block['className']) ) {
    $className .= ' '.$block['className'];
}

?>
<a href="#" onclick="history.back()" id="<?= esc_attr($id); ?>" class="inline-flex items-center px-2 <?= esc_attr($className); ?>">
  <svg class="h-6 md:h-8 lg:h-12 w-auto" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 64.9 56" enable-background="new 0 0 64.9 56" xml:space="preserve">
  <g enable-background="new    ">
    <path d="M28.1,0l4.2,4.4L11.7,24.8h53.2v6.3H11.7l20.6,20.5L28.1,56L0,28L28.1,0z"/>
  </g>
  </svg>
  <span class="text-xs sm:text-base lg:text-lg ml-6 md:ml-8 whitespace-nowrap hover:underline decoration-2"><?= get_field('text') ?></span>
</a>