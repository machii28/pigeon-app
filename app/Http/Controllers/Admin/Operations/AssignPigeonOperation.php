<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Pigeon;
use App\Models\Race;
use App\Models\RacePigeon;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

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
        Route::get($segment.'/{raceId}/assign-pigeon', [
            'as'        => $routeName.'.assignPigeon',
            'uses'      => $controller.'@assignPigeon',
            'operation' => 'assignPigeon',
        ]);

        Route::post($segment .  '/add-pigeon', [
            'as' => $routeName . '.add-pigeon',
            'uses' => $controller . '@addPigeon',
            'operation' => 'addPigeon'
        ]);

        Route::get($segment . '/{raceId}/start', [
            'as' => $routeName . '.start',
            'uses' => $controller . '@startRace',
            'operation' => 'startRace'
        ]);

        Route::get($segment . '/{raceId}/end', [
            'as' => $routeName . '.end',
            'uses' => $controller . '@endRace',
            'operation' => 'startRace'
        ]);

        Route::get($segment . '/{raceId}/{pigeonId}/arrive', [
            'as' => $routeName . '.arrive',
            'uses' => $controller . '@arrive',
            'operation' => 'arrive'
        ]);
    }

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

    public function assignPigeon(int $raceId)
    {
        CRUD::hasAccessOrFail('assignPigeon');

        $racePigeons = RacePigeon::where('race_id', $raceId)->get();
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Assign Pigeon';
        $this->data['raceId'] = $raceId;
        $this->data['racePigeons'] = $racePigeons;
        $this->data['pigeons'] = Pigeon::where('owner_id', backpack_auth()->id())
            ->whereNotIn('id', $racePigeons->pluck('pigeon_id')->toArray())
            ->get();
        $this->data['isStarted'] = $racePigeons->first()?->start_date_time ? true : false;
        $this->data['isEnded'] = $racePigeons->first()?->race->is_finished;

        // load the view
        return view('crud::operations.assign_pigeon', $this->data);
    }

    public function addPigeon(Request $request)
    {
        $racePigeon = new RacePigeon();
        $racePigeon->race_id = $request->get('race_id');
        $racePigeon->pigeon_id = $request->get('pigeon_id');
        $racePigeon->save();

        Alert::success('<strong>Success !</strong> Pigeon Assigned To Race')->flash();

        return Redirect::back();
    }

    public function startRace($raceId, Request $request)
    {
        $racePigeons = RacePigeon::where('race_id', $raceId)->get();

        foreach ($racePigeons as $racePigeon) {
            $racePigeon->start_date_time = now();
            $racePigeon->save();
        }

        Alert::success('<strong>Success!</strong> Race Started')->flash();

        return Redirect::back();
    }

    public function endRace($raceId, Request $request)
    {
        $race = Race::find($raceId);
        $race->is_finished = true;
        $race->save();

        Alert::success('<strong>Success!</strong> Race Ended')->flash();

        return Redirect::back();
    }

    public function arrive($raceId, $pigeonId, Request $request)
    {
        $arrivalTime = now();
        $racePigeon = RacePigeon::where('race_id', $raceId)
                        ->where('pigeon_id', $pigeonId)
                        ->first();
        $race = Race::where('id', $raceId)->first();
        $racePigeon->end_date_time = $arrivalTime;

        $totalTime = Carbon::parse($racePigeon->start_date_time)->diffInMinutes(now());
        $totalTime = round($totalTime / 60, 2);

        $racePigeon->speed = round($race->distance / $totalTime, 2);
        $racePigeon->save();

        return Redirect::back();
    }
}
