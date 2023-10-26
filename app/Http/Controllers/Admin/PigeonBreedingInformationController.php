<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

/**
 * Class PigeonBreedingInformationController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PigeonBreedingInformationController extends Controller
{
    public function index()
    {
        return view('admin.pigeon_breeding_information', [
            'title' => 'Pigeon Breeding Information',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'PigeonBreedingInformation' => false,
            ],
            'page' => 'resources/views/admin/pigeon_breeding_information.blade.php',
            'controller' => 'app/Http/Controllers/Admin/PigeonBreedingInformationController.php',
        ]);
    }
}
