<?PHP
function university_register_search()
{
  register_rest_route('university/v1', 'search', [
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => function ($data) {

      $term = sanitize_text_field($data['term'] ?? '');

      $mainQuery = new WP_Query([
        'post_type' => [
          'post',
          'page',
          'professor',
          'program',
          'event',
          'campuse'
        ],
        's' => $term,
        'posts_per_page' => -1
      ]);

      $response = [
        'generalInfo' => [],
        'professors' => [],
        'programs' => [],
        'events' => [],
        'campuses' => []
      ];

      while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        $type = "generalInfo";
        if (get_post_type() == 'professor') $type = "professors";
        else if (get_post_type() == 'program') $type = "programs";
        else if (get_post_type() == 'event') $type = "events";
        else if (get_post_type() == 'campus') $type = "campuses";

        $data = [
          'ID'         => get_the_ID(),
          'title'      => get_the_title(),
          'link'       => get_the_permalink(),
          'authorName' => get_the_author()
        ];

        if (get_post_type() == "professor") {
          $data['thumb'] = get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape');
        } else if (get_post_type() == "event") {
          $data['description'] = (has_excerpt()) ? get_the_excerpt() : wp_trim_words(get_the_content(), 18);

          try {
            $eventDate = new DateTime(get_field('event_date'));
            $data['month'] = $eventDate->format('M');
            $data['day'] = $eventDate->format('d');
          } catch (Exception $e) {
            $data['month'] = "00";
            $data['day'] = "00";
          }
        }

        array_push($response[$type], $data);
      }

      // Search Programs related to Professor 
      $metaQuery = ['relation' => 'OR'];
      foreach ($response['programs'] as $program) {
        $metaQuery[] = [
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . $program['ID'] . '"'
        ];
      }
      $programRelationshipQuery = new WP_Query([
        'post_type' => ['professor', 'event'],
        'meta_query' => $metaQuery
      ]);
      while ($programRelationshipQuery->have_posts()) {
        $programRelationshipQuery->the_post();

        $type = "generalInfo";
        if (get_post_type() == 'professor') $type = "professors";
        else if (get_post_type() == 'program') $type = "programs";
        else if (get_post_type() == 'event') $type = "events";
        else if (get_post_type() == 'campus') $type = "campuses";

        $data = [
          'ID'         => get_the_ID(),
          'title'      => get_the_title(),
          'link'       => get_the_permalink(),
          'authorName' => get_the_author()
        ];


        if (get_post_type() == 'professor')
          $data['thumb'] = get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape');
        else if (get_post_type() == 'event') {
          $data['description'] = (has_excerpt()) ? get_the_excerpt() : wp_trim_words(get_the_content(), 18);

          try {
            $eventDate = new DateTime(get_field('event_date'));
            $data['month'] = $eventDate->format('M');
            $data['day'] = $eventDate->format('d');
          } catch (Exception $e) {
            $data['month'] = "00";
            $data['day'] = "00";
          }
        }

        $response[$type][] = $data;
      }
      wp_reset_query();
      $response['professors'] = array_values(array_unique($response['professors'] ?? [], SORT_REGULAR));
      $response['events'] = array_values(array_unique($response['events'] ?? [], SORT_REGULAR));

      return $response;
    }
  ]);
}

add_action('rest_api_init', 'university_register_search');
