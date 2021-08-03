<?php

function dealer_get_template_part($slug, $name = null) {
  
    do_action("dealer_get_template_part_{$slug}", $slug, $name);
  
    $templates = array();
    if (isset($name))
        $templates[] = "{$slug}-{$name}.php";
  
    $templates[] = "{$slug}.php";
  
    dealer_get_template_path($templates, true, false);
  }
  
  /* Extend locate_template from WP Core 
  * Define a location of your plugin file dir to a constant in this case = DEALER_PATH 
  * Note: DEALER_PATH - can be any folder/subdirectory within your plugin files 
  */ 
  
  function dealer_get_template_path($template_names, $load = false, $require_once = true ) {
      $located = ''; 
      foreach ( (array) $template_names as $template_name ) { 
        if ( !$template_name ) 
          continue; 
  
        /* search file within the DEALER_PATH only */ 
        if ( file_exists(DEALER_PATH . '/' . $template_name)) { 
          $located = DEALER_PATH . '/' . $template_name; 
          break; 
        } 
      }
  
      if ( $load && '' != $located )
          load_template( $located, $require_once );
  
      return $located;
  }
  
  // Get your Page template link By template file
function get_page_template_link($template_file) {
  $archive_page = get_pages(
      array(
          'meta_key'   => '_wp_page_template',
          'meta_value' => $template_file,
      )
  );
  $archive_id = $archive_page[0]->ID;
  return get_permalink( $archive_id );
}

// Use
//  get_page_template_link('page-templates/template.php')

add_filter('bigcommerce/account/subnav/links', 'my_links');
function my_links($links) {
	$user = wp_get_current_user();
    $valid_roles = [ 'administrator', 'dealer' ];
    $the_roles = array_intersect( $valid_roles, $user->roles );
    if(!empty( $the_roles )){
		$links['dealer-portal'] = [
			'url' => get_page_template_link(DEALER_PATH . '/includes/dealer-template.php'),
			'label' => 'Dealer portal',
			'current' => ( get_the_ID() == get_queried_object_id() ),
		];
	}

	return $links;
}