<?php
/**
 * title: Downloads
 * icon: list-view
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

$items = get_field('files');

?>

<section id="<?= esc_attr($id); ?>" class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 <?= esc_attr($className); ?>">
    <?php foreach ( $items as $item ): ?>
      <a href="<?= $item["file"]["url"] ?>" target="_blank" class="flex justify-between items-start has-white-background-color text-xxs sm:text-sm md:text-base sm:font-bold py-4 sm:py-6 px-6 sm:px-8 mb-3">
        <span><?= $item["title"] ?></span>
        <span class="uppercase">.<?= $item["file"]["subtype"] ?></span>
      </a>
    <?php endforeach; ?>
</section>

