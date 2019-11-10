<?php


namespace App\DataFixtures\Provider;


use Faker\Provider\Base;

class ProducerProvider extends Base
{
    protected static $images = [
        'avatar1.jpg',
        'avatar2.jpg',
        'avatar3.jpg',
        'avatar4.jpg',
        'avatar5.jpg',
        'avatar6.jpg',
        'avatar7.jpg',
        'avatar8.jpg',
        'avatar9.jpg',
        'avatar10.jpg',
    ];

    public static function producerAvatar()
    {
        return static::randomElement(static::$images);
    }
}
