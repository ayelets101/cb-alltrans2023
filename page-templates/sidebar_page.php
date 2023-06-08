<?php
/* Template Name: Sidebar Page */

// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
?>
<main id="main">
    <?php
    $content = get_the_content();
    $blocks = parse_blocks($content);
    foreach ($blocks as $block) {
        if($block['blockName'] == 'acf/cb-hero-short') {
            echo render_block($block);
            break;
        }
    }
    $sidebar = array();
    $after;
    ?>
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-lg-9 order-2">
            <?php
    foreach ($blocks as $block) {
        if($block['blockName'] == 'acf/cb-hero-short') {
            continue;
        }
        if($block['blockName'] == 'acf/cb-cta-block') {
            $after = $block;
            continue;
        }
        if ($block['blockName'] == 'core/heading') {
            if (!array_key_exists('level', $block['attrs'])) {
                $heading = strip_tags($block['innerHTML']);
                $id = acf_slugify($heading);
                echo '<a id="' . $id . '" class="anchor"></a>';
                $sidebar[$heading] = $id;
            }
        }
        echo render_block($block);
    }
            ?>
            </div>
            <div class="col-lg-3 order-1">
                <div class="sidebar">
                    <div class="h5 d-none d-lg-block">Quick Links</div>
                    <div class="h5 d-lg-none" data-bs-toggle="collapse" href="#links" role="button">Quick Links</div>
                    <div class="collapse d-lg-block" id="links">
                        <?php
                        foreach ($sidebar as $heading => $id) {
                            ?>
                            <li><a href="#<?=$id?>"><?=$heading?></a></li>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // after blocks
    if ($after != '') {
        echo render_block($block);
    }
    ?>
</main>
<?php
get_footer();