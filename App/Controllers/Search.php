<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;



/**
 * Profile controller
 *
 * PHP version 7.0
 */
class Search extends Authenticated
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function list()
    {
        $allUsers = User::getAll();
        View::renderTemplate('Search/list.html', [
            'users' => $allUsers
        ]);
    }

    public function search()
    {

        $result = User::findByID($_POST['search']);
        if(!$result){
            $result = User::findByEmail($_POST['search']);
        }
        View::renderTemplate('Search/result.html', [
            'user' => $result,
        ]);
    }


}
