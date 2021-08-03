<?php
/**
 * Template Name: Dealer Portal
 *
 */
get_header();
$obj_id = get_queried_object_id();
$current_url = get_permalink( $obj_id );

?>
<?php if(is_user_logged_in()):
    $user = wp_get_current_user();
    $valid_roles = [ 'administrator', 'dealer' ];
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
                    <a class="nav-link active" aria-current="page" href="<?php echo $current_url. add_query_arg(['dp' => 'dashboard']); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $current_url. add_query_arg(['dp' => 'add-sr']); ?>">Add new Sales representative</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $current_url. add_query_arg(['dp' => 'list-sr']); ?>">List All SR</a>
                </li>
            </ul>
        </div>
        <div class="col-8">
            <?php
            $get_page = isset($_GET['dp']) ? $_GET['dp'] :'';
            switch ($get_page){
                case 'dashboard':
                    dealer_get_template_part('templates/dashboard'); 
                    break;
                case 'add-sr':
                    dealer_get_template_part('templates/add-sr');
                    break;
                case 'list-sr':
                    dealer_get_template_part('templates/list-sr');
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


<?php
get_footer();

