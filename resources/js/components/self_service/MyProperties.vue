<template>


                <div class="card">

                    <div class="progress" v-if="loading">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>

                    <div class="container" v-if="hasError">
                        <h5 class="text-danger">Something went wrong. Please try again...</h5>
                    </div>

                    <div class="card-body" v-if="ready">


                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5"
                                    @paginate="indexData()"></pagination>

                        <ul class="list-group" v-for="property in properties">

                            <li class="list-group-item">
                                <h5>ID:</h5> {{ property.id }}
                            </li>
                            <li class="list-group-item">
                                <h5>Description:</h5>  {{ property.description}}
                            </li>
                            <li class="list-group-item" v-for="category in property.propertycategories">
                                <h5>Category:</h5> {{ category.category }}
                            </li>
                            <li class="list-group-item">
                                <h5>Brutto:</h5> {{property.brutto}}
                            </li>
                            <li class="list-group-item">
                                <h5>Netto:</h5> {{property.netto}}
                            </li>
                            <li class="list-group-item">
                                <h5>Owner expense:</h5> {{property.own_exp}}
                            </li>
                            <li class="list-group-item">
                                <h5>Price:</h5> {{property.price}}
                            </li>
                            <li class="list-group-item">
                                <h5>m² price:</h5> {{property.sqm_price}}
                            </li>
                            <li class="list-group-item">
                                <small>
                                    Updated at: {{property.updated_at}}

                                    Created at: {{property.created_at}}
                                </small>
                            </li>

                            <div class="list-group">
                                <a href="#" class="btn btn-light">
                                    Request modification
                                </a>
                                <a href="#" class="btn btn-danger">
                                    Request permanent delete
                                </a>
                            </div>
                            <hr style="color: #1d68a7 !important;">
                        </ul>
                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5"
                                    @paginate="indexData()"></pagination>
                    </div>

                </div>


</template>


<script>
    import axios from 'axios'

    export default {

        data: function () {
            return {
                properties: '',
                ready: false,
                pagination: {
                    'current_page': 1
                },
                loading: false,
                hasError: false,
                error: ''
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        created() {
            this.indexData()
        },

        methods: {
            indexData() {

                this.loading = true;
                axios.get('myProperties?page=' + this.pagination.current_page)
                    .then(res => {
                        this.properties = res.data.data.data;
                        this.pagination = res.data.pagination;
                        this.loading = false;
                        this.ready = true;

                    }).catch(error => {
                    console.log(error.res.data.data);
                    this.error = error.res.data.data;
                    this.loading = false;
                    this.ready = false;
                    this.hasError = true;
                });
            }
        }
    }
</script>
