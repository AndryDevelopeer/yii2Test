<?php


    namespace app\controllers;


    use app\models\Products;
    use app\models\Sections;

    class ProductController
    {
        public static function getProductsByIdSection($id)
        {
            $sectionsId = [];
            $items = [];
            $query = Sections::find();
            $sections = $query
                ->select(['id', 'name', 'parent_id'])
                ->all();

            foreach ($sections as $section) {
                $items[$section->parent_id][] = [
                    'id'        => $section->id,
                    'name'      => $section->name,
                    'parent_id' => $section->parent_id
                ];
            }
            function RecursiveTree(array $items, int $parent, array &$sectionsId): array
            {
                $result = [];
                if (!isset($items[$parent])) return $result;
                foreach ($items[$parent] as $item) {
                    $children = RecursiveTree($items, $item['id'], $sectionsId);
                    if ($children) $item['children'] = $children;
                    if ($parent === 0)
                        foreach ($children as $child)
                            $sectionsId[$child['id']] = $child['id'];
                    else
                        $sectionsId[$item['id']] = $item['id'];
                    $result[$item['id']] = $item;
                }
                return $result;
            }

            RecursiveTree($items, $id, $sectionsId);

            $queryProduct = Products::find();
            return $queryProduct
                ->select(['id', 'group_id', 'name', 'marking', 'rating'])
                ->orderBy(['rating' => 'DESC'])
                ->where(['group_id' => $sectionsId ?: $id])
                ->all();
        }
    }