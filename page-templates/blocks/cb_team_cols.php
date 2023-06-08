<section class="team_cols">
    <div class="container-xl py-5">
        <h2 class="text-center mb-5"><?=get_field('title')?></h2>
        <div class="row g-4 justify-content-center">
            <?php
            while(have_rows('team')) {
                the_row();
                ?>
            <div class="col-sm-2 col-md-4 col-lg-3">
                <div class="team_cols__card">
                    <div class="team_cols__img">
                        <img src="<?=wp_get_attachment_image_url(get_sub_field('photo'),'full')?>">
                    </div>
                    <div class="team_cols__name"><?=get_sub_field('name')?></div>
                    <div class="team_cols__role"><?=get_sub_field('role')?></div>
                    <div class="team_cols__bio"><?=get_sub_field('bio')?></div>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>