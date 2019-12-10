
<div class="container">
    <div class="row">
        <div class="col bg-brand-greenish text-center">
                <img class="img-fluid" src="{{ asset('./images/logo.png') }}" alt="Main Solution for Real Estate logo">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header text-brand-greenish">New inquiry received</div>
                <div class="card-body">
                    <h6>From:</h6><span>{{$validated['name']}} [{{$validated['email']}}]</span>
                    <h6>Subject:</h6><span>{{$validated['topic']}}</span>
                    <h6>Message:</h6><span>{{$validated['message']}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col bg-brand-greenish text-center">
            <img class="img-fluid" src="{{ asset('./images/logo.png') }}" alt="Main Solution for Real Estate logo">
        </div>
    </div>
</div>
