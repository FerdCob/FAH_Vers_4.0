<?php
// frontend/models/ConfirmDeleteForm.php

namespace frontend\models;

use yii\base\Model;

class ConfirmDeleteForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            [['password'], 'required'],
        ];
    }
}
