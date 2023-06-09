<?PHP
function university_post_types()
{
    register_post_type('campus', [
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'campuses'
        ],
        'public' => true,
        'show_in_rest' => true,
        'labels' => [
            'name'          => 'Capuses',
            'add_new_item'  => 'Add New Campus',
            'edit_item'     => 'Edit Campus',
            'all_items'     => 'All Campuses',
            'singular_name' => 'Campus'
        ],
        'menu_icon' => 'dashicons-location-alt',
        'supports' => [
            'title',
            'editor',
            'excerpt'
        ]
    ]);

    register_post_type('event', [
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'events'
        ],
        'public' => true,
        'show_in_rest' => true,
        'labels' => [
            'name'          => 'Events',
            'add_new_item'  => 'Add New Event',
            'edit_item'     => 'Edit Event',
            'all_items'     => 'All Events',
            'singular_name' => 'Event'
        ],
        'menu_icon' => 'dashicons-calendar',
        'supports' => [
            'title',
            'editor',
            'excerpt'
        ]
    ]);

    register_post_type('program', [
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'programs'
        ],
        'public' => true,
        'show_in_rest' => true,
        'labels' => [
            'name'          => 'Programs',
            'add_new_item'  => 'Add New Program',
            'edit_item'     => 'Edit Program',
            'all_items'     => 'All Programs',
            'singular_name' => 'Program'
        ],
        'menu_icon' => 'dashicons-awards',
        'supports' => [
            'title'
        ]
    ]);

    register_post_type('professor', [
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'labels' => [
            'name'          => 'Professors',
            'add_new_item'  => 'Add New Professor',
            'edit_item'     => 'Edit Professor',
            'all_items'     => 'All Professors',
            'singular_name' => 'Professor'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => [
            'title',
            'editor',
            'thumbnail'
        ]
    ]);
}
add_action('init', 'university_post_types');
