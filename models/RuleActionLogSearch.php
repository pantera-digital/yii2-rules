<?php

namespace pantera\rules\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use const SORT_DESC;

/**
 * RuleActionLogSearch represents the model behind the search form about `pantera\rules\models\RuleActionLog`.
 */
class RuleActionLogSearch extends RuleActionLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'action_id', 'primary_key', 'user_id', 'status'], 'integer'],
            [['message', 'created_at'], 'safe'],
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
        $query = RuleActionLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'action_id' => $this->action_id,
            'primary_key' => $this->primary_key,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ]);

        if ($this->created_at) {
            $dates = explode(' - ', $this->created_at);
            $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
            $stop = date('Y-m-d 23:59:59', strtotime($dates[1]));
            $query->andWhere([
                'AND',
                ['>=', 'created_at', $start],
                ['<=', 'created_at', $stop],
            ]);
        }

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
