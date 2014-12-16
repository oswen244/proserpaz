<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title =  $model->nombres. ' ' . $model->apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombres. ' ' . $model->apellidos, 'url' => ['view', 'id' => $model->id_cliente]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="col-md-12">
	<div class="col-md-3">
	    <ul class="nav nav-pills nav-stacked">
	        <li><?= Html::a('Ver información', ['view', 'id' => $model->id_cliente], ['class' => '']) ?></li>
	        <li><?= Html::a('Familiares', ['familiares', 'id' => $model->id_cliente], ['class' => '']) ?></li>
	        <li><a href="">Mensualidad</a></li>
	        <li><a href="">Auxilios</a></li>
	        <li><a href="index">Listar clientes</a></li>
	        <br>
	        <li><?= Html::a('Eliminar cliente', ['delete', 'id' => $model->id_cliente], [
	            'class' => '',
	            'data' => [
	                'confirm' => 'Are you sure you want to delete this item?',
	                'method' => 'post',
	            ],
	            ]) ?>
	        </li>
	    </ul>
	</div>
	<div class="clientes-update col-md-9">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
</div>