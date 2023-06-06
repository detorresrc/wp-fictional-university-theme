<?PHP get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?= get_theme_file_uri('images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            Past Events
        </h1>
        <div class="page-banner__intro">
            <p>A recap of our past events.</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?PHP
    $pastEvents = new WP_Query([
        'paged'          => get_query_var('paged', 1),
        'post_type'      => 'event',
        'orderby'        => 'meta_value_num', // Sort by Custom Field
        'meta_key'       => 'event_date',
        'order'          => 'DESC',
        'meta_query'     => [
            [
                'key'     => 'event_date',
                'compare' => '<',
                'value'   => date("Ymd"),
                'type'    => 'numeric'
            ]
        ]
    ]);
    while ($pastEvents->have_posts()) :
        $pastEvents->the_post();
        get_template_part('template-parts/content', get_post_type());
    endwhile; ?>
    <?= paginate_links([
        'total' => $pastEvents->max_num_pages
    ]) ?>
</div>


<?PHP get_footer(); ?>