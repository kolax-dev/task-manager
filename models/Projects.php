<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $name
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
    }

    public function getTasks($id_project)
    {
      return  Yii::$app->db->createCommand("
SELECT t.* FROM tasks t
LEFT JOIN projects p ON t.id_project = p.id
WHERE  p.id = :id_project
ORDER BY t.id DESC
" , [':id_project' => $id_project])->queryAll();
    }
}
