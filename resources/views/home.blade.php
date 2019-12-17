@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="container-fluid p-0">
            <div class="col p-0 heroContainer" >
                <div class="hero-overlay">
                    <div class="container-fluid p-0">
                        <div class="row p-0">
                            <div class="col-4 p-5 heroCol">
                                <h1 class="text-white">Purchase and sell <strong class="text-brand-greenish">properties</strong>
                                    with our help today!</h1>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-4 p-5 heroCol1">
                                <h4 class="text-white">Main Solution is dedicated to provide quick
                                    <strong class="text-brand-greenish">services</strong>
                                    and optimal <strong class="text-brand-greenish">solutions</strong> for your housing needs.</h4>
                                <h3>
                                    <button class="btn btn-outline-brand-greenish mt-2">Contact us</button>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <img  src="{{asset('images/hero.png')}}" class="img-fluid" alt="">

            </div>
    </div>
@endsection
