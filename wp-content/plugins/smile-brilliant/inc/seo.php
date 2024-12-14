<?php
add_filter('wpseo_sitemap_index_links', 'smilebrilliant_remove_empty_sitemap', 10, 1);
/**
 * Filter callback to remove empty sitemap links.
 *
 * @param array $links An array of sitemap links.
 *
 * @return array Filtered array of sitemap links.
 */
function smilebrilliant_remove_empty_sitemap($links)
{

    foreach ($links as $sitemap => $value) {
        if (!$value['lastmod']) {
            unset($links[$sitemap]);
        }
        if (in_array($value['loc'], array('https://www.smilebrilliant.com/supplier-sitemap.xml', 'https://www.smilebrilliant.com/author-sitemap.xml', 'https://www.smilebrilliant.com/wfacp_checkout-sitemap.xml', 'https://www.smilebrilliant.com/type-sitemap.xml'))) {
            unset($links[$sitemap]);
        }
    }
    return $links;
}
add_filter('wpseo_exclude_from_sitemap_by_post_ids', 'smilebrilliant_exclude_posts_and_urls_from_sitemaps');

/**
 * Exclude specific product posts and posts with a certain pattern from XML sitemaps.
 *
 * @param array $excluded_posts_ids An array of post IDs to be excluded.
 * @return array An updated array of post IDs to be excluded.
 */
function smilebrilliant_exclude_posts_and_urls_from_sitemaps($excluded_posts_ids)
{
    global $wpdb;

    // Exclude specific product posts
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array('raw', 'packaging', 'uncategorized', 'data-only', 'addon', 'exclude-in-feed', 'exclude-in-sitemap'),
                'operator' => 'IN',
            ),
        ),
    );

    $product_list = get_posts($args);
    $excluded_posts_ids = array_merge($excluded_posts_ids, $product_list);

    // Exclude posts with a certain pattern
    $pattern = 'recommendations-page-for-%';
    $query = $wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE post_name LIKE %s AND post_type IN ('post', 'page')",
        $pattern
    );
    $results = $wpdb->get_results($query, ARRAY_A);
    $postIds = wp_list_pluck($results, 'ID');
    $excluded_posts_ids = array_merge($excluded_posts_ids, $postIds);

    return $excluded_posts_ids;
}

