<?php

namespace SBCert\Model;

use SBCert\Table;

class Token
{

    const SECURITY_TOKEN_PREFIX = 'lfa32!y98ssa';

    protected $token;

    public function __construct($email = '') {
        $this->token = $this->createToken($email);
    }

    public function getById($id)
    {
        return Table\Token::findById($id);
    }

    public function save($user_id = 0)
    {
        if ($user_id) {
            $this->remove($user_id);
            $fields = [
                'token' => $this->token,
                'user_id' => $user_id,
                'created' => date('U'),
            ];

            $token = new Table\Token($fields);
            $token->save();

            return $token->token;
        }
    }

    public function remove($user_id)
    {
        $token = Table\Token::findOne(['user_id' => $user_id]);
        if (isset($token->token)) {
            $token->delete();
        }
    }

    private function createToken($email)
    {
        $timestamp = date('U');
        $key = Token::SECURITY_TOKEN_PREFIX . '_' .$timestamp.  '_' . $email;
        $token = sha1($key);
        return $token;
    }
}