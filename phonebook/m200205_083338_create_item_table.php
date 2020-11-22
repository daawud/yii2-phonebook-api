<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item}}`.
 */
class m200205_083338_create_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci';
		$this->createTable('{{%item}}', [
            'id' => $this->primaryKey()->comment('Код ингредиента'),
			'title' => $this->string()->notNull()->unique()->comment('Наименование ингредиента'),
			'active' => $this->integer()->defaultValue('1')->comment('Наличие ингредиента')
        ], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%item}}');
    }
}
