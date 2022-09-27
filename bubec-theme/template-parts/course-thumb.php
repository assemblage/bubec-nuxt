<a href="/kurz/<?= $args['post']->post_name ?>/" class="course-thumb has-white-background-color has-black-border-color border py-6 px-2 justify-between flex flex-col text-center w-[18rem] min-h-[18rem] md:w-[20rem] md:min-h-[20rem] 2xl:min-h-[22rem] 2xl:w-[22rem] 3xl:min-h-[25rem] 3xl:w-[25rem]">
  <h3 class="text-base basis-12"><?= $args['post']->post_title ?></h3>

  <span class="text-xs"><?= $args['post']->post_excerpt ?></span>
</a>