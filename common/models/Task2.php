<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin
 * Date: 04.08.2018
 * Time: 5:58
 */

namespace common\models;

use yii\db\Connection;
use yii\caching\DbDependency;

class Task2
{
    /**
     * @param $date
     * @param $type
     * @return mixed
     */
    public function cachedQuery($date, $type)
    {
        $userId = Yii::$app->user->id;

        return SomeDataModel::getDb()->cache(function (Connection $db) use($date, $type, $userId) {
            $dataList = SomeDataModel::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();

            $result = [];
            if (!empty($dataList)) {
                foreach ($dataList as $dataItem) {
                    $result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
                }
            }

            return $result;
        }, null, new DbDependency([
            'db' =>SomeDataModel::getDb(),
            'sql' => 'SELECT MAX(id), COUNT(*) FROM ' . SomeDataModel::tableName(),
        ]));
    }
}