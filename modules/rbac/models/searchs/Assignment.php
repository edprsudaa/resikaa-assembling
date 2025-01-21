<?php

namespace app\modules\rbac\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AssignmentSearch represents the model behind the search form about Assignment.
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Assignment extends Model
{
    public $userid;
    public $username;
    public $nama;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid'], 'integer'],
            [['username', 'nama'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $class, $usernameField)
    {
        /* @var $query \yii\db\ActiveQuery */
        // $class = Yii::$app->getUser()->identityClass ? : 'app\modules\rbac\models\User';
        $class = Yii::$app->getUser()->identityClass ?: 'app\models\auth\User';
        $query = $class::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['setting']['paging']['size']['long']
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
