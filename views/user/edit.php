<?php $this->setLayoutVar('title', 'ユーザ情報更新') ?>

<?php if(isset($errors) && count($errors) > 0): ?>
        <?php echo $this->render('errors', ['errors' => $errors]); ?>
<?php endif; ?>

<form action="<?php echo $base_url; ?>/user/edit" method="post">
    <p>ユーザ情報更新</p>
        <table border="1">
        <tr>
            <th bgcolor="#e6b029">ユーザ名</th>
            <td><?php echo $this->escape($user['mail']); ?></td>
        </tr>
        <tr>
            <th bgcolor="#e6b029">ニックネーム</th>
            <td><input type="text" class="form-control" name="nickname" value="<?php echo $this->escape($user['nickname']); ?>" /></td>
        </tr>
        </table>
        <input type="submit" class="btn" value="更新" />
    
</form>