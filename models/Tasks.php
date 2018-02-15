<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property string $deadline
 * @property int $id_project
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','deadline'], 'string'],
            [['id_project'], 'required'],
            [['id_project'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'deadline' => 'Deadline',
            'id_project' => 'Id Project',
        ];
    }

    public static function getColor($status)
    {
        switch ($status) {
          case 'done':
            return 'color-done';
            break;
          case 'priority':
              return 'color-priority';
              break;
          case 'none':
              return '';
              break;
          default:
            return '';
            break;
        }
    }

}
