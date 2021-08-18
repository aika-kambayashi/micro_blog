<?php

class FavoriteRepository extends DbRepository {

    public function getFavesByUserId($user_id) {
        $sql = 'select u.user_id,u.nickname,t.tweet_id,t.body,t.created_at
            from user as u
            join tweet as t
            on u.user_id=t.user_id
            where t.tweet_id in 
            (select tweet_id from favorite where user_id=:user_id)
            order by t.created_at desc';
        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }

    public function deleteTweetId($user_id, $tweet_id) {
        $sql = 'delete from favorite where user_id = :user_id and tweet_id = :tweet_id';
        $stmt = $this->execute($sql, [':user_id' => $user_id, ':tweet_id' => $tweet_id]);
    }

}