<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuxiliosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = 'Auxilios';
?>
<div class="auxilios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => ['class' => 'text-center'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_auxilio',
            [
                'attribute' => 'id_cliente',
                'label'=>'Documento',
                'value' => function($model){
                    return $model->idCliente->num_id;
                },
            ],
            [
                'attribute' => 'id_cliente',
                'label'=>'Nombres',
                'value' => function($model){
                    return $model->idCliente->nombres;
                },
            ],
             [
                'attribute' => 'id_cliente',
                'label'=>'Apellidos',
                'value' => function($model){
                    return $model->idCliente->apellidos;
                },
            ],
            // 'tipo',
            // 'porcentaje_aux',
            [
                'attribute' => 'monto',
                'value' => function($data){ return "$ ".number_format($data->monto,0);}
            ],
             [
                'attribute' => 'tipo_auxilio',
                'label'=>'Tipo de auxilio',
                'value' => function($model){
                    return $model->tipoAuxilio->tipo_auxilio;
                },
            ],
            // 'num_meses',
            'fecha_auxilio',
            // 'proveedor',
            // 'estado',
            'id_familiar',

            [
                    'label' => '', 
                    'vAlign' => 'middle',
                    'value' =>  function($data){
                        return  Html::a('', ['update', 'id'=>$data->id_auxilio, 'tipo' => $data->tipo], [
                            'class' => 'act glyphicon glyphicon-pencil', 
                        ]).'&nbsp'.Html::a('', ['delete', 'id' => $data->id_auxilio, 'tipo' => $data->tipo], [
                            'class' => 'act glyphicon glyphicon-trash',
                                'data' => [
                                    'confirm' => '¿Está seguro que desea borrar este auxilio?',
                                    'method' => 'post',
                                ]
                            ]);;
                    },
                    'format' => 'raw',
                    'options'=>['width'=>'5%'],
            ],
        ],
        'toolbar' => [
            ['content'=>
                Html::a('Crear auxilio exequial', ['create', 'tipo'=> $tipo], ['class' => 'btn btn-success'])
            ],
            '{export}',
        ],
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<i class="glyphicon glyphicon-usd"></i>  Auxilio exequial ',
        ],
    ]); ?>

</div>
