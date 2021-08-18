<?php

class TweetController extends Controller {

    protected $auth_actions = ['timeline', 'go'];

    public function timelineAction() {
        $user = $this->session->get('user');
        $errors = [];

        if ($this->request->getGet('tweet_id') !== null) {
            $this->db_manager->get('Tweet')->favorite($user['user_id'],$this->request->getGet('tweet_id'));
            return $this->redirect('/');
        }

        $tweets = $this->db_manager->get('Tweet')->getModel();
        if ($this->request->isPost()) {
            $keys = array_keys($tweets);
            foreach ($keys as $key) {
                $tweets[$key] = $this->request->getPost($key);
            }
            if (!strlen($this->request->getPost('body'))){
                return $this->redirect('/');
            }
            $tweets['user_id'] = $user['user_id'];
            $this->db_manager->get('Tweet')->insert($tweets);
            return $this->redirect('/');
        } else {
            $tweets = $this->db_manager->get('Tweet')->getAll($user['user_id']);
        }

        return $this->render([
            'tweets'    => $tweets,
        ]);
    }


    public function allTweetsAction() {
        $user = $this->session->get('user');
        if ($this->request->getGet('tweet_id') !== null) {
            $this->db_manager->get('Tweet')->favorite($user['user_id'],$this->request->getGet('tweet_id'));
        }

        $tweets = $this->db_manager->get('Tweet')->getAllTweets($user['user_id'],$this->request->getGet('user_id'));
        $nickname = implode($this->db_manager->get('Tweet')->getNickname($this->request->getGet('user_id')));
        return $this->render([
            'tweets'    => $tweets,
            'nickname'  => $nickname
        ]);
    }

    public function oneTweetAction() {
        $user = $this->session->get('user');
        if ($this->request->getGet('fave_id') !== null) {
            $this->db_manager->get('Tweet')->favorite($user['user_id'],$this->request->getGet('fave_id'));
        }

        $tweet = $this->db_manager->get('Tweet')->getTweet($user['user_id'],$this->request->getGet('tweet_id'));
        return $this->render([
            'tweet'     => $tweet,
        ]);
    }
}