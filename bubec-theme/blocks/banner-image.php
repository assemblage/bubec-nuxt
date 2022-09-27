<?php
/**
 * title: Banner image
 * icon: cover-image 
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

$image = get_field('image');

?>
<div class="max-w-screen-3xl mx-auto">
    <img id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> w-full min-h-[40vh] mix-blend-multiply -mt-4 object-cover object-bottom hidden sm:block" src="<?= $image['url'] ?>"></img>

    <img id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> w-full min-h-[40vh] mix-blend-multiply object-cover object-bottom sm:hidden" src="<?= $image['sizes']['large'] ?>"></img>
</div>