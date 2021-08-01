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
  