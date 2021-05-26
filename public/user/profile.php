<?php require_once '../../private/config/initialize.php'; ?>
<?php
 require_login('/');
 $page_title = 'Porfile';
 ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

        <div class="notes_title_full_wrap" id="profile_section">
        	<article class="notes_title_art">
        		<div class="head_notes_title_wrap">
        			<h2 class="head_notes_title">Profile</h2>
                </div>
                <?php
                    $user_id = isset($_COOKIE['user_id']) ? h((int) $_COOKIE['user_id']) : null;
                    if($user_id != null){
                        $user_data = User::find_by_id($user_id);
                    }
                    if($user_data->avator_type == 'monsterid'){
                        $s_image1_url = str_replace('s=60&d=monsterid', 's=80&d=wavatar',$user_data->user_avator);
                        $s_image2_url = str_replace('s=60&d=monsterid', 's=80&d=identicon',$user_data->user_avator);
                    }else if($user_data->avator_type == 'wavatar'){
                        $s_image1_url = str_replace('s=60&d=wavatar', 's=80&d=monsterid',$user_data->user_avator);
                        $s_image2_url = str_replace('s=60&d=wavatar', 's=80&d=identicon',$user_data->user_avator);
                    }else{
                        $s_image1_url = str_replace('s=60&d=identicon', 's=80&d=monsterid',$user_data->user_avator);
                        $s_image2_url = str_replace('s=60&d=identicon', 's=80&d=wavatar',$user_data->user_avator);
                    }
                ?>
                <section class="profile_sec">
                    <p class="username" title="username"><?php echo h($_COOKIE['username']);?></p>
                    <div class="profile_wrap">
                        <div class="current_user_profile">
                            <img src="<?php echo h(str_replace('s=60', 's=130',$user_data->user_avator));?>" alt="current user profile">
                        </div>
                        <div class="ch_pro_op">
                            <i>To change profile pic, there're 2 more pics given below</i>
                         </div>          
                        <div class="more_user_profiles">
                            <div class="ex-profile_1 profile">
                                <label for="s_profile_1">
                                <img src="<?php echo h($s_image1_url);?>" alt="profile image to change">
                                </label>
                                <input type="radio" name="s_profile" id="s_profile_1">
                            </div>
                            <div class="ex-profile_2 profile current_profile">
                                <img src="<?php echo h($user_data->user_avator);?>" alt="current user profile">
                                <div class="submimt_btn"><button>Save</button></div>
                            </div>
                            <div class="ex-profile_3 profile">
                                <label for="s_profile_3">
                                <img src="<?php echo h($s_image2_url);?>" alt="profile image to change">
                                </label>
                                <input type="radio" name="s_profile" id="s_profile_3">
                            </div>
                        </div>
                    </div>
                </section>
        		
        	</article><!-- .notes_title_art  -->
	        <aside class="right_aside_wrap">
	        	<?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
	        </aside><!-- .right_aside_wrap  -->
	    </div><!-- .notes_title_full_wrap  -->
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
