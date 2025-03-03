<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JobOpenings;

/**
 * JobOpeningSearch represents the model behind the search form of `common\models\JobOpenings`.
 */
class JobOpeningSearch extends JobOpenings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['title', 'position', 'description', 'company_name', 'location', 'work_type', 'experience', 'education', 'age', 'skills', 'stages', 'document', 'salary_range', 'job_type', 'posted_at', 'expires_at', 'created_at', 'updated_at', 'deleted_at', 'email', 'gform_link', 'image_url'], 'safe'],
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
        $query = JobOpenings::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, "");

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'posted_at' => $this->posted_at,
            'expires_at' => $this->expires_at,
            'status_active' => 1,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'work_type', $this->work_type])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'age', $this->age])
            ->andFilterWhere(['like', 'skills', $this->skills])
            ->andFilterWhere(['like', 'stages', $this->stages])
            ->andFilterWhere(['like', 'document', $this->document])
            ->andFilterWhere(['like', 'salary_range', $this->salary_range])
            ->andFilterWhere(['like', 'job_type', $this->job_type])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gform_link', $this->gform_link])
            ->andFilterWhere(['like', 'image_url', $this->image_url]);

        return $dataProvider;
    }
}
