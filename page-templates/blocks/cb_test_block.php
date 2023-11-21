<section class="test_block">
    <div class="container-xl py-5">
        <h2 class="text-center mb-5"><?=get_field('title')?></h2>
        <div class="row g-4 justify-content-center">
            <?php
            while(have_rows('test')) {
                the_row();
                ?>
            <div class="col-sm-2 col-md-4 col-lg-3">
                <div class="test_block__card">
                    <div class="test_block __img">
                        <img src="<?=wp_get_attachment_image_url(get_sub_field('photo'),'full')?>">
                    </div>
                    <div class="test_block__name"><?=get_sub_field('name')?></div>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>