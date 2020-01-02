<?php

namespace app\controllers;


use app\models\Points;
use app\models\Route;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class RouteController extends BaseController
{
    public $modelClass = Route::class;

    public function actionShortRoute($from_point_id, $to_point_id){
        $from_point = $this->findPoint($from_point_id);
        $to_point = $this->findPoint($to_point_id);

        $route = new Route($from_point, $to_point);
        return $route->getShortRoute();
    }

    private function findPoint($point_id){
        $point = Points::findOne($point_id);

        if (!$point)
            throw new NotFoundHttpException('no point');

        return $point;
    }
}