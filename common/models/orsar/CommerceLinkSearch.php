<?php

namespace common\models\orsar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\orsar\CommerceLink;

/**
 * CommerceLinkSearch represents the model behind the search form of `common\models\orsar\CommerceLink`.
 */
class CommerceLinkSearch extends CommerceLink
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'commerce', 'link', 'productId'], 'safe'],
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
        $query = CommerceLink::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,"");

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'commerce', $this->commerce])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'productId', $this->productId]);

        return $dataProvider;
    }
}
