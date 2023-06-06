<?PHP get_header(); ?>

<?= pageBanner(null, 'Our Campuses', 'We have several conveniently campuses.') ?>

<div class="container container--narrow page-section">
    <div class="acf-map">
        <?PHP while (have_posts()) :
            the_post();
            $mapLocation = get_field('map_location');
        ?>
            <div class="marker" data-lat="<?= $mapLocation['lat'] ?>" data-lng="<?= $mapLocation['lng'] ?>">
                <h3>
                    <a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a>
                </h3>
                <?= $mapLocation['address'] ?>
            </div>
        <?PHP endwhile; ?>
    </div>
</div>

<?PHP get_footer(); ?>