<?php $IP = $_SERVER['REMOTE_ADDR'];?>
<html>
	<body style="font-size: 1rem;">
		<main style="max-width: 450px;">
		<header>
			<div style="text-align: right;">
				<a href="<?php echo '';?>"><img src="https://oauth.net/images/code/php.png" style="width: 60px;"></a>
			</div>
		</header>
		<h1>Thankyou for subscription</h1>
		<div style="font-size: 1.3em;">Now you will get notifications about new features in <a href="<?php echo '/';?>" style="display: inline-block;padding: 3px; color: #000000;background-color: #FFC107; text-decoration: none;">Save Note</a> in future.</div>

		<div style="font-size: 1em;margin-top: 5px">
			<span>Note :</span><span>If you did not subscribe us then it means someone (IP: <?php echo $IP;?>) has given your email-ID by mistake.</span>
		</div>
		<div style="margin-top: 20px; font-size: 1.3em;">
			<i>Thankyou !</i><br>
			<i>Save Notes</i>
		</div>
		</main>
	</body>
</html>

