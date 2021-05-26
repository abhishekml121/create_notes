<?php require_once '../../private/config/initialize.php'; ?>
<?php
 require_login('/');
 $page_title = 'Important Notes';
 ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

        <div class="notes_title_full_wrap">
        	<article class="notes_title_art">
        		<div class="head_notes_title_wrap">
        			<h2 class="head_notes_title">Important notes</h2>
                        <?php 
                        $top_info = UserSubject::get_top_info_html($args=['count_all_notes'=>true, 'count_all_subjects'=>true,'count_all_watch_later_notes'=>false, 'count_all_imp_notes'=>true]);
                        if($top_info){
                        $html = '<article class="topics_info_wrap common_top_info_style">';
                        $html .= $top_info;
                        $html .='</article>';
                        echo $html;
                    }
                         ?>
        		</div>
        		<section class="notes_title_wrap_sec">
        			<div class="all_notes_title_wrap">

        			</div>
 
                    <?php
                    echo htmlMarkup::create_new_note();
                    ?>
        		</section><!-- .notes_title_wrap_sec  -->

        	</article><!-- .notes_title_art  -->
	        <aside class="right_aside_wrap">
	        	<?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
	        </aside><!-- .right_aside_wrap  -->
	    </div><!-- .notes_title_full_wrap  -->
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
