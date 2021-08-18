<?php $this->setLayoutVar('title', 'ユーザ一覧画面') ?>

<form action="<?php echo $base_url; ?>/follow" method="post">

<table border="1">
<tr bgcolor="#e6b029">
    <th>ユーザ名</th>
    <th>フォロー数</th>
    <th>フォロワー数</th>
    <th>フォロー</th>
</tr>

    <?php foreach ($users as $user): ?>
        <tr>
        <td><a href="<?php echo $base_url; ?>/tweet/allTweets?user_id=<?php echo $user['user_id']; ?>">
            <?php echo $user['nickname'];?></a>
        </td>
        <td>
            <?php echo $user['following_count']; ?>
        </td>
        <td>
            <?php echo $user['follower_count']; ?>
        </td>
        <td>
            <?php if ($user['following'] == '1'): echo 'フォロー中'; ?>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/follow?user_id=<?php echo $user['user_id']; ?>">フォローする</a>
            <?php endif; ?>
        </td>
        </tr>
    <?php endforeach; ?>


