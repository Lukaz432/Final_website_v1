<?php

namespace Core\Abstracts;

abstract class DataHolder
{
    protected $properties;

    protected function __Construct ()
    {

    }

    abstract protected function setData(array $data);
    abstract protected function getData();
}