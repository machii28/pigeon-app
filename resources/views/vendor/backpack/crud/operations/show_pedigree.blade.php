@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h2>
            <span class="text-capitalize mb-0">Pigeon Pedigree</span>
        </h2>
    </section>
@endsection

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .pedigree {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .person {
            background-color: #007bff;
            color: #fff;
            border: 2px solid #0056b3;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 10px;
            text-align: 'center';
        }

        .connection {
            width: 2px;
            background-color: #007bff;
            margin: 0 20px;
        }
    </style>

    <div class="container">
        <div class="pedigree">
            <div class="person">{{ $pigeon->name }}</div>
        </div>
        @if($pigeon->dam && $pigeon->sire)
            <div class="pedigree">
                <div class="person">{{ $pigeon->dam->name }}</div>
                <div class="connection"></div>
                <div class="person">{{ $pigeon->sire->name }}</div>
            </div>
            @if($pigeon->dam->dam && $pigeon->sire->sire)
                <div class="pedigree">
                    <div class="person">{{ $pigeon->dam->dam->name }}</div>
                    <div class="connection"></div>
                    <div class="person">{{ $pigeon->dam->sire->name }}</div>
                    <div class="connection"></div>
                    <div class="person">{{ $pigeon->sire->dam->name }}</div>
                    <div class="connection"></div>
                    <div class="person">{{ $pigeon->sire->sire->name }}</div>
                </div>
            @endif
        @endif
    </div>
@endsection
