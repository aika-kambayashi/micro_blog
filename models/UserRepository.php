<?php

class UserRepository extends DbRepository {

    public function insert($mail, $password, $nickname) {
        $password = $this->hashPassword($password);
        $now = new DateTime();
        $sql = '
            insert into user(mail,password,nickname,modified_at,created_at) values(:mail,:password,:nickname,:modified_at,:created_at)
        ';
        $stmt = $this->execute($sql, [
            ':mail'         => $mail,
            ':password'     => $password,
            ':nickname'     => $nickname,
            ':modified_at'  => $now->format('Y-m-d H:i:s'),
            ':created_at'   => $now->format('Y-m-d H:i:s')
        ]);
    }

    public function hashPassword($password) {
        return sha1($password . 'SecretKey');
    }
    
    public function fetchByMail($mail) {
        $sql = 'select * from user where mail = :mail';
        return $this->fetch($sql, [':mail' => $mail]);
    }

    public function isUniqueMail($mail) {
        $sql = 'select count(user_id) as count from user where mail = :mail';
        $row = $this->fetch($sql, [':mail' => $mail]);
        if ($row['count'] === '0') {
            return true;
        }
        return false;
    }

    public function isUniqueNickname($nickname) {
        $sql = 'select count(nickname) as count from user where nickname = :nickname';
        $row = $this->fetch($sql, [':nickname' => $nickname]);
        if ($row['count'] === '0') {
            return true;
        }
        return false;
    }

    public function update($user) {
        $sql = 'update user set nickname = :nickname where user_id = :user_id';
        $stmt = $this->execute($sql, $user);
    }

    public function fetchByUserId($user_id) {
        $sql = 'select * from user where user_id = :user_id';
        return $this->fetch($sql, [':user_id' => $user_id]);
    }

}