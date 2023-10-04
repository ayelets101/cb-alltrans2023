<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

$page_for_posts = get_option( 'page_for_posts' );
$img = get_the_post_thumbnail_url($page_for_posts,'full');

get_header();
?>
<main id="main">
<link rel="preload" as="image" href="<?=$img?>">
<header class="hero <?=$class?>">
    <div class="container-xl px-0" style="background-image: url(<?=$img?>)">
        <div class="overlay"></div>
        <div class="titles">
            <h1><?=get_the_title($page_for_posts)?></h1>
        </div>
    </div>
</header>

    <div class="container-xl py-5">
        <?php
        if (get_the_content(null, false, $page_for_posts)) {
            echo '<div class="mb-5">' . get_the_content(null, false, $page_for_posts) . '</div>';
        }

        $cats = get_categories(array('exclude' => array(32)));
        /*
        ?>
        <div class="filters mb-4">
            <?php
        echo '<button class="btn btn-outline-primary active me-2 mb-2" data-filter="*">All</button>';
        foreach ($cats as $cat) {
            echo '<button class="btn btn-outline-primary me-2 mb-2" data-filter=".' . cbslugify($cat->name) . '">' . $cat->cat_name . '</button>';
        }
        ?>
        </div>
        <?php
        */
        ?>
        <div class="row w-100 news" id="grid">
            <?php
            while (have_posts()) {
                the_post();
                $img = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                if (!$img) {
                    $img = get_stylesheet_directory_uri() . '/img/default-blog.jpg';
                }
                $cats = get_the_category();
                $category = wp_list_pluck($cats, 'name');
                $flashcat = cbslugify($category[0]);
                $catclass = implode(' ', array_map( 'cbslugify', $category ) );
                $category = implode(', ',$category);

                $the_date = get_the_date('jS F, Y');

                ?>
            <div class="grid_item col-lg-4 col-md-6 px-2 mb-3 <?=$catclass?>">
                <a href="<?=get_the_permalink(get_the_ID())?>" class="news__item">
                    <div class="card card--<?=$flashcat?>">
                        <div class="news__image_container">
                            <!--div class="news__flash news__flash--<?=$flashcat?>"><?=$category?></div -->
                            <div class="news__image" style="background-image:url('<?=get_the_post_thumbnail_url(get_the_ID(),'large')?>')"></div>
                        </div>
                        <div class="news__inner">
                            <h3 class="news__title mb-0"><?=get_the_title()?></h3>
                            <div class="news__date"><?=$the_date?></div>
                            <div class="news__content">
                                <div class="news__content__overlay"></div>
                                <?=wp_trim_words(get_the_content(get_the_ID()),20)?>
                            </div>
                        </div>
                        <!-- <div class="card__link">Read more</div> -->
                    </div>
                </a>
            </div>
                <?php
            }
            ?>
        </div>
        <div class="mt-5">
        <?php
        numeric_posts_nav();
        ?>
        </div>
    </div>
</main>
<?php
add_action('wp_footer',function(){
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
(function($){
        
    var $grid=$('#grid').isotope({
        itemSelector:'.grid_item',
        percentPosition: true,
        layoutMode: 'fitRows',
    });
    
    $('.filters').on('click','button',function(){
        var filterValue=$(this).attr('data-filter');
        $('.filters').find('.active').removeClass('active');
        $(this).addClass('active');
        $grid.isotope({filter:filterValue});
    });



})(jQuery);
</script>
    <?php
},9999);

get_footer();