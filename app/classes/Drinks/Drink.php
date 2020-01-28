<?php

namespace App\Drinks;

use App\DataHolder;

class Drink extends DataHolder
{
    protected $properties = [
        'id',
        'name',
        'amount',
        'abarot',
        'image',
        'price',
        'stock',
    ];

    public function setName (string $name)
    {
        $this->data['name'] = $name;
    }

    public function getName ()
    {
        return $this->data['name'];
    }

    public function setAmount (int $amount)
    {
        $this->data['amount'] = $amount;
    }

    public function getAmount ($display = false)
    {
        return $this->data['amount'] . ($display ? 'ml' : '');
    }

    public function setAbarot (float $abarot)
    {
        $this->data['abarot'] = $abarot;
    }

    public function getAbarot ($display = false)
    {
        return $this->data['abarot'] . ($display ? '%' : '');
    }

    public function setImage (string $url)
    {
        $this->data['image'] = $url;
    }

    public function getImage ()
    {
        return $this->data['image'];
    }

    public function setPrice (int $price)
    {
        $this->data['price'] = $price;
    }

    public function getPrice($display = false)
    {
        return $this->data['price'] . ($display ? '€' : '');
    }

    public function setStock (int $stock)
    {
        $this->data['stock'] = $stock;
    }

    public function getStock ()
    {
        return $this->data['stock'];
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

    public function setID(int $id)
    {
        $this->data['id'] = $id;
    }

    public function getID()
    {
        return $this->data['id'] ?? null;
    }
}