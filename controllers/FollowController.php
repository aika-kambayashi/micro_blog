<?php

class FollowController extends Controller {

    public function repositoryAction() {
        $user = $this->session->get('user');

        if ($this->request->getGet('user_id') !== null) {
            $this->db_manager->get('Follow')->follow($user['user_id'],$this->request->getGet('user_id'));
            return $this->redirect('/');
        }

        $users = $this->db_manager->get('Follow')->followArray($user['user_id']);

        return $this->render([
            'users'  =>  $users,
        ]);
    }

}