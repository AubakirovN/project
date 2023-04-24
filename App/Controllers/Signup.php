<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {

        $path_filename_ext = 'uploads/default-ava.png';

        if (($_FILES['avatar']['name'] != "")) {
            $path_filename_ext = $this->prepareAvatar($_FILES['avatar']['name']);
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'birth_date' => $_POST['birth_date'],
            'avatar' => $path_filename_ext,
        ];


        $user = new User($data);

        if ($user->save()) {

            //$user->sendActivationEmail();

            $this->redirect('/project/signup/success');

        } else {

            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Show the signup success page
     *
     * @return void
     */
    public function successAction()
    {
        View::renderTemplate('Signup/success.html');
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/project/signup/activated');
    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');
    }

    public function prepareAvatar($file)
    {
        $target_dir = "uploads/";
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['avatar']['tmp_name'];
        $path_filename_ext = $target_dir . $filename . "." . $ext;

//        if (file_exists($path_filename_ext)) {
//            return false;
//        }
            move_uploaded_file($temp_name, $path_filename_ext);
            return $path_filename_ext;

    }
}
