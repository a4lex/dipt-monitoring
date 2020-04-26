<?php


namespace App\Represent;


class JsonRepresentStorage extends AbstractRepresentStorage
{
    function __construct($args)
    {
        throw new \Exception('JSON storage is not ready...');
    }

    protected function init(int $id)
    {
        // TODO: Implement init() method.
    }
}
