<template>

        <div class="card">

            <h2 v-if="deleteMsg" class="bg-info">{{deleteMsg}}.</h2>

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
                    <li class="list-group-flush list-group-item">
                        <button @click="showEditField = true" class="btn btn-light">Edit</button>
                        <button @click="showDeleteConfirm = true" class="btn btn-danger">Delete Account</button>

                        <div class="deleteconfirm" v-if="showDeleteConfirm">
                        <p class="text-danger mt-2">Are you sure you want to delete your account?</p>

                        <button @click="storeSoftDeleteUser" class="btn btn-outline-danger btn-sm">Yes, delete!</button>
                        <button @click="showDeleteConfirm = false" class="btn btn-outline-info btn-md">No, abort!</button>
                        </div>

                        <h6 v-if="output" class="text-info">{{output.status}}</h6>
                    </li>

                </ul>

                <div v-if="showEditField">
                <form  @submit.prevent="storeEdit" >

                    <input type="text" name="csrf" hidden v-model="$csrf" required>

                    <div class="form-group mt-3">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" v-model="$user.first_name" id="first_name" aria-describedby="firstNameHelp">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" v-model="$user.last_name" id="last_name" aria-describedby="lastNameHelp">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" v-model="$user.phone" id="phone" aria-describedby="phoneHelp">
                    </div>

                    <div class="form-check">
                        <p>
                            <label>
                                <input name="gender" v-model="$user.gender" value="Male" type="radio" required/>
                                <span>Male</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="gender" v-model="$user.gender" value="Female" type="radio" required />
                                <span>Female</span>
                            </label>
                        </p>
                    </div>


                    <h6 class="text-danger" v-if="errors">{{errors}}</h6>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <div @click="showEditField = false" class="btn btn-light">Cancel</div>

                </form>

                </div>

            </div>
        </div>

</template>

<script>
    import axios from 'axios'

    export default {

        data: function () {
            return {
                showDeleteConfirm: false,
                showEditField: false,
                $user: [{
                    first_name: '',
                    last_name: '',
                    phone: '',
                    gender: '',
                    csrf: '',
                    loading: false,
                    hasError: false,

                }],
                output: '',
                errors: '',
                deleteMsg: '',
            }
        },

        methods: {

            storeEdit() {

                this.loading = true;

                axios.post('storeEditUser', {
                    first_name: this.$user.first_name,
                    last_name: this.$user.last_name,
                    email: this.$user.email,
                    gender: this.$user.gender,
                    phone: this.$user.phone,
                    csrf: this.$user.csrf,

                })

                    .then(response => {
                        console.log(response.data);
                        console.log(response.errors);
                        this.output = response.data;
                        this.errors = response.errors;
                        this.loading = false;
                        this.showEditField = false;

                    })
                    .catch(response => {
                        console.log(response);
                        this.loading = false;
                    })

            },

            storeSoftDeleteUser() {
                this.loading = true;

                axios.delete('storeSoftDeleteUser', {
                    csrf: this.$user.csrf,
                })

                    .then(response => {
                        console.log(response.data.msg);
                        this.deleteMsg = response.data.msg;
                        this.loading = false;

                    })
                    .catch(response => {
                        console.log(response);
                        this.loading = false;
                    })
            }

        }
    }
</script>
