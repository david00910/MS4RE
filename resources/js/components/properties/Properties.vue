<template>
    <div class="container-fluid py-3">
        <div class="row justify-content-center">

            <div class="accordion">
                <div class="card bg-brand-white border-brand-greenish">
                    <div class="card-header bg-brand-primary text-white">
                        <button class="btn text-brand-white dropdown-toggle" type="button" data-toggle="collapse" data-target="#filters"
                                aria-expanded="true" aria-controls="filters">
                            Modify your search and find your home!
                        </button>
                    </div>
                    <div class="card-body" id="filters">

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control border-brand-greenish" @change="callFiltering"
                                           v-model.lazy="expressionQuery" type="text"
                                           id="expressionQuery"
                                           placeholder="Search by address: street, door, house nr., city, postcode, etc...">
                                    <button class="btn btn-sm btn-outline-brand-greenish mt-2">Search</button>
                                </div>
                            </div>
                        </div>
                        <hr class="bg-brand-greenish">

                        <div class="row text-center">
                            <div class="col text-left">
                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Apartment"
                                           id="cat1">
                                    <label class="form-check-label" for="cat1">
                                        Apartment
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Villa"
                                           id="cat2">
                                    <label class="form-check-label" for="cat2">
                                        Villa
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="House"
                                           id="cat3">
                                    <label class="form-check-label" for="cat3">
                                        House
                                    </label>
                                </div>
                            </div>

                            <div class="col text-left">
                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Recreational unit"
                                           id="cat4">
                                    <label class="form-check-label" for="cat4">
                                        Recreational unit
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" @change="callFiltering"
                                           v-model.lazy="checkedCategories" type="checkbox" value="Other"
                                           id="cat5">
                                    <label class="form-check-label" for="cat5">
                                        Other
                                    </label>
                                </div>

                            </div>
                        </div>

                        <hr class="bg-brand-greenish">
                        <div class="card border-brand-greenish">
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

                        <div class="card border-brand-greenish">
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

                        <div class="card border-brand-greenish">
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

                        <div class="card border-brand-greenish">
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

                        <div class="card border-brand-greenish">
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

                        <div class="card border-brand-greenish">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="deposit">Deposit (DKK)</label>
                                    <vue-slider v-bind="depositOptions" @change="callFiltering"
                                                v-model.lazy="queryDeposit" id="deposit"></vue-slider>
                                    <div class="row">
                                        <div class="col text-left">{{queryDeposit[0] | numeral('0,0')}} DKK</div>
                                        <div class="col text-right">{{queryDeposit[1] | numeral('0,0')}} DKK</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-brand-greenish">
                    <div class="card-header bg-brand-primary text-white">List of properties</div>

                    <div class="progress" v-if="loading">
                        <div class="progress-bar progress-bar-striped bg-brand-greenish progress-bar-animated"
                             role="progressbar"
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                             style="width: 100%"></div>
                    </div>

                    <div class="container" v-if="hasError">
                        <h5 class="text-danger">Something went wrong. Please try again...</h5>
                    </div>

                    <div class="card-body bg-brand-white p-3 text-brand-greenish" v-if="ready && properties.length">

                        <pagination v-if="searchInProgress && pagination.last_page > 1"
                                    :pagination="filteredPagination" :offset="10"
                                    @paginate="fetchFiltered()"></pagination>
                        <pagination v-else-if="pagination.last_page > 1" :pagination="pagination"
                                    :offset="10"
                                    @paginate="indexData()"></pagination>

                        <div class="cardContainer p-3" v-for="property in properties">


                            <div class="row propertyDesign">
                                <div class="col-4 d-none d-sm-block p-0">

                                    <div id="carouselExampleIndicators" class="carousel slide"  data-ride="carousel">

                                        <div class="carousel-inner">
                                            <div class="carousel-item" v-for="(pf, p) in property.files" :class="{ active: p==0}">
                                                <img class="d-block w-100" :src="'storage/'+pf.thumbnail_url" alt="Property images on the property show page">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4-sm d-block d-sm-none" v-for="pf in property.files">
                                    <div id="carouselExampleIndicators2" class="carousel slide"  data-ride="carousel">

                                        <div class="carousel-inner">
                                            <div class="carousel-item" v-for="(pf, p) in property.files" :class="{ active: p==0}">
                                                <img class="d-block w-100" :src="'storage/'+pf.thumbnail_url" alt="Property images on the property show page">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col mt-3" @click="showProperty(property.id)">
                                    <h6 class="pb-2 pt-2 text-brand-charleston" v-for="pc in property.propertycategories">{{pc.category}}</h6>
                                    <h5 class="h5 text-brand-primary">
                                        {{property.address.street}}
                                        {{property.address.housenr}},
                                        {{property.address.floor}}
                                        {{property.address.door}}
                                    </h5>
                                    <h5 class="h5 text-brand-primary">{{property.address.city}}</h5>
                                </div>
                                <div class="col mt-3" style="border-left: 1px solid rgba(0, 60, 15, 0.1) !important;" @click="showProperty(property.id)">
                                    <h6 class="text-brand-slate">Price: </h6>
                                    <h5 class="text-brand-charleston">{{property.price | numeral('0,0')}} DKK</h5>

                                    <small class="text-brand-slate">Brutto:</small>
                                    <p class="text-brand-slate">{{property.brutto | numeral('0,0')}} DKK</p>
                                    <small class="text-brand-slate">Netto:</small>
                                    <p class="text-brand-slate">{{property.netto | numeral('0,0')}} DKK</p>
                                </div>

                                <div class="col mt-3" @click="showProperty(property.id)">
                                    <small class="text-brand-slate">Deposit:</small>
                                    <p class="text-brand-slate">{{property.deposit | numeral('0,0')}} DKK</p>
                                    <small class="text-brand-slate">m²:</small>
                                    <p class="text-brand-slate">{{property.sqm_price | numeral('0,0')}} DKK</p>
                                    <small class="text-brand-slate">Owner's expense:</small>
                                    <p class="text-brand-slate">{{property.own_exp | numeral('0,0')}} DKK</p>
                                </div>

                            </div>
                            <hr class="bg-brand-greenish">

                        </div>
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
                expressionQuery: null, // Main search query
                checkedCategories: [], // saving the checked categories so we can send it with the filter request (if there are any checked filters, controlled in the fetchFilter() function)
                queryPrice: [100000, 55000000], // multi-range slider for the price filter query
                priceOptions: { // array of options for the price slider component
                    min: 100000,
                    max: 55000000,
                    minRange: 1000000,
                    processStyle: {
                        backgroundColor: '#42a191'
                    },
                    tooltipStyle: {
                        backgroundColor: '#42a191'
                    }

                },
                queryBrutto: [1000, 100000],
                bruttoOptions: { // array of options for the brutto price slider component
                    min: 1000,
                    max: 100000,
                    minRange: 1000,
                    processStyle: {
                        backgroundColor: '#42a191'
                    },
                    tooltipStyle: {
                        backgroundColor: '#42a191'
                    }
                },
                queryNetto: [1000, 100000],
                nettoOptions: { // array of options for the netto price slider component
                    min: 1000,
                    max: 100000,
                    minRange: 1000,
                    processStyle: {
                        backgroundColor: '#42a191'
                    },
                    tooltipStyle: {
                        backgroundColor: '#42a191'
                    }
                },
                queryOwnExp: [1000, 50000],
                ownExpOptions: { // array of options for the owner expense price slider component
                    min: 1000,
                    max: 50000,
                    minRange: 1000,
                    processStyle: {
                        backgroundColor: '#42a191'
                    },
                    tooltipStyle: {
                        backgroundColor: '#42a191'
                    }
                },
                querySqmPrice: [100, 20000],
                sqmPriceOptions: { // array of options for the sqm price price slider component
                    min: 100,
                    max: 20000,
                    minRange: 200,
                    processStyle: {
                        backgroundColor: '#42a191'
                    },
                    tooltipStyle: {
                        backgroundColor: '#42a191'
                    }
                },
                queryDeposit: [1000, 500000],
                depositOptions: { // array of options for the deposit slider component
                    min: 1000,
                    max: 500000,
                    minRange: 10000,
                    processStyle: {
                        backgroundColor: '#42a191'
                    },
                    tooltipStyle: {
                        backgroundColor: '#42a191'
                    }
                },
                properties: [null, { // this is where the properties with all their props are getting saved from the request
                    price: null,
                    brutto: null,
                    netto: null,
                    own_exp: null,
                    sqm_price: null,
                    deposit: null,
                    address: {
                        street: null,
                        door: null,
                        floor: null,
                        housenr: null,
                        zipCode: null,
                        city: null,
                        //status: null,
                        //x: null,
                        //y: null
                    },
                    propertycategories: {
                        category: null,
                        description: null,

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
                        //console.log(res.data.data);
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
                        queryDepositFrom: this.queryDeposit[0],
                        queryDepositTo: this.queryDeposit[1],
                        queryCategory: this.checkedCategories.length ? this.checkedCategories : null, // checking with a ternary operator if any of the boxes are checked. If not, send a null value.
                        queryExpression: this.expressionQuery ? this.expressionQuery : null
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

            showProperty(id) {
                window.location.href = `/property/show/${id}`;
            }


        },


    }
</script>

<style scoped>

  .propertyDesign:hover {
      -webkit-box-shadow: 7px 6px 8px 1px rgba(171,169,171,1) !important;
      -moz-box-shadow: 7px 6px 8px 1px rgba(171,169,171,1) !important;
      box-shadow: 7px 6px 8px 1px rgba(171,169,171,1) !important;
      cursor:pointer;
  }
</style>
