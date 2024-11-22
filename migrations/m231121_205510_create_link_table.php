<?php

use yii\db\Migration;

class m231121_205510_create_link_table extends Migration
{
    protected $table = 'link';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'hash' => $this->string(5)->notNull()->comment('Хеш сокращенной ссылки'),
            'original' => $this->text()->notNull()->comment('Оригинальная ссылка'),
        ]);
        $this->addCommentOnTable($this->table, 'Ссылки');

        $this->createIndex(
            'uq-link-hash',
            'link',
            'hash',
            false
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'uq-link-hash',
            'link'
        );

        $this->dropTable($this->table);
    }
}
