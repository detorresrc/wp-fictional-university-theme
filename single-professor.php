<?PHP get_header(); ?>

<?PHP while (have_posts()) :
    the_post();
    $pageBannerImage = get_field('page_banner_background_image');
?>

    <?= pageBanner($pageBannerImage['sizes']['pageBanner'] ?? null, get_the_title(), get_field('page_banner_subtitle')) ?>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?= get_the_post_thumbnail(get_the_ID(), 'professorPortrait'); ?></div>
                <div class="two-thirds"><?= get_the_content(); ?></div>
            </div>
        </div>

        <hr class="section-break">
        <h2 class="headline headline--medium">Subject(s) Taught</h2>
        <ul class="link-list min-list">
            <?PHP foreach ((array)get_field('related_programs') as $program) : ?>
                <li><a href="<?= get_the_permalink($program) ?>"><?= get_the_title($program); ?></a></li>
            <?PHP endforeach; ?>
        </ul>
    </div>

<?PHP endwhile; ?>

<?PHP get_footer(); ?>