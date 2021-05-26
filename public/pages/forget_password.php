<?php require_once '../../private/config/initialize.php';?>
<?php $page_title = 'Change Password';?>
<?php require_once(SHARED_PATH . '/public_doctypeHTML.include.php'); ?>
    <div class="dimlight"></div>
        <?php require_once(SHARED_PATH . '/public_header.include.php'); ?>
        <?php require_once(PUBLIC_PATH .'/user/shared/login_form_popup.include.php'); ?>
        <?php require_once(PUBLIC_PATH .'/user/shared/signup_form_popup.include.php'); ?>

    <main class="main_f_p">
		<header class="forget_password_header">
    		<div class="center_logo">
				<span class="material-icons md-72" style="color:rgb(84,83,83,0.36);">mail</span>
    		</div>
		</header>
		
    	<article class="write_email">
    		<div class="email_form_div">
    			<form class="email_form" id="email_form">
    				<div class="input_email_div center_form">
    					<label for="email">Email</label>
    					<input type="email" name="email" id="email" class="common_input_styles email_input_f_p" autofocus>
    				</div>
    				<div class="input-info">
    					<i>Write your email ID which is registered with this website.</i>
    				</div>

    				<div class="submit_btn_div center_form"><button class="submit_btn email_send_btn" data-src="email_send_btn">Send</button></div>
    			</form>
    		</div>
    	</article>
    </main>
    <?php require_once SHARED_PATH . '/public_footer.include.php';?>

