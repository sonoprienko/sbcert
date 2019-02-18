<?php

namespace SBCert\Model;

use SBCert\Table;

class UserType
{
    public static function getAll(array $options = null)
    {
        return Table\UserType::findAll($options);
    }

    public function getById($id)
    {
        return Table\UserType::findById($id);
    }

    public function save($form)
    {
        $type = new Table\UserType([
            'type' => (!empty($form['user_type']) ? $form['user_type'] : NULL),
        ]);
        $type->save();
    }

    public function remove($id)
    {
        $type = Table\User::findById($id);
        if (isset($type->id)) {
            $type->delete();
        }
    }
}