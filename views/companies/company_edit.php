<?php

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\form\Select;
use app\core\Language;

/**
 * company_edit.php
 * User: kzoltan
 * Date: 2022-07-04
 * Time: 07:30
 */

$this->title = Language::trans('company_edit');

?>

<h1><?php echo $this->title; ?></h1>

<?php

// ----------------------------
// form kezdete
// ----------------------------
$form = Form::begin('', 'post');

// ----------------------------
// Rekord azonosító
// ----------------------------
echo $form->field($model, 'id')->hiddenField();

// ----------------------------
// Cég neve
// ----------------------------
echo $form->field($model, 'name');

// ----------------------------
// Ország
// ----------------------------
//$countries = (new CountryController)->getCountriesToSelect();
echo (new Select($model, [
    'id' => 'country_id',
    'name' => 'country_id',
    'class' => 'form-control',
    'value_field' => 'id',
    'selected_field' => 'id',
    'model_selected_field' => 'country_id',
    'title_field' => 'country_hu',
    'blank_row' => true,
    'data' => $countries,
] ));

// ----------------------------
// Pénznem
// ----------------------------
//$currencies = (new CurrencyController)->getCurrenciesToSelect();
echo (new Select($model, [
    'id' => 'currency',
    'name' => 'currency',
    'class' => 'form-control',
    'value_field' => 'currency',
    'selected_field' => 'currency',
    'model_selected_field' => 'currency',
    'title_field' => 'currency',
    'blank_row' => true,
    'data' => $currencies,
] ));

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
    'class' => 'btn btn-primary',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'title' => Language::trans('save')
]))->submit();

// ----------------------------
// Form vége
// ----------------------------
echo Form::end();

?>
