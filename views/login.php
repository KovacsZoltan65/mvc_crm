<?php

use app\core\form\Button;
use app\core\form\Form;
use app\core\Language;

/**
 * login.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 7:18
 */
/** @var $model \app\models\User */

/** @var $this \app\core\View */
$this->title = Language::trans('login');

?>

<h1><?php echo $this->title; ?></h1>

<?php $form = Form::begin('', 'post'); ?>

<?php 
// ----------------------------
// Email
// ----------------------------
echo $form->field($model, 'email'); 
?>

<?php 
// ----------------------------
// Jelszó
// ----------------------------
echo $form->field($model, 'password')->passwordField();  
?>
<!--
<button type="submit" class="btn btn-primary">Submit</button>
-->
<?php
echo (new Button(['id' => 'btn','class' => 'btn btn-primary','title' => Language::trans('login')]))->submit();
?>

<?php echo Form::end(); ?>