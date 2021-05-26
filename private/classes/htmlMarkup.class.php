<?php 
/**
 * 
 */
class htmlMarkup
{
	public static function create_new_note(){
		$html = <<<HTML
		    <article class="s_v_note_action_wrap">
		      <div class="go_back_wrap">
		          <button onclick="goBack()"><<< Go Back</button>
		          </div>
		          <div class="create_note_link">
		          <a href="./create_note">Create new note</a>
		        </div>
		    </article>
		HTML;

		return $html;
	}

	public static function otp_form($email_id=''){
		if(isset($email_id)){
			$status_msg = '<div style="text-align:center;margin-bottom:20px;">Write 6 digit OTP which we just sent to '. $email_id . ' </div>';
		}else{
			$status_msg = null;
		}
		
		$html = <<<HTML
		<article class="write_otp">
			<form class="otp_form" id="otp_form">
				{$status_msg}
				<div class="input_otp_div center_form">
					<label for="otp">OTP</label>
					<input type="text" maxlength="6" name="otp" id="otp" class="common_input_styles">
				</div>
				<div class="input-info">
					<i class="otp_info">Didn't get OTP ?</i><i class="resend_otp"> Resend OTP</i> 
				</div>

				<div class="submit_btn_div center_form"><button class="submit_btn otp_send_btn" data-src="otp_send_btn">Submit</button></div>
			</form>
		</article>
		HTML;

		return $html;
	}

	public static function new_paswd_form(){
		$html = <<<HTML
		<article class="write_new_paswd">
			<form class="new_paswd_form" id="new_paswd_form">
				<div style="text-align:center;margin-bottom:20px;">Start writing new password</div>
				<div class="input_paswd_div center_form">
					<label for="new_paswd">New Password</label>
					<input type="password" name="password" id="new_paswd" class="common_input_styles">
				</div>
				<div class="confirm_input_paswd_div center_form">
					<label for="confirm_new_paswd">Confirm New Password</label>
					<input type="password" name="confirm_password" id="confirm_new_paswd" class="common_input_styles">
				</div>

				<div class="submit_btn_div center_form"><button class="submit_btn new_paswd_btn" data-src="new_paswd_btn">Submit</button></div>
			</form>
		</article>
		HTML;

		return $html;
	}
	public static function nav_bar(){
		$div_info =static::create_new_note();
		$html = <<< HTML
		<div class="top_nav_menu_application">
		    <div class="burger_icon_wrap">
			<span class="material-icons burger_icon md-36">expand_more</span>
		    </div>
		<div class="top_nav_menu_info_wrap">
		   {$div_info}
		   </div><!-- .top_nav_menu_info_wrap -->
		</div>
		HTML;

		return $html;
	}

	public static function zero_note_message(){
		$html = 'You do not have any note. Try to ';
		$html .= '<a href="'. url_for('/user/create_note') .'">create new note</a>';
		return $html;
	}

	public static function no_watch_later_note_message(){
		$html = 'You do not have any watch later notes. You can view your ';
		$html .= '<a href="'. url_for('/user/notes') .'">all notes</a>';
		return $html;
	}

	public static function no_imp_note_message(){
		$html = 'You do not have any important notes. You can view your ';
		$html .= '<a href="'. url_for('/user/notes') .'">all notes</a>';
		return $html;
	}
}
 ?>
