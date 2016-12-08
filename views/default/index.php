<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lookups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lookup-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Lookup', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $lookupModel,
        'tableOptions' => ['class'=>'table table-hover table-striped table-condensed'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'type',
            'name',
            'code',
            //'comment:ntext',
            [
                'attribute' => 'active',
                'value' => function($model, $key) {
                    return ($model->active == '1') ? 'Yes' : 'No';
                },
                'filter' => ['1'=>'Yes', '2' => 'No'],
            ],
            'sort_order',
            // 'created_at',
            // 'created_by',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
