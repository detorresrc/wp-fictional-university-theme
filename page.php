<?PHP
get_header();
$pageBannerImage = get_field('page_banner_background_image');
?>

<?= pageBanner($pageBannerImage['sizes']['pageBanner'] ?? null, get_the_title(), get_field('page_banner_subtitle')) ?>

<div class="container container--narrow page-section">
  <?PHP
  $parent = wp_get_post_parent_id(get_the_ID());

  if ($parent) : ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?= get_permalink($parent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?= get_the_title($parent) ?></a> <span class="metabox__main"><?= the_title() ?></span>
      </p>
    </div>
  <?PHP endif; ?>

  <?PHP if ($parent || get_pages(['child_of' => get_the_ID()])) : ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?= get_permalink($parent) ?>"><?= get_the_title($parent) ?></a></h2>
      <ul class="min-list">
        <?php
        $childOf = null;
        if ($parent) {
          $childOf = $parent;
        } else {
          $childOf = get_the_ID();
        }

        wp_list_pages([
          'title_li' => null,
          'child_of' => $childOf,
          'sort_column' => 'menu_order'
        ]);
        ?>
      </ul>
    </div>
  <?PHP endif; ?>

  <div class="generic-content">
    <?= the_content() ?>
  </div>
</div>

<?PHP get_footer(); ?>