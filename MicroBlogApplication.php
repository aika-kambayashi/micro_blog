<?php

class MicroBlogApplication extends Application {
    //認証されていない場合に遷移するコントローラ名とアクションの配列指定
    
    protected $login_action = ['user', 'login'];

    public function getRootDir() {
        return dirname(__FILE__);
    }

    protected function registerRoutes() {
        return [
            '/'
                => ['controller' => 'tweet', 'action' => 'timeline'],
            '/user/:action'
                => ['controller' => 'user'],
            '/tweet/:action'
                => ['controller' => 'tweet'],
            '/follow'
                => ['controller' => 'follow', 'action' => 'repository'],
            '/favorite'
                => ['controller' => 'favorite', 'action' => 'favorite']
        ];
    }

    protected function configure() {
        $this->db_manager->connect('master', [
            'dsn'      => 'mysql:dbname=micro_blog;host=localhost;charset=utf8',
            'user'     => 'root',
            'password' => '',
        ]);
    }
}
