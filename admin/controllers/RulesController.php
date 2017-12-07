<?php

namespace pantera\rules\admin\controllers;

use pantera\rules\admin\Module;
use pantera\rules\models\Rule;
use pantera\rules\models\RuleAction;
use pantera\rules\models\RuleSearch;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RulesController implements the CRUD actions for Rule model.
 */
class RulesController extends Controller
{
    /* @var BackendModule */
    public $module;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->permissions,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => RuleAction::className(),
            ],
        ];
    }

    public function actionGetEvents()
    {
        $class = Yii::$app->request->post('depdrop_parents')[0];
        $out = [];
        array_map(function ($item) use (&$out) {
            array_push($out, [
                'id' => $item,
                'name' => $item,
            ]);
        }, $this->module->getEventsOfClass($class));
        return $this->asJson(['output' => $out]);
    }

    /**
     * Lists all Rule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rule();
        $model->status = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $query = RuleAction::find()
            ->where(['=', 'rule_id', $id])
            ->orderBy(['sort' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionCreateAction($id)
    {
        $model = new RuleAction();
        $model->rule_id = $id;
        $model->status = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->asJson(['status' => 'success']);
        }
        return $this->renderAjax('_form_action', [
            'model' => $model
        ]);
    }

    public function actionUpdateAction($id)
    {
        $model = $this->findActionModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->asJson(['status' => 'success']);
        }
        return $this->renderAjax('_form_action', [
            'model' => $model
        ]);
    }

    public function actionDeleteAction($id)
    {
        $this->findActionModel($id)->delete();
        return $this->asJson(['status' => 'success']);
    }

    /**
     * Deletes an existing Rule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findActionModel($id)
    {
        if (($model = RuleAction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
