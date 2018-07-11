<?php

namespace pantera\rules\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RuleSearch represents the model behind the search form about `pantera\rules\models\Rule`.
 */
class RuleSearch extends Rule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['class', 'event', 'comment', 'created_at', 'updated_at', 'name'], 'safe'],
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
        $query = Rule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        if($this->created_at) {
            $dates = explode(' - ', $this->created_at);
            $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
            $stop = date('Y-m-d 23:59:59', strtotime($dates[1]));
            $query->andWhere([
                'AND',
                ['>=', 'created_at', $start],
                ['<=', 'created_at', $stop],
            ]);
        }

        if($this->updated_at) {
            $dates = explode(' - ', $this->updated_at);
            $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
            $stop = date('Y-m-d 23:59:59', strtotime($dates[1]));
            $query->andWhere([
                'AND',
                ['>=', 'updated_at', $start],
                ['<=', 'updated_at', $stop],
            ]);
        }

        $query->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
