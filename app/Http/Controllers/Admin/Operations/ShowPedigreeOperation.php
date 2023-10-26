<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Pigeon;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ShowPedigreeOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupShowPedigreeRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{pigeonId}/show-pedigree', [
            'as'        => $routeName.'.showPedigree',
            'uses'      => $controller.'@showPedigree',
            'operation' => 'showPedigree',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupShowPedigreeDefaults()
    {
        CRUD::allowAccess('showPedigree');

        CRUD::operation('showPedigree', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'show_pedigree', 'view', 'crud::buttons.show_pedigree');
            CRUD::addButton('line', 'show_pedigree', 'view', 'crud::buttons.show_pedigree');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function showPedigree($pigeonId)
    {
        CRUD::hasAccessOrFail('showPedigree');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Show Pedigree '.$this->crud->entity_name;
        $this->data['pigeon'] = Pigeon::where('id', $pigeonId)->with('dam.dam.dam', 'sire.sire.sire')->first();

        // load the view
        return view('crud::operations.show_pedigree', $this->data);
    }
}
