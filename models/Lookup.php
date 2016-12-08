<?php

namespace backend\modules\lookup\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $code
 * @property string $comment
 * @property integer $active
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property User $updatedBy
 * @property User $createdBy
 */
class Lookup extends \yii\db\ActiveRecord
{
    private $_items=[];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lookup';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'code', 'active', 'sort_order'], 'required'],
            [['code', 'active', 'sort_order', 'created_at', 'created_by', 'updated_by', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['type', 'name'], 'string', 'max' => 100],
            [['type', 'name'], 'unique', 'targetAttribute' => ['type', 'name'], 'message' => 'The combination of Type and Name has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'code' => 'Code',
            'comment' => 'Comment',
            'active' => 'Active',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Returns the items for the specified type.
     * @param string item type (e.g. 'PostStatus').
     * @return array item names indexed by item code. The items are order by their sort_order values.
     * An empty array is returned if the item type does not exist.
     */
    public function items($type)
    {
        if(!isset($this->_items[$type]))
            $this->loadItems($type);
        return $this->_items[$type];
    }

    /**
     * Returns the item name for the specified type and code.
     * @param string the item type (e.g. 'PostStatus').
     * @param integer the item code (corresponding to the 'code' column value)
     * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
     */
    public function item($type,$code)
    {
        if(!isset($this->_items[$type]))
            $this->loadItems($type);
        return isset($this->_items[$type][$code]) ? $this->_items[$type][$code] : false;
    }

    /**
     * Loads the lookup items for the specified type from the database.
     * @param string the item type
     */
    private function loadItems($type)
    {
        $this->_items[$type]=array();
        $models=$this->find()
        ->where([
            'type'=>$type,
            'active'=>1,
        ])
        ->orderBy('sort_order')
        ->all();

        foreach($models as $model)
            $this->_items[$type][$model->code]=$model->name;
    }

}
