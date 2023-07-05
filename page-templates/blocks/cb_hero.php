<?php
$img = wp_get_attachment_image_url( get_field('background') ,'full');


$class = $block['className'] ?? null ?: '';

?>
<link rel="preload" as="image" href="<?=$img?>">
<header class="hero <?=$class?>">
    <div class="container-xl px-0" style="background-image: url(<?=$img?>)">
        <div class="overlay"></div>
        <div class="titles">
            <h1><?=get_field('title')?></h1>
        <?php
        if (get_field('subtitle')) {
            ?>
            <h2><?=get_field('subtitle')?></h2>
            <?php
        }
        ?>
        </div>
    </div>
</header>
