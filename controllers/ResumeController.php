<?php

namespace app\controllers;

use app\models\Competence;
use app\models\ResumeCompetence;
use Yii;
use app\models\Resume;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ResumeController implements the CRUD actions for Resume model.
 */
class ResumeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Resume models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Resume::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Resume model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Resume model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Resume();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $postData = Yii::$app->request->post('Resume');
            $model->saveCompetences($postData['competences']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $competences = ArrayHelper::getColumn(Competence::find()->select('title')->distinct()->all(), 'title');

        return $this->render('create', [
            'model' => $model,
            'competences' => array_combine($competences, $competences)
        ]);
    }

    /**
     * Updates an existing Resume model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->competences = ArrayHelper::getColumn(
            ArrayHelper::getColumn($model->resumeCompetences, 'competence'),
            'title'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Competence::deleteAll(['resume_id' => $model->id]);
            $postData = Yii::$app->request->post('Resume');
            $model->saveCompetences($postData['competences']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $competences = ArrayHelper::getColumn(Competence::find()->all(), 'title');

        return $this->render('update', [
            'model' => $model,
            'competences' => array_combine($competences, $competences)
        ]);
    }

    /**
     * Deletes an existing Resume model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Resume model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resume the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resume::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
