<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planillas".
 *
 * @property integer $id_planilla
 * @property integer $numero 
 * @property string $fecha
 * @property string $lugar
 * @property string $unidad
 * @property string $comision_afiliado
 * @property string $por_ant_com
 *
 * @property Clientes[] $clientes
 * @property GastosPlanillas[] $gastosPlanillas
 * @property PromotoresPlanillas[] $promotoresPlanillas
 */
class Planillas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planillas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero', 'fecha', 'comision_afiliado', 'por_ant_com'], 'required'],
            [['numero'], 'integer'],
            [['fecha'], 'safe'],
            [['comision_afiliado', 'por_ant_com'], 'number'],
            [['lugar', 'unidad'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_planilla' => 'Planilla',
            'numero' => 'Número',
            'fecha' => 'Fecha',
            'lugar' => 'Lugar',
            'unidad' => 'Unidad',
            'comision_afiliado' => 'Comisión Afiliado',
            'por_ant_com' => '% Anticipo Comisión',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['id_planilla' => 'id_planilla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGastosPlanillas()
    {
        return $this->hasMany(GastosPlanillas::className(), ['id_planilla' => 'id_planilla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotoresPlanillas()
    {
        return $this->hasMany(PromotoresPlanillas::className(), ['id_planilla' => 'id_planilla']);
    }
}
