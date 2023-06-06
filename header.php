<!DOCTYPE html>
<html <?PHP language_attributes(); ?>>

<head>
  <meta charset="<?PHP bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?PHP wp_head(); ?>
</head>

<body <?PHP body_class(); ?>>
  <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left">
        <a href="<?= site_url('/') ?>"><strong>Fictional</strong> University</a>
      </h1>
      <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <!-- <?PHP wp_nav_menu(['theme_location' => 'headerMenuLocation']) ?> // OPTION 1 -->
          <ul>
            <?PHP
            $menus = wp_get_nav_menu_items('My Main Menu Header');
            foreach ($menus as $menu) :
              $class = "";
              if (get_the_ID() == $menu->object_id) $class = "class='current-menu-item'";

              $parent = wp_get_post_parent_id(get_the_ID());
              if ($parent && !$class) {
                if ($parent == $menu->object_id) $class = "class='current-menu-item'";
              }
            ?>
              <li <?= $class ?>><a href="<?= $menu->url ?>"><?= $menu->title ?></a></li>
            <?PHP endforeach; ?>
            <li <?PHP if (get_post_type() == "program") : ?>class="current-menu-item" <?PHP endif; ?>><a href="<?= get_post_type_archive_link('program'); ?>">Programs</a></li>
            <li <?PHP if (get_post_type() == "event" || is_page('past-event')) : ?>class="current-menu-item" <?PHP endif; ?>><a href="<?= get_post_type_archive_link('event'); ?>">Events</a></li>
            <li <?PHP if (get_post_type() == "campus") : ?>class="current-menu-item" <?PHP endif; ?>><a href="<?= get_post_type_archive_link('campus'); ?>">Campuses</a></li>
            <li <?PHP if (get_post_type() == "post") : ?>class="current-menu-item" <?PHP endif; ?>><a href="<?= site_url('/blog') ?>">Blog</a></li>
          </ul>
        </nav>
        <div class="site-header__util">
          <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
          <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
          <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        </div>
      </div>
    </div>
  </header>