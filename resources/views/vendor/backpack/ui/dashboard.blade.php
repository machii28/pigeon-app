@extends(backpack_view('blank'))

@section('content')
    <style>
        .bg-image {
            background-image: url('/background.jpg'); /* Replace 'your-image.jpg' with your actual image file name */
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
    </style>
    <div class="container-fluid bg-image">
        <!-- Your content goes here -->
    </div>
@endsection
