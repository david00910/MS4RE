<template>

        <div class="card">

            <div class="card-body">

                <div class="container text-center">
                    <h5>{{$user.first_name+' '+$user.last_name}}</h5>
                    <h6>{{$user.birth_date}}</h6>
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><h6 class="text-black-50">Email</h6><h5>{{$user.email}}</h5></li>
                    <li class="list-group-item"><h6 class="text-black-50">Phone</h6><h5>{{$user.phone}}</h5></li>
                    <li class="list-group-item"><h6 class="text-black-50">Gender</h6><h5>{{$user.gender}}</h5></li>
                    <li class="list-group-item"><small class="text-black-50">Registered at {{$user.created_at}}</small></li>
                    <li class="list-group-item"><small class="text-black-50">Last updated at {{$user.updated_at}}</small></li>

                </ul>
            </div>
        </div>

</template>
