<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competence".
 *
 * @property int $id
 * @property string $title
 *
 * @property ResumeCompetence[] $resumeCompetences
 */
class Competence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competence';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeCompetences()
    {
        return $this->hasMany(ResumeCompetence::className(), ['competence_id' => 'id']);
    }
}
