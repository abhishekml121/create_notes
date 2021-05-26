<?php require_once '../../private/config/initialize.php'; ?>
<?php
 require_login('/');
 $page_title = 'Edit Note';
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
        $note_id = h($_GET['noteID']);
        $user_note = new UserNote;
        $show_editing_form = false;
        $note = $user_note->get_note_deatils_for_edit((int) $_COOKIE['user_id'] , $note_id);
        // Allow only owner to edit thier note.
        if($note === false){
            redirect_to(url_for('/user/notes'));
        }elseif (!empty($note)) {
            // note found,
            //then store note_id in session.
            // we are accessing this $_SESSION['note_id'] in save_edited_note.process.php
            $_SESSION['note_id'] = $_GET['noteID'];
            $show_editing_form = true;
        }

         ?>
        
        <div class="edit_note_full_wrap">
        	<article class="edit_new_note_art">
                <div class="head_create_new_note_wrap">
                    <h2 class="head_create_new_note">Edit Note</h2>
                </div>
                <div title="Topic">
                    <a href="<?php echo url_for('/user/view_note?noteID='. h($_GET['noteID'])); ?>" class="no_underline">
                    <h2 class="note_head"><?php
                    if($show_editing_form == true){
                    echo h(UserNote::get_topic_name_by_noteID(h($_GET['noteID']))['topic']);
                }
                    ?></h2>
                    </a>
                </div>
                <section class="edit_new_note_sec">
                    <?php if($show_editing_form == true){ ?>
                    <form id="edit_note_form">
                    <?php require_once(PUBLIC_PATH . '/user/includes/create_new_note_form.include.php'); ?>
                    <div class="save_note_btn_wrap">
                        <button class="edit_note_btn" data-src="edit_note_btn">Save edited note</button>
                    </div>
                    </form>
                <?php }else{ ?>
                    <div class="note_for_edit_not_found">
                        <div class="material-icons md-24">info</div>
                        <p>You can not access this note with the ID : <?php echo '<span class="note_not_found">'.$note_id . '</span>'; ?></p>
                    </div>
                <?php } ?>
                </section><!-- .edit_new_note_sec  -->
            </article><!-- .edit_new_note_art  -->

            <aside class="right_aside_wrap">
                <?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
            </aside><!-- .right_aside_wrap  -->
	    </div><!-- .edit_note_full_wrap  -->
        
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
