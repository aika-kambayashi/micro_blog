<?php $this->setLayoutVar('title', 'タイムライン画面') ?>

<form action="<?php echo $base_url; ?>/tweet/oneTweet" method="post">

<p>
    <?php foreach($tweet as $t): ?>
        <?php $created_at = date('Y年m月d日 H時i分', strtotime($t['created_at'])); ?>
        <a href="<?php echo $base_url; ?>/tweet/allTweets?user_id=<?php echo $t['user_id']; ?>"><?php echo $t['nickname'];?></a>
        <?php if ($t['favorite'] == '0'): ?>
            <a href="<?php echo $base_url; ?>/tweet/oneTweet?fave_id=<?php echo $t['tweet_id']; ?>&tweet_id=<?php echo $t['tweet_id']; ?>">
            お気に入りに追加</a>
        <?php else: echo ''; endif; ?>
        <br/>
        <?php echo $this->escape($t['body']); ?>
        <br/>
        <a href="<?php echo $base_url; ?>/tweet/oneTweet?tweet_id=<?php echo $t['tweet_id']; ?>"><?php echo $created_at;?></a>
        <hr/>
        <?php endforeach; ?>
</p>
</form>