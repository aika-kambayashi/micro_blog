<?php

class UserController extends Controller {
    
    protected $auth_actions = ['index', 'logout'];

    public function registerAction() { 
        if ($this->session->isAuthenticated()) {
            return $this->redirect( '/' );
        }
        $mail = '';
        $password = '';
        $passwordCheck = '';
        $nickname = '';
        $errors = [];

        if ($this->request->isPost()) {
            $token = $this->request->getPost('_token');
            if (!$this->checkCsrfToken('user/register', $token)) {
                return $this->redirect('/user/register');
            }
            $mail = $this->request->getPost('mail');
            $password = $this->request->getPost('password');
            $passwordCheck = $this->request->getPost('passwordCheck');
            $nickname = $this->request->getPost('nickname');

            if (!strlen($mail)) {
                $errors[] = 'メールアドレスを入力してください';
            } else if (!preg_match('/^[0-9a-zA-Z_+\.-]+@[0-9a-zA-Z_\.-]+\.[a-zA-Z]+$/', $mail)) {
                $errors[] = 'メールアドレスを入力してください';
            } else if (!$this->db_manager->get('User')->isUniqueMail($mail)) {
                $errors[] = 'メールアドレスは既に使用されています';
            }

            if (!strlen($password)) {
                $errors[] = 'パスワードを入力してください';
            } else if (4 > strlen($password) || strlen($password) > 30) {
                $errors[] = 'パスワードは4～30文字以内で入力してください';
            }
            
            if (!strlen($passwordCheck)) {
                $errors[] = 'パスワード再確認を入力してください';
            } else if ($passwordCheck !== $password ) {
                $errors[] = 'パスワードと再確認は一致していません';
            }

            if (!strlen($nickname)) {
                $errors[] = 'ニックネームを入力してください';
            }
            
            if(count($errors) === 0) {
                $this->db_manager->get('User')->insert($mail, $password, $nickname);
                $this->session->setAuthenticated(true);
                $user = $this->db_manager->get('User')->fetchByMail($mail);
                $this->session->set('user', $user);
                
                
                //登録完了メール
                $to = $mail;
                $sbj = '【新規登録完了】マイクロブログ';

                $msg = "<hr/>新規登録完了のお知らせ<hr/>";
                $msg .= "この度は、「マイクロブログ」をご利用ありがとうございます。";
                $msg .= "このメールは、ユーザ登録が完了したことをご確認頂くためお送りしているものです。";
                $msg .= "<hr/><br/><ul><li>ユーザ情報</li><br/>ユーザ名：" . $mail;
                $msg .= "<br/>パスワード：" . $password;
                $msg .= "</ul><hr/><br/><ul><li>お知らせ</li><br/>";
                $msg .= "ご不明な点がございましたら気軽にご連絡ください。<br/>";
                $msg .= "また、今後とも宜しくお願い申し上げます。<br/><br/>お問い合わせ先<br/>";
                $msg .= "<a href=\"http://localhost:8080/zaiseki/\">http://localhost:8080/zaiseki/</a></ul>";
                
                $hdr = 'Content-Type: text/html;charset=ISO-2022-JP';

                mb_language('ja');
                $sbj = mb_convert_encoding($sbj,'JIS','UTF-8');
                $msg = mb_convert_encoding($msg,'JIS','UTF-8');
                mb_send_mail($to,$sbj,$msg,$hdr);
                //メール設定終了
                
                return $this->redirect('/');
            }
        }
        return $this->render([
            'mail'      => $mail,
            'password'  => $password,
            'passwordCheck' => $passwordCheck,
            'nickname'  => $nickname,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken('user/register')
        ], 'register');
    }
    
    public function editAction() {
        $user = $this->session->get('user');
        if ($this->request->isPost()) {
            $data['user_id'] = $user['user_id'];
            $data['nickname'] = $this->request->getPost('nickname');

            $this->db_manager->get('User')->update($data);
            $user = $this->db_manager->get('User')->fetchByUserId($user['user_id']);
            $this->session->set('user', $user);
            return $this->redirect('/');
        }
        return $this->render([
            'user'      => $user,
        ]);
    }

    public function loginAction() {
        //認証済みならHOME画面へ遷移
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/');
        }
        $mail = '';
        $password = '';
        $errors = [];
        $message = '';

        if ($this->request->getGet('logout') == '1') { 
            $message = 'ログアウトしました';
            return $this->render([
                'mail'      => $mail,
                'password'  => $password,
                'errors'    => $errors,
                'message' => $message
            ]);
        }

        if ($this->request->isPost()) {
            $token = $this->request->getPost('_token');
            if (!$this->checkCsrfToken('user/login', $token)) {
                return $this->redirect('/user/login');
            }
            $mail = $this->request->getPost('mail');
            $password = $this->request->getPost('password');

            if (!strlen($mail))
                $errors[] = 'メールアドレスを入力してください';

            if (!strlen($password)) {
                $errors[] = 'パスワードを入力してください';
            }
            
            if (count($errors) === 0) {
                $user_repository = $this->db_manager->get('User');
                $user = $user_repository->fetchByMail($mail); 
                if (!$user || ($user['password'] !== $user_repository->hashPassword($password))) {
                    $errors[] = 'メールアドレスかパスワードが不正です';
                } else {
                    //認証OKなのでホーム画面遷移
                    $this->session->setAuthenticated(true);
                    $this->session->set('user', $user);
                    return $this->redirect('/');
                }
            }
        }
        return $this->render([
            'mail'      => $mail,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken('user/login'),
            'message'   => $message
        ]);
    }

    public function logoutAction() {
        $this->session->clear();
        $this->session->setAuthenticated(false);
        return $this->redirect('/user/login?logout=1');
    }
}