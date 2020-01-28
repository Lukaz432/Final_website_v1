<?php

namespace App\Orders;

use App\DataHolder;

Class Order extends DataHolder
{
    private $data;
    private $properties = [
            'id',
            'drink_id',
            'timestamp',
            'status',
        ];

    public function setID(int $id)
    {
        $this->data['id'] = $id;
    }

    public function getID()
    {
        return $this->data['id'] ?? null;
    }

    public function setDrinkID (int $drink_id)
    {
        $this->data['drink_id'] = $drink_id;
    }

    public function getDrinkID ()
    {
        return $this->data['drink_id'];
    }

    public function setTimestamp (int $timestamp)
    {
        $this->data['timestamp'] = $timestamp;
    }

    public function getTimestamp ()
    {
        return $this->data['timestamp'];
    }

    public function setStatus (int $status)
    {
        $this->data['status'] = $status;
    }

    public function getStatus ()
    {
        return $this->data['status'];
    }

    public function setData($data)
    {
        foreach ($this->properties as $property) {
            if (isset($data[$property])) {
                $value = $data[$property];
                $setter = str_replace('_', '', 'set' . $property);

                $this->{$setter} ($value);
            }
        }
//        foreach is equal to the manually written issets below
//        if(isset($data['data'])) $this->setName ($data['name']);
//        if(isset($data['data'])) $this->setAmount ($data['amount']);
//        if(isset($data['data'])) $this->setAbarot ($data['abarot']);
//        if(isset($data['data'])) $this->setImage ($data['image']);
//        if(isset($data['data'])) $this->setPrice ($data['price']);
//        if(isset($data['data'])) $this->setStock ($data['stock']);
    }

    // get data summons all getters (get data, get name, image, etc...)
    public function getData(): array
    {
        $data =[];
        foreach ($this->properties as $property)
        {
            $getter = str_replace('_', '', 'get' . $property);
            $data[$property] = $this->{$getter}();
        }
        return $data;
    }

    public function __construct(array $data = null)
    {
        if ($data) {
            $this->setData($data);
        }
    }


}
