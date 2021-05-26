<?php require_once '../../private/config/initialize.php'; ?>
<?php
 // require_login('/index.php');
/*
* non login user can access this page. 
**/
 $page_title = 'View Note';
 if(!isset($_GET['noteID'])){
  redirect_to(url_for('/user/notes'));
 }
 ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

        <?php
        if(isset($user_login) && $user_login == false){
        require_once(PUBLIC_PATH .'/user/shared/login_form_popup.include.php');
       require_once(PUBLIC_PATH .'/user/shared/signup_form_popup.include.php');
        }
       ?>


        <div class="show_previous_notes_full_wrap view_single_note_wrap_main">
        	<article class="prev_notes_art">
        		<div class="head_prev_notes_wrap">
        			<h2 class="head_prev_notes">Your note</h2>
        		</div>
            <?php 
            echo htmlMarkup::nav_bar();
             ?>
        		<section class="prev_notes_wrap_sec">
        			<div class="all_notes_art_wrap">
                       <?php 
                       $usernote = new UserNote;
                       $user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : null;
                       $note_id = h($_GET['noteID']);
                       //array of is_objects
                       $note_by_id = $usernote->get_user_note_by_only_noteID($note_id,$user_id,true);
                       ?>
                       <article class="note_wrap" id="view_single_note"
                    <?php    
                    // non login user can access notes which are only public
                    if(empty($note_by_id)){
                        echo ' style="border:1px solid #f84548;">';
                        if($user_id !== null){
                            $dynamic_msg = 'This note is private protected. So you can not access this note.';
                        }elseif($user_id == null){
                            $dynamic_msg = 'Please login first and then access note.';
                        }
                        echo $err_msg = '<p class="unable_to_access_note" style="text-align:center;"><span class="material-icons">info</span><span class="utac_note_text">'.$dynamic_msg.'</span></p>';
                }else{
                    echo '>';
                    echo $usernote->barCode_wrap_for_note($note_id);
                    ?>
                <?php
                    echo $usernote->get_view_note_html($note_by_id);
                }
                ?>        
                </article>
                <?php
                    echo htmlMarkup::create_new_note();
                ?>

        			</div>
        		</section><!-- .prev_notes_wrap_sec  -->
        	</article><!-- .prev_notes_art  -->
	        <aside class="right_aside_wrap">
	        	<?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
	        </aside><!-- .right_aside_wrap  -->
	    </div><!-- .show_previous_notes_full_wrap  -->
        
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
