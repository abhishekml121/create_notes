<?php require_once '../../private/config/initialize.php'; ?>
<?php
 require_login('/');
 $page_title = 'User Notes';
 ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

        <div class="show_previous_notes_full_wrap">
        	<article class="prev_notes_art">
        		<div class="head_prev_notes_wrap">
        			<h2 class="head_prev_notes">Overview</h2>
                        <?php 
                            $top_info = UserSubject::get_top_info_html($args=['count_all_notes'=>true, 'count_all_subjects'=>true, 'count_all_watch_later_notes'=>true, 'count_all_imp_notes'=>true]);
                            if($top_info){
                                $html = '<article class="topics_info_wrap common_top_info_style">';
                                $html .= $top_info;
                                $html .='</article>';
                                echo $html;
                            }
                         ?>
        		</div>
        		<section class="prev_notes_wrap_sec overview_graph">
        			<div class="all_notes_art_wrap">
                        <div id="graph_ch" style="position:relative;">
                            <div style="text-align:center;">
                                <img src="<?php echo url_for('images/svg_loader_width_160.svg'); ?>">
                            </div>
                        </div><!-- .top_five_posts_links  -->
                        <!-- all notes of a user will be show here   -->
        			</div>
        		</section><!-- .prev_notes_wrap_sec  -->
                <?php echo htmlMarkup::create_new_note(); ?>
        	</article><!-- .prev_notes_art  -->
	        <aside class="right_aside_wrap">
	        	<?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
	        </aside><!-- .right_aside_wrap  -->
	    </div><!-- .show_previous_notes_full_wrap  -->
        
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
