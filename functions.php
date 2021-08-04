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

function update_sr_profiles(){
  global $current_user, $wp_roles;
//get_currentuserinfo(); //deprecated since 3.1

/* Load the registration file. */
//require_once( ABSPATH . WPINC . '/registration.php' ); //deprecated since 3.1
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] )
            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
        else
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
    }

    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->id )
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink() );
        exit;
    }
}
}