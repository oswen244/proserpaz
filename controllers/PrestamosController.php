<?php

namespace app\controllers;

use Yii;
use app\models\Prestamos;
use app\models\Clientes;
use app\models\PagosPrestamos;
use app\models\PrestamosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PrestamosController implements the CRUD actions for Prestamos model.
 */
class PrestamosController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','indexcl','view'],
                        'roles' => ['leer_prestamos'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','create'],
                        'roles' => ['crear_prestamos'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','update'],
                        'roles' => ['editar_prestamos'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','delete'],
                        'roles' => ['borrar_prestamos'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Prestamos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrestamosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexcl($id) //Renderiza los prestamos en la vista View de un cliente
    {
        $searchModel = new PrestamosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        $cliente = $this->findModelCliente($id);

        return $this->render('indexcl', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_cliente' => $id,
            'nombre_cliente'=>$cliente->nombres.' '.$cliente->apellidos,
        ]);
    }

    /**
     * Displays a single Prestamos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Prestamos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prestamos();
        $pagos = new PagosPrestamos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $pagos->capital = $model->monto;
            $pagos->id_prestamo = $model->id_prestamo;
            $pagos->save();
            return $this->redirect(['index']);
        } else {
            $estados = $this->buscarEstados(); 
            return $this->render('create', [
                'model' => $model,
                'estados'=> $estados,
            ]);
        }
    }

    /**
     * Updates an existing Prestamos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_prestamo]);
        } else {
            $estados = $this->buscarEstados();
            $num_id = $this->idCliente($model->id_cliente);
            return $this->render('update', [
                'model' => $model,
                'estados'=> $estados,
                'num_id'=> $num_id,
            ]);
        }
    }

    /**
     * Deletes an existing Prestamos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $total = $this->isPagos($id);
        if($total==='0'){
            $this->findModel($id)->delete();
            $m = 'Borrado exitoso';
        }else{
            $m = 'Imposible borrar el prestamo, existen pagos asociados!';
        }
        

        return $this->redirect(['index', 'm'=>$m]);
    }

    public function isPagos($id) // Devuelve el número de pagos de un prestamo sí los hay
    {
        $query = (new \yii\db\Query());
        $query->select('COUNT(*)')->from('pagos_prestamos')->where('id_prestamo=:id');
        $query->addParams([':id'=>$id]);
        $total = $query->scalar();

        return $total;
    }

    public function actionGetcliente(){ //obtiene el nombre, apellidos y id de un cliente pasando el número de documento
        $query = (new \yii\db\Query());
        $query->select('id_cliente, nombres, apellidos')->from('clientes')->where('num_id=:documento');
        $query->addParams([':documento'=>$_POST['data']]);
        $cliente = $query->one();
        \Yii::$app->response->format = 'json';

        return $cliente;
    }

    public function buscarEstados() //Lista los estados relacionados con prestamos
    {
        $query = (new \yii\db\Query());
        $query->select('id_estado, nombre')->from('estados')->where('entidad=:entidad');
        $query->addParams([':entidad'=>'Prestamos']);
        $instituciones = $query->all();

        return $instituciones;
    }

    public function idCliente($id) //obtiene el número de identificacion del cliente pasando el id
    {
        $query = (new \yii\db\Query());
        $query->select('num_id')->from('clientes')->where('id_cliente=:id');
        $query->addParams([':id'=>$id]);
        $numero = $query->scalar();

        return $numero;
    }

    /**
     * Finds the Prestamos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prestamos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prestamos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

    protected function findModelCliente($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
