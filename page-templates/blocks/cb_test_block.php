<?php
$r = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 4,
));
if ($r->have_posts()) {
?>
<section class="related pb-5 test_block">
    <div class="container-xl">
        <h2>Test block</h2>
        <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <a class="blog_card" href="<?=get_the_permalink()?>">
                        <img src="<?=get_the_post_thumbnail_url(get_the_ID(),'large')?>" alt="" class="blog_card__image">
                        <div class="blog_card__content">
                            <h3 class="blog_card__title"><?=get_the_title()?></h3>
                        </div>
                    </a>
                </div>
        </div>
    </div>
</section>

