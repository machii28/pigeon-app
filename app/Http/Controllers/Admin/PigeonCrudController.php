<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\ShowPedigreeOperation;
use App\Http\Requests\PigeonRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PigeonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PigeonCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Pigeon::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pigeon');
        CRUD::setEntityNameStrings('pigeon', 'pigeons');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (backpack_auth()->user()->role !== 'admin') {
            $this->crud->addClause('where', 'owner_id', backpack_auth()->id());
        }

        if (backpack_auth()->user()->role === 'admin') {
            $this->crud->removeAllButtonsFromStack('top');
        }

        //CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('id');
        CRUD::addColumn([
            'name' => 'img_url',
            'label' => 'Image',
            'type' => 'image',
            'width' => '300px',
            'height' => '300px'
        ]);
        CRUD::column('ring_number')->type('string');
        CRUD::column('name');
        CRUD::column('color_description')->label('Color');
        CRUD::column('sex')->label('Gender');
        CRUD::column('notes')->type('text');

        CRUD::column('id')->remove();

        $this->crud->addColumn([
            'name' => 'row_number',
            'type' => 'row_number',
            'label' => '#'
        ])->makeFirstColumn();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PigeonRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.

        $this->crud->field([
            'label' => 'Name',
            'type' => 'text',
            'name' => 'name',
        ]);

        $this->crud->field([
            'label' => 'Ring Number',
            'type' => 'text',
            'name' => 'ring_number'
        ]);

        $this->crud->field([
            'label' => 'Color',
            'type' => 'text',
            'name' => 'color_description'
        ]);

        $this->crud->field([
            'label' => 'Gender',
            'type' => 'select_from_array',
            'name' => 'sex',
            'options' => [
                'cock' => 'Cock',
                'hen' => 'Hen'
            ]
        ]);

        $this->crud->field([
            'label' => 'Notes',
            'type' => 'textarea',
            'name' => 'notes',
        ]);

        $this->crud->field([
            'label' => 'Status',
            'type' => 'text',
            'name' => 'status',
        ]);

        $this->crud->field([
            'label' => 'Date Hatched',
            'type' => 'date',
            'name' => 'date_hatched'
        ]);

        $this->crud->field([
            'label' => 'Dam',
            'type' => 'select',
            'name' => 'dam_id',
            'entity' => 'dam',
            'model' => 'App\Models\Pigeon',
            'attribute' => 'ring_number',
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            })
        ]);

        $this->crud->field([
            'label' => 'Sire',
            'type' => 'select',
            'name' => 'sire_id',
            'entity' => 'sire',
            'model' => 'App\Models\Pigeon',
            'attribute' => 'ring_number',
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            })
        ]);

        CRUD::field([
            'name' => 'img_url',
            'label' => 'Image',
            'type' => 'upload',
            'withFiles' => [
                'disk' => 'public',
                'path' => 'uploads'
            ]
        ]);

        $this->crud->field([
            'name' => 'owner_id',
            'type' => 'hidden',
            'value' => backpack_auth()->id()
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

