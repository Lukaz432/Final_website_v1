<?php

namespace App\Users;

use App\App;

class Model
{

    private $table_name = 'users';
    private $db;

    public function __construct()
    {
        App::$db->createTable($this->table_name);
    }

    public function insert(User $user)
    {

        return App::$db->insertRow($this->table_name, $user->getData());
    }

    public function get($conditions)
    {
        $users_objects = [];
        $users_array = App::$db->getRowsWhere($this->table_name, $conditions);
        foreach ($users_array as $user_id => $user_array)
        {
            $user = new User($user_array);
            $user->setId($user_id);

            $users_objects [] = $user;
        }

        return $users_objects;
    }

    public function update(User $user)
    {
        return App::$db->updateRow($this->table_name, $user->getID(), $user->getData());
    }

    public function delete(User $user)
    {
        return App::$db->deleteRow($this->table_name, $user->getID());
    }
}
