<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="accordion">
                <div class="card">
                    <div class="card-header">
                        <button class="btn dropdown-toggle" type="button" data-toggle="collapse" data-target="#filters" aria-expanded="true" aria-controls="filters">
                        Modify your search and find your home!
                        </button>
                    </div>
                    <div class="card-body" id="filters">

                        <div class="row text-center">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Category 1"
                                           id="cat1">
                                    <label class="form-check-label" for="cat1">
                                        Category 1
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Category 2"
                                           id="cat2">
                                    <label class="form-check-label" for="cat2">
                                        Category 2
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Category 3"
                                           id="cat3">
                                    <label class="form-check-label" for="cat3">
                                        Category 3
                                    </label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Category 4"
                                           id="cat4">
                                    <label class="form-check-label" for="cat4">
                                        Category 4
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Category 5"
                                           id="cat5">
                                    <label class="form-check-label" for="cat5">
                                        Category 5
                                    </label>
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="price">Price (DKK)</label>
                                    <vue-slider v-bind="priceOptions" @change="callFiltering" v-model.lazy="queryPrice"
                                                id="price"></vue-slider>
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
                                    <vue-slider v-bind="bruttoOptions" @change="callFiltering"
                                                v-model.lazy="queryBrutto" id="brutto"></vue-slider>
                                    <div class="row">
                                        <div class="col text-left">{{queryBrutto[0] | numeral('0,0')}} DKK</div>
                                        <div class="col text-right">{{queryBrutto[1] | numeral('0,0')}} DKK</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="netto">Netto amount (DKK)</label>
                                    <vue-slider v-bind="nettoOptions" @change="callFiltering" v-model.lazy="queryNetto"
                                                id="netto"></vue-slider>
                                    <div class="row">
                                        <div class="col text-left">{{queryNetto[0] | numeral('0,0')}} DKK</div>
                                        <div class="col text-right">{{queryNetto[1] | numeral('0,0')}} DKK</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="own_exp">Owner expense (DKK)</label>
                                    <vue-slider v-bind="ownExpOptions" @change="callFiltering"
                                                v-model.lazy="queryOwnExp" id="own_exp"></vue-slider>
                                    <div class="row">
                                        <div class="col text-left">{{queryOwnExp[0] | numeral('0,0')}} DKK</div>
                                        <div class="col text-right">{{queryOwnExp[1] | numeral('0,0')}} DKK</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sqm_price">m² price (DKK)</label>
                                    <vue-slider v-bind="sqmPriceOptions" @change="callFiltering"
                                                v-model.lazy="querySqmPrice" id="sqm_price"></vue-slider>
                                    <div class="row">
                                        <div class="col text-left">{{querySqmPrice[0] | numeral('0,0')}} DKK</div>
                                        <div class="col text-right">{{querySqmPrice[1] | numeral('0,0')}} DKK</div>
                                    </div>
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
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                             style="width: 100%"></div>
                    </div>

                    <div class="container" v-if="hasError">
                        <h5 class="text-danger">Something went wrong. Please try again...</h5>
                    </div>

                    <div class="card-body" v-if="ready && properties.length">

                        <pagination v-if="searchInProgress && pagination.last_page > 1"
                                    :pagination="filteredPagination" :offset="10"
                                    @paginate="fetchFiltered()"></pagination>
                        <pagination v-else-if="pagination.last_page > 1" :pagination="pagination"
                                    :offset="10"
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
                        <pagination v-if="searchInProgress && pagination.last_page > 1"
                                    :pagination="filteredPagination" :offset="10"
                                    @paginate="fetchFiltered()"></pagination>
                        <pagination v-else-if="pagination.last_page > 1" :pagination="pagination"
                                    :offset="10"
                                    @paginate="indexData()"></pagination>

                    </div>

                    <div class="container" v-else-if="properties.length < 1">
                        <div class="col text-center mt-2">
                            <h5 class="text-muted">There are no results with the current search options.</h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {

        data: function () {
            return {
                searchInProgress: false, // if this is true, the pagination is rendered for the filtered results only.
                checkedCategories: [], // saving the checked categories so we can send it with the filter request (if there are any checked filters, controlled in the fetchFilter() function)
                queryPrice: [100000, 55000000], // multi-range slider for the price filter query
                priceOptions: { // array of options for the price slider component
                    min: 100000,
                    max: 55000000,
                    minRange: 100000
                },
                queryBrutto: [100000, 55000000],
                bruttoOptions: { // array of options for the brutto price slider component
                    min: 100000,
                    max: 55000000,
                    minRange: 100000
                },
                queryNetto: [100000, 55000000],
                nettoOptions: { // array of options for the netto price slider component
                    min: 100000,
                    max: 55000000,
                    minRange: 100000
                },
                queryOwnExp: [1000, 500000],
                ownExpOptions: { // array of options for the owner expense price slider component
                    min: 1000,
                    max: 500000,
                    minRange: 1000
                },
                querySqmPrice: [100, 20000],
                sqmPriceOptions: { // array of options for the sqm price price slider component
                    min: 100,
                    max: 20000,
                    minRange: 200
                },
                properties: [null, { // this is where the properties with all their props are getting saved from the request
                    price: null,
                    brutto: null,
                    netto: null,
                    own_exp: null,
                    sqm_price: null,
                    propertycategories: {
                        category: '',
                        description: '',
                    }
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
            //this.getCategories();
        },

        methods: {
            indexData() {
                this.searchInProgress = false;
                this.loading = true;
                axios.get('/properties?page=' + this.pagination.current_page)
                    .then(res => {
                        console.log(res.data.bbr);
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

            /*getCategories() {
                axios.get('/categories')
                    .then(res => {
                        console.log(res.data);
                        this.ready = false;
                        this.categories = res.data;
                        this.ready = true;

                    }).catch(error => {
                    this.error = error.data;
                    this.ready = false;
                    this.hasError = true;
                });
            },*/
            // this computed property runs when a filter change triggers it, avoiding multiple requests on every single move of the slider pin.
            callFiltering: _.debounce(function () {
                this.fetchFiltered();
            }, 800),

            fetchFiltered() { // sending the get request with the filter parameters and getting back the results from eloquent.

                this.searchInProgress = true;
                this.loading = true;
                axios.get('/search?page=' + this.filteredPagination.current_page, {
                    params: {
                        queryPriceFrom: this.queryPrice[0],
                        queryPriceTo: this.queryPrice[1],
                        queryBruttoFrom: this.queryBrutto[0],
                        queryBruttoTo: this.queryBrutto[1],
                        queryNettoFrom: this.queryNetto[0],
                        queryNettoTo: this.queryNetto[1],
                        queryOwnExpFrom: this.queryOwnExp[0],
                        queryOwnExpTo: this.queryOwnExp[1],
                        querySqmPriceFrom: this.querySqmPrice[0],
                        querySqmPriceTo: this.querySqmPrice[1],
                        queryCategory: this.checkedCategories.length ? this.checkedCategories : null, // checking with a ternary operator if any of the boxes are checked. If not, send a null value.
                    }
                })
                    .then(response => {
                        console.log(this.checkedCategories);
                        console.log(response.data);
                        this.properties = response.data.data.data;
                        this.filteredPagination = response.data.pagination;
                        this.loading = false;
                        this.ready = true;

                    })
                    .catch(error => {
                        console.log(error);
                    })
            },

        },


    }
</script>
