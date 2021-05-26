 <footer>
  <div class="footer_div_wrap">
    <div class="footer_logo_web_wrap">
      <img src="<?php echo url_for('/images/logo.svg'); ?>" alt="Website Logo" class="footer_logo_web_img common_img_props">
    </div>
    <p class="website_name_footer"><?php echo SITE_NAME; ?></p>
    <p class="copyright_disclaimer">
	<?php include(SHARED_PATH . '/public_copyright_disclaimer.php'); ?>
  </p>
  </div>
 </footer>
<!--
    * Given below script is used for live reloading when page will save.
    * You should have to delete this script in develepement phase.
     -->
     <script>//document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
    <script src="<?php echo url_for('/js/google_graph.min.js') ?>"></script>
    <script src="<?php echo url_for('/js/main.js'); ?>"></script>
    <script src="<?php echo url_for('/js/graph.js'); ?>"></script>
</body>
</html>

<?php
db_disconnect($database);
?>
