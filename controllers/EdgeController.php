<?php

namespace app\controllers;

use app\models\Edges;

class EdgeController extends BaseController
{
    public $modelClass = Edges::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }
}