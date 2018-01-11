<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_competence".
 *
 * @property int $id
 * @property int $resume_id
 * @property int $competence_id
 *
 * @property Competence $competence
 * @property Resume $resume
 */
class ResumeCompetence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resume_competence';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resume_id', 'competence_id'], 'default', 'value' => null],
            [['resume_id', 'competence_id'], 'integer'],
            [['competence_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competence::className(), 'targetAttribute' => ['competence_id' => 'id']],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::className(), 'targetAttribute' => ['resume_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'resume_id' => Yii::t('app', 'Resume ID'),
            'competence_id' => Yii::t('app', 'Competence ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetence()
    {
        return $this->hasOne(Competence::className(), ['id' => 'competence_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }
}
