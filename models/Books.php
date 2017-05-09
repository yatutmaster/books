<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_hist
 * @property integer $access
 * @property string $created
 *
 * @property History $idHist
 * @property Users $idUser
 * @property History[] $histories
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user', 'access'], 'integer']
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHist()
    {
        return $this->hasOne(History::className(), ['id' => 'id_hist']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistory()
    {
        return $this->hasMany(History::className(), ['id_book' => 'id']);
    }
}
