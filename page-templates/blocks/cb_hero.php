<?php
$img = wp_get_attachment_image_url( get_field('background') ,'full');


$class = $block['className'] ?? null ?: '';

?>
<link rel="preload" as="image" href="<?=$img?>">
<header class="hero <?=$class?>">
    <div class="container-xl" style="background-image: url(<?=$img?>)">
        <div class="overlay"></div>
        <h1><?=get_field('title')?></h1>
    </div>
</header>
