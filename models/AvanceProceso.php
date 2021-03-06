<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avance_proceso".
 *
 * @property integer $id_avance
 * @property integer $id_proceso
 * @property string $fecha
 * @property string $hora
 * @property string $avance
 * @property string $archivo
 * @property string $usuario
 *
 * @property ProcesoJuridico $idProceso
 */
class AvanceProceso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'avance_proceso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_proceso', 'fecha', 'hora'], 'required'],
            [['id_proceso'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['avance'], 'string', 'max' => 1000],
            [['archivo'], 'string', 'max' => 80],
            [['usuario'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_avance' => 'Id Avance',
            'id_proceso' => 'Id Proceso',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'avance' => 'Avance',
            'archivo' => 'Archivo',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProceso()
    {
        return $this->hasOne(ProcesoJuridico::className(), ['id_proceso' => 'id_proceso']);
    }
}
