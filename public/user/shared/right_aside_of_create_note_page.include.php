<section class="right_aside_sec">
	<div class="how_to_creat_new_note">
		<i class="material-icons md-24">help_outline</i>
		<p class="right_aside_head"><a href="javascript:void(0)">Need help on How to create note ?</a></p>
	</div>
	<?php if(isset($user_login) && $user_login != false):?>
	<div class="last_five_posts_wrap">
		<p class="right_aside_head"><label for="last_five_posts">Last five notes</label></p>
		<input type="checkbox" class="checkbox" id="last_five_posts">

		<div class="last_five_posts_links prev_data_links">
			<ol class="previuos_post_ol">
				<?php 
				$last_five_posts = UserNote::get_last_N_notesID($limit =5, $userID= (int) $_COOKIE['user_id']);
				$html_data = '';
				foreach ($last_five_posts as $note) {
					$html_data .= '<li><a href="'. url_for('/user/view_note') .'?noteID=' .$note['note_id'].'" class="no_underline">';
					$html_data .= ucfirst(h($note['topic'])) . '</a></li>';
				}
				echo $html_data;
				 ?>
			</ol>
		</div><!-- .last_five_posts_links  -->
	</div><!-- .last_five_posts_wrap  -->

	<div class="top_five_posts_wrap">
		<p class="right_aside_head"><label for="top_five_posts">Most visited notes</label></p>
		<input type="checkbox" class="checkbox" id="top_five_posts">
		<div class="top_five_posts_links prev_data_links">
			<ol class="previuos_post_ol">
				<?php
				$top_five_posts = UserNote::get_self_most_viwed_N_notesID(5, (int) $_COOKIE['user_id']);
				$html_data = '';
				foreach ($top_five_posts as $note) {
					$html_data .= '<li><a href="'. url_for('/user/view_note') .'?noteID=' .$note['note_id'].'" class="no_underline">';
					$html_data .= ucfirst(h($note['topic'])) . '</a></li>';
				}
				echo $html_data;
				?>
			</ol>
		</div><!-- .top_five_posts_links  -->
	</div><!-- .top_five_posts_wrap  -->

<?php endif; ?>

</section><!-- .right_aside_sec  -->
