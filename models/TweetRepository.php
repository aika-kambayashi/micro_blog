<?php

class TweetRepository extends DbRepository {

    public function getModel() {
        return [
            'user_id'   => '',
            'body'      => ''
        ];
    }
    
    public function getAll($user_id) {
        $sql = 'select t.tweet_id,t.user_id,t.body,t.created_at,u.nickname,
            case when f.tweet_id is null then "0" else "1" end as favorite
        from (
            tweet as t
            join user as u
            on t.user_id = u.user_id)
        left join (
            select tweet_id from favorite where user_id = :user_id) f
            on t.tweet_id = f.tweet_id
        order by t.created_at desc;
        ';
        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }

    public function getAllTweets($user_id,$tweet_user_id) {
        $sql = 'select u.user_id,u.nickname,t.tweet_id,t.body,t.created_at,
            case when f.tweet_id is null then "0" else "1" end as favorite
            from tweet as t
            join user as u
            on t.user_id=u.user_id
            left join (
                select tweet_id from favorite where user_id = :user_id ) f
                on t.tweet_id = f.tweet_id
            where u.user_id=:tweet_user_id
            order by t.created_at desc';
        return $this->fetchAll($sql, [':user_id' => $user_id, ':tweet_user_id' => $tweet_user_id]);
    }

    public function getTweet($user_id,$tweet_id) {
        $sql = 'select u.user_id,u.nickname,t.tweet_id,t.body,t.created_at,
            case when f.tweet_id is null then "0" else "1" end as favorite
            from tweet as t
            join user as u
            on t.user_id=u.user_id
            left join (
                select tweet_id from favorite where user_id = :user_id) f
                on t.tweet_id = f.tweet_id
            where t.tweet_id = :tweet_id';
        return $this->fetchAll($sql, [':user_id' => $user_id, ':tweet_id' => $tweet_id]);
    }

    public function getNickname($user_id) {
        $sql = 'select nickname from user where user_id = :user_id';
        return $this->fetch($sql, [':user_id' => $user_id]);
    }

    public function insert($tweets) {
        $sql = '
            insert into tweet
                (user_id, body)
            values
                (:user_id, :body)
        ';
        $stmt = $this->execute($sql, $tweets);
    }

    public function favorite($user_id,$tweet_id) {
        $sql = '
            insert into favorite
                (user_id, tweet_id)
            values
                (:user_id, :tweet_id)
        ';
        $stmt = $this->execute($sql, [':user_id' => $user_id, ':tweet_id' => $tweet_id]);
    }
}