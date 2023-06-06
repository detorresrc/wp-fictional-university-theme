<?PHP get_header(); ?>

<?PHP while (have_posts()) :
    the_post();
    $pageBannerImage = get_field('page_banner_background_image');
?>

    <?= pageBanner($pageBannerImage['sizes']['pageBanner'] ?? null, get_the_title(), get_field('page_banner_subtitle')) ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true">
                    </i> All Campuses
                </a>
                <span class="metabox__main"><?PHP the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?= get_the_content() ?>
            <div class="acf-map">
                <?PHP $mapLocation = get_field('map_location'); ?>
                <div class="marker" data-lat="<?= $mapLocation['lat'] ?>" data-lng="<?= $mapLocation['lng'] ?>">
                    <h3>
                        <?= get_the_title() ?>
                    </h3>
                    <?= $mapLocation['address'] ?>
                </div>
            </div>
        </div>
    <?PHP
endwhile;
wp_reset_postdata();

$relatedPrograms = new WP_Query([
    'posts_per_page' => 2,
    'post_type' => 'program',
    'orderby' => 'title',
    'order' => 'ASC',

    'meta_query' => [
        [
            'key' => 'related_campus',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'
        ]
    ]
]);

if ($relatedPrograms->have_posts())
    echo '<hr class="section-break"><h2 class="headline headline--medium">Programs available at this campus</h2>';
echo '<ul class="min-list link-list">';
while ($relatedPrograms->have_posts()) :
    $relatedPrograms->the_post();
    ?>
        <li class="">
            <a href="<?= get_the_permalink() ?>">
                <?= get_the_title() ?>
            </a>
        </li>
    <?PHP endwhile;
wp_reset_postdata(); ?>
    </ul>
    </div>
    <?PHP get_footer(); ?>