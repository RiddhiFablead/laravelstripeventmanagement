@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="card shadow-lg">
        <div class="card-body text-center">
            <h2>Welcome Customer, {{ session('name') }}</h2>
            <p>Email: {{ session('email') }}</p>
        </div>
    </div>
</div>




@endsection
