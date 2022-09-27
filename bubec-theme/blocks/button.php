<?php
/**
 * title: Button
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
<a href="<?= get_field('link') ?>" id="<?= esc_attr($id); ?>" class="inline-flex items-center px-2 <?= esc_attr($className); ?>">
  <span class="text-xs sm:text-base lg:text-lg mr-6 md:mr-8 whitespace-nowrap hover:underline decoration-2"><?= get_field('text') ?></span>
  <svg class="h-6 md:h-8 lg:h-12 w-auto" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 64.9 56" enable-background="new 0 0 64.9 56" xml:space="preserve">
    <g enable-background="new    ">
      <path d="M36.8,56l-4.2-4.4l20.6-20.4H0v-6.3h53.2L32.6,4.4L36.8,0l28.1,28L36.8,56z"/>
    </g>
  </svg>
</a>