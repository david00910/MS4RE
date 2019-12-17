<template>
    <div class="container-fluid">
        <div class="row p-5 text-brand-white bg-brand-greenish">
            <div class="col-sm p-3 text-center">
                <img class="img-fluid mt-5" :src="'/images/logo.png'" alt="Main Solution for Real Estate logo">
                <p>Englandsgade 15 th. <br>
                    Esbjerg 6700 <br>
                    Denmark</p>

                <a class="text-brand-primary" :href="'http://main-solution.dk'"><h6>Visit our official site</h6></a>
            </div>
            <div class="col-sm p-3">
                <div class="h5 text-center">Contact us</div>
                <form @submit="checkForm" id="footer" method="post">



                    <div class="bg-brand-charleston" v-if="errors && errors.length">
                        <h6 class="text-danger p-2" v-for="error in errors">
                            {{error}}
                        </h6>
                    </div>

                    <div class="form-group" id="contact">
                        <label for="name">Name</label>
                        <input type="text" v-model="name" class="form-control" id="name" placeholder="What is your name?">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" v-model="email" class="form-control" id="email" aria-describedby="emailHelp"
                               placeholder="Enter your email">
                        <small id="emailHelp" class="form-text text-brand-white">We will never share your personal
                            information with a third party.</small>
                    </div>
                    <div class="form-group">
                        <label for="topic">Subject</label>
                        <input type="text" v-model="topic" class="form-control" id="topic" placeholder="What can we help you with?">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea v-model="message" class="form-control" id="message" placeholder="Enter your message here.."></textarea>
                    </div>
                    <button type="submit" class="btn btn-brand-primary">Send</button>
                    <button v-if="loading" type="submit" class="btn disabled">Send</button>
                    <div class="progress" v-if="loading">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                             style="width: 100%"></div>
                    </div>
                    <div v-if="output" class="alert-success mt-3">
                        <h6 class="p-3">{{output}}</h6>
                    </div>

                </form>
            </div>

            <div class="col-sm p-3">

                <div class="h5 text-center">Quick navigation</div>

                <div class="col">

                <ul class="list-group-flush">
                    <li class="list-group-item bg-brand-greenish">
                        <a class="text-brand-white" :href="'/property/create'">Privacy Policy</a>
                    </li>
                    <li class="list-group-item bg-brand-greenish">
                        <a class="text-brand-white" :href="'/property/create'">Terms of Use</a>
                    </li>
                    <li class="list-group-item bg-brand-greenish">
                        <a class="text-brand-white" :href="'/property/create'">F.A.Q</a>
                    </li>
                </ul>
                </div>

                <div class="col">
                <ul class="list-group-flush">
                    <li class="list-group-item bg-brand-greenish">
                        <a :href="'/'" class="text-brand-white">Home</a>
                    </li>
                    <li class="list-group-item bg-brand-greenish">
                        <a :href="'/'" class="text-brand-white">Properties</a>
                    </li>
                    <li class="list-group-item bg-brand-greenish">
                        <a :href="'/self-service'" class="text-brand-white">Self-service</a>
                    </li>
                </ul>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 p-2 bg-brand-primary">
                <p class="text-center text-brand-white mt-2">© {{new Date().getFullYear()}} Main Solution A/S <br> All Rights Reserved</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                name: null,
                email: null,
                topic: null,
                message: null,
                errors: null,
                output: null,
                errormsg: null,
                loading: false
            }
        },

        methods: {

            checkForm: function (e) {
                if (this.name && this.email && this.topic && this.message) {

                    this.loading = true;

                    axios.post('contactUs', {
                        name: this.name,
                        email: this.email,
                        topic:this.topic,
                        message: this.message,
                    })

                        .then(response => {
                            console.log(response.data);
                            console.log(response.errors);
                            this.output = response.data.status;
                            this.errors = response.errors;
                            this.loading = false;

                        })
                        .catch(response => {
                            console.log(response.msg);
                            this.errormsg = response.msg;
                            this.loading = false;
                        })

                }

                this.errors = [];

                if (!this.name) {
                    this.errors.push("The name field is empty")
                }

                if (!this.email) {
                    this.errors.push("The email address field is empty")
                }

                if (!this.topic) {
                    this.errors.push('The topic field is empty')
                }

                if (!this.message) {
                    this.errors.push('The message field is empty')
                }
                e.preventDefault();
            },

        }
    }
</script>
