<a href="/program/detail/<?= $args['post']->post_name ?>/" class="program-thumb has-white-background-color border py-6 px-4 flex flex-col text-center w-[18rem] min-h-[18rem] 2xl:basis-auto md:w-[20rem] md:min-h-[20rem] 2xl:min-h-[22rem] 2xl:w-[22rem] 3xl:min-h-[26rem] 3xl:w-[26rem]">
  <h3 class="text-xs md:text-sm lg:text-base font-bold basis-12"><?= str_replace('–','<br>',$args['post']->post_title) ?></h3>

  <?php $end = get_field('event_end', $args['post']->ID);?>

  <span class="flex flex-1 items-center justify-center tracking-tight md:font-light <?= $end ? 'text-lg xl:text-xl whitespace-nowrap' : 'text-1xl 2xl:text-2xl' ?>">
    <?= date('j/n',strtotime(get_field('event_date', $args['post']->ID))) ?>

    <?php
      if( $end ) {
        echo ' – '.date('j/n',strtotime( $end ));
      }
    ?>
  </span>

  <span class="text-xs md:text-sm lg:text-base font-bold"><?= get_the_terms($args['post']->ID, 'program_type')[0]->name ?></span>
</a>
