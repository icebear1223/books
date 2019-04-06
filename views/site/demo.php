
<?php 
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\Column;
use yii\widgets\LinkPager;
use yii\db\Query;
use yii\helpers\Html;
?>


<?= Html::a('新增', ["site/entryform"], ['class' => 'btn btn-warning']) ?>


<?php
$query = (new Query())->from('books');
$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 20,
    ]
]);


echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'format' => 'text',
            'label'=> '书名'
        ],
        [
            'attribute' => 'writer',
            'format' => 'text',
            'label'=> '作者'
        ],
        [
            //'label'=> '操作',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    $url = Yii::$app->urlManager->createUrl(["site/update",'id'=>$model['id']]);
                    return Html::a('修改', $url);
                },
                'delete' => function ($url, $model, $key) {
                    $url = Yii::$app->urlManager->createUrl(["site/delete",'id'=>$model['id']]);
                    return Html::a('删除', $url);
                },
            ]
            
        ],
	   
]]
);

?>


