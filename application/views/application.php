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
        <?php if ($is_admin && $key <= 2): ?>
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
        <div class="well files-table-view">
            <?php if ($files): ?>
                <div class="table-div">
                    <table class="table table-striped files-table">
                        <thead>
                            <tr>
                                <th width = "7px"></th>
                                <th>#</th>
                                <th>File title</th>
                                <th>File size[mb]</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($files as $key => $file):
                                $file_title = $file->title ? $file->title : '';
                                $file_id = $file->id
                                ?>
                                <tr file_id = <?= $file_id; ?>>
                                    <th>
                                        <a class="btn btn-small btn-info ico-button download-btn" title="download" file_id = <?= $file_id; ?>>
                                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                        </a>
                                    </th>
                                    <th scope="row"><?= $key + 1 ?></th>
                                    <td>
                                        <div class = "file-title">
                                            <?= $file_title ?>
                                        </div>
                                        <!--<input class ="hidden" type="text" value="<?= $file_title ?>" width="48" />-->
                                    </td>
                                    <td><?= $file->file_size ? round($file->file_size, 3) : '' ?></td>
                                    <td>
                                        <a class="btn btn-large btn-danger ico-button remove-file pull-right" title="remove" file_id = <?= $file_id; ?>>
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a> 
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>    
                </div>
            <?php else: ?>
                <h2>No files yet!</h2>
            <?php endif; ?>
        </div>

        <script>
            $(document).ready(function () {
                filesGrid.init();
            })
        </script>
        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#fileUploadModal">Upload file</button>
    </div>
</div>

<div id="fileUploadModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog file-upload-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
                    Select file
                </h4>
            </div>
            <?php echo form_open_multipart('file/do_upload'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" name="userfile" size="20" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" value="upload" class="btn btn-success">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url(); ?>src/js/upload.js"></script>
<script src="<?= base_url(); ?>src/js/users.js"></script>
<script src="<?= base_url(); ?>src/js/filesList.js"></script>
<script>
    $(document).ready(userList.init());
    $(document).ready(filesGrid.init());
</script>