<?php $this->setLayoutVar('title', 'お気に入り一覧画面') ?>

<form action="<?php echo $base_url; ?>/favorite" method="post">

<p><?php echo $user['nickname']; ?>さんのお気に入り</p>
<p>
    <?php foreach ($tweets as $tweet): ?>
        <?php $created_at = date('Y年m月d日 H時i分', strtotime($tweet['created_at'])); ?>
        <a href="<?php echo $base_url; ?>/tweet/allTweets?user_id=<?php echo $tweet['user_id']; ?>"><?php echo $tweet['nickname'];?></a>
        
        <a href="<?php echo $base_url; ?>/favorite?tweet_id=<?php echo $tweet['tweet_id']; ?>" >お気に入り解除</a>
        <br/>
        <?php echo $this->escape($tweet['body']); ?>
        <br/>  
        <a href="<?php echo $base_url; ?>/tweet/oneTweet?tweet_id=<?php echo $tweet['tweet_id']; ?>"><?php echo $created_at;?></a>
        
        <hr/>
    <?php endforeach; ?>
</p>
</form>