<header class="main_top_header">
    <div class="header_wrap">
        <div class="website_name_logo_wrap">
            <div class="website_logo">
                <figure class="header_fig">
                <img src="<?php echo url_for('/images/logo.svg'); ?>" alt="Website Logo" class="website_logo_img common_img_props">
                <figcaption class="website_name"><a href="javascript:void(0)" class="no_underline" tabindex="1"><?php echo SITE_NAME; ?></a></figcaption>
                </figure>
            </div>
            <!-- <div class="website_name"></div> -->
        </div> <!-- .website_name_logo_wrap  -->

        <div class="right_top_header">
            <div class="action_top_header">
                <?php 
                if(!$session->is_logged_in()){
                    $user_login = false;
                 ?>
                <div class="signin_btn_wrap">
                    <button class="signin_btn" tabindex="2">Login</button>
                </div> <!-- .signin_btn_wrap  -->

                <div class="signup_btn_wrap">
                    <button class="signup_btn" tabindex="3">Regsiter</button>
                </div> <!-- .signup_btn_wrap  -->
            <?php }else{ $user_login = true; ?>
                <div class="create_new_note_header_wrap">
                    <span class="create_new_note_span"><a href="<?php echo url_for('/user/create_note');?>" class="no_underline">Create Note</a></span>
                </div>

                <div class="settings_login_user">
                    <ul class="settings_login_user_main_ul">
                        <li class="setting_img_wrap">
                            <div><a href="<?php echo url_for('/user/profile');?>" class="no_underline"><?php echo h($_COOKIE['username']); ?></a></div>
                        </li>
                        <li class="settings_items_wrap">
                            <ul class="settings_items_ul">
                                <li><a href="javascript:void(0)" class="no_underline">My activities</a></li>
                                <li><a href="javascript:void(0)" class="no_underline">My Posts</a></li>
                                <li><a href="<?php echo url_for('/logout.php'); ?>" class="no_underline">Logout</a></li>
                            </ul>
                        </li>
                </ul>
                </div>
            <?php } ?>
            </div> <!-- .action_top_header  -->
        </div> <!-- .right_top_header -->
    </div> <!-- .header_wrap  -->
</header> <!-- .main_top_header -->
