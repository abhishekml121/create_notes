<?php require_once '../../private/config/initialize.php'; ?>
<?php
if((!empty($_GET) && !array_key_exists('subjectName', $_GET))){
    redirect_to('./subjects.php');
}
 require_login('/');

 $page_title = 'User Notes';
 ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

        <section class="show_subjects_wrap">
        <article class="subjects_info_art">
            <div class="head_notes_title_wrap">
                <h2 class="head_notes_title">Subjects</h2>
                <?php 
                $top_info = UserSubject::get_top_info_html();
                if($top_info){
                    $html = '<div class="subjects_top_info_wrap common_top_info_style">';
                    $html .= $top_info;
                    $html .='</div>';
                    echo $html;
                }
                 ?>
            </div>
        </article><!-- .subjects_info_art  -->

        <aside class="right_aside_wrap">
            <?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
        </aside><!-- .right_aside_wrap  -->            
        </section><!-- .show_subjects_wrap  -->
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
