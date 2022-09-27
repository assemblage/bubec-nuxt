<?php
/**
 * title: Kurzy manuální
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

$posts = get_field('courses');

?>


<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> relative max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 lg:mb-10 mt-10 lg:mt-14">
    <div class="gap-8 xl:gap-12 flex justify-center flex-wrap">
        <?php
            foreach( $posts as $post ):

                get_template_part('template-parts/course-thumb', null,
                    array(
                    'post'   => $post,
                    )
                );

            endforeach;
            ?>
    </div>
</section>