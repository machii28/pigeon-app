<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait AssignPigeonOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupAssignPigeonRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/assign-pigeon', [
            'as'        => $routeName.'.assignPigeon',
            'uses'      => $controller.'@assignPigeon',
            'operation' => 'assignPigeon',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupAssignPigeonDefaults()
    {
        CRUD::allowAccess('assignPigeon');

        CRUD::operation('assignPigeon', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'assign_pigeon', 'view', 'crud::buttons.assign_pigeon');
             CRUD::addButton('line', 'assign_pigeon', 'view', 'crud::buttons.assign_pigeon');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function assignPigeon()
    {
        CRUD::hasAccessOrFail('assignPigeon');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Assign Pigeon '.$this->crud->entity_name;

        // load the view
        return view('crud::operations.assign_pigeon', $this->data);
    }
}
