<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\History */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Список книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
