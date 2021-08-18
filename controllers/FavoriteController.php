<?php

class FavoriteController extends Controller {

    public function favoriteAction() {
        $user = $this->session->get('user');

        if ($this->request->getGet('tweet_id') !== null) {
            $this->db_manager->get('Favorite')->deleteTweetId($user['user_id'], $this->request->getGet('tweet_id'));
            return $this->redirect('/favorite');
        }
        
        $tweets = $this->db_manager->get('Favorite')->getFavesByUserId($user['user_id']);
        return $this->render([
            'user'      => $user,
            'tweets'    => $tweets,
        ]);


    }

}