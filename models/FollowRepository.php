<?php

class FollowRepository extends DbRepository {

    public function followArray($user_id) {
        $sql = 'select f1.user_id,f1.nickname,f1.following_count,f2.follower_count,
            case when f3.following_user_id is null then "0" else "1" end as following
        from (
            select u.user_id,u.nickname,count(f.user_id) following_count
            from user u
            left join follow f
            on u.user_id = f.user_id
            group by u.user_id) f1
        left join (
            select u.user_id,count(ff.following_user_id) follower_count
            from user u
            left join follow ff
            on u.user_id = ff.following_user_id
            group by u.user_id) f2        
        on f1.user_id = f2.user_id
        left join (
            select following_user_id from follow where user_id = :user_id
        ) f3
        on f1.user_id = f3.following_user_id
        where f1.user_id <> :user_id;
        ';
        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }

    
    public function follow($user_id, $following_user_id) {
        $sql = 'insert into follow (user_id, following_user_id) values (:user_id, :following_user_id)';
        return $this->execute($sql, [':user_id' => $user_id, ':following_user_id' => $following_user_id]);
    }

}