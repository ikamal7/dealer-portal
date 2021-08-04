<?php
/**
 * Template Name: SR Portal
 *
 */
get_header();
$obj_id = get_queried_object_id();
$current_url = get_permalink( $obj_id );

?>
<?php if(is_user_logged_in()):
    $user = wp_get_current_user();
    $valid_roles = [ 'administrator', 'dealer', 'sales_r' ];
    $the_roles = array_intersect( $valid_roles, $user->roles );
    if(empty( $the_roles )){
        wp_redirect( home_url('/' ) );
        exit;
    }
    ?>

<div class="container">
    <div class="row">
        <div class="col-4">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo $current_url. add_query_arg(['sr' => 'dashboard']); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $current_url. add_query_arg(['sr' => 'form-entry']); ?>">Forms List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $current_url. add_query_arg(['sr' => 'profile']); ?>">Profile</a>
                </li>
            </ul>
        </div>
        <div class="col-8">
            <?php
            $get_page = isset($_GET['sr']) ? $_GET['sr'] :'';
            switch ($get_page){
                case 'dashboard':
                    dealer_get_template_part('templates/dashboard'); 
                    break;
                case 'profile':
                    dealer_get_template_part('templates/sr-profile');
                    break;
                case 'form-entry':
                    dealer_get_template_part('templates/sr-form-entry');
                    break;
                default:
                    dealer_get_template_part('templates/dashboard'); 
                    break;
            }
            ?>
        </div>
    </div>
</div>
<?php else: ?>

    <?php echo do_shortcode('[gravityform action="login" login_redirect="'. home_url('/dealer-portal') .'"]'); ?>

<?php endif; ?>


<?php get_footer(); ?>