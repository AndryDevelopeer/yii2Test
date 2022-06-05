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
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            echo "m220603_081904_create_catalog_tables cannot be reverted.\n";

            return false;

            /*$this->dropIndex('idx-parent_id', 'sections');
            $this->dropForeignKey('groupId', 'products');
            $this->dropIndex('idx-group_id-rating', 'products');
            $this->dropIndex('idx-group_id-name', 'products');

            $this->dropTable('{{%sections}}');
            $this->dropTable('{{%products}}');*/
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
