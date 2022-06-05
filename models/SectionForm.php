<?php


    namespace app\models;

    use yii\base\Model;

    class SectionForm extends Model
    {
        public int $id;

        public function attributeLabels()
        {
            return [
                'id' => 'ID раздела'
            ];
        }

        public function rules()
        {
            return [
                ['id', 'required', 'message' => 'Пожалуйсто, введите ID раздела.'],
                ['id', 'integer', 'max' => 999999,],
            ];
        }
    }