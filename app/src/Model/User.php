<?php

namespace SBCert\Model;

use SBCert\Table;

class User
{

    const PASS_PREFIX = 'SBCERT-POP-HASH';

    const STATUS_CREATED = 0;

    const STATUS_CONFIRMED = 1;

    public function getById($id)
    {
        return Table\User::findById($id);
    }

    public function save($form, $id = 0, $token = '')
    {
        if ($id) {
            $user = $this->getById($id);
            if (!$user) {
                return 0;
            }

            $user->first_name = (!empty($form['first_name']) ? $form['first_name'] : $user->first_name);
            $user->last_name = (!empty($form['last_name']) ? $form['last_name'] : $user->last_name);
            $user->email = (!empty($form['email']) ? $form['email'] : $user->email);
            $user->pass = (!empty($form['pass'])
                ? $this->createPassword($user->email) : $user->pass);
            $user->type = (!empty($form['type']) ? $form['type'] : $user->type);
            $user->status = (!empty($form['status']) ? $form['status'] : $user->status);

            if ($token && $user->type == 3) {
                $user->status = USER::STATUS_CONFIRMED;
            }
        }
        else {
            $fields = [
                'email' => (!empty($form['email']) ? $form['email'] : NULL),
                'type' => (!empty($form['type']) ? $form['type'] : NULL),
                'status' => USER::STATUS_CREATED,
            ];

            $user = new Table\User($fields);
        }

        $user->save();

        return $user->id;
    }

    public function remove($id)
    {
        $user = Table\User::findById($id);
        if (isset($user->id)) {
            $user->delete();
        }
    }

    private function createPassword($email)
    {
        $key = User::PASS_PREFIX . ':' . $email . ':' . date('U');
        return sha1($key);
    }
}