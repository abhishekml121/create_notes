<?php require_once '../private/config/initialize.php'; ?>
<?php $page_title = 'User Notes';
?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
		<?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
		<?php
		/**
		 * [$random_id description]
		 * @var null
		 * if page loads without $_GET['id'] then it will generate
		 * new random id for new note
		 */
		$random_id = NULL;
		$is_admin = false;
		/**
		 * [$private_note description]
		 * @var boolean
		 * if note is private protected then don't show note.
		 */
		$private_note = false;
		$required_paswd = true;
		$paswd_err = false;
		$quick_note = new UserQuickNote;

		if(!isset($_GET['id'])){
			$random_id = generate_random_id();
			$required_paswd = false;
		}else{
			/**
			 * [$filtered_id description]
			 * @var ['/[\w]+/i']
			 * accepting only word characters i.e; [0-9a-zA-Z_]
			 * we are note accepting -(minus sign) for IDs
			 */
			$filtered_id = $quick_note->filter_quick_note_id($_GET['id']);
			$fetch_note = $quick_note->get_note_by_note_id($filtered_id);
			if(!empty($fetch_note)){
				$quick_note = array_shift($fetch_note);
				$quick_note->current_note_ip_address = $quick_note->ip_address;
				$random_id = h($quick_note->note_id);
				//Fetching the owner of current note is the current client which is accesing this note.
				if ($quick_note->check_note_ip_address()) {
					// current user is ADMIN of current note.
					$is_admin = true;					
				}else{
					function reset_obj(){
						global $quick_note;
						$quick_note = new UserQuickNote;
					}
					// current user is [ NOT ] ADMIN of current note.
					// if accesing note is private and user is not admin then do not show note content
					if($quick_note->is_private == 1){
						// do not show content private protected and is not admin.
						// reseting object.
						reset_obj();
						$private_note = true;
						// checking if is post request
					}elseif(is_post_request('q_n_auth_btn', 1)){
						// checking if password is correct
						if(!$quick_note->verify_password($_POST['q_n_paswd'])){
							$paswd_err = true;
							reset_obj();
						}else{
							echo '<div class="paswd_info_wrap"><div class="material-icons md-24 paswd_right_icon">done</div><div class="paswd_correct">Password is correct. You can now access this note (ID: '. $filtered_id .')</div></div>';
							$required_paswd = false;
						}
						}else if(has_presence($quick_note->get_hashed_paswd())){
							reset_obj();
							// echo 'password required to access current note';
							}else{
								$required_paswd = false;
							}
					}
			}else{
				$required_paswd = false;
			}
		}



		if($private_note){
			$html = <<<HTML
			<div class="q_n_private_pro">
				<div class="material-icons md-24 q_n_pri_icon">shield</div>
				<div>This note is private protected.</div>
				<div>You can not access this note !</div>
			</div>
			HTML;
			echo $html;
		}
		?>

		<?php if($required_paswd && !$private_note && !$is_admin) : ?>
		<div class="q_n_paswd_div_wrap">
			<div class="q_n_paswd_auth_info_wrap">
				<div class="material-icons md-24">info_outline</div>
				<div class="q_n_p_a_info">
					This note (ID: <span class="q_n_note_id"><?php echo h($filtered_id) ?></span>) is password protected.
				<div class="q_n_p_a_info2">Write correct password to access this note !</div>
				</div>
			</div>
			<form class="q_n_paswd_input_wrap" method="post">
				<input type="password" id="q_n_paswd_auth" class="only_word_char_input" name="q_n_paswd" value="" placeholder="write password">
				<input type="hidden" name="q_n_note_id" value="<?php echo h($filtered_id); ?>">
					<?php if($required_paswd && $paswd_err): ?>
					<div class="paswd_info_wrap quick_note_error"><div class="paswd_err">Password is not given correct.</div></div>
				<?php endif; ?>
				<div class="submit_btn"><button class="btn" name="q_n_auth_btn" value="1">SUBMIT</button></div>
			</form>
		</div>
	<?php endif;?>
		<section class="quick_note_section">
		<form id="q_n_form">
			<div class="quick_note_wrap">
				<div class="q_n_head">
					<div class="q_n_text_big">Create Quick Note</div>
					<div class="q_n_text_info">Share with others or create for yourself</div>
				</div>

				<section class="q_n_right_side">
					<div class="q_n_save_btn_wrap"><button class="q_n_save_btn" data-src="q_n_save_btn">Save</button></div>
					<div class="split_view_wrap">
						<div class="s_v_box">
							<div class="s_v_divider"></div>
						</div>
					</div>
					<div class="q_n_menu_wrap">
						<span class="material-icons menu_icon">menu</span>
						<?php require_once(PUBLIC_PATH . '/user/includes/quick_note_sidebar.include.php');?>
					</div>
				</section>
			</div>

			<div class="row1_item item2">
				<!-- for markdown button --STARTS-->
				<section class="q_n_write_note">
					<div id="wmd-button-bar"></div>
					<!-- for markdown button ----ENDS-->
					<textarea name="note_markdown" cols="30" rows="10" class="wmd-input" id="wmd-input"><?php echo $quick_note->note_markdown ?? NULL;?></textarea>
				</section>
				<section class="preview_section">
					<div class="preview_note_head">PREVIEW</div>
					<div id="wmd-preview" class="wmd-preview"></div>
				</section>
			</div>
			</form>
		</section>

        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_search_bar.include.php'); ?>

       <?php require_once(PUBLIC_PATH .'/user/shared/login_form_popup.include.php'); ?>
       <?php require_once(PUBLIC_PATH .'/user/shared/signup_form_popup.include.php'); ?>

       <div class="home_info_wrap">
       	<article class="row1 homepage_row">
       		<div class="row1_item item1">
				   <span>Creating <small class="small_note_text">short</small> or <big class="long_note_text">long</big> notes become very easy</span>
			</div>

			<div class="row1_item item10">
				Save or share in just <span class="one_click">one</span> click.
			</div>

       		<div class="row1_item item4">
       			Use <span class="paswd_info">password</span> or make your note as private to protect note from unwanted access.
       		</div>

       		<div class="row1_item item5">
       			<span>Easy to organise/find your notes by <big>tags</big> <big>topics</big> <big>subjects</big></span>
       		</div>
       		<div class="row1_item item6">
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">search</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">label</span>
       			<span class="material-icons md-72 bronze-trophy google-material-icon-shadow">loyalty</span>
       			<span class="material-icons md-72 silver-trophy google-material-icon-shadow">favorite_border</span>
       			<span class="material-icons md-72 strawberry google-material-icon-shadow">favorite</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">subject</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">topic</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">watch_later</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">public</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">public_off</span>
       			<span class="material-icons md-72 gold-trophy google-material-icon-shadow">delete</span>
       		</div>
       	</article>
       	<div class="subscribe_div_wrap">
       		<span class="heading">Subscribe now to get notifications of new features in future</span>
       		<div class="subsc_div_child_wrap">
       			<form id="subsc_form">
       			<div class="email_subsc_wrap">
       				<span class="input_span_psuedo">
       					<input type="email" class="subsc_email" placeholder="email" name="user_email_id">
       				</span>
       			</div>
       			<div class="btn_wrap">
       				<button class="btn subscription_form_btn" data-src="subscription_form_btn">Subscribe</button>
       				
       			</div>
       			</form>
       		</div>
       	</div>
       </div>
    </main>
<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
