<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AvanceProcesoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Avance Procesos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12">
     <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
           <li><?= Html::a('Regresar', ['proceso-juridico/index'], ['class' => '']) ?></li>
        </ul>
    </div>
    <div class="avance-proceso-index col-md-10">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => ['class' => 'text-center'],
            'columns' => [

                // 'id_avance',
                // 'id_proceso',
                'fecha',
                'hora',
                // 'avance',

                // ['class' => 'yii\grid\ActionColumn'],

                [
                'label' => 'Acciones', 
                'vAlign' => 'middle',
                'value' =>  function($model){
                    return  Html::a('', ['view', 'id'=>$model->id_avance, 'id_p'=>$model->id_proceso], ['class' => 'glyphicon glyphicon-eye-open', 'title'=>'Ver']).'&nbsp'.
                            Html::a('', ['update', 'id'=>$model->id_avance,  'id'=>$model->id_proceso], ['class' => 'glyphicon glyphicon-pencil', 'title'=>'Actualizar']).'&nbsp'.
                            Html::a('', ['delete', 'id'=>$model->id_avance,  'id' => $model->id_proceso], ['class' => 'glyphicon glyphicon-trash',
                            'data' => [
                                'confirm' => '¿Está seguro que desea borrar este avance?',
                                'method' => 'post',
                            ],
                            'title'=>'Eliminar',

                        ]);
                },
                'format' => 'raw',
                'options'=>['width'=>'8%'],
            ],
            ],
            'toolbar' => [
                ['content'=>
                   Html::a('Agregar un avance', ['create', 'id_proceso'=>$id_proceso], ['class' => 'btn btn-success']),
                ],
                '{export}',
            ],
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<i class="glyphicon glyphicon-folder-open"></i> Acances del proceso',
            ],
        ]); ?>

    </div>
</div>