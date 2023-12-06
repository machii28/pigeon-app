{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Pigeons" icon="la la-dove" :link="backpack_url('pigeon')" />
<x-backpack::menu-item title="Pedigrees" icon="la la-project-diagram" :link="backpack_url('pedigree')" />
<x-backpack::menu-item title="Races" icon="la la-flag" :link="backpack_url('race')" />

<x-backpack::menu-item title="Breeding Information" icon="la la-crow" :link="backpack_url('pigeon_breeding_information')" />


@if (backpack_auth()->user()->role === 'admin')
    <x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
@endif
