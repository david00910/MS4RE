@extends('layouts.app')
@section('title', 'Admin - Dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 p-3">

                @if (isset($msg))
                    <div class="alert alert-danger" role="alert">
                        {{ $msg }}
                    </div>

                @else
                <div class="card border-brand-greenish">
                    <div class="card-header bg-brand-primary text-white">Admin Dashboard :: Welcome, {{auth()->user()->first_name}}</div>

                    <div class="card-body">

                        <admin-dashboard></admin-dashboard>

                    </div>
                </div>

                @endif
            </div>

        </div>
    </div>
@endsection
