<?php
if (array_key_exists('logged_in', $user)) {
    $logged = true;
    $user_data = $user['logged_in'];
} else
    $logged = false;
?>
