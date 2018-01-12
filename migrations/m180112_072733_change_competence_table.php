<?php

use yii\db\Migration;

/**
 * Class m180112_072733_change_competence_table
 */
class m180112_072733_change_competence_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropTable('resume_competence');
        $this->dropIndex('unique_competence', 'competence');
        $this->addColumn('competence', 'grade', $this->integer()->notNull());
        $this->addColumn('competence', 'resume_id', $this->integer()->notNull());
        $this->addForeignKey(
            'fk_competence_resume_id',
            'competence',
            'resume_id',
            'resume',
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
        echo "m180112_072733_change_competence_table cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180112_072733_change_competence_table cannot be reverted.\n";

        return false;
    }
    */
}
