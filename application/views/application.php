<?php
if (array_key_exists('logged_in', $user)) {
    $logged = true;
    $user_data = $user['logged_in'];
} else
    $logged = false;
$is_admin = $current_user['rights'] == 'admin';
$curr_user_id = $current_user['id'];
?>



<div class="container">
    <div class="jumbotron">
        <div class="container">
            <h3>Group users</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($group_users as $key => $user):
                        $login = $user['username'] ? $user['username'] : '';
                        $email = $user['email'] ? $user['email'] : '';
                        $user_id = $user['id'] ? $user['id'] : '';
                        ?>

                        <tr>
                            <td><?= $login ?></td>
                            <td><?= $email ?></td>

                            <td>
                                <?php if ($curr_user_id != $user_id && $is_admin): ?>
                                    <a class="btn btn-sm btn-danger ico-button remove-user pull-right" title="remove" data-user-id = <?= $user_id; ?>>
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </a> 
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php  if ($is_admin && $key <=2): ?>
            <div class="container">
                <p>Add user:</p>
                <form class="form-inline add-user-form">
                    <div class="form-group">
                        <label for="addUserLogin">Name</label>
                        <input type="text" name="username" class="form-control" id="addUserLogin" placeholder="Jane Doe">
                    </div>
                    <div class="form-group">
                        <label for="addUserEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="addUserEmail" placeholder="jane.doe@example.com">
                    </div>
                    <button type="submit" class="btn btn-default">Add</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="container">
    <div class="jumbotron">
        <h3>Shared files list</h3>    
    </div>
</div>

<script src="<?= base_url(); ?>src/js/users.js"></script>
<script>
$(document).ready(userList.init());
</script>