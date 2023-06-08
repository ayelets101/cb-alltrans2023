<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>
<!-- hero -->
<main id="main" class="caseStudies">
    <header class="hero hero--short">
        <div class="hero_bg" style="background-image: url(/wp-content/uploads/2023/01/hero-home.jpg)"></div>
        <div class="container-xl">
            <h1>Read our <span>Case Studies</span></h1>
            <div class="mw-md-75 text-center"></div>
        </div>
    </header>
    <div class="container-xl pb-5">
        <div class="mb-4" id="filters">
            <?php
        $terms = get_terms(
    array(
                'taxonomy'   => 'cstypes',
                'hide_empty' => true,
                'order' => 'DESC',
            )
);
?>
            <div class="option-set mb-2" data-group="cstype">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input all" value="" id="type-all" checked>
                    <label for="type-all" class="form-check-label">All Types</label>
                </div>
                <?php
foreach ($terms as $term) {
    ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"
                        value=".<?=$term->slug?>"
                        id="<?=$term->slug?>">
                    <label class="form-check-label"
                        for="<?=$term->slug?>"><?=$term->name?></label>
                </div>
                <?php
}
?>
            </div>
            <!-- hr>
            <?php
        $terms = get_terms(
    array(
                'taxonomy'   => 'locations',
                'hide_empty' => true,
                'order' => 'DESC',
            )
);
?>
            <div class="option-set mb-2" data-group="location">
                <div class="form-check">
                    <input type="checkbox" value="" id="loca-all" class="form-check-input all" checked>
                    <label for="loca-all" class="form-check-label">All Locations</label>
                </div>
                <?php
foreach ($terms as $term) {
    ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"
                        value=".<?=$term->slug?>"
                        id="<?=$term->slug?>">
                    <label for="<?=$term->slug?>"
                        class="form-check-label"><?=$term->name?></label>
                </div>
                <?php
}
?>
            </div -->
            <div class="status">
                <div class="count"><span class="filter-count"></span> items found.</div>
            </div>
        </div>

        <p id="filter-display"></p>

        <div class="w-100" id="grid">
            <?php
    while (have_posts()) {
        the_post();
        $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if (!$img) {
            $img = get_stylesheet_directory_uri() . '/img/default.png';
        }
        $types = get_the_terms($post->ID, 'cstypes');
        $type = wp_list_pluck($types, 'name');
        $catclass = implode(' ', array_map('cbslugify', $type));

        $types = get_the_terms($post->ID, 'locations');
        $type = wp_list_pluck($types, 'name');
        $catclass .= ' ' . implode(' ', array_map('cbslugify', $type));

        $the_date = get_the_date('jS F, Y');

        $slug = acf_slugify(basename(get_the_permalink()));
        ?>
            <div class="<?=$catclass?> caseStudy w-100 mb-4">
                <a class="anchor" id="<?=$slug?>"></a>
                <div class="caseStudy_card">
                    <div class="caseStudy_card__image">
                        <img src="<?=$img?>" alt="">
                    </div>
                    <div class="caseStudy_card__content">
                        <div class="article-title mb-2">
                            <?=get_the_title()?>
                        </div>
                        <div class="article-body">
                            <?=get_the_content()?>
                        </div>
                        <?php
                    if (get_field('quote')) {
                        ?>
                        <div class="quote-container">
                            <div class="article-quote">
                                <?=apply_filters('the_content', get_field('quote'))?>
                            </div>
                            <?php
                        if (get_field('attribution')) {
                            ?>
                            <div class="article-attrib">
                                <?=get_field('attribution')?>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                        <?php
                    }
        ?>
                        <div class="article-highlights">
                            <?php
            $hl = get_field('highlights');
        if ($hl['offered'] ?? null) {
            ?>
                            <div>
                                <img decoding="async" src="/wp-content/uploads/2023/01/icon__free-cash-offer.svg"
                                    width="60" height="40">
                                <span><?=$hl['offered']?></span>
                            </div>
                            <?php
        }
        if ($hl['duration'] ?? null) {
            ?>
                            <div>
                                <img decoding="async" src="/wp-content/uploads/2023/02/icon__complete.svg" width="60"
                                    height="40">
                                <span><?=$hl['duration']?></span>
                            </div>
                            <?php
        }
        if ($hl['price'] ?? null) {
            ?>
                            <div>
                                <img decoding="async" src="/wp-content/uploads/2023/01/icon__no-fees.svg" width="60"
                                    height="40">
                                <span><?=$hl['price']?></span>
                            </div>
                            <?php
        }
        ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
    }
?>
        </div>
    </div>
</main>
<?php
add_action('wp_footer', function () {
    ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"
    integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var $container;
    var filters = {};

    (function($) {

        var $filterCount = $('.filter-count');

        var $container = $('#grid');

        // var $filterDisplay = $('#filter-display');


        $container.isotope();
        // do stuff when checkbox change
        $('#filters').on('change', function(jQEvent) {
            var $checkbox = $(jQEvent.target);
            manageCheckbox($checkbox);

            var comboFilter = getComboFilter(filters);

            $container.isotope({
                filter: comboFilter
            });

            // $filterDisplay.text( comboFilter );
            updateFilterCount();
        });

        function getComboFilter(filters) {

            var i = 0;
            var comboFilters = [];
            var message = [];

            for (var prop in filters) {
                message.push(filters[prop].join(' '));
                var filterGroup = filters[prop];
                // skip to next filter group if it doesn't have any values
                if (!filterGroup.length) {
                    continue;
                }
                if (i === 0) {
                    // copy to new array
                    comboFilters = filterGroup.slice(0);
                } else {
                    var filterSelectors = [];
                    // copy to fresh array
                    var groupCombo = comboFilters.slice(0); // [ A, B ]
                    // merge filter Groups
                    for (var k = 0, len3 = filterGroup.length; k < len3; k++) {
                        for (var j = 0, len2 = groupCombo.length; j < len2; j++) {
                            filterSelectors.push(groupCombo[j] + filterGroup[k]); // [ 1, 2 ]
                        }
                    }
                    // apply filter selectors to combo filters for next group
                    comboFilters = filterSelectors;
                }
                i++;
            }

            var comboFilter = comboFilters.join(', ');
            return comboFilter;
        }

        function manageCheckbox($checkbox) {
            var checkbox = $checkbox[0];

            var group = $checkbox.parents('.option-set').attr('data-group');
            // create array for filter group, if not there yet
            var filterGroup = filters[group];
            if (!filterGroup) {
                filterGroup = filters[group] = [];
            }

            var isAll = $checkbox.hasClass('all');
            // reset filter group if the all box was checked
            if (isAll) {
                delete filters[group];
                if (!checkbox.checked) {
                    checkbox.checked = 'checked';
                }
            }
            // index of
            // var index = $.inArray(checkbox.value, filterGroup);
            var index = $checkbox.parent().siblings().find('input').index(checkbox.value);

            if (checkbox.checked) {
                var selector = isAll ? 'input' : 'input.all';
                // $checkbox.siblings(selector).removeAttr('checked');
                $checkbox.parent().siblings().find(selector).removeAttr('checked');
                if (!isAll && index === -1) {
                    // add filter to group
                    filters[group].push(checkbox.value);
                }

            } else if (!isAll) {
                // remove filter from group
                filters[group].splice(index, 1);
                // if unchecked the last box, check the all
                // if (!$checkbox.siblings('[checked]').length) {
                //     $checkbox.siblings('input.all').attr('checked', 'checked');
                if (!$checkbox.parent().siblings().find('[checked]').length) {
                    $checkbox.parent().siblings().find('input.all').attr('checked', 'checked');

                }
            }
        }

        var iso = $container.data('isotope');

        function updateFilterCount() {
            $filterCount.text(iso.filteredItems.length);
        }
        updateFilterCount();

    })(jQuery);
</script>
<?php
}, 9999);

get_footer();
?>