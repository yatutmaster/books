<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\History */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-form">

    <?php $form = ActiveForm::begin([
		'id' => 'form-input-example',
		'options' => [
			'enctype' => 'multipart/form-data' ,
			'class' => 'col-sm-6'
		],
	]); ?>
	

    <?= $form->field($model, 'book_name')->textInput()->label( 'Название книги')  ?>
	
    <?= $form->field($model, 'author')->textInput()->label('Автор книги')  ?>
	
    <?= $form->field($model, 'year')->textInput()
				->label('Год издания')->widget(\yii\widgets\MaskedInput::className(), [
							'mask' => '9999'
	]);  ?>

    <?= $form->field($model, 'access') ->checkbox([
	    'value' => '1',
        'label' => 'Разрешить другим пользователям изменять запись',
    ])?>


    <?= $form->field($model, 'imageFile')->fileInput()->label('Обложка книги') ?>

  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать запись' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	

</div>
