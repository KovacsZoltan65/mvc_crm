<?php

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\form\Select;
use app\core\Language;

/**
 * company_new.php
 * User: kzoltan
 * Date: 2022-07-05
 * Time: 08:30
 */

$this->title = Language::trans('company_new');

?>

<h1><?php echo $this->title; ?></h1>

<?php $form = Form::begin('', 'post');

echo $form->field($model, "id")->hiddenField();

// ----------------------------
// Cég neve
// ----------------------------
echo $form->field($model, 'name');

// ----------------------------
// Select
// ----------------------------
/*
echo (new Select($model, [
    'id' => 'select',
    'name' => 'select',
    'class' => 'form-control',
    'value_field' => 'id',
    'selected_field' => 'id',
    'title_field' => 'name',
    'blank_row' => true,
    'data' => [
        ['id' => 1, 'name' => 'name 01'], 
        ['id' => 2, 'name' => 'name 02'], 
        ['id' => 3, 'name' => 'name 03'],
    ],
] ));
*/
// ----------------------------
// "Mégsem" gomb
// ----------------------------
echo (new Anchor([
    'id' => 'btn_cancel',
    'class' => 'btn btn-info',
    'href' => '/companies',
    'title' => Language::trans('cancel')
]));

// ----------------------------
// "Mentés" gomb
// ----------------------------
echo (new Button([
    'id' => 'btn',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'title' => Language::trans('save')
]))->submit();

echo Form::end(); ?>