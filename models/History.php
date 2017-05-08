<?php

namespace app\models;

use Yii;
use app\models\Books;
use yii\web\UploadedFile;


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

	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
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

	
 
}
