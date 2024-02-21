<?php

/**
 * Shortcode to display posts from the 'service' custom post type that are assigned
 * to the 'design-and-installation' term in the 'service-type' taxonomy.
 * Outputs the title, featured image, and description of each post.
 */
function custom_service_posts_shortcode() {
    $args = array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'service-type',
                'field'    => 'slug',
                'terms'    => 'design-and-installation',
            ),
        ),
    );

    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        $output .= '<div class="custom-services-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $title = get_the_title();
            $description = get_the_content();
            $thumbnail = get_the_post_thumbnail($post_id, 'full'); 

            $output .= '<div class="custom-service">';
            $output .= '<div>' . $thumbnail . '</div>'; 
            $output .= '<h2>' . esc_html($title) . '</h2>';
            $output .= '<p>' . wp_kses_post($description) . '</p>';
            $output .= '</div>';
        }
        $output .= '</div>';
    } else {
        $output .= '<p>No services found.</p>';
    }

    wp_reset_postdata();

    return $output;
}
add_shortcode('services_design_installation', 'custom_service_posts_shortcode');
