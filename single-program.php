<?PHP get_header(); ?>

<?PHP while (have_posts()) :
    the_post();
    $pageBannerImage = get_field('page_banner_background_image');
?>

    <?= pageBanner($pageBannerImage['sizes']['pageBanner'] ?? null, get_the_title(), get_field('page_banner_subtitle')) ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true">
                    </i> Programs Home
                </a>
                <span class="metabox__main"><?PHP the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content"><?PHP the_field('main_body_content'); ?></div>

        <?PHP
        $events = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'orderby' => 'meta_value_num',
            'meta_key' => 'event_date',
            'order' => 'ASC',

            'meta_query' => [
                [
                    'key'     => 'event_date',
                    'compare' => '>=',
                    'value'   => date("Ymd"),
                    'type'    => 'numeric'
                ],
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                ]
            ]
        ]);

        if ($events->have_posts())
            echo '<hr class="section-break"><h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

        while ($events->have_posts()) :
            $events->the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;

        wp_reset_postdata();

        $relatedCampuses = get_field('related_campus');
        if ($relatedCampuses) :
        ?>
            <hr>
            <h2 class="headlione headline-medium"><?= get_the_title() ?> is available at these campuses:</h2>
            <ul class="min-list link-list">
                <?PHP foreach ($relatedCampuses as $campus) : ?>
                    <li><a href="<?= get_the_permalink($campus) ?>"><?= get_the_title($campus) ?></a></li>
                <?PHP endforeach; ?>
            </ul>
        <?PHP endif; ?>

        <?PHP

        $relatedProfessors = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',

            'meta_query' => [
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                ]
            ]
        ]);

        if ($relatedProfessors->have_posts())
            echo '<hr class="section-break"><h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
        echo '<ul class="professor-cards">';
        while ($relatedProfessors->have_posts()) :
            $relatedProfessors->the_post();
        ?>
            <li class="professor-card__list-item">
                <a href="<?= get_the_permalink() ?>" class="professor-card">
                    <img class="professor-card__image" src="<?= get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape') ?>" />
                    <span class="professor-card__name"><?= get_the_title() ?></span>
                </a>
            </li>
        <?PHP endwhile;
        wp_reset_postdata(); ?>
        </ul>

    </div>

<?PHP endwhile; ?>

<?PHP get_footer(); ?>