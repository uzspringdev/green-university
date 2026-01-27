<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;

class UserController extends Controller
{
    /**
     * Create admin user
     */
    public function actionCreate($username, $email, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->role = User::ROLE_SUPER_ADMIN;
        $user->permissions = json_encode(array_keys(User::getAllPermissions()));

        if ($user->save()) {
            echo "User created successfully!\n";
            echo "Username: {$username}\n";
            echo "Email: {$email}\n";
            echo "Password: {$password}\n";
            return 0;
        } else {
            echo "Error creating user:\n";
            print_r($user->errors);
            return 1;
        }
    }
}
