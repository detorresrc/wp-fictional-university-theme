<?PHP get_header(); ?>

<?PHP while (have_posts()) :
    the_post();
    $pageBannerImage = get_field('page_banner_background_image');
?>

    <?= pageBanner($pageBannerImage['sizes']['pageBanner'] ?? null, get_the_title(), get_field('page_banner_subtitle')) ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('event') ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a>
                <span class="metabox__main"><?PHP the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content"><?= the_content() ?></div>

        <hr class="section-break">
        <h2 class="headline headline--medium">Related Program(s)</h2>
        <ul class="link-list min-list">
            <?PHP foreach ((array)get_field('related_programs') as $program) : ?>
                <li><a href="<?= get_the_permalink($program) ?>"><?= get_the_title($program); ?></a></li>
            <?PHP endforeach; ?>
        </ul>
    </div>

<?PHP endwhile; ?>

<?PHP get_footer(); ?>