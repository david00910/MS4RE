@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="container-fluid p-0">
        <div class="col p-0 heroContainer">
            <div class="hero-overlay d-none d-lg-block">
                <div class="container-fluid p-5">
                    <div class="row justify-content-center">
                        <div class="col-4 p-5 heroCol">
                            <h1 class="text-white">Purchase and sell <strong
                                    class="text-brand-greenish">properties</strong>
                                with our help today!</h1>
                        </div>


                        <div class="col-4 p-5 heroCol1 text-right">
                            <h4 class="text-white">Main Solution is dedicated to provide quick
                                <strong class="text-brand-greenish">services</strong>
                                and optimal <strong class="text-brand-greenish">solutions</strong> for your housing
                                needs.</h4>
                            <h3>
                                <button class="btn btn-outline-brand-greenish mt-2">Contact us</button>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{asset('images/hero.png')}}" class="img-fluid" alt="">

        </div>

    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm bg-brand-primary text-white p-5">
                <h3>What can Main Solution do for you?</h3>
                <p class="promoText">

                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
                    dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
                    sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam
                    est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius
                    modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima
                    veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea
                    commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil
                    molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur

                </p>
            </div>
            <div class="col-sm bg-brand-greenish p-5">
                <div class="row">
                    <div class="col-sm p-5">
                        <h5 class="text-white">Properties ready for purchase:</h5>
                        <h3 class="text-brand-primary">345</h3>

                        <h5 class="text-white">Most popular area</h5>
                        <h3 class="text-brand-primary">Esbjerg</h3>

                        <h5 class="text-white">Most popular category</h5>
                        <h3 class="text-brand-primary">Apartment</h3>

                        <h5 class="text-white">Online sellers and buyers</h5>
                        <h3 class="text-brand-primary">34</h3>
                    </div>

                    <div class="col-sm p-5">
                        <h5 class="text-white">Latest property</h5>
                        <img src="{{asset('images/example.jpg')}}" alt="" class="img-fluid">
                        <h5 class="text-white mt-2">Holmevej 15, 6700 Esbjerg</h5>
                        <h6 class="text-white">House</h6>
                        <button class="btn btn-sm btn-brand-primary text-white">View</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-white justify-content-center">
            <div class="col-sm">
                <div class="row bg-brand-greenish">
                    <div class="col-sm p-3">
                        <h3 class="text-center text-white">FEATURED PROPERTIES</h3>
                    </div>
                </div>
                <div class="row justify-content-center p-4">
                    <div class="col-sm">
                        <img src="{{asset('images/example.jpg')}}" alt="" class="img-fluid">
                        <h5 class="mt-2">Holmevej 15, 6700 Esbjerg</h5>
                        <h6>House</h6>
                        <button class="btn btn-sm btn-brand-primary text-white">View</button>
                    </div>
                    <div class="col-sm">
                        <img src="{{asset('images/example.jpg')}}" alt="" class="img-fluid">
                        <h5 class="mt-2">Holmevej 15, 6700 Esbjerg</h5>
                        <h6>House</h6>
                        <button class="btn btn-sm btn-brand-primary text-white">View</button>
                    </div>
                    <div class="col-sm">
                        <img src="{{asset('images/example.jpg')}}" alt="" class="img-fluid">
                        <h5 class="mt-2">Holmevej 15, 6700 Esbjerg</h5>
                        <h6 class="">House</h6>
                        <button class="btn btn-sm btn-brand-primary text-white">View</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-brand-primary justify-content-center">
            <div class="col-sm">
                <div class="row justify-content-center text-center p-4">
                    <div class="col-sm p-3">

                        <a class="text-white" href="#">Self - service</a>

                    </div>
                    <div class="col-sm p-3 inline-nav-col">

                        <a class="text-white " href="#">Properties</a>


                    </div>
                    <div class="col-sm p-3 inline-nav-col">

                        <a class="text-white" href="#">About</a>


                    </div>
                    <div class="col-sm p-3 inline-nav-col">

                        <a class="text-white" href="#">Services</a>


                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
