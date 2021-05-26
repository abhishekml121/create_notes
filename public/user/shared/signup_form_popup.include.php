<article class="reg_art" id="reg_art">
    <div class="reg_user_box_wrap">
        <div class="reg_box_header_wrap">
            <span class="reg_header_info">Register</span>
            <span class="reg_close_btn">X</span>
        </div><!-- .reg_box_header_wrap  -->

        <div class="reg_header_body_wrap">
            <div class="reg_body_form_wrap">
                <form id="reg_form">
                    <div class="reg_user_name_or_email">
                    <label for="unique_username">Username</label>
                    <input type="text" name="username" id="unique_username">  
                    </div>

                    <div class="reg_user_paswd">
                    <label for="reg_user_paswd">Password</label>
                    <div class="paswd_div_wrap">
                        <input type="password" name="password" id="reg_user_paswd" class="only_word_char_input">
                        <div class="show_paswd_wrapp">
                            <span class="material-icons show_paswd_icon md-18">visibility</span>
                        </div>
                    </div>
                    </div> <!-- .reg_user_paswd  -->

                    <div class="reg_user_confirm_paswd">
                    <label for="reg_user_confirm_paswd">Confirm password</label>
                    <div class="paswd_div_wrap">
                        <input type="password" name="confirm_password" id="reg_user_confirm_paswd" class="only_word_char_input">
                        <div class="show_paswd_wrapp">
                            <span class="material-icons show_paswd_icon md-18">visibility</span>
                        </div>
                    </div>
                    </div> <!-- .reg_user_paswd  -->

                    <div class="reg_btn_wrap">
                        <button class="reg_btn" data-src="reg_btn">Register</button>
                    </div>

                    <div class="back_to_login">
                        <span>Have an account ? Login now !</span>
                    </div>

                </form> <!-- #reg_form  -->
            </div> <!-- .reg_body_form_wrap  -->
        </div><!-- .reg_header_body_wrap  -->
    </div><!-- .reg_user_box_wrap  -->
</article> <!-- .reg_art  -->
