<template>
    <div class="container" v-if="propertyCreated === false">
        <div class="row">
            <div class="col">

                <div class="card alert-success" v-if="output">
                    <div class="card-header">Property registered for sale</div>
                    <div class="card-body">{{output}}</div>
                </div>

                <div class="card alert-danger" v-if="errormsg">
                    <div class="card-header">An error has occured</div>
                    <div class="card-body">{{errormsg}}</div>
                </div>

                <form @submit="checkForm" id="app" enctype="multipart/form-data" method="post">


                    <h6 v-if=" errors && errors.length">
                        <p>Please correct the following error(s):</p>
                        <ul class="list-group-flush">
                            <li class="list-group-item text-danger" v-for="error in errors">{{ error }}</li>
                        </ul>
                    </h6>

                    <!--<div class="form-group" v-if="!selectedAddressArray.id">
                        <label for="dawa-autocomplete-input">Address</label>
                        <input class="form-control" type="search" autocomplete="off" v-model="address"
                               aria-describedby="addressHelp"
                               placeholder="Start typing the address"
                               id="dawa-autocomplete-input">
                    </div>-->

                    <div class="form-group" id="addressContainer">
                        <vue-dawa @select="selectItem($event, 'addressObject')"
                                  :val="addressObject.addressLine"
                                  :showMax="10"
                                  placeholder="Start typing the address"
                                  containerId="addressContainer"
                                  fieldClasses="form-control border-brand-greenish"
                                  fieldId="address"
                                  fieldName="address">
                            <label slot="label-top" for="field-2">Address</label>
                        </vue-dawa>
                    </div>

                    <h5 v-model="addressObject.id">{{addressObject.id}}</h5>


                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control border-brand-greenish" v-model="description"
                                  aria-describedby="descriptionHelp"
                                  placeholder="Describe the property you would like to sell"
                                  id="description"></textarea>
                    </div>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="price">Price (DKK)</label>
                                <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="price"
                                       aria-describedby="priceHelp"
                                       placeholder="The price in DKK"
                                       id="price">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="brutto">Brutto (DKK)</label>
                                <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="brutto"
                                       aria-describedby="bruttoHelp"
                                       placeholder="The brutto price in DKK"
                                       id="brutto">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="netto">Netto (DKK)</label>
                                <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="netto"
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
                                <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="own_exp"
                                       aria-describedby="ownExpHelp"
                                       placeholder="The owner's expense in DKK"
                                       id="own_exp">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="deposit">Deposit (DKK)</label>
                                <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="deposit"
                                       aria-describedby="depositHelp"
                                       placeholder="The deposit in DKK"
                                       id="deposit">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="sqm_price">m2 price (DKK)</label>
                                <input class="form-control border-brand-greenish" type="number" autocomplete="off" v-model="sqm_price"
                                       aria-describedby="sqmPriceHelp"
                                       placeholder="The square metre price in DKK"
                                       id="sqm_price">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-brand-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container" v-else-if="propertyCreated">
        <div class="row">
            <div class="col">
                Property ID: {{newPropertyID}}
                <div class="row">
                    <div class="col">
                        <vue-dropzone id="dropzone" v-on:vdropzone-sending="sendingEvent" :options="config"></vue-dropzone>
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
                config: {
                    url: "storeUpload",
                    maxFilesize: 5, // MB
                    maxFiles: 10,
                    chunking: true,
                    thumbnailWidth: 150, // px
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                },
                addressObject: {
                    addressLine: '',
                },
                description: null,
                price: null,
                brutto: null,
                netto: null,
                own_exp: null,
                deposit: null,
                sqm_price: null,

                output: null,
                errors: [],
                errormsg: null,
                loading: false,
                newPropertyID: null,
                propertyCreated: false,

            }
        },

        mounted() {
            //console.log('Component mounted.');
            // Getting BBR autocomplete from DAWA API
            /* var self = this;
             this.$dawa.dawaAutocomplete(document.getElementById('dawa-autocomplete-input'), {
                 select: function (selected) {
                     console.log(selected.tekst);
                     self.selectedAddress = selected.tekst;
                     self.selectedAddressArray = selected.data;
                 }
             });*/

        },

        created() {

        },

        methods: {

            //Sending property id with the img upload request
            sendingEvent (file, xhr, formData) {
                formData.append('propertyId', this.newPropertyID);
            },

            // handle the select event emitted by vue-dawa
            selectItem (payload, objectName) {
                this.$set(this, objectName, this.translateData(payload))
            },

            // here the event payload is of the type "adresse"
            translateData(address) {
                if (!address || !address.data) {
                    return
                }
                return {
                    id: address.data.id,
                    street: address.data.vejnavn,
                    streetNumber: address.data.husnr,
                    floor: address.data.etage,
                    door: address.data.dør,
                    zipCode: address.data.postnr,
                    city: address.data.postnrnavn,
                    oneLineAddress: address.tekst,
                    x: address.data.x,
                    y: address.data.y
                }
            },



            checkForm: function (e) {

                if (this.addressObject.id && this.description && this.price && this.brutto && this.netto &&
                    this.own_exp && this.deposit && this.sqm_price) {

                        this.loading = true;


                        axios.post('store', {
                            address_id: this.addressObject.id,
                            street: this.addressObject.street,
                            door: this.addressObject.door,
                            floor: this.addressObject.floor,
                            housenr: this.addressObject.streetNumber,
                            postcode: this.addressObject.zipCode,
                            city: this.addressObject.city,
                            description: this.description,
                            price: this.price,
                            brutto: this.brutto,
                            netto: this.netto,
                            own_exp: this.own_exp,
                            deposit: this.deposit,
                            sqm_price:this.sqm_price,
                            x: this.addressObject.x,
                            y: this.addressObject.y,

                        })

                            .then(response => {
                                console.log(response.data);
                                console.log(response.errors);
                                this.output = response.status;
                                this.errors = response.errors;
                                this.loading = false;
                                this.newPropertyID = response.data.id;
                                this.propertyCreated = true;

                            })
                            .catch(response => {
                                console.log(response.msg);
                                this.errormsg = response.msg;
                                this.loading = false;
                            })

                }

                this.errors = [];

                if (!this.addressObject.id) {
                    this.errors.push('The address field is empty.')
                }

                if (!this.description) {
                    this.errors.push('The description field is empty.')
                }

                if (!this.price) {
                    this.errors.push('The price field is empty')
                }

                if (!this.brutto) {
                    this.errors.push('The brutto price field is empty')
                }

                if (!this.netto) {
                    this.errors.push('The netto price field is empty')
                }

                if (!this.own_exp) {
                    this.errors.push("The owner's expense field is empty")
                }

                if (!this.deposit) {
                    this.errors.push('The deposit field is empty')
                }

                if (!this.sqm_price) {
                    this.errors.push('The square metre price field is empty')
                }

                e.preventDefault();
            },


        },


    }
</script>

<style scoped>

    .autocomplete-container input {
        /* Både input og forslag får samme bredde som omkringliggende DIV */
        width: 100%;
        box-sizing: border-box;
    }

    .dawa-autocomplete-suggestions {
        margin: 0.3em 0 0 0;
        padding: 0;
        text-align: left;
        border-radius: 0.3125em;
        background: #fcfcfc;
        box-shadow: 0 0.0625em 0.15625em rgba(0, 0, 0, .15);
        position: absolute;
        left: 0;
        right: 0;
        z-index: 9999;
        overflow-y: auto;
        box-sizing: border-box;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion {
        margin: 0;
        list-style: none;
        cursor: pointer;
        padding: 0.4em 0.6em;
        color: #333;
        border: 0.0625em solid #ddd;
        border-bottom-width: 0;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion:first-child {
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion:last-child {
        border-bottom-left-radius: inherit;
        border-bottom-right-radius: inherit;
        border-bottom-width: 0.0625em;
    }

    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion.dawa-selected,
    .dawa-autocomplete-suggestions .dawa-autocomplete-suggestion:hover {
        background: #f0f0f0;
    }
</style>
