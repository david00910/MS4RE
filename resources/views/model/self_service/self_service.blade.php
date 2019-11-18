@extends('layouts.app')
@section('title', 'Self - service')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Self-service</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">

                            <div class="col-md-4">
                                <user></user>
                            </div>

                            <div class="col-lg-8">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="collapse" data-target="#myProperties" aria-expanded="false" aria-controls="myProperties">
                                    My Properties
                                </button>
                                <div class="collapse" id="myProperties">
                                    <myproperties></myproperties>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
