<?php

namespace app\helpers;

use app\models\Products;
use app\models\Sections;

class ProductHelper
{
    public function getProductsBySectionId(int $id)
    {
        $currentLevel = [$id];
        $descendantSectionIds = [];
        do {
            $descendantSectionIds = array_merge($descendantSectionIds, $currentLevel);
            $children = Sections::find()
                ->select(['id'])
                ->indexBy('id')
                ->andWhere(['parent_id' => $currentLevel])
                ->column();
            $currentLevel = $children;
        } while ($children);

        return Products::find()
            ->select(['id', 'group_id', 'name', 'marking', 'rating'])
            ->orderBy(['rating' => SORT_ASC, 'name' => SORT_ASC])
            ->where(['group_id' => $descendantSectionIds])
            ->all();
    }
}
