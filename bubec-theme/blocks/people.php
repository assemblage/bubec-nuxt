<?php
/**
 * title: People
 * icon: groups
 * 
*/

$name = basename(__FILE__, '.php');

$id = $name.'-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = $name;
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$people = get_field('people');

?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> mb-10 mt-14 space-y-10 md:space-y-0 md:space-x-10 items-center flex flex-col md:flex-row justify-center mx-auto max-w-7xl">
  <?php foreach( $people as $item ): ?>
    <div class="flex md:flex-col items-center w-8/12 sm:w-5/12 md:w-auto">
      <img class="h-20 w-20 md:h-44 md:w-44 rounded-full mr-4 md:mr-0 md:mb-8" src="<?= $item["image"]["sizes"]["medium"] ?>" alt="" />
      <span class="grow md:grow-0"><?= $item["name"] ?></span>
    </div>
  <?php endforeach; ?>
</section>
