<?php require_once '../../private/config/initialize.php'; ?>
<?php
require_login('/');
$page_title = 'Notes Topic';
?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
<div class="dimlight"></div>
<main>
  <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
  <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
  <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

  <div class="notes_title_full_wrap">
    <article class="notes_title_art">
      <div class="head_notes_title_wrap tags_top_head_wrap">
      <?php
          $top_info = NoteTag::get_tags((int) $_COOKIE['user_id']);
          $counts = count_values_in_array($top_info, 'tag_name');
      ?>
        <h2 class="head_notes_title"><span>Tags</span> <?php
          $total_tags = ($counts == false) ? false: array_sum($counts);
          if($total_tags != false){
            echo '<span class="total_tags">Total tags '. $total_tags .'</span>';
          }
         ?></h2>
      </div>
      <?php echo htmlMarkup::nav_bar(); ?>
      <section class="notes_title_wrap_sec">
        <div class="all_notes_title_wrap">
          <?php
          if (!empty($top_info)) {
            $min = 1000000;
            $max = -1000000;
            foreach ($top_info as $key => $value) {
              if ($value['self_views'] > $max)
                $max = $value['self_views'];
              if ($value['self_views'] < $min)
                $min = $value['self_views'];
            }
            $diff = (($max - $min) == 0) ? 1 : $max - $min;
            $ratio = 18.0 / $diff;
          }
          ?>

          <?php
          $h = 'h';
          if (isset($min)) {
          $previous_tag_track = NULL;
          $tags_html = '<article class="notes_tag_page">';
            foreach ($top_info as $key => $value) {
              $fs = (int)(16 + ($value['self_views'] * $ratio));

              // this if block runs only for first time
              if($previous_tag_track === NULL){
                $tags_html .= <<< HTML
                <div class="tag_info_wrap">
                  <div class="notes_tag_link " style="font-size:{$fs}px; padding:8px">
                  <span class="tag_name_text">{$h($value['tag_name'])}</span><sup class="total_tags_super">{$counts[$value['tag_name']]}</sup></div>
                  <div class="links_wrap hide_element">
                  <a href="./view_note?noteID={$value['note_id']}" class="no_underline title_note_link">{$h($value['topic'])}</a>
                HTML;
                $previous_tag_track = $h($value['tag_name']);
              }else{
                if($value['tag_name'] === $previous_tag_track){
                  $tags_html .= <<< HTML
                  <a href="./view_note?noteID={$value['note_id']}" class="no_underline title_note_link">{$h($value['topic'])}</a>
                  HTML;
                }else{
                  $tags_html .='</div></div>';
                  $tags_html .= <<< HTML
                  <div class="tag_info_wrap">
                    <div class="notes_tag_link" style="font-size:{$fs}px; padding:8px"><span class="tag_name_text">{$h($value['tag_name'])}</span><sup class="total_tags_super">{$counts[$value['tag_name']]}</sup></div>
                    <div class="links_wrap hide_element">
                    <a href="./view_note?noteID={$value['note_id']}" class="no_underline title_note_link">{$h($value['topic'])}</a>
                  HTML;
                  $previous_tag_track = $h($value['tag_name']);
                }

              }
            } // foreach
            echo $tags_html;
            echo '</article>';
          } else {
          ?>
            <div id="json_subject_message">
              <span class="no_more_note_wrap">
                <span class="no_more_note_message">You do not have any note. Try to <a href="<?php echo url_for('user/create_note'); ?>">create new note</a></span>
              </span>
            </div>
          <?php } ?>


          <?php
          echo htmlMarkup::create_new_note();
          ?>

        </div>
      </section><!-- .notes_title_wrap_sec  -->
    </article><!-- .notes_title_art  -->
    <aside class="right_aside_wrap">
      <?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
    </aside><!-- .right_aside_wrap  -->
  </div><!-- .notes_title_full_wrap  -->
</main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
