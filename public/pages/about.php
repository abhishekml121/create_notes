<?php require_once '../../private/config/initialize.php'; ?>
<?php $page_title = 'About'; ?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
    <main>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(SHARED_PATH . '/public_navbar.include.php'); ?>
        <?php require_once(PUBLIC_PATH .'/user/shared/login_form_popup.include.php'); ?>
        <?php require_once(PUBLIC_PATH .'/user/shared/signup_form_popup.include.php'); ?>

        <div class="about_page_wrap">
        	<div class="user_image_about_wrap">
	        	<div class="user_image user_image_first">
	        		<img src="<?php echo url_for('/images/admin.jpg'); ?>" alt="admin image" class="common_img_props admin_pic">
	        	</div>
	        	<div class="user_name_about_wrap">Abhishek kamal</div>
	        	<div class="user_image user_image_second">
	        		<img src="<?php echo url_for('/images/logo.svg'); ?>" alt="admin image" class="common_img_props">
	        	</div>
        	</div>

        	<!-- FETCHING GREETINGS FROM PHP -->
        	<?php
        	 $greeting = get_greetings();

        	 if($greeting == 1){
        	 	$top = 'good morning';
        	 }else if ($greeting == 2) {
        	 	$top = 'good afternoon';
        	 }else if($greeting == 3){
        	 	$top = 'good evening';
        	 }else{
        	 	$down = 'good night';
        	 }
        	?>
        	<article class="about_page_info_art">
        		<div class="greeting"><span class="hello_g">Hello </span>
        			<?php if(isset($top)){
        				$msg = '<span class="gretting_msg top_gretting_msg">';
        				$msg .= $top;
        				$msg .= '</span>';
        				echo $msg;
        			} ?>
        		</div>
        		<section class="this_web_objective">
        			<div class="this_web_objective_text">
        				<p class="this_web_objective_para">My goal is to save all your information which you read daily on the internet or anywhere about a topic so that whenever you do want all information about that topic you just need to come here and see your notes instead of <big>wasting your time on google</big> again.
        				</p>
        			</div>
    				<?php if(isset($down)){
    					$msg = '<div class="greeting_msg bottom_greeting_msg">';
    					$msg .= $down . ' !';
    					$msg .= '</div>';
    				}else{
    					$msg = '<div class="greeting_msg bottom_greeting_msg">';
    					$msg .= 'God Bless You !';
    					$msg .= '</div>';
    				}
    				echo $msg; ?>
        			
        		</section>
        	</article>

        	<div class="address_contact_wrap">
        		<article class="address_about_wrap">
        			<p class="addr_head"><span>Address</span>
        				<i class="material-icons md-36 strawberry">location_on</i>
        			</p>
        			<div class="addr_info">
        				<div class="addr_info_pincode"><span class="pincode_head lighter_font">Pincode: </span><span class="pincode_text">209101</span></div>
        				<div class="addr_info_country"><span class="country_head lighter_font">Nationality: </span><span class="country_text">Indian</span></div>
        			</div><!-- .addr_info -->
        		</article>

        		<article class="contact_about_wrap">
        			<p class="contact_head"><span>Contact</span>
        				<i class="material-icons md-36 strawberry">perm_phone_msg</i></p>
        			</p>

        			<div class="contact_info">
        				<div class="contact_info_email"><span class="email_head lighter_font">Email: </span><span class="email_text">abhishekkamal1800@gmail.com</span></div>
        				<div class="contact_info_whatsapp">
        					<span class="whatsapp_head lighter_font">Whatsapp: </span>
        					<span class="whatsapp_text">
        						<span class="country_code" title="+91 is the country code of INDIA">+91</span><span class="mobile_number">8317044505</span>
        					</span>
        				</div>
        			</div><!-- .addr_info -->
        		</article>	
        	</div><!-- .address_contact_wrap -->

        	<div class="msg_me_wrap">
        		<div class="txt_area_wrap">
        			<form class="masg_to_admin_form" id="send_msg_to_admin_form">
	        			<label class="mag_me_head" for="msg_admin"><i class="material-icons md-36 strawberry">message</i><span>Message me</span></label>
                        <div class="con_info">
                        <label for="contact_info">Contact info</label>
                            <input type="text" name="contact_info" placeholder="Email ID" id="contact_info">
                        </div>
	        			<textarea class="textarea" placeholder="write your message :)" name="msg" id="msg_admin"></textarea>

	        			<div class="send_btn">
	        				<button class="btn message_to_developer_btn" data-src="message_to_developer_btn">Send Message</button>
	        			</div>
        				
        			</form>
        			
        		</div>
        	</div> <!-- .msg_me_wrap -->

        	<div class="award_me_wrap">
        		<article class="award_me_art">
        			<p class="award_me_head">Give me <span>AWARD</span></p>
        			<div class="gold_award_wrap child_award" data-trophy-id="0">
        				<i class="material-icons md-108 gold-trophy black-shadow no-pointer-event">emoji_events</i>
        			</div>
        			<div class="silver_award_wrap child_award" data-trophy-id="1">
        				<i class="material-icons md-108 silver-trophy black-shadow no-pointer-event">emoji_events</i>
        			</div>
        			<div class="broze_award_wrap child_award" data-trophy-id="2">
        				<i class="material-icons md-108 bronze-trophy black-shadow no-pointer-event">emoji_events</i>
        			</div>

        			<div class="award_send_btn_wrap">
        				<div class="btn_wrap_submit">
        				<button class="btn award_to_deve_btn">Send</button>
        			</div>
        				
        			</div>
        			
        		</article>
        	</div><!-- .award_me_wrap -->
        	
        </div><!-- .about_page_wrap -->
    </main>

<?php require_once(SHARED_PATH . '/public_footer.include.php'); ?>
