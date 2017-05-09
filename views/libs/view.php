<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\History */

$user = Yii::$app->user;

$this->params['breadcrumbs'][] = ['label' => 'Список книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $book->book_name;
?>
<div class="history-view">

    <h1><?= Html::encode($book->book_name) ?></h1>
    
<?php if(!$user->isGuest) { ?>	
    <div class="row">
	
     <?php if($book->books[0]['access'] or $user->identity->id == $book->books[0]['id_user']) { ?>
		<div class="col-md-2  col-xs-6 " >
			<?= Html::a('Изменить запись', ['update', 'id' =>$book->id], ['id' => 'update_link','class' => 'btn btn-primary']) ?>
		</div>
	 <?php } ?>
	
	
	 <?php if($user->identity->id == $book->books[0]['id_user']) { ?>
		<div class=" col-md-2  col-xs-6 " >
		<?php if(!!$book->books[0]['access']) { ?>
			<?= Html::a('Изменение разрешено', ['#'], ['data-id_book' => $book->id_book,'class' => 'btn-access btn btn-danger ','title' => 'Доступ другим пользователям изменять данные']) ?>
		<?php }else{ ?>
			<?= Html::a('Изменение запрещено', ['#'], ['data-id_book' => $book->id_book,'class' => 'btn-access btn btn-success ','title' => 'Доступ другим пользователям изменять данные']) ?>
		<?php } ?>
		</div>
	 <?php } ?>	
		
		
   </div>
	   
	<br>
 <?php } ?>

 
 
    <?= DetailView::widget([
        'model' => $book,
        'attributes' => [
            [
			    'attribute'=>'book_name',
				'value' => '<span  id="dv_book_name">'.$book->book_name.'</span>',
                'format' => 'raw',
			],
            [
			    'attribute'=>'author',
				'value' => '<span  id="dv_author">'.$book->author.'</span>',
                'format' => 'raw',
			],
			[
			    'attribute'=>'year',
				'value' => '<span  id="dv_year">'.$book->year.'</span>',
                'format' => 'raw',
			],
            [
				'attribute'=>'image',
				'value'=> 'uploads/prev/'.$book->image,
				'format' => ['image',['id' => 'dv_img','width'=>'100','height'=>'100']],
			],
            [
			    'attribute'=>'date',
				'value' => '<span  id="dv_date">'.$book->date.'</span>',
                'format' => 'raw',
			]
        ],
    ]) ?>  

</div>


 <?php if($user->identity->id == $book->books[0]['id_user']) { ?>
<div class="container-fluid">	
	<h3>История изенений</h3>
	
<table class="table table-bordered">
	<thead> 
	<tr> <th>№</th> 
	<th>Кто изменил</th> 
	<th>Название книги</th> 
	<th>Автор книги</th> 
	<th>Год издания</th> 
	<th>Обложка книги</th>
	<th>Дата создания</th> 
	<th></th> 
	</tr> 
	</thead>
	 <tbody> 
	 
	 <?php $i = 1; foreach($model as $values) { ?>
	 <tr>
	     <th scope="row"><?=$i?></th> 
		 <td><?=$values->users->fio?></td> 
		 <td><?=$values->book_name?></td> 
		 <td><?=$values->author?></td> 
		 <td><?=$values->year?></td> 
		 <td>
					<div class=" thumbnail">
						  <img  src="uploads/prev/<?=$values->image?>" width="100" height="100" alt="">
				    </div>
        </td> 
		 <td><?=$values->date ?></td> 
		 <td>
		   
		     <?php if(!!$values->active_ver ) { ?>
	      
		        <button data-id_hist=<?=$values->id?> data-id_book=<?=$values->id_book?> disabled title="Активная версия" type="button" class="btn-hist btn col-xs-12 btn-success btn-xs">
				    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				</button>
			 <?php } else {   ?>	
				 <button data-id_hist=<?=$values->id?> data-id_book=<?=$values->id_book?> title="Нажмите чтобы применить" type="button" class="btn-hist btn col-xs-12 btn-default btn-xs">
				    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				</button>
			 <?php } ?>
		 	
		</td> 
	 </tr>
	 <?php $i++; } ?>
	 
	
	 
	</tbody> 
 </table>
 
</div>
<?php } ?>
