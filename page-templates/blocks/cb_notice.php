<section class="notice py-5">
    <div class="container-xl">
        <?php
        if (get_field('press_release')[0] == 'Yes') {
            echo '<div class="text-center pb-4"><strong>PRESS RELEASE</strong></div>';
        }
        ?>
        <h2 class="notice__title"><?=get_field('title')?></h2>
        <div class="notice__date mb-2"><?=get_field('date')?></div>
        <hr>
        <div class="notice__content">
            <?=get_field('content')?>
        </div>
        <hr>
        <?php
        if (get_field('press_release')[0] == 'Yes') {
            echo '<div class="pt-4 text-center"><strong>END PRESS RELEASE</strong></div>';
        }
        ?>
    </div>
</section>