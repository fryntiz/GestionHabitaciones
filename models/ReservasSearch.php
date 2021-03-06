<?php

namespace app\models;

use const SORT_DESC;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservas;

/**
 * ReservasSearch represents the model behind the search form of `\app\models\Reservas`.
 */
class ReservasSearch extends Reservas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'habitaciones_id', 'clientes_id'], 'integer'],
            [['fecha_entrada', 'fecha_salida', 'observacion'], 'safe'],
            [['precio'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Reservas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // Ordeno de forma descendiente por ID para tener arriba
            // las nuevas reservas
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'habitaciones'=>$this->habitaciones,
            //'habitaciones_id' => $this->habitaciones_id,
            'fecha_entrada' => $this->fecha_entrada,
            'fecha_salida' => $this->fecha_salida,
            //'clientes_id' => $this->clientes_id,
            'precio' => $this->precio,
        ]);

        $query->andFilterWhere(['ilike', 'clientes', $this->clientes]);
        $query->andFilterWhere(['ilike', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
