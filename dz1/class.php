<?php


abstract class People
{

    abstract public function save();


    abstract public function new();


    public function getName()
    {
        $names = [
            'Сергей',
            'Юрий',
            'Иван',
            'Елена',
            'Наталья',
        ];

        return $names[array_rand($names)];
    }
}


class Person extends People
{
    public function save()
    {
        return __METHOD__;
    }


    public function new()
    {
        return __METHOD__;
    }


    public function getName()
    {
        return parent::getName() . ' Здорово!';
    }
}


$person = new Person();

echo $person->new();
echo '<br><br>';
echo $person->save();
echo '<br><br>';
echo $person->getName();

