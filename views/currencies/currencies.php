<?php

use app\core\Language;

/**
 * currencies.php
 * User: kzoltan
 * Date: 2022-10-05
 * Time: 09:30
 */

$this->title = Language::trans('currencies');

?>

<h1><?php echo $this->title; ?></h1>

<div>
    <a id="btn_new" name="btn_new" 
       href="company_new" 
       type="button" 
       class="btn btn-primary"><?php echo Language::trans('add new'); ?></a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo Language::trans('name'); ?></th>
            <th><?php echo Language::trans('functions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($currencies as $currency): ?>
        <?php
            //echo '<pre>';
            //print_r($currency);
            //echo '</pre>';
        ?>
        <tr>
            <td><?php echo $currency->currency; ?></td>
            <td><?php echo $currency->currency_symbol; ?></td>
            <td></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>