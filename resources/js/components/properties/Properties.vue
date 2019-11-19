<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Modify your search and find your home!</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Category 1
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Category 2
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Category 3
                                    </label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Category 4
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Category 5
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Category 6
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>
                            <div class="form-group">
                                <label for="price">Price (DKK)</label>
                                <input type="range" min="100000" step="10000" value="1500000" max="15000000" class="form-control-range" id="price">
                            </div>

                            <div class="form-group">
                                <label for="brutto">Brutto amount (DKK)</label>
                                <input type="range" class="form-control-range" id="brutto">
                            </div>

                            <div class="form-group">
                                <label for="netto">Netto amount (DKK)</label>
                                <input type="range" class="form-control-range" id="netto">
                            </div>

                            <div class="form-group">
                                <label for="own_exp">Owner expense (DKK)</label>
                                <input type="range" class="form-control-range" id="own_exp">
                            </div>

                            <div class="form-group">
                                <label for="sqm_price">m² price (DKK)</label>
                                <input type="range" class="form-control-range" id="sqm_price">
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">List of properties</div>

                    <div class="progress" v-if="loading">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>

                    <div class="container" v-if="hasError">
                        <h5 class="text-danger">Something went wrong. Please try again...</h5>
                    </div>

                    <div class="card-body" v-if="ready">



                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5"
                                    @paginate="indexData()"></pagination>
                        <ul class="list-group" v-for="property in properties">

                            <li class="list-group-item" style="padding: 0px !important;" v-for="file in property.files">
                                <!-- TEMPORARY IMAGE OUTPUT -->
                                <img class="img-fluid" v-if="property.files.length" :src="'../images/'+file.url" alt="">
                            </li>

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
                            <small>
                                Updated at: {{property.updated_at}}

                                Created at: {{property.created_at}}
                            </small>
                            <hr/>
                        </ul>
                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5"
                                    @paginate="indexData()"></pagination>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

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
                axios.get('/properties?page=' + this.pagination.current_page)
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
