<div class="q_n_m_content">
	<div class="q_n_link"><span class="note_id_tt">Note ID</span>
		<div class="flex_same_line">
			<input type="text" class="q_n_note__id" maxlength="15" name="note_id" value="<?php echo $random_id;?>">
			<span class="material-icons md-18 q_n_info_popup">info_outline</span>
			<div class="q_n_link_right_sidebar_info"><div>Only word characters are valid [<span class="word_char">0-9A-Za-z_</span>] without any space</div></div>
		</div>

	</div>
	<div class="q_n_is_private flex_same_line">
		<input type="checkbox" id="q_n_private" class="q_n_checkbox q_n_private q_n_check_auth" name="is_private" value="1" <?php echo ($quick_note->is_private == 1) ? 'checked': NULL ?>>
		<div class="flex_q_n_info">
			<label for="q_n_private" class="q_n_checkbox_label q_n_private">Private</label>
			<span class="material-icons md-18 q_n_info_popup">info_outline</span>
			<div class="q_n_link_right_sidebar_info"><div>If checked then no one can access this note except you.</div></div>
		</div>
	</div>
	<div class="q_n_editable flex_same_line">
		<input type="checkbox" id="q_n_editable" class="q_n_checkbox q_n_editable" name="is_editable" value="1" <?php echo ($quick_note->is_editable == 1) ? 'checked': NULL ?>>
		<div class="flex_q_n_info">
			<label for="q_n_editable" class="q_n_checkbox q_n_editable">Editable</label>
			<span class="material-icons md-18 q_n_info_popup">info_outline</span>
			<div class="q_n_link_right_sidebar_info"><div>If checked then any user can edit this note. But you can see your original note at any time.</div></div>
		</div>
	</div>
	<div class="q_n_paswd">
		<input type="checkbox" id="q_n_paswd_checkbox" class="q_n_checkbox q_n_paswd_in_ch q_n_check_auth" name="is_paswd_check" value="1" <?php echo (has_presence($quick_note->get_hashed_paswd())) ? 'checked': NULL; ?>><label for="q_n_paswd_checkbox" class="q_n_checkbox q_n_paswd_in_ch">Password</label>
		<div class="q_n_paswd_div_main_wrap">
			<div class="flex_q_n_info flex_same_line">
				<div class="paswd_div_wrap">
					<input type="password" id="q_n_paswd_input" class="q_n_checkbox q_n_paswd_in" name="is_paswd" placeholder="write password" maxlength="15">
					<div class="show_paswd_wrapp">
						<span class="material-icons show_paswd_icon md-18">visibility</span>
					</div>
				</div>
				<span class="material-icons md-18 q_n_info_popup">info_outline</span>
				<div class="q_n_link_right_sidebar_info">
					<ol>
						<li>Only word characters are valid [<span class="word_char">0-9A-Za-z_</span>] without any space.</li>
						<li>Password should not be more than 15 characters.</li>
						<li>If you give password then other users must have to write correct password to access this note.</li>
					</ol>	
				</div>
			</div>
			<div class="paswd_no_mod">You can't modify password later !</div>
		</div>
	</div>
	<div class="q_n_owner"><?php echo ($is_admin == false) ? '<strike>You are ADMIN</strike>' : 'You are ADMIN'; ?></div>
	<div class="q_n_barcode_wrap">
		<div class="q_n_bc_head">
			Bar Code
		</div>
		<div class="q_n_bc">
			<img src="./phpqrcode/temp.php?quick_note_id=">
		</div>
	</div>
</div>
