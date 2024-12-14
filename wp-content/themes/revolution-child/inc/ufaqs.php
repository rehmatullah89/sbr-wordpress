<?php
add_action('init','register_custom_post_type_ufaqs');
function register_custom_post_type_ufaqs() {
    global $ewd_ufaq_controller;

    // Define the faq custom post type
    $args = array(
        'labels' => array(
            'name' 					=> __( 'FAQs',           			'ultimate-faqs' ),
            'singular_name' 		=> __( 'FAQ',                   	'ultimate-faqs' ),
            'menu_name'         	=> __( 'FAQs',          			'ultimate-faqs' ),
            'name_admin_bar'    	=> __( 'FAQs',                  	'ultimate-faqs' ),
            'add_new'           	=> __( 'Add New',                 	'ultimate-faqs' ),
            'add_new_item' 			=> __( 'Add New FAQ',           	'ultimate-faqs' ),
            'edit_item'         	=> __( 'Edit FAQ',               	'ultimate-faqs' ),
            'new_item'          	=> __( 'New FAQ',                	'ultimate-faqs' ),
            'view_item'         	=> __( 'View FAQ',               	'ultimate-faqs' ),
            'search_items'      	=> __( 'Search FAQs',           	'ultimate-faqs' ),
            'not_found'         	=> __( 'No FAQs found',          	'ultimate-faqs' ),
            'not_found_in_trash'	=> __( 'No FAQs found in trash', 	'ultimate-faqs' ),
            'all_items'         	=> __( 'All FAQs',              	'ultimate-faqs' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-chat',
        'rewrite' => array( 
            'slug' => 'ufaqs',
        ),
        'supports' => array(
            'title', 
            'editor', 
            'author',
            'excerpt',
            'comments'
        ),
        'show_in_rest' => true,
    );

    // Create filter so addons can modify the arguments
   

    // Add an action so addons can hook in before the post type is registered
    

    // Register the post type
    register_post_type( EWD_UFAQ_FAQ_POST_TYPE, $args );

    // Add an action so addons can hook in after the post type is registered
    do_action( 'ewd_ufaq_faqs_post_register' );

    // Define the review category taxonomy
    $args = array(
        'labels' => array(
            'name' 				=> __( 'FAQ Categories',			'ultimate-faqs' ),
            'singular_name' 	=> __( 'FAQ Category',				'ultimate-faqs' ),
            'search_items' 		=> __( 'Search FAQ Categories', 	'ultimate-faqs' ),
            'all_items' 		=> __( 'All FAQ Categories', 		'ultimate-faqs' ),
            'parent_item' 		=> __( 'Parent FAQ Category', 		'ultimate-faqs' ),
            'parent_item_colon' => __( 'Parent FAQ Category:', 		'ultimate-faqs' ),
            'edit_item' 		=> __( 'Edit FAQ Category', 		'ultimate-faqs' ),
            'update_item' 		=> __( 'Update FAQ Category', 		'ultimate-faqs' ),
            'add_new_item' 		=> __( 'Add New FAQ Category', 		'ultimate-faqs' ),
            'new_item_name' 	=> __( 'New FAQ Category Name', 	'ultimate-faqs' ),
            'menu_name' 		=> __( 'FAQ Categories', 			'ultimate-faqs' ),
        ),
        'public' 		=> true,
        'query_var'		=> true,
        'hierarchical' 	=> true,
        'show_in_rest' 	=> true,
    );

    // Create filter so addons can modify the arguments
    
    register_taxonomy( EWD_UFAQ_FAQ_CATEGORY_TAXONOMY, EWD_UFAQ_FAQ_POST_TYPE, $args );

    // Define the review category taxonomy
    $args = array(
        'labels' => array(
            'name' 				=> __( 'FAQ Tags',				'ultimate-faqs' ),
            'singular_name' 	=> __( 'FAQ Tag',				'ultimate-faqs' ),
            'search_items' 		=> __( 'Search FAQ Tags', 		'ultimate-faqs' ),
            'all_items' 		=> __( 'All FAQ Tags', 			'ultimate-faqs' ),
            'parent_item' 		=> __( 'Parent FAQ Tag', 		'ultimate-faqs' ),
            'parent_item_colon' => __( 'Parent FAQ Tag:', 		'ultimate-faqs' ),
            'edit_item' 		=> __( 'Edit FAQ Tag', 			'ultimate-faqs' ),
            'update_item' 		=> __( 'Update FAQ Tag', 		'ultimate-faqs' ),
            'add_new_item' 		=> __( 'Add New FAQ Tag', 		'ultimate-faqs' ),
            'new_item_name' 	=> __( 'New FAQ Tag Name', 		'ultimate-faqs' ),
            'menu_name' 		=> __( 'FAQ Tags', 				'ultimate-faqs' ),
        ),
        'public' 		=> true,
        'hierarchical' 	=> false,
        'show_in_rest' 	=> true,
    );

    // Create filter so addons can modify the arguments
    

    register_taxonomy( EWD_UFAQ_FAQ_TAG_TAXONOMY, EWD_UFAQ_FAQ_POST_TYPE, $args );
}