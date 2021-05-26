<article class="login_art" id="login_art">
    <div class="login_user_box_wrap">
        <div class="login_box_header_wrap">
            <span class="login_header_info">Login</span>
            <span class="login_close_btn">X</span>
        </div><!-- .login_box_header_wrap  -->

        <div class="login_header_body_wrap">
            <div class="login_body_form_wrap">
                <form id="login_form">
                    <div class="user_name_or_email">
                    <label for="unique_user_id">Username or email address</label>
                    <input type="text" name="username_or_email" id="unique_user_id">  
                    </div>

                    <div class="user_paswd">
                        <div class="user_paswd_wrap">
                            <label for="user_paswd">Password</label>
                            <div class="paswd_div_wrap">
                                <input type="password" name="password" id="user_paswd" class="only_word_char_input">
                                <div class="show_paswd_wrapp">
                                    <span class="material-icons show_paswd_icon md-18">visibility</span>
                                </div>
                            </div>
                        </div>
                    <div class="forget_paswd">
                        <span><a href="<?php echo url_for('/pages/forget_password');?>" class="no_underline">Forget password?</a></span>
                    </div>
                    </div> <!-- .user_paswd  -->

                    <div class="login_btn_wrap">
                        <button class="login_btn" data-src="login_btn">Login</button>
                    </div>

                    <div class="back_to_sinup">
                        <span>Don't have an account yet ? Register now !</span>
                    </div>

                </form> <!-- #login_form  -->
            </div> <!-- .login_body_form_wrap  -->
        </div><!-- .login_header_body_wrap  -->
    </div><!-- .login_user_box_wrap  -->
</article> <!-- .login_art  -->
