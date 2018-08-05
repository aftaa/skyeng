    <?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drug".
 *
 * @property int $id
 * @property string $name Наименование лекарства
 * @property string $expiration_date Срок годности лек-ва
 *
 * @property DrugIll[] $drugIlls
 * @property Ill[] $ills
 */
class Drug extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drug';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'expiration_date'], 'required'],
            [['expiration_date'], 'safe'],
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
            'name' => 'Наименование лекарства',
            'expiration_date' => 'Срок годности лек-ва',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrugIlls()
    {
        return $this->hasMany(DrugIll::className(), ['drug_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIlls()
    {
        return $this->hasMany(Ill::className(), ['id' => 'ill_id'])->viaTable('drug_ill', ['drug_id' => 'id']);
    }
}
