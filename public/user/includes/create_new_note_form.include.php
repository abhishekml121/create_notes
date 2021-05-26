	<section class="form_create_new_note_top_center_align">
		<div id="form_create_new_note_top">
		<div class="new_note_subject_wrap">
			<div class="new_note_subject_input">
				<label for="new_note_subject">Subject</label>
				<span class="span_input_wrap">
	    			<input type="text" name="subject_name" id="new_note_subject" maxlength="40" value="<?php echo $note['subject_name'] ?? ''; ?>">
	    		</span>
	    	</div>
		</div>
		<div class="new_note_topic_wrap">
			<div class="new_note_topic_input">
				<label for="new_note_topic">Topic</label>
				<span class="span_input_wrap">
	    			<input type="text" name="topic" id="new_note_topic" value="<?php echo $note['topic'] ?? ''; ?>">
	    		</span>
	    	</div>
		</div>
		<div class="new_note_tag_wrap">
			<div class="new_note_tag_input">
				<label for="new_note_tag">Tag</label>
				<span class="span_for_align_tag">
		    		<input type="text" name="tag_name" id="new_note_tag" value="<?php echo $note['tag_name'] ?? ''; ?>">
					<div class="preview_all_tags">
		    			<?php 
		    			if(isset($note['tag_name'])){
		    				$tags_preview_html = '';
		    				foreach(explode(',', $note['tag_name']) as $value) {
		    					$tags_preview_html .= '<div class="p_tags">
		                <span class="p_tag_info">'.h($value).'</span>
		                <span class="p_tag_close_btn p_tag_close_btn_0">x</span>
		                </div>';
		    				}
		    				echo $tags_preview_html;
		    			}
		    			 ?>
	    			</div>
				</span>
				<aside class="help_tag_wrap">
				<span class="material-icons tag_help_img">help</span>
	        		<?php require_once(PUBLIC_PATH . '/user/includes/create_tag_help.include.php'); ?>
				</aside>   		
	    	</div>
		</div>
		<div class="new_note_access_type_wrap">
			<div class="new_note_access_type_inner">
				<label for="access_type">Access type</label>
				<span class="span_input_wrap">
					<select name="access_type" id="access_type">
						<option value="Public">Pubic</option>
						<option value="Private" <?php if(isset($note['access_type']) && $note['access_type'] == 'Private') echo 'selected' ?>>Private</option>
					</select>
				</span>
			</div>
		</div>
		</div>
	</section><!-- .form_create_new_note_top_center_align -->

	<section class="form_create_new_note_bottom_center_align">
		<div class="note_textarea_wrap">
			<label for="textarea_markdown"><span class="text">Start writing your new note</span><span class="show_formating_help">show tips</span></label>

			<!-- Formating markdown tips --STARTS -->
	        <?php require_once(PUBLIC_PATH . '/user/includes/formating_markdown_help.include.php'); ?>
			
			<!-- Formating markdown tips **************ENDS -->
			<!-- for markdown button --STARTS-->
            <div id="wmd-button-bar"></div>
			<!-- for markdown button ----ENDS-->
			<textarea name="note_markdown" cols="30" rows="10" class="wmd-input" id="wmd-input"><?php echo $note['note_markdown'] ?? ''; ?></textarea>
			<div class="c_note_help_tiny">
				<div class="tiny_help1">
					<span>**bold**</span>
				</div>
				<div class="tiny_help2">
					<span>*italic*</span>
				</div>
				<div class="tiny_help3">
					<span><code>```code```</code></span>
				</div>
			</div><!-- .c_note_help_tiny  -->
		</div>
		<div class="note_parsed_md_wrap">
			<section class="note_parsed_md_sec">
				<!-- <h3 class="preview_parsed_md_head">preview</h3> -->
				<div id="wmd-preview" class="wmd-preview"><?php echo $note['note_html'] ?? ''; ?></div>
			</section>
		</div>
</section><!-- .form_create_new_note_bottom_center_align  -->
