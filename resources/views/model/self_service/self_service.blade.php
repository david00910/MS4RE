@extends('layouts.app')
@section('title', 'Self - service')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 p-5">
                <div class="card border-brand-greenish">
                    <div class="card-header bg-brand-primary text-white">Self-service</div>

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
                                <button class="btn btn-brand-greenish dropdown-toggle" type="button" data-toggle="collapse" data-target="#myProperties" aria-expanded="false" aria-controls="myProperties">
                                    My Properties
                                </button>
                                <a class="btn btn-outline-brand-greenish" href="{{route('create.property')}}">
                                    + New Property
                                </a>
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
