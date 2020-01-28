<?php

namespace App\Users;

use App\DataHolder;

class User extends DataHolder
{
    protected $properties = [
        'id',
        'name',
        'email',
        'password',
    ];

    public function setID(int $id)
    {
        $this->data['id'] = $id;
    }

    public function getID()
    {
        return $this->data['id'] ?? null;
    }

    public function setName(string $name)
    {
        $this->data['name'] = $name;
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function setEmail(string $email)
    {
        $this->data['email'] = $email;
    }

    public function getEmail()
    {
        return $this->data['email'];
    }

    public function setPassword(string $password)
    {
        $this->data['password'] = $password;
    }

    public function getPassword()
    {
        return $this->data['password'];
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
