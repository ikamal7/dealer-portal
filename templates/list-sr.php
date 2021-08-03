<h1>List all SR</h1>
<?php
$args = array(
    'role' => 'sales_r',
    'meta_query' => array(
        'key'=> 'dealer',
        'value'=> get_current_user_id(),
    )
);
$wp_user_query= new WP_User_Query($args);
// Get the results
$sr_lists = $wp_user_query->get_results();
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
            <td>Delete</td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>