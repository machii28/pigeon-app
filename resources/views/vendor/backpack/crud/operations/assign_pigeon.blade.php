@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h2>
            <span class="text-capitalize mb-0">{{ $title }}</span>
        </h2>
    </section>
@endsection

@section('content')
    <div class="container-fluid animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="">
                            {{ csrf_field() }}

                            <input type="hidden" name="race_id" value="{{ $raceId }}">

                            <div class="mb-3">
                                <label for="pigeon_id" class="form-label">Pigeon</label>s
                                <select name="pigeon_id" id="pigeons" class="form-control">
                                    @foreach($pigeons as $pigeon)
                                        <option value="{{ $pigeon->id }}">{{ $pigeon->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary">Add Pigeon</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pigeon</th>
                                    <th>Speed</th>
                                    <th>Start Time</th>
                                    <th>Arrival Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($racePigeons as $racePigeon)
                                    <tr>
                                        <td>{{ $racePigeon->pigeon->name }}</td>
                                        <td>{{ $racePigeon->speed }}</td>
                                        <td>{{ $racePigeon->start_time }}</td>
                                        <td>{{ $racePigeon->start_date_time }}</td>
                                        <td>{{ $racePigeon->end_date_time }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
