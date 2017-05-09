<?php


use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Список книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    
    <?php if(!Yii::$app->user->isGuest) { ?>
			<p>
				<?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
			</p>
	<?php } ?>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
              'book_name',
			  'author',
			  'year',
			  [
					'attribute'=>'image',
					'format'=>'raw',
					 'value'=>function ($data) {
                         return '<img src="uploads/prev/'.$data->image.'"  width ="100" />';
					},
            ],
         
			['class' => 'yii\grid\ActionColumn',
            'template' => '{view} ',
						'buttons' => [
								'view' => function ($url,$model) {
										return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', ['view', 'id' =>$model->id_book], ['class' => 'col-xs-12  btn btn-default']) ;
								}
							
						],
            ]
			
        ],
    ]); ?>
</div>
