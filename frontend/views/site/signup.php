<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

/* @var $types [] */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'type')->dropDownList($types) ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <hr size="1">

            <?= $form->field($model, 'real_name') ?>
            <?= $form->field($model, 'INN')->textInput(['disabled' => $model->type == \common\models\User::TYPE_FIZ]) ?>
            <?= $form->field($model, 'org_name')->textInput(['disabled' => $model->type != \common\models\User::TYPE_ORG]) ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
<?php $this->beginBlock('js') ?>
    let types = {
        fiz: <?= \common\models\User::TYPE_FIZ ?>,
        ip: <?= \common\models\User::TYPE_IP ?>,
        org: <?= \common\models\User::TYPE_ORG ?>,
    };

    let $INN = $('#signupform-inn');
    let $org_name = $('#signupform-org_name')

    $(function () {
        $('#signupform-type').on('change', function () {
            switch (parseInt(this.value)) {
                case types.fiz:
                    $INN.val('').attr({disabled: true});
                    $org_name.val('').attr({disabled: true});
                    break;
                case types.ip:
                    $org_name.val('').attr({disabled: true});
                    $INN.removeAttr('disabled');
                    break;
                case types.org:
                    $INN.removeAttr('disabled');
                    $org_name.removeAttr('disabled');
            }
        });
    });
<?php $this->endBlock() ?>
</script>
<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END) ?>
