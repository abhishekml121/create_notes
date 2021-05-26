<?php
require_once '../private/config/initialize.php';

// Log out
$session->logout();

redirect_to(url_for('/'));

?>
