<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property array $tmpCompetences
 *
 * @property Competence[] $resumeCompetences
 */
class Resume extends \yii\db\ActiveRecord
{
    public $competences;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resume';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'tmpCompetences'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'tmpCompetences' => Yii::t('app', 'Competences'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetences()
    {
        return $this->hasMany(Competence::className(), ['resume_id' => 'id']);
    }

    public function saveCompetences($competences)
    {
        foreach ($competences as $title) {
            $competence = Competence::find()->where(['title' => $title])->one();
            if (!$competence) {
                $competence = new Competence();
                $competence->title = $title;
                $competence->grade = 1;
                $competence->resume_id = $this->id;
                $competence->save();
            }
        }
    }
}
