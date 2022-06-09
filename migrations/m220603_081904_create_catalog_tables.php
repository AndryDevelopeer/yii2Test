<?php

use yii\db\Migration;

/**
 * Class m220603_081904_create_catalog_tables
 */
class m220603_081904_create_catalog_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sections = [
            ['parent_id' => 0, 'name' => 'Для ванны'],
            ['parent_id' => 0, 'name' => 'Ногти'],
            ['parent_id' => 2, 'name' => 'Лаки'],
            ['parent_id' => 2, 'name' => 'Лампы для сушки'],
            ['parent_id' => 0, 'name' => 'Кожа'],
            ['parent_id' => 5, 'name' => 'Для рук'],
            ['parent_id' => 5, 'name' => 'Для лица'],
            ['parent_id' => 0, 'name' => 'Парфюмерия'],
        ];
        $sectionFields = ['parent_id', 'name'];

        $this->createTable('{{%sections}}', [
            'id'        => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name'      => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-parent_id',
            'sections',
            'parent_id'
        );

        $this->batchInsert('{{%sections}}', $sectionFields, $sections);

        $products = [
            ['group_id' => 3, 'name' => 'Лак черный', 'marking' => 'ЛЧ2', 'rating' => 1.6],
            ['group_id' => 3, 'name' => 'Лак черный', 'marking' => 'ЛЧ1', 'rating' => 1.5],
            ['group_id' => 4, 'name' => 'Лампа для сушки 300Вт', 'marking' => 'ЛС1', 'rating' => 2.5],
            ['group_id' => 6, 'name' => 'Крем для рук', 'marking' => 'КР1', 'rating' => 5],
            ['group_id' => 7, 'name' => 'Крем для лица ночной', 'marking' => 'КЛ1', 'rating' => 3.5],
            ['group_id' => 3, 'name' => 'Лак красный', 'marking' => 'ЛК2', 'rating' => 4.5],
            ['group_id' => 3, 'name' => 'Абразивный круг', 'marking' => 'АВ2', 'rating' => 5],
            ['group_id' => 3, 'name' => 'Лак синий', 'marking' => 'ЛС2', 'rating' => 5],
            ['group_id' => 3, 'name' => 'Лак прозрачный', 'marking' => 'ЛП2', 'rating' => 2.6],
            ['group_id' => 3, 'name' => 'Лак почти черный черный #000011', 'marking' => 'ЛПЧ2', 'rating' => 3.7],
            ['group_id' => 4, 'name' => 'Лампа 400кВт', 'marking' => 'ЛС3', 'rating' => 4.7],
            ['group_id' => 6, 'name' => 'Крем для ладоней', 'marking' => 'КЛ2', 'rating' => 3.8],
            ['group_id' => 6, 'name' => 'Крем для пальцев', 'marking' => 'КП2', 'rating' => 4.9],
        ];

        $productsFields = ['group_id', 'name', 'marking', 'rating'];

        $this->createTable('{{%products}}', [
            'id'       => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'name'     => $this->string()->notNull(),
            'marking'  => $this->string()->notNull(),
            'rating'   => $this->float(),
        ]);

        $this->addForeignKey(
            'groupId',
            'products',
            'group_id',
            'sections',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-group_id-rating',
            'products',
            ['group_id', 'rating']
        );

        $this->createIndex(
            'idx-group_id-name',
            'products',
            ['group_id', 'name']
        );

        $this->batchInsert('{{%products}}', $productsFields, $products);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*echo "m220603_081904_create_catalog_tables cannot be reverted.\n";

        return false;*/

        $this->dropIndex('idx-parent_id', 'sections');
        $this->dropForeignKey('groupId', 'products');
        $this->dropIndex('idx-group_id-rating', 'products');
        $this->dropIndex('idx-group_id-name', 'products');

        $this->dropTable('{{%sections}}');
        $this->dropTable('{{%products}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220603_081904_create_catalog_tables cannot be reverted.\n";
        return false;
    }
    */
}

