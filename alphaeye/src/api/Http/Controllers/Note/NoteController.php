<?php namespace Api\Http\Controllers\Note;

use Api\Http\Controllers\ApiController;
use Api\Logics\NoteLogic;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16/12/9
 * Time: 下午6:36
 */

class NoteController extends ApiController
{
    protected $noteLogic;

    public function __construct(NoteLogic $noteLogic)
    {
        $this->noteLogic = $noteLogic;
    }

    public function index()
    {
        return view('note.index');
    }

    public function show()
    {
        return view('note.index');
    }

    public function getFolders()
    {
        $folders = $this->noteLogic->getFolders();

        return $folders;
    }
}