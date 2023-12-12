<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Auditoria;

/**
 * AuditoriaSearch represents the model behind the search form of `backend\models\Auditoria`.
 */
class AuditoriaSearch extends Auditoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fecha_hora', 'usuario', 'email', 'titulo', 'nombre_arrendamiento'], 'safe'],
            [['precio'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Auditoria::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'fecha_hora' => $this->fecha_hora,
            'precio' => $this->precio,
        ]);

        $query->andFilterWhere(['like', 'usuario', $this->usuario])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'nombre_arrendamiento', $this->nombre_arrendamiento]);

        return $dataProvider;
    }
    public function isEmpty()
    {
        foreach ($this->attributes() as $attribute) {
            if (!empty($this->$attribute)) {
                return false;
            }
        }
        return true;
    }
}
