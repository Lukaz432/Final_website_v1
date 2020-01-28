<?php

namespace App\Drinks;

use App\App;

class Model
{

    private $table_name = 'drinks';
    private $db;

    public function __construct()
    {
        App::$db->createTable($this->table_name);
    }

    public function insert(Drink $drink)
    {

        return App::$db->insertRow($this->table_name, $drink->getData());
    }

    public function get($conditions)
    {
        $drinks_objects = [];
        $drinks_array = App::$db->getRowsWhere($this->table_name, $conditions);
        foreach ($drinks_array as $drink_id => $drink_array) {
            $drink = new Drink($drink_array);
            $drink->setId($drink_id);

            $drinks_objects [] = $drink;
        }

        return $drinks_objects;
    }

    public function update(Drink $drink)
    {
        return App::$db->updateRow($this->table_name, $drink->getID(), $drink->getData());
    }

    public function delete(Drink $drink)
    {
        return App::$db->deleteRow($this->table_name, $drink->getID());
    }

    public function getByID($id)
    {
        $drink_data = App::$db->getRow($this->table_name, $id);
        $drink = new Drink($drink_data);
        $drink->setID($id);

        return $drink;
    }
}