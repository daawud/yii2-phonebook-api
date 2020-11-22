<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dish}}`.
 */
class m200204_085757_create_dish_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci';
        $this->createTable('{{%dish}}', [
            'id' => $this->primaryKey()->comment('Код блюда'),
			'title' => $this->string()->notNull()->unique()->comment('Наименование блюда'),
			'active' => $this->integer()->defaultValue('1')->comment('Наличие блюда')
        ], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dish}}');
    }
}
