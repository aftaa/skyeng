<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ill".
 *
 * @property int $id
 * @property string $name Название болезние
 *
 * @property DrugIll[] $drugIlls
 * @property Drug[] $drugs
 */
class Ill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название болезние',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrugIlls()
    {
        return $this->hasMany(DrugIll::className(), ['ill_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrugs()
    {
        return $this->hasMany(Drug::className(), ['id' => 'drug_id'])->viaTable('drug_ill', ['ill_id' => 'id']);
    }
}
