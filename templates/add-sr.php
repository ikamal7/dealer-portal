
<?php
 $notice = '';
    if(isset($_POST['sales_r'])){
        $username = isset($_POST['sr_username']) ? $_POST['sr_username']:'';
        $email = isset($_POST['sr_email']) ? $_POST['sr_email']:'';
        $sr_password = isset($_POST['sr_password']) ? $_POST['sr_password']:'';
        $role = isset($_POST['role']) ? $_POST['role'] : '';
        $dealeid = isset($_POST['dealeid']) ? $_POST['dealeid'] : '';

        $user_id = username_exists( $username );
        if ( ! $user_id && false == email_exists( $email ) ) {
            $userid = wp_create_user( $username, $sr_password, $email );
            $user = new WP_User($userid);
            $user->set_role( $role );
            add_user_meta($userid, 'dealer', $dealeid);
            $notice = __( 'SR created');
            $message = "You are added in sales represntative.";
            $message .= "username: {$username}";
            $message .= "password: {$sr_password}";
            $message .= "You can now login with username and password";
            $message .= "{}";
            $headers = array();
            wp_mail($email, 'Sales Representative added', $message, $headers);
        }else{
            $notice = __('User already exists');
        }

    }
?>
<div class="add-new-sr-form">
    <div class="notice"><?php echo $notice; ?></div>
    <form action="" method="post">
        <div class="input-field">
            <label for="sr_username">Username</label>
            <input type="text" name="sr_username" id="sr_username">
        </div>
        <div class="input-field">
            <label for="sr_email">Email</label>
            <input type="email" name="sr_email" id="sr_email">
        </div>
        <div class="input-field">
            <label for="sr_password">Password</label>
            <input type="password" name="sr_password" id="sr_password">
        </div>
        <div class="input-field">
            <input type="hidden" name="role" value="sales_r">
            <input type="hidden" name="dealeid" value="<?php echo get_current_user_id(); ?>">
            <input type="submit" name="sales_r" id="sales_r" value="Add SR">
        </div>
    </form>
</div>
