<template>
    <div class="container-fluid">
        <div class="row" v-if="!selected">

            <div class="col">
                <div class="card border-brand-greenish text-center text-brand-greenish p-5 bigCard"
                     @click="propertyManager">
                    <h4>MANAGE PROPERTIES</h4>
                </div>
            </div>

            <div class="col">
                <div class="card border-brand-greenish text-center text-brand-greenish p-5 bigCard"
                     @click="userManager">
                    <h4>MANAGE <br> USERS</h4>
                </div>
            </div>

            <div class="col">
                <div class="card border-brand-greenish text-center text-brand-greenish p-5 bigCardDisabled">
                    <h4>SITE CONFIGURATION</h4>
                </div>
            </div>

        </div>

        <div class="row" v-if="selected === 'propertyManager'">
            <div class="col-2 text-center">
                <button class="btn btn-lg btn-brand-greenish" @click="selected = false">Menu</button>
            </div>

            <div class="col">


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

                        <pagination v-if="pagination.last_page > 1" :pagination="pagination"
                                    :offset="10"
                                    @paginate="indexData()"></pagination>

                        <div class="cardContainer p-3" v-for="property in properties">


                            <div class="row propertyDesign">
                                <div class="col-4 d-none d-sm-block p-0">

                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                                        <div class="carousel-inner">
                                            <div class="carousel-item" v-for="(pf, p) in property.files"
                                                 :class="{ active: p==0}">
                                                <img class="d-block w-100" :src="'/storage/'+pf.thumbnail_url"
                                                     alt="Property images on the property show page">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4-sm d-block d-sm-none" v-for="pf in property.files">
                                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">

                                        <div class="carousel-inner">
                                            <div class="carousel-item" v-for="(pf, p) in property.files"
                                                 :class="{ active: p==0}">
                                                <img class="d-block w-100" :src="'/storage/'+pf.thumbnail_url"
                                                     alt="Property images on the property show page">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col mt-3">
                                    <h6 class="pb-2 pt-2 text-brand-charleston"
                                        v-for="pc in property.propertycategories">{{pc.category}}</h6>
                                    <h5 class="h5 text-brand-primary">
                                        {{property.address.street}}
                                        {{property.address.housenr}},
                                        {{property.address.floor}}
                                        {{property.address.door}}
                                    </h5>
                                    <h5 class="h5 text-brand-primary">{{property.address.city}}</h5>
                                    <small>Created by {{property.creator.first_name}} {{property.creator.last_name}}</small>
                                </div>
                                <div class="col mt-3" style="border-left: 1px solid rgba(0, 60, 15, 0.1) !important;">
                                    <h6 class="text-brand-slate">Price: </h6>
                                    <h5 class="text-brand-charleston">{{property.price | numeral('0,0')}} DKK</h5>

                                    <small class="text-brand-slate">Brutto:</small>
                                    <p class="text-brand-slate">{{property.brutto | numeral('0,0')}} DKK</p>
                                    <small class="text-brand-slate">Netto:</small>
                                    <p class="text-brand-slate">{{property.netto | numeral('0,0')}} DKK</p>
                                </div>

                                <div class="col mt-3">
                                    <small class="text-brand-slate">Deposit:</small>
                                    <p class="text-brand-slate">{{property.deposit | numeral('0,0')}} DKK</p>
                                    <small class="text-brand-slate">m²:</small>
                                    <p class="text-brand-slate">{{property.sqm_price | numeral('0,0')}} DKK</p>
                                    <small class="text-brand-slate">Owner's expense:</small>
                                    <p class="text-brand-slate">{{property.own_exp | numeral('0,0')}} DKK</p>
                                    <button class="btn btn-sm btn-danger" @click="confirmDelete = true">Delete</button>
                                    <button class="btn btn-sm btn-outline-brand-greenish" @click="showEditField(property.id)">Edit</button>
                                    <div class="row" v-if="confirmDelete">
                                        <div class="col">
                                            <p class="text-danger mt-1">Are you sure?</p>
                                            <button class="btn btn-sm btn-danger" @click="deleteProperty(property.id)">Yes</button>
                                            <button class="btn btn-sm btn-brand-greenish"
                                                    @click="confirmDelete = false">No
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" v-if="output">
                                        <div class="col">
                                            <p class="text-success">{{output}}</p>
                                        </div>
                                    </div>
                                    <div class="row" v-if="hasError">
                                        <div class="col">
                                            <p class="text-danger">{{error}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="bg-brand-greenish">

                        </div>

                        <pagination v-if="pagination.last_page > 1" :pagination="pagination"
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

        <div class="row" v-if="selected === 'editProperty'">
            <div class="col-2">
                <button class="btn btn-lg btn-brand-greenish" @click="selected = false">Menu</button>
            </div>
            <div class="col">

                <div class="row">
                    <div class="col">

                        <div class="card alert-success" v-if="output">
                            <div class="card-header">Property edited</div>
                            <div class="card-body">{{output}}</div>
                        </div>

                        <div class="card alert-danger" v-if="errormsg">
                            <div class="card-header">An error has occured</div>
                            <div class="card-body">{{errormsg}}</div>
                        </div>




                            <h6 v-if=" errors && errors.length">
                                <p>Please correct the following error(s):</p>
                                <ul class="list-group-flush">
                                    <li class="list-group-item text-danger" v-for="error in errors">{{ error }}</li>
                                </ul>
                            </h6>

                            <h6 class="text-brand-charleston">Info: Property addresses are not be modifiable in the Beta version.</h6>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control border-brand-greenish" v-model="singleProperty.description"
                                          aria-describedby="descriptionHelp"
                                          placeholder="Describe the property you would like to sell"
                                          id="description"></textarea>
                            </div>

                            <div class="row">

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="price">Price (DKK)</label>
                                        <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="singleProperty.price"
                                               aria-describedby="priceHelp"
                                               placeholder="The price in DKK"
                                               id="price">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="brutto">Brutto (DKK)</label>
                                        <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="singleProperty.brutto"
                                               aria-describedby="bruttoHelp"
                                               placeholder="The brutto price in DKK"
                                               id="brutto">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="netto">Netto (DKK)</label>
                                        <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="singleProperty.netto"
                                               aria-describedby="nettoHelp"
                                               placeholder="The netto price in DKK"
                                               id="netto">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="own_exp">Owner's Expense (DKK)</label>
                                        <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="singleProperty.own_exp"
                                               aria-describedby="ownExpHelp"
                                               placeholder="The owner's expense in DKK"
                                               id="own_exp">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="deposit">Deposit (DKK)</label>
                                        <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="singleProperty.deposit"
                                               aria-describedby="depositHelp"
                                               placeholder="The deposit in DKK"
                                               id="deposit">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="sqm_price">m2 price (DKK)</label>
                                        <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="singleProperty.sqm_price"
                                               aria-describedby="sqmPriceHelp"
                                               placeholder="The square metre price in DKK"
                                               id="sqm_price">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" @click="checkForm" v-if="!loading" class="btn btn-primary btn-brand-primary mt-3">Submit</button>
                            <button type="submit" v-if="loading" class="btn btn-primary btn-brand-primary mt-3 disabled">Please wait</button>

                    </div>
                </div>

            </div>
        </div>

        <div class="row" v-if="selected === 'userManager'">
            <div class="col">
                <button class="btn btn-lg btn-brand-greenish" @click="selected = false">Menu</button>
            </div>

            <div class="col">
                User management
            </div>

        </div>

    </div>
</template>

<script>

    export default {

        data: function () {
            return {
                selected: false,
                confirmDelete: false,
                searchInProgress: false, // if this is true, the pagination is rendered for the filtered results only.
                expressionQuery: null, // Main search query
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
                loading: false,
                hasError: false,
                error: '',
                output: false,
                singleProperty: {
                    id: null,
                    description: null,
                    price: null,
                    brutto: null,
                    netto: null,
                    own_exp: null,
                    deposit: null,
                    sqm_price: null,
                },
                errors: [],
                errormsg : null,
            }
        },

        created() {

        },

        mounted() {

        },

        methods: {

            showProperty(id) {
                window.location.href = `/property/show/${id}`;
            },

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

            propertyManager() {
                this.selected = 'propertyManager';
                this.indexData();
            },

            userManager() {
                this.selected = 'userManager';
                //this.indexData();
            },

            showEditField(id) {
                this.loading = true;

                axios.get('../property/show/showProperty/' + id)
                    .then(res => {
                        this.singleProperty = res.data.data;
                        this.loading = false;
                        this.selected = 'editProperty';
                    })
                    .catch(error => {
                        console.log(error.res.data);
                        this.error = error.res.data;
                        this.loading = false;
                        this.hasError = true;
                    });

            },

            checkForm: function () {

                if (this.singleProperty.id && this.singleProperty.description && this.singleProperty.price && this.singleProperty.brutto && this.singleProperty.netto &&
                    this.singleProperty.own_exp && this.singleProperty.deposit && this.singleProperty.sqm_price) {

                    this.loading = true;

                    axios.post('editProperty/' + this.singleProperty.id, {

                        description: this.singleProperty.description,
                        price: this.singleProperty.price,
                        brutto: this.singleProperty.brutto,
                        netto: this.singleProperty.netto,
                        own_exp: this.singleProperty.own_exp,
                        deposit: this.singleProperty.deposit,
                        sqm_price:this.singleProperty.sqm_price,
                    })

                        .then(response => {
                            this.output = response.status;
                            this.errors = response.errors;
                            this.loading = false;
                            var self = this;
                            setTimeout(function () { self.output = false }, 3000)
                            //this.newPropertyID = response.data.id;
                            //this.propertyCreated = true;

                        })
                        .catch(response => {
                            this.errormsg = response.msg;
                            this.loading = false;
                        })

                }

                this.errors = [];


                if (!this.singleProperty.description) {
                    this.errors.push('The description field is empty.')
                }

                if (!this.singleProperty.price) {
                    this.errors.push('The price field is empty')
                }

                if (!this.singleProperty.brutto) {
                    this.errors.push('The brutto price field is empty')
                }

                if (!this.singleProperty.netto) {
                    this.errors.push('The netto price field is empty')
                }

                if (!this.singleProperty.own_exp) {
                    this.errors.push("The owner's expense field is empty")
                }

                if (!this.singleProperty.deposit) {
                    this.errors.push('The deposit field is empty')
                }

                if (!this.singleProperty.sqm_price) {
                    this.errors.push('The square metre price field is empty')
                }

            },

            deleteProperty(id) {

                this.loading = true;
                axios.delete('deleteProperty/' + id)
                    .then(res => {
                        this.output = res.data.msg;
                        this.loading = false;
                        this.confirmDelete = false;
                        var self = this;
                        setTimeout(function () { self.indexData(); self.output = false }, 3000)
                    })
                    .catch(error => {
                        this.error = error.msg;
                        this.hasError = true;
                        this.confirmDelete = false;
                    })

            },

        }
    }
</script>

<style scoped>
    .bigCard:hover {
        background-color: #42a191;
        color: white !important;
        cursor: pointer;
    }

    .bigCardDisabled {
        color: rgba(66, 161, 145, 0.4) !important;
        cursor: not-allowed;
    }
</style>
