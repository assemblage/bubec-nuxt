<?php
/**
 * title: Gallery
 * icon: format-gallery
*/

$name = basename(__FILE__, '.php');

$id = $name.'-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = '';
if( !empty($block['className']) ) {
    $className .= $block['className'];
}

$items = get_field('gallery');

?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> max-w-screen-3xl mx-auto relative my-10 md:my-16">
  <div class="slider flex overflow-hidden space-x-36" data-current="1">
    <?php foreach ( $items as $item ): ?>
      <img src="<?= $item['sizes']['large'] ?>" class="max-h-[16rem] md:max-h-[25rem] lg:max-h-[80vh] max-w-full object-contain object-center basis-10/12">
    <?php endforeach; ?>
  </div>

  <div class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 md:mt-8 flex justify-between items-center space-x-4">
    <button class="text-lg" onclick="prevSlide(this)">
      <svg class="h-6 md:h-8 lg:h-12 w-auto" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 64.9 56" enable-background="new 0 0 64.9 56" xml:space="preserve">
      <g enable-background="new">
        <path d="M28.1,0l4.2,4.4L11.7,24.8h53.2v6.3H11.7l20.6,20.5L28.1,56L0,28L28.1,0z"/>
      </g>
      </svg>  
    </button>
    <span class="text-base lg:text-lg !mr-auto"><span class="slider-current">1</span>/<?= count($items) ?></span>
    <button class="text-lg" onclick="nextSlide(this)">
      <svg class="h-6 md:h-8 lg:h-12 w-auto" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 64.9 56" enable-background="new 0 0 64.9 56" xml:space="preserve">
        <g enable-background="new">
          <path d="M36.8,56l-4.2-4.4l20.6-20.4H0v-6.3h53.2L32.6,4.4L36.8,0l28.1,28L36.8,56z"/>
        </g>
      </svg>    
    </button>
  </div>
</section>

