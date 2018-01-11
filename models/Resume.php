<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $competences
 *
 * @property ResumeCompetence[] $resumeCompetences
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
            [['title', 'description', 'competences'], 'required'],
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
            'competences' => Yii::t('app', 'Competences'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeCompetences()
    {
        return $this->hasMany(ResumeCompetence::className(), ['resume_id' => 'id']);
    }

    public function saveCompetences($competences)
    {
        foreach ($competences as $title) {
            $competence = Competence::find()->where(['title' => $title])->one();
            if (!$competence) {
                $competence = new Competence();
                $competence->title = $title;
                $competence->save();
            }

            $resumeCompetence = new ResumeCompetence();
            $resumeCompetence->resume_id = $this->id;
            $resumeCompetence->competence_id = $competence->id;
            $resumeCompetence->save();
        }
    }
}
