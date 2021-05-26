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

               <?php 
               $user_id = (int) $_COOKIE['user_id'];
               $sql = "select * from notes AS N JOIN notes_subject AS S ON N.user_id = $user_id AND  N.user_id = S.user_id AND N.note_id = S.note_id JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id = T.note_id";
               $result = UserNote::find_by_sql($sql);
               // print_r($result);
               $table = '<table>';
               $table .= '<tr><th>id</th><th>user_id</th><th>note_id</th><th>topic</th><th>note_html</th><th>note_markdown</th><th>subject</th><th>tags</th><th>date</th><th>time</th><th>access_type</th></tr>';
               foreach ($result as $key => $value) {
                   $table .= '<tr>';
        		   /* echo '<hr>';
                   echo '<hr>';
                   echo '<br>';
                   */
                   foreach ($value as $key1 => $value1) {
                       if($key1 != 'errors'){
                           $table .= "<td>$value1</td>";
                		   /*
                		   var_dump($key1);
                           echo '<hr>';
                           var_dump($value1);
                           echo '<hr>';
                           */
                       }
                   }
                   $table .='</tr>';
               }
               $table .= '</table>';
               echo $table;
                ?>

        <div class="show_previous_notes_full_wrap">
        	<article class="prev_notes_art">
        		<div class="head_prev_notes_wrap">
        			<h2 class="head_prev_notes">Your previous notes</h2>
        		</div>
        		<section class="prev_notes_wrap_sec">
        			<div class="all_notes_art_wrap">
        				<article class="note_wrap" id="note1">
        					<div class="note_head_wrap">
        						<h3 class="note_head" title="title of note">How to find adjacent matrix ?</h3>
        					</div><!-- .note_head_wrap  -->
        					<div class="tags_wrap" title="tags">
        						<span class="tag">Matrix</span>
        						<span class="tag">Adjacent matrix</span>
        						<span class="tag">Question on matrix</span>
        					</div><!-- .tags_wrap  -->
        					<div class="accessiblity_wrap">
        						<div class="accessiblity">
        							<span class="accessiblity_name">Private</span>
        						</div>
        					</div><!-- .accessiblity_wrap  -->

        					<section class="note_sec_wrap">
	        					<div class="note_user_info_wrap">
	        						<a href="javascript:void(0)" class="user_page_link no_underline">
	        							<figure class="note_user_info_figure">
	        								<div class="note_user_info_img_wrap">
	        									<img src="https://via.placeholder.com/50" alt="user profile image" class="note_user_info_img">
	        								</div>
	        								<figcaption class="note_user_info_img_figc" title="username">
	        									abhishekml
	        								</figcaption>
	        							</figure>
	        						</a><!-- .user_page_link  -->
                      <span class="date_time_note">
                        thursday, 1 Aug 2020
                      </span>
	        					</div><!-- .note_user_info_wrap  -->

        						<div class="parsed_md_wrap ">
        							<span class="show_more_note_wrap"><span class="show_more_text">Show more</span></span>
        							<div class="parsed_md_text">
        							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat alias labore odit, hic aperiam aliquam accusantium architecto cum ipsa, sapiente velit? A minima, assumenda ullam pariatur aliquid tempore eligendi nemo.
        							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas sequi cum provident culpa obcaecati beatae cupiditate tempora deleniti voluptatibus eveniet ea quae veniam eligendi sapiente quo praesentium similique, ratione inventore numquam doloribus ipsum tenetur libero, laudantium. Harum voluptatum sit minus qui consequuntur laboriosam autem similique error, blanditiis officiis. Cum repellat aspernatur sit rem, eveniet, sed voluptatem enim ut fugiat nesciunt assumenda molestiae odit soluta ea. Inventore ducimus deleniti consectetur dicta culpa esse quis ex, voluptatibus maiores voluptate aliquid natus nisi, temporibus optio. Dolorum unde modi, sapiente fuga. Iure unde rem, qui? Necessitatibus deleniti excepturi unde, porro consequuntur molestiae laboriosam quasi, sed maiores ducimus molestias saepe harum quis illo eum quo hic labore soluta aut, debitis vitae quos! Tempora doloribus corporis ratione voluptatum magni nam! Sed, doloribus, atque. Quam aut in hic nemo illum nam libero ad ea quibusdam dolores ab dolor quae obcaecati repellat, repudiandae labore, provident iure. Ipsam, placeat.
        							</div><!-- .parsed_md_text  -->
        						</div><!-- .parsed_md_wrap  -->
        					</section><!-- .note_sec_wrap  -->

        					<section class="action_wrap_sec">
        						<div class="action_wrap_div">
        							<div class="note_likes_wrap">
        								<div class="note_like_img_wrap">
        									<img src="https://via.placeholder.com/25" alt="Save to pocket" class="note_like_img">
        								</div>
        								<div class="note_number_likes_wrap" title="Number of likes">
		        							<span class="note_number_likes">12</span>
	        							</div>
        								<div class="note_like_btn_wrap">
		        							<span class="note_like_btn">Like</span>
	        							</div>
        							</div><!-- .note_likes_wrap  -->

        							<div class="save_to_pocket_wrap">
        								<div class="save_to_pocket_img_wrap">
        									<img src="https://via.placeholder.com/25" alt="Save to pocket" class="save_to_pocket_img">
        								</div>
        								<div class="save_to_pocket_btn_wrap">
		        							<span class="save_to_pocket_btn" title="Save to pocket for quickly access in future">Save to pocket</span>
	        							</div>
        							</div><!-- .save_to_pocket_wrap  -->

        							<div class="mark_as_imp_wrap">
        								<div class="mark_as_imp_img_wrap">
        									<img src="https://via.placeholder.com/25" alt="Save to pocket" class="mark_as_imp_img">
        								</div>
        								<div class="mark_as_imp_btn_wrap">
		        							<span class="mark_as_imp_btn">Mark as Important</span>
	        							</div>
        							</div><!-- .mark_as_imp_wrap  -->

        							<div class="note_edit_wrap">
        								<div class="note_edit_btn_wrap">
		        							<span class="note_edit_btn">Edit</span>
	        							</div>
        							</div><!-- .note_edit_wrap  -->
        						</div><!-- .action_wrap_div  -->
        						
        					</section><!-- .action_wrap_sec  -->
        				</article><!-- .note_wrap  -->
        				
        			</div>
        		</section><!-- .prev_notes_wrap_sec  -->
        	</article><!-- .prev_notes_art  -->
	        <aside class="right_aside_wrap">
	        	<?php require_once(PUBLIC_PATH . '/user/shared/right_aside_of_create_note_page.include.php'); ?>
	        </aside><!-- .right_aside_wrap  -->
	    </div><!-- .show_previous_notes_full_wrap  -->
        
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
