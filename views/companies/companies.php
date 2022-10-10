<?php

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Modal;
use app\core\Language;

//use app\core\form\Anchor;
//use app\core\form\Button;

/**
 * companies.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:00
 */

//$this->title = 'Companies';
$this->title = Language::trans('companies');

$create_modal_id = 'modal_create';
$edit_modal_id = 'modal_edit';
$delete_modal_id = 'modal_delete';

$modal_body = '<form>
    <input type="hidden" id="id" name="id" value=""/>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" 
               class="form-control" 
               id="name"/>
    </div>
    
    <div class="row">
        <div class="col">
        
            <div class="form-group">
                <label for="currency">currency</label>
                <input type="text" 
                       class="form-control" 
                       id="currency"/>
            </div>

        </div>
        <div class="col">
        
            <div class="form-group">
                <label for="country_id">country</label>
                <input type="text" 
                       class="form-control" 
                       id="country_id"/>
            </div>

        </div>
    </div>

</form>';

?>

<h1><?php echo $this->title; ?></h1>

<div>
<?php
/*
echo (new Anchor([
    'id' => 'btn_new',
    'class' => 'btn btn-primary',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'href' => '#',
    'title' => Language::trans('add new'),
]));
*/
// ----------.
// NEW MODAL
// ----------
echo (new Button([
    'id' => 'btn_' . $create_modal_id,
    'class' => 'btn btn-primary',
    //'title' => 'delete modal',
    'icon' => 'bi bi-plus-circle',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'data-toggle' => 'modal',
    'data-target' => "#$edit_modal_id",
    'data-id' => 0,
    'data-whatever' => 'Új elem',
]))->modal();

?>
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
        <?php foreach($companies as $company): ?>
        <tr>
            <td><?php echo $company->id; ?></td>
            <td><?php echo $company->name; ?></td>
            <td>
                
<?php

//echo (new Anchor(['id' => 'btn_edit','class' => 'btn btn-primary','href' => 'company_edit/' . $company->id,'icon' => 'bi bi-pencil',]));

// ----------.
// EDIT MODAL
// ----------
echo (new Button([
    'id' => 'btn_' . $edit_modal_id,
    'class' => 'btn btn-primary',
    //'title' => 'delete modal',
    'icon' => 'bi bi-pencil',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'data-toggle' => 'modal',
    'data-target' => "#$edit_modal_id",
    'data-id' => $company->id,
    'data-whatever' => 'Szerkesztés',
]))->modal();

#echo (new Anchor(['id' => 'btn_delete','class' => 'btn btn-danger','href' => 'company_delete/' . $company->id,'icon' => 'bi bi-trash',]));
// ------------
// DELETE MODAL
// ------------
echo (new Button([
    'id' => 'btn_' . $delete_modal_id,
    'class' => 'btn btn-danger',
    //'title' => 'delete modal',
    'icon' => 'bi bi-trash',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'data-toggle' => 'modal',
    'data-target' => "#$delete_modal_id",
    'data-id' => $company->id,
    'data-whatever' => 'Törlés',
]))->modal();

?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php

// -----------------------------
// EDIT MODAL
// -----------------------------
echo (new Modal([
    'id' => $edit_modal_id,
    'modal_title' => 'edit modal',
    'modal_body' => $modal_body,
    'modal_cancel_button' => [
        'id' => 'cancel_button',
        'class' => 'btn btn-secondary',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-dismiss' => 'modal',
        'title' => Language::trans('cancel'),
    ],
    'modal_function_button' => [
        'id' => 'save_button',
        'class' => 'btn btn-primary',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'title' => Language::trans('save'),
    ],
]))->edit();

// -----------------------------
// DELETE MODAL
// -----------------------------
echo (new Modal([
    'id' => $delete_modal_id,
    'modal_title' => 'delete modal',
    'modal_body' => $modal_body,
    'modal_cancel_button' => [
        'id' => 'cancel_button',
        'class' => 'btn btn-secondary',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-dismiss' => 'modal',
        'title' => Language::trans('cancel'),
    ],
    'modal_function_button' => [
        'id' => 'delete_button',
        'class' => 'btn btn-danger',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'title' => Language::trans('delete'),
    ],
]))->delete();

?>

<script>
$(document).ready(function(e)
{
    $('#<?php echo $edit_modal_id; ?>').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var whatever = button.data('whatever'); // Extract info from data-* attributes
        var id = button.data('id');

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-title').text(whatever);
        //modal.find('.modal-body input').val(recipient);
        
        // id
        modal.find('.modal-body #id').val(id);
        
        $.ajax({
            type: 'get',
            url: '/api/company/' + id,
            async: true,
            success: function(str_data)
            {
                json_data = JSON.parse(str_data);
                console.log(json_data);
                // név
                modal.find('.modal-body #name').val(json_data.name);
                // Pénznem
                modal.find('.modal-body #currency').val(json_data.currency);
                // Ország
                modal.find('.modal-body #country_id').val(json_data.country_id);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log('error');
            }
        });
        
    });
/*
    $('#<?php echo $delete_modal_id; ?>').on('show.bs.modal', function (event)
    {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient);
        //modal.find('.modal-body input').val(recipient);
    });

    $('#<?php echo $edit_modal_id; ?>').on('hide.bs.modal', function(event)
    {
        console.log('hide edit');
    });
*/


    //$('#btn_modal_create').on('click', function(event){
    //    console.log('new');
    //});

});
</script>