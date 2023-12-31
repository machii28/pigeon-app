<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\AssignPigeonOperation;
use App\Http\Requests\RaceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RaceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use AssignPigeonOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Race::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/race');
        CRUD::setEntityNameStrings('race', 'races');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        CRUD::setOperationSetting('showEntriesCount', true);

        $totalRows = $this->crud->count();

        if (backpack_auth()->user()->role !== 'admin') {
            $this->crud->addClause('where', 'owner_id', backpack_auth()->id());
        }

        if (backpack_auth()->user()->role === 'admin') {
            $this->crud->removeAllButtonsFromStack('top');
        }

        $this->crud->addColumn([
            'name' => 'is_finished',
            'label' => 'Status',
            'type' => 'custom_html',
            'value' => function ($entry) {
                if ($entry->is_finished) {
                    return '<span class="text-success">Finished</span>';
                } else {
                    return '<span class="text-warning">In Progress</span>';
                }
            }
        ]);

        $this->crud->setOperationSetting('totalEntryCount', $totalRows);


        CRUD::column('owner_id')->remove();
        CRUD::column('id')->remove();

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RaceRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        $this->crud->field([
            'name' => 'owner_id',
            'type' => 'hidden',
            'value' => backpack_auth()->user()->id
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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
