<h1>List all SR</h1>
<?php
require_once(ABSPATH.'wp-admin/includes/user.php' );
$notice = '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$user_id = isset($_GET['id']) ? $_GET['id'] : '';
$deleted = isset($_GET['deleted']) ? $_GET['deleted'] : '';
if($action == 'delete' && !empty($user_id)){
    if(wp_delete_user($user_id)){
        // wp_redirect(home_url(add_query_arg(['dp'=>'list-sr', 'deleted'=>'1'])));
    }else{
        // wp_redirect(home_url(add_query_arg(['dp'=>'list-sr', 'deleted'=>'0'])));
    }
}
$args = array(
    'role' => 'sales_r',
    // 'meta_query' => array(
        'meta_key'=> 'dealer',
        'meta_value'=> get_current_user_id(),
        // 'meta_compare'=> 'EXIST'
    // )
);
$wp_user_query= new WP_User_Query($args);
// Get the results
$sr_lists = $wp_user_query->get_results();
if($deleted == 1){
    echo "Sales Representative deleted successfully";
}if($deleted == 0){
    echo "Sales Representative deleted Failed";
}
?>

<table>
    <thead>
        <tr>
            <th>username</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($sr_lists)): foreach($sr_lists as $sr_list): ?>
            <?php //var_dump($sr_list); ?>
        <tr>
            <td><?php echo $sr_list->user_nicename; ?></td>
            <td><a href="<?php echo get_permalink().add_query_arg(['action'=> 'delete', 'id'=>$sr_list->ID]) ?>">Delete</a></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>