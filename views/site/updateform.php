<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
	
	<?= Html::activeHiddenInput($model,'id',array('value'=>$val['id'])) ?>

    <?= $form->field($model, 'name')->hint('请输入书名')->label('书名')->input('text',['value'=>$val['name']]) ?>

    <?= $form->field($model, 'writer')->hint('请输入作者')->label('作者')->input('text',['value'=>$val['writer']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>