<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\models\Category;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CategoryController extends \yii\web\Controller
{
    /**
     * Access Control
     */
    public function behaviors(){
        return[
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex(){
        // Create Query
        $query = Category::find();
        
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount'=>$query->count()
        ]);

        $categories = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'pagination' => $pagination
        ]);

    }

    public function actionCreate()
    {
        $category = new Category();

        if ($category->load(Yii::$app->request->post())) {
            // Validation
            if ($category->validate()) {
                // Save Record
                $category->save();

                // Send Message
                Yii::$app->getSession()->setFlash('success','Category Added');
                // form inputs are valid, do something here
                return $this->redirect('index.php?r=category');
            }
        }

        return $this->render('create', [
            'category' => $category
        ]);
    }
}
