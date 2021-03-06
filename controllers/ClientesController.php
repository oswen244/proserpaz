<?php

namespace app\controllers;

use Yii;
use app\models\Clientes;
use app\models\ClientesSearch;
use app\models\Parentezcos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Familiares;
use app\models\FamiliaresSearch;
use yii\filters\AccessControl;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
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
                        'actions' => ['index','view'],
                        'roles' => ['leer_clientes'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view-familiar'],
                        'roles' => ['leer_familiares'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['familiares'],
                        'roles' => ['leer_familiares','crear_familiares','editar_familiares','borrar_familiares'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['leer_mensualidad','editar_mensualidad','crear_mensualidad','borrar_mensualidad','leer_planillas','editar_planillas','crear_planillas','borrar_planillas'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['leer_mensualidad','editar_mensualidad','crear_mensualidad','borrar_mensualidad','leer_planillas','editar_planillas','crear_planillas','borrar_planillas','abog'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['crear_clientes'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create-familiares'],
                        'roles' => ['crear_familiares'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['editar_clientes'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-familiar'],
                        'roles' => ['editar_familiares'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['borrar_clientes'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['deleteFamiliar'],
                        'roles' => ['borrar_familiares'],
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

    public function rangoFecha()
    {
        $fecha = date('Y');
        $fecha_min = strtotime('-65 year', strtotime($fecha));
        $fecha_max = strtotime('-15 year', strtotime($fecha));
        $fecha_min = date('Y', $fecha_min);
        $fecha_max = date('Y', $fecha_max);

        return $fecha_min.':'.$fecha_max;
    }

    /**
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Lists all Client's Familiares models.
     * @param integer $id
     * @return mixed
     */
    public function actionFamiliares($id)
    {
        $familiar = new Familiares();
        $cliente = $this->findModel($id);

        $searchModel = new FamiliaresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('indexFamiliares', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'familiar' => $familiar,
            'id_cliente' => $id,
            'nombre_cliente'=>$cliente->nombres.' '.$cliente->apellidos,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $estados = $this->buscarEstados();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'estados'=>$estados,
        ]);
    }

    /**
     * Displays a single Familiar model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewFamiliar($id,$idc)
    {
        $familiar = new Familiares();

       return $this->render('viewFamiliares', [
            'familiar' => $this->findFamiliar($id),
            'id_cliente' => $idc,
        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clientes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cliente]);
        } else {
            $instituciones = $this->buscarInstituciones();
            $planillas = $this->buscarPlanillas();
            $estados = $this->buscarEstados();
            $rango_fecha = $this->rangoFecha();
            return $this->render('create', [
                'model' => $model,
                'instituciones' => $instituciones,
                'planillas' => $planillas,
                'estados'=>$estados,
                'rango_fecha'=>$rango_fecha,
            ]);
        }
    }

    public function buscarInstituciones()
    {
        $query = (new \yii\db\Query());
        $query->select('id_institucion, nombre')->from('instituciones');
        $instituciones = $query->all();

        return $instituciones;
    }

    public function buscarPlanillas()
    {
        $query = (new \yii\db\Query());
        $query->select('id_planilla')->from('planillas');
        $instituciones = $query->all();

        return $instituciones;
    }

    public function buscarEstados()
    {
        $query = (new \yii\db\Query());
        $query->select('id_estado, nombre')->from('estados')->where('entidad=:entidad');
        $query->addParams([':entidad'=>'Clientes']);
        $instituciones = $query->all();

        return $instituciones;
    }

    public function buscarParentezcos()
    {
        $query = (new \yii\db\Query());
        $query->select('id_parentezco, parentezco')->from('parentezcos');
        $parentezcos = $query->all();

        return $parentezcos;
    }

     /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateFamiliares($id)
    {
        $familiar = new Familiares();

        if ($familiar->load(Yii::$app->request->post()) && $familiar->save()) {
            return $this->redirect(['familiares', 'id' => $id]);
        } else {
            $parentezcos = $this->buscarParentezcos();
            $rango_fecha = $this->rangoFecha();
            return $this->render('createFamiliares', [
                'familiar' => $familiar,
                'id_cliente' => $id,
                'parentezcos' => $parentezcos,
                'rango_fecha'=>$rango_fecha,
            ]);
        }
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cliente]);
        } else {
            $instituciones = $this->buscarInstituciones();
            $planillas = $this->buscarPlanillas();
            $estados = $this->buscarEstados();
            $rango_fecha = $this->rangoFecha();
            return $this->render('update', [
                'model' => $model,
                'instituciones' => $instituciones,
                'planillas' => $planillas,
                'estados'=>$estados,
                'rango_fecha'=>$rango_fecha,
            ]);
        }
    }

    public function actionCambiarEstado()// Cambia el estado de un cliente desde la vista View
    {
        if (Yii::$app->request->post()) 
        {   
            $model = $this->findModel($_POST['id_cliente']);
            $model->id_estado = $_POST['id_estado'];
            if($_POST['id_estado'] === 1){
                $model->fecha_rep = date('Y-m-d'); //fecha_rep es la fecha de referencia cuando un estado cambia
            }

            if(isset($_POST['fecha_ven']))
            {
                $model->fecha_ven = $_POST['fecha_ven'];
                $model->fecha_desafil = date('Y-m-d');
            }else{
                if(isset($_POST['fecha_desafil']))
                {
                    $model->fecha_desafil = $_POST['fecha_desafil'];
                    $model->fecha_ven = null;
                }else{
                    $model->fecha_desafil = null;
                    $model->fecha_ven = null;
                }
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id_cliente]);
            }else{
                return 'No guardó';
            }
        }
    }

     /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateFamiliar($id,$idc)
    {
        $familiar = $this->findfamiliar($id);

        if ($familiar->load(Yii::$app->request->post()) && $familiar->save()) {
            return $this->redirect(['view-familiar', 'id' => $familiar->id_familiar, 'idc'=> $idc]);
        } else {
            $parentezcos = $this->buscarParentezcos();
            $rango_fecha = $this->rangoFecha();
            return $this->render('updateFamiliares', [
                'familiar' => $familiar,
                'id_cliente' => $idc,
                'parentezcos' => $parentezcos,
                'rango_fecha'=>$rango_fecha,
            ]);
        }
    }

    /**
     * Deletes an existing Clientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cliente = $this->findModel($id);
        $cliente->id_estado = 4;

        if($cliente->save()){
            return $this->redirect(['index']);
        }

    }

     /**
     * Deletes an existing Clientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteFamiliar($id)
    {   

        $this->findFamiliar($id)->delete();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findFamiliar($id)
    {
        if (($model = Familiares::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
