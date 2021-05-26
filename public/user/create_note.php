<?php require_once '../../private/config/initialize.php'; ?>
<?php
 require_login('/');
 $page_title = 'Create new post';
$note = [];
/* If we come to this page by clicking on a link from another page 
* in which `subjectName`
* is in the URL then it will automatically
* fill the input filed of subject name.
*/
$note['subject_name'] =  isset($_GET['subjectName']) ? urldecode(trim($_GET['subjectName'])) : '';
 ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

        <div class="create_new_note_wrap_div">
        <article class="create_new_note_art">
        	<div class="head_create_new_note_wrap">
        		<h2 class="head_create_new_note">Create new note</h2>
        	</div>
        	<section class="create_new_note_sec">
                <form id="create_note_form">
        		<?php require_once(PUBLIC_PATH . '/user/includes/create_new_note_form.include.php'); ?>
                <div class="save_note_btn_wrap">
                    <button class="save_note_btn" data-src="save_note_btn">Save note</button>
                </div>
                </form>
        	</section><!-- .create_new_note_sec  -->
        </article><!-- .create_new_note_art  -->

        <aside class="right_aside_wrap">
        	<?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
        </aside><!-- .right_aside_wrap  -->
    </div><!-- create_new_note_wrap_div  -->
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
