<?php

use PharIo\Manifest\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url as HelpersUrl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Images', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class='spisok'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [

            'name',
            'caption',
            'path:image:picture',

            [
            'class' => 'yii\grid\ActionColumn',
           
                'template' => '{view} {update} {delete}',

    'buttons' => [
        'delete' => function ($url, $model, $key) {
            return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                'title' => Yii::t('yii', 'Delete'),
                'data-method' => 'post',
                'data-pjax' => '0',
            ]);
        },
        
            ]
            ]
        ]
    ]); ?>
    
    </div>

</div>
