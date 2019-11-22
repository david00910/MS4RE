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
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="price">Price (DKK)</label>
                                    <vue-slider v-bind="priceOptions" v-debounce="delay"  v-model.lazy="queryPrice" id="price"></vue-slider>
                                    <div class="row">
                                        <div class="col text-left">{{queryPrice[0] | numeral('0,0')}} DKK</div>
                                        <div class="col text-right">{{queryPrice[1] | numeral('0,0')}} DKK</div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="brutto">Brutto amount (DKK)</label>
                                    <input type="range" class="form-control-range" min="100000"
                                           v-model="properties.brutto" step="10000" max="15000000"
                                           id="brutto">
                                    <div>{{properties.brutto | numeral('0,0')}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="netto">Netto amount (DKK)</label>
                                    <input type="range" class="form-control-range" min="100000"
                                           v-model="properties.netto" step="10000" max="15000000"
                                           id="netto">
                                    <div>{{properties.netto | numeral('0,0')}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="own_exp">Owner expense (DKK)</label>
                                    <input type="range" class="form-control-range" id="own_exp"
                                           min="1000"
                                           v-model="properties.own_exp" step="100" max="150000">
                                    <div>{{properties.own_exp | numeral('0,0')}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sqm_price">m² price (DKK)</label>
                                    <input type="range" class="form-control-range" id="sqm_price"
                                           min="100"
                                           v-model="properties.sqm_price" step="100" max="10000">
                                    <div>{{properties.sqm_price | numeral('0,0')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">List of properties</div>

                    <div class="progress" v-if="loading">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>

                    <div class="container" v-if="hasError">
                        <h5 class="text-danger">Something went wrong. Please try again...</h5>
                    </div>

                    <div class="card-body" v-if="ready">

                        <pagination v-if="searchInProgress && pagination.last_page > 1" :pagination="filteredPagination" :offset="10"
                                    @paginate="fetchFiltered()"></pagination>
                        <pagination v-else-if="pagination.last_page > 1" :pagination="pagination" :offset="10"
                                    @paginate="indexData()"></pagination>

                        <ul class="list-group" v-for="property in properties">

                            <!--<li class="list-group-item" style="padding: 0px !important;" v-for="file in property.files">
                                  TEMPORARY IMAGE OUTPUT
                                 <img class="img-fluid" v-if="property.files.length" :src="'../images/'+file.url" alt="">
                            </li>-->

                            <li class="list-group-item">
                                <h5>ID:</h5> {{ property.id }}
                            </li>
                            <li class="list-group-item">
                                <h5>Description:</h5> {{ property.description}}
                            </li>
                            <li class="list-group-item" v-for="category in property.propertycategories">
                                <h5>Category:</h5> {{ category.category }}
                            </li>
                            <li class="list-group-item">
                                <h5>Brutto:</h5> {{property.brutto | numeral('0,0')}} DKK
                            </li>
                            <li class="list-group-item">
                                <h5>Netto:</h5> {{property.netto | numeral('0,0')}} DKK
                            </li>
                            <li class="list-group-item">
                                <h5>Owner expense:</h5> {{property.own_exp | numeral('0,0')}} DKK
                            </li>
                            <li class="list-group-item">
                                <h5>Price:</h5> {{property.price | numeral('0,0')}} DKK
                            </li>
                            <li class="list-group-item">
                                <h5>m² price:</h5> {{property.sqm_price | numeral('0,0')}} DKK
                            </li>
                            <small>
                                Updated at: {{property.updated_at}}

                                Created at: {{property.created_at}}
                            </small>
                            <hr/>
                        </ul>
                        <pagination v-if="searchInProgress && pagination.last_page > 1" :pagination="filteredPagination" :offset="10"
                                    @paginate="fetchFiltered()"></pagination>
                        <pagination v-else-if="pagination.last_page > 1" :pagination="pagination" :offset="10"
                                    @paginate="indexData()"></pagination>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import debounce from './index';

    export default {

        data: function () {
            return {
                searchInProgress: false, // if this is true, the pagination is rendered for the filtered results only.
                delay: 500,
                queryPrice:[100000, 55000000], // multi-range slider for the price filter query
                priceOptions: { // array of options for the multi-range slider component
                    min: 100000,
                    max: 55000000,
                    minRange: 100000
                },
                properties: [null, { // this is where the properties with all their props are getting saved from the request
                    price: null,
                    brutto: null,
                    netto: null,
                    own_exp: null,
                    sqm_price: null
                }],
                ready: false,
                pagination: {
                    'current_page': 1
                },
                filteredPagination: {
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
            this.indexData();
        },

        watch: {
            queryPrice(after, before) {
                setTimeout(function() {
                    console.log("Hello");
                    }, 400);

            }
        },


        methods: {
            indexData() {
                this.searchInProgress = false;
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
            },

            fetchFiltered() {
                this.searchInProgress = true;
                this.loading = true;
                axios.get('/search?page=' + this.filteredPagination.current_page, {params: { queryPriceFrom: this.queryPrice[0], queryPriceTo: this.queryPrice[1] }})
                    .then(response => {
                        console.log(response.data);
                        this.properties = response.data.data.data;
                        this.filteredPagination = response.data.pagination;
                        this.loading = false;
                        this.ready = true;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }

        },

        directives: {
            debounce
        }
    }
</script>
