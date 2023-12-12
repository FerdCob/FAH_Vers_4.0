<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Arrendamiento;

/**
 * ArrendamientoSearch represents the model behind the search form of `common\models\Arrendamiento`.
 */
class ArrendamientoSearch extends Arrendamiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'user_id'], 'integer'],
            [['titulo', 'descripcion'], 'safe'],
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
        $query = Arrendamiento::find();

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
            'precio' => $this->precio,
            'categoria_id' => $this->categoria_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
    
}
