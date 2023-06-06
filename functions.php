<?PHP
require_once(get_theme_file_path('/university-post-types.php'));
require_once(get_theme_file_path('/common.php'));
require_once(get_theme_file_path('/inc/search-route.php'));

function university_custom_rest()
{
  register_rest_field('post', 'authorName', [
    'get_callback' => function ($object, $field_name, $request) {
      return get_the_author($object['id']);
    }
  ]);
}
add_action('rest_api_init', 'university_custom_rest');

function university_files()
{
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

  wp_enqueue_script('google_map', '//maps.googleapis.com/maps/api/js?key=AIzaSyAwGRt65ktrklRxGQFIjI4xWn7Y1cDGsuk', null, '1.0', true);
  wp_enqueue_script('university_main_js', get_theme_file_uri('/build/index.js'), ['jquery'], '1.0', true);

  wp_localize_script('university_main_js', 'universityData', [
    'root_url' => get_site_url()
  ]);
}
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
  register_nav_menu('headerMenuLocation', 'Header Menu Location');
  register_nav_menu('footerLeftMenuLocation', 'Footer Left Menu Location');
  register_nav_menu('footerRightMenuLocation', 'Footer Right Menu Location');

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
  if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', [
      [
        'key'     => 'event_date',
        'compare' => '>=',
        'value'   => date("Ymd"),
        'type'    => 'numeric'
      ]
    ]);
  } else if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  } else if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
    $query->set('posts_per_page', -1);
  }
}
add_action('pre_get_posts', 'university_adjust_queries');

function university_map_key($api)
{
  $api['key'] = 'AIzaSyAwGRt65ktrklRxGQFIjI4xWn7Y1cDGsuk';
  return $api;
}
add_filter('acf/fields/google_map/api', 'university_map_key');

function dd($var)
{
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}
