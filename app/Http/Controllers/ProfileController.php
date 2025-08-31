<?php

namespace App\Http\Controllers;

use App\Http\Classes\ProfileClass;

class ProfileController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new ProfileClass();
    }

    public function updateProfile()
    {
        try {
            return response()->json($this->class->updateProfile());
        } catch (\Throwable $th) {
        }
    }

    public function updatePassword()
    {
        try {
            return response()->json($this->class->updatePassword());
        } catch (\Throwable $th) {
        }
    }

    public function getProfileData()
    {
        try {
            return response()->json($this->class->getProfileData());
        } catch (\Throwable $th) {
        }
    }

}
