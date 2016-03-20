<?php
if (array_key_exists('logged_in', $user)) {
    $logged = true;
    $user_data = $user['logged_in'];
} else
    $logged = false;
?>


<header >
    <div class="pull-right">
        <?php if ($logged): ?>
            <a><span class="glyphicon glyphicon-user"></span> <?php print_r($user_data['username']); ?></a>
            <a href="<?= base_url(); ?>login/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>                       
        <?php endif; ?>
    </div>
</header>