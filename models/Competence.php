<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competence".
 *
 * @property int $id
 * @property string $title
 * @property int $grade
 * @property int $resume_id
 *
 * @property Resume $resume
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
            [['title', 'grade', 'resume_id'], 'required'],
//            [['grade', 'resume_id'], 'default', 'value' => null],
            [['grade', 'resume_id'], 'integer'],
            [['grade'], 'number', 'min' => 1, 'max' => 5],
            [['title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'grade' => Yii::t('app', 'Grade'),
            'resume_id' => Yii::t('app', 'Resume ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }
}
