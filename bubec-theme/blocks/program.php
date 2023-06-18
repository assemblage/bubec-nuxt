<?php
/**
 * title: Program
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

$args = array(
    'post_type' => 'program',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'meta_key' => 'event_date',
    'meta_type' => 'DATE',
    'order' => 'ASC',
    'orderby'   => 'meta_value',
    'meta_query' => array(
		array(
			'key'     => 'event_date',
			'value'   => wp_date("Y-m-d"),
			'compare' => '>=',
            'type' => 'DATE'
		),
	),
);

$terms = get_field('program_type');

if( $terms ) {
    $args['tax_query'] = array(
        array(
          'taxonomy' => $terms[0]->taxonomy,
          'terms' => wp_list_pluck( $terms, 'term_id' )
        )
    );
}

$lang = get_field('program_lang');

if( $lang ) {
    $args['lang'] = $lang;
}

$query = new WP_Query($args);
$posts = $query->get_posts();

?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> relative max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 lg:mb-10 mt-10 lg:mt-14">
    <div class="program-grid-container gap-8 overflow-x-auto">
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

