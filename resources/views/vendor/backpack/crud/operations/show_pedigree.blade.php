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
            background-color: gray;
            color: #fff;
            border: 2px solid dimgray;
            width: 200px;
            height: 200px;
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
            <div class="person">
                <span class="d-block">
                    <img src="/{{ $pigeon->img_url }}" width="100" height="100">
                </span>
                <span class="d-block">{{ $pigeon->name }}</span>
                <span class="d-block">{{ Carbon\Carbon::parse($pigeon->date_hatched)->format('M d, Y') }}</span>
            </div>
        </div>
        @if($pigeon->dam && $pigeon->sire)
            <div class="pedigree">
                <div class="person">
                    <span class="d-block">
                        <img src="/{{ $pigeon->dam->img_url }}" width="100" height="100">
                    </span>
                    <span class="d-block">{{ $pigeon->dam->name }}</span>
                    <span class="d-block">{{ Carbon\Carbon::parse($pigeon->dam->date_hatched)->format('M d, Y') }}</span>
                </div>
                <div class="connection"></div>
                <div class="person">
                    <span class="d-block">
                        <img src="/{{ $pigeon->sire->img_url }}" width="100" height="100">
                    </span>
                    <span class="d-block">{{ $pigeon->sire->name }}</span>
                    <span class="d-block">{{ Carbon\Carbon::parse($pigeon->sire->date_hatched)->format('M d, Y') }}</span>
                </div>
            </div>
            @if($pigeon->dam->dam && $pigeon->sire->sire)
                <div class="pedigree">
                    <div class="person">
                        <span class="d-block">
                            <img src="/{{ $pigeon->dam->dam->img_url }}" width="100" height="100">
                        </span>
                        <span class="d-block">{{ $pigeon->dam->dam->name }}</span>
                        <span class="d-block">{{ Carbon\Carbon::parse($pigeon->dam->dam->date_hatched)->format('M d, Y') }}</span>
                    </div>
                    <div class="connection"></div>
                    <div class="person">
                        <span class="d-block">
                            <img src="/{{ $pigeon->dam->sire->img_url }}" width="100" height="100">
                        </span>
                        <span class="d-block">{{ $pigeon->dam->sire->name }}</span>
                        <span class="d-block">{{ Carbon\Carbon::parse($pigeon->dam->sire->date_hatched)->format('M d, Y') }}</span>
                    </div>
                    <div class="connection"></div>
                    <div class="person">
                        <span class="d-block">
                            <img src="/{{ $pigeon->sire->dam->img_url }}" width="100" height="100">
                        </span>
                        <span class="d-block">{{ $pigeon->sire->dam->name }}</span>
                        <span class="d-block">{{ Carbon\Carbon::parse($pigeon->sire->dam->date_hatched)->format('M d, Y') }}</span>
                    </div>
                    <div class="connection"></div>
                    <div class="person">
                        <span class="d-block">
                            <img src="/{{ $pigeon->sire->sire->img_url }}" width="100" height="100">
                        </span>
                        <span class="d-block">{{ $pigeon->sire->sire->name }}</span>
                        <span class="d-block">{{ Carbon\Carbon::parse($pigeon->sire->sire->date_hatched)->format('M d, Y') }}</span>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
