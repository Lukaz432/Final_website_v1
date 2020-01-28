<?php

namespace App;

class DataHolder extends \Core\Abstracts\DataHolder
{

    public function setData(array $data)
    {
        foreach ($this->properties as $property) {
            if (isset($data[$property])) {
                $value = $data[$property];
                $setter = str_replace('_', '', 'set' . $property);

                $this->{$setter} ($value);
            }
        }
    }

    public function getData()
    {
        $data = [];
        foreach ($this->properties as $property) {
            $getter = str_replace('_', '', 'get' . $property);
            $data[$property] = $this->{$getter}();
        }
        return $data;
    }
}