<?php $this->setLayoutVar('title', 'タイムライン画面') ?>

<form action="<?php echo $base_url; ?>/" method="post">

<p>いま、何しているの？<br/>
<textarea rows="5" cols="70" maxlength="255" name="body"></textarea><br/>
<input type="submit" class="btn" value="つぶやく">
</p> 

<p>
    <?php foreach ($tweets as $tweet): ?>
        <?php $created_at = date('Y年m月d日 H時i分', strtotime($tweet['created_at'])); ?>
        <a href="<?php echo $base_url; ?>/tweet/allTweets?user_id=<?php echo $tweet['user_id']; ?>"><?php echo $tweet['nickname'];?></a>
        <?php if ($tweet['favorite'] == '0'): ?>
            <a href="<?php echo $base_url; ?>/?tweet_id=<?php echo $tweet['tweet_id']; ?>">お気に入りに追加</a>
        <?php else: echo ''; endif; ?>
        <br/>
        <?php echo $this->escape($tweet['body']); ?>
        <br/>
        <a href="<?php echo $base_url; ?>/tweet/oneTweet?tweet_id=<?php echo $tweet['tweet_id']; ?>"><?php echo $created_at;?></a>
        <hr/>
    <?php endforeach; ?>
</p>
    </form>