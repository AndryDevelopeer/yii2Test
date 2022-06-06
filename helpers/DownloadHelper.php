<?php

namespace app\helpers;

use Yii;

class DownloadHelper
{
    /**
     * @param string $directory upload directory.
     * @return string path
     */
    public function getFilePath(string $directory = "/upload/excel/"): string
    {
        $fileName = time() . "_table.xlsx";
        $dir = Yii::getAlias('@app') . $directory;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir . $fileName;
    }
}