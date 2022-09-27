<?php
/**
 * title: Person
 * icon: admin-users 
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

?>

<div class="flex items-center">
  <img class="h-20 w-20 md:h-44 md:w-44 rounded-full mr-8" src="<?= get_field("image")["sizes"]["medium"] ?>" alt="" />
  <span class="text-xs md:text-sm lg:text-base xl:text-lg"><?= get_field("name") ?></span>
</div>
