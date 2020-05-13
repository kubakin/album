<?php

use Codeception\Lib\Interfaces\Web;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Images */

$this->title = 'Create Images';
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
  

<?= $form->field($model1, 'imageFile')->fileInput();

?>
<?= $this->render('_form', [
        'model' => $model,
        'model1' => $model1
    ]) ?>


<?php ActiveForm::end() ?>
    

</div>
