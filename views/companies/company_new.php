<?php

/**
* company_new.php
* User: kzoltan
* Date: 2022-07-05
* Time: 08:30
*/

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\form\Select;
use app\core\Language;
use app\models\Company;

/** @var Company $company */
/** @var array<Country> $countries */
/** @var array<Currency> $currencies */

$this->title = Language::trans('company_new');

?>

<h1><?php echo $this->title; ?></h1>

<?php $form = Form::begin('', 'post');

echo $form->field($company, "id")->hiddenField();

// ----------------------------
// Cég neve
// ----------------------------
echo $form->field($company, 'name');

// ----------------------------
// Ország
// ----------------------------

//$countries = (new CountryController)->getCountriesToSelect();
echo (new Select($company, [
    'id' => 'country_id',
    'name' => 'country_id',
    'class' => 'form-control',
    'title' => 'country',
    'value_field' => 'id',
    'selected_field' => 'id',
    'model_selected_field' => 'id',
    'title_field' => 'country_hu',
    'blank_row' => true,
    'data' => $countries,
] ));

// ----------------------------
// Pénznem
// ----------------------------
//$currencies = (new CurrencyController)->getCurrenciesToSelect();
echo (new Select($company, [
    'id' => 'currency',
    'name' => 'currency',
    'class' => 'form-control',
    'title' => 'currency',
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
    'class' => 'btn btn-primary float-right',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'title' => Language::trans('save')
]))->submit();

echo Form::end(); ?>