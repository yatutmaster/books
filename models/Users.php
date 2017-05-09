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
class Users extends \yii\db\ActiveRecord 
{
	

	private $_salt = 'kuku';
	private $_user = false;
	
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
            [['username'], 'unique','on' => self::SCENARIO_REGIST, 'message' => 'Логин уже используется'],
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
	
	
	public function login()
    {
        if($this->validate()) 
		{
			  return Yii::$app->user->login($this->getUser(),3600*24);
        }
		
		return false;
    }
	
	
	
    public function saveUser()
    {
        
			
			 $this->password = md5($this->_salt.$this->username.$this->password);
			
			 $this->authKey = Yii::$app->security->generateRandomString();
			 
			 if($this->save())
			 {
				  return Yii::$app->user->login($this->getUser(),3600*24);
			 }
		
			 return false;
        
		
    }
	
	 /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
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
