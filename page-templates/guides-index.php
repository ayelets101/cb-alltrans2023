<?php
/* Template Name: Guides Index */
// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>
<main id="main">
<header class="hero hero--short">
    <div class="hero_bg" style="background-image: url(/wp-content/uploads/2023/01/hero-home.jpg)"></div>
    <div class="container-xl">
        <h1>Discover Our <span>Property Guides</span></h1>
        <div class="mw-md-75 text-center">Our detailed and informative property guides are a step-by-step resource to help you sell your house quickly, safely and successfully. We make your selling process easier by providing you up-to-date and step-by-step information on the property industry.</div>
    </div>
</header>
<div class="container-xl pb-5">
    <h2><span>Featured</span> Guides</h2>
<?php
    $f = new WP_Query(array(
        'category_name' => 'featured',
        'posts_per_page' => 5
    ));
    ?>
    <section class="featured carousel-dark carousel slide pb-4" id="featured" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#featured" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#featured" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#featured" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#featured" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#featured" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
    <?php
    $active = 'active';
    while ($f->have_posts()) {
        $f->the_post();
        ?>
        <div class="carousel-item <?=$active?>">
            <a href="<?=get_the_permalink(get_the_ID())?>">
                <div class="row">
                    <div class="col-md-4"><div class="featured__img" style="background-image:url(<?=get_the_post_thumbnail_url(get_the_ID(),'large')?>)"></div></div>
                    <div class="col-md-8">
                        <div class="featured__inner">
                            <h3><?=get_the_title()?></h3>
                            <div class="featured__content">
                                <?=wp_trim_words(get_the_content(null, false, get_the_ID()),40)?>
                            </div>
                            <div class="fs-7 pb-2 text-end fst-italic"><?=estimate_reading_time_in_minutes( get_the_content(), 200, true, false )?> minute read</div>
                            <div class="featured__more">Read More</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
        $active = '';
    }
    ?>
        </div>
    </section>
    <?php
$allcats = get_categories();

foreach ($allcats as $cat) {
    if ($cat->slug == 'featured' || $cat->slug == 'guides') {
        continue;
    }
    ?>
    <h2><span><?=$cat->name?></span> Guides</h2>
    <div class="row g-4 mb-4">
        <?php
    $q = new WP_Query(array(
        'category_name' => $cat->slug,
        'posts_per_page' => 4
    ));
    while ($q->have_posts()) {
        $q->the_post();
        ?>
        <div class="col-md-6 col-xl-3">
            <a class="blog_card" href="<?=get_the_permalink()?>">
                <img src="<?=get_the_post_thumbnail_url(get_the_ID(),'large')?>" alt="" class="blog_card__image">
                <div class="blog_card__content pb-0" style="min-height:3.7rem">
                    <h3 class="blog_card__title"><?=get_the_title()?></h3>
                </div>
                <div class="fs-7 has-primary-color px-2 pb-2"><?=estimate_reading_time_in_minutes( get_the_content(), 200, true, false )?> minute read</div>
            </a>
        </div>
        <?php
    }
    ?>
    </div>
    <div class="text-center pb-5"><a href="/guides/category/<?=$cat->slug?>/" class="btn btn--accent">View All <?=$cat->name?> Guides</a></div>
    <?php
}
?>
</div>
</main>
<?php

get_footer();
