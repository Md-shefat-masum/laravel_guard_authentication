@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <h1 class="text-danger">this is admin dash board</h1>
                    <a href="{{ route('admin.logout') }}" onclick="return confirm('want to logout')" class="btn btn-danger">logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
