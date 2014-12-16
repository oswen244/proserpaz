<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property integer $id_cliente
 * @property string $num_afiliacion
 * @property string $fecha_afiliacion
 * @property string $nombres
 * @property string $apellidos
 * @property string $tipo_id
 * @property string $num_id
 * @property string $genero
 * @property string $lugar_exp
 * @property string $fecha_nacimiento
 * @property string $grado
 * @property string $pais
 * @property string $ciudad
 * @property string $email
 * @property string $direccion
 * @property string $telefono
 * @property integer $id_institucion
 * @property integer $id_planilla
 * @property integer $id_estado
 * @property string $monto_paquete
 * @property string $observaciones
 *
 * @property Auxilios[] $auxilios
 * @property Estados $idEstado
 * @property Instituciones $idInstitucion
 * @property Planillas $idPlanilla
 * @property Familiares[] $familiares
 * @property Mensualidades[] $mensualidades
 * @property Prestamos[] $prestamos
 * @property ProcesoJuridico[] $procesoJuridicos
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_afiliacion', 'nombres', 'apellidos', 'tipo_id', 'num_id', 'genero', 'id_institucion', 'id_planilla', 'id_estado', 'monto_paquete'], 'required'],
            [['fecha_afiliacion', 'fecha_nacimiento'], 'safe'],
            [['id_institucion', 'id_planilla', 'id_estado'], 'integer'],
            [['monto_paquete'], 'number'],
            [['num_afiliacion', 'nombres', 'apellidos', 'tipo_id', 'num_id', 'lugar_exp', 'grado', 'pais', 'ciudad', 'email', 'direccion', 'telefono'], 'string', 'max' => 45],
            [['genero'], 'string', 'max' => 1],
            [['observaciones'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'Id Cliente',
            'num_afiliacion' => 'Num Afiliacion',
            'fecha_afiliacion' => 'Fecha Afiliacion',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'tipo_id' => 'Tipo ID',
            'num_id' => 'Num ID',
            'genero' => 'Genero',
            'lugar_exp' => 'Lugar Exp',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'grado' => 'Grado',
            'pais' => 'Pais',
            'ciudad' => 'Ciudad',
            'email' => 'Email',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'id_institucion' => 'Id Institucion',
            'id_planilla' => 'Id Planilla',
            'id_estado' => 'Id Estado',
            'monto_paquete' => 'Monto Paquete',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuxilios()
    {
        return $this->hasMany(Auxilios::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(Estados::className(), ['id_estado' => 'id_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInstitucion()
    {
        return $this->hasOne(Instituciones::className(), ['id_institucion' => 'id_institucion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanilla()
    {
        return $this->hasOne(Planillas::className(), ['id_planilla' => 'id_planilla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFamiliares()
    {
        return $this->hasMany(Familiares::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensualidades()
    {
        return $this->hasMany(Mensualidades::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamos::className(), ['id_cliente' => 'id_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoJuridicos()
    {
        return $this->hasMany(ProcesoJuridico::className(), ['id_cliente' => 'id_cliente']);
    }
}