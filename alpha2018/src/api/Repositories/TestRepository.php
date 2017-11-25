<?php namespace Api\Repositories;
use Api\Models\Component\File;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/2/20
 * Time: 上午10:11
 */
class TestRepository extends File
{
    public function saveFile()
    {
        $file = new $this;

    }
}