<a href="/program/detail/<?= $args['post']->post_name ?>/" class="program-thumb has-white-background-color border">

  <div class="program-thumb-in  py-6 px-4 text-center">
    <h3 class="text-xs md:text-sm lg:text-base font-bold basis-12 program-thumb__title"><?= str_replace('–','<br>',$args['post']->post_title) ?></h3>

    <?php $end = get_field('event_end', $args['post']->ID);?>

    <span class="flex flex-1 items-center justify-center tracking-tight md:font-light <?= $end ? 'text-lg xl:text-xl whitespace-nowrap' : 'text-1xl 2xl:text-2xl' ?> program-thumb__date">
      <?= date('j/n',strtotime(get_field('event_date', $args['post']->ID))) ?>

      <?php
        if( $end ) {
          echo ' – '.date('j/n',strtotime( $end ));
        }
      ?>
    </span>

    <span class="text-xs md:text-sm lg:text-base font-bold program-thumb__type"><?= get_the_terms($args['post']->ID, 'program_type')[0]->name ?></span>
  </div>
</a>
