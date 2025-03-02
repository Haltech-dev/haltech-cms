<?php

namespace common\models\orsar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\orsar\Upload;

/**
 * UploadSearch represents the model behind the search form of `common\models\orsar\Upload`.
 */
class UploadSearch extends Upload
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'url', 'thumbnail', 'productId'], 'safe'],
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
        $query = Upload::find();

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
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail])
            ->andFilterWhere(['like', 'productId', $this->productId]);

        return $dataProvider;
    }
}
