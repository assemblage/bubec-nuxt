<?php
/**
 * title: Program manuální
 * icon: columns
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

$posts = get_field('program');

?>


<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> relative max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 lg:mb-10 mt-10 lg:mt-14">
    <div class="program-grid-container 3xl:justify-center gap-8 overflow-x-auto">
        <?php
            foreach( $posts as $post ):

                get_template_part('template-parts/program-thumb', null,
                    array(
                    'post'   => $post,
                    )
                );

            endforeach;
            ?>
    </div>

    <?php if( count($posts) > 1): ?>
    <span class="block lg:hidden absolute top-0 right-0 h-full w-28 bg-gradient-to-l from-gray-900"></span>
    <?php endif; ?>
</section>
