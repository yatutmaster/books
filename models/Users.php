<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $fio
 *
 * @property Books[] $books
 * @property History[] $histories
 * @property History[] $histories0
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	

	private $_salt = 'kuku';
	
	const SCENARIO_LOGIN = 'login';
	const SCENARIO_REGIST = 'regist';
	
	public function scenarios()
    {
		$scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] =  ['username','password'];
        $scenarios[self::SCENARIO_REGIST] =  ['username','password', 'fio'];
    
        return $scenarios;
		
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password','fio'], 'required','message' => 'Пожалуйста заполните поле'],
            [['username'], 'string', 'max' => 20,'message' => 'Логин не должен превышать 20 символов'],
            [['fio'], 'string', 'max' => 255],
            [['username'], 'unique','message' => 'Логин уже используется'],
            ['password', 'validatePassword','on' => self::SCENARIO_LOGIN ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'fio' => 'ФИО',
        ];
    }

	 
	public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
			
			$this->password = md5($this->_salt.$this->username.$this->password);
			
            $check = static::findOne(['password' => $this->password]);
               
            if(!$check) {
                $this->addError($attribute, 'Не верно введен логин или пароль.');
            }
        }
    }
	
    public function saveUser()
    {
        
			
			 $this->password = md5($this->_salt.$this->username.$this->password);
			
			 $this->authKey = Yii::$app->security->generateRandomString();
		
			
			 return $this->save();
        
		
		
    }
	

	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::className(), ['id_owner' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistories0()
    {
        return $this->hasMany(History::className(), ['id_user' => 'id']);
    }
}
