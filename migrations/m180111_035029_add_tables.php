<?php

use yii\db\Migration;

/**
 * Class m180111_035029_add_tables
 */
class m180111_035029_add_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('resume', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull()
        ]);
        $this->createTable('competence', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
        ]);
        $this->createIndex('unique_competence', 'competence', 'title', true);
        $this->createTable('resume_competence', [
            'id' => $this->primaryKey(),
            'resume_id' => $this->integer(),
            'competence_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk_rc_resume_id',
            'resume_competence',
            'resume_id',
            'resume',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_rc_competence_id',
            'resume_competence',
            'competence_id',
            'competence',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('resume_competence');
        $this->dropTable('competence');
        $this->dropTable('resume');
    }
}
