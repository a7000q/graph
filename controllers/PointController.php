<?php

namespace app\controllers;

use app\models\Points;

class PointController extends BaseController
{
    public $modelClass = Points::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }
}