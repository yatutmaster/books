<?php

namespace app\models;

use Yii;
use app\models\Books;



/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_owner
 * @property integer $id_book
 * @property integer $active
 * @property string $date
 * @property string $book_name
 * @property string $image
 * @property string $author
 *
 * @property Books[] $books
 * @property Books $idBook
 * @property Users $idOwner
 * @property Users $idUser
 */
class History extends \yii\db\ActiveRecord
{
	
	public $access = 0;
	public $imageFile = '';

	const SCENARIO_UPDATE = 'update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }
	

   

    public function scenarios()
    {
		$scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] =  ['year','book_name', 'author'];
    
        return $scenarios;
		
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year','book_name', 'author'], 'required', 'message' => 'Пожалуйста заполните поле'],
            [['access'], 'boolean'],
		    [['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
            [['year'],  'match', 'pattern' => '/^\d{4}$/'],
            [['book_name','author'], 'string', 'max' => 255, 'message' => 'Слишком длинное название']
        ];
    }
	
	

    public function saveBook()
    {
       
			$user_id = 1;///////id авториз польз
			
			$book_model = new Books();
			$book_model->id_user = $user_id;
			$book_model->access = $this->access;
			$book_model->save();
			
			$this->image = $user_id. '_' .uniqid(). '.' . $this->imageFile->extension;
			
			$this->id_book = $book_model->id;
			$this->id_owner = $user_id;
			
			$this->save();
			
		    return  true ;
		
    }
	
    public function insertBook($old_rec)
    {
       
			$user_id = 1;///////id авториз польз
				
			$this->id_book = $old_rec->id_book;
			$this->id_owner = $user_id;
			$this->active_ver = 1;
			
			$this->year = $old_rec->year;
			$this->book_name = $old_rec->book_name;
			$this->image =$old_rec->image;
			$this->author = $old_rec->author;
			$this->imageFile = $old_rec->imageFile;
			
			if(empty($old_rec->imageFile))
			       $this->image = $old_rec->image;
			else   
			       $this->image = $user_id. '_' .uniqid(). '.' . $old_rec->imageFile->extension;
		
		    return  true ;
		
    }

	
	 public function attributeLabels()
    {
        return [
            'book_name' => 'Название книги',
            'author' => 'Автор книги',
        	'year' => 'Год издания',
            'image' => 'Обложка книги', 
			'date' => 'Дата создания записи',
        ];
    }
	  /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['id' => 'id_book']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'id_book']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOwner()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_owner']);
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
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_owner']);
    }
 
}
