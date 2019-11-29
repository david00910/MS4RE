<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <form>
                    <div class="form-group">
                        <label for="dawa-autocomplete-input">Address</label>
                        <input class="form-control" type="search" autocomplete="off" v-model="address"
                               aria-describedby="addressHelp"
                               placeholder="Start typing the address and select from the list.."
                               id="dawa-autocomplete-input">
                    </div>

                    <div class="card" >
                        <div class="card-header">Your property</div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                            <h5>Address:</h5> {{selectedAddress}}
                            </div>
                            <div class="col">
                                <h6>General information:</h6> {{selectedAddressArray}}
                            </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';


    export default {

        data: function () {
            return {
                address: null,
                selectedAddress: null,
                selectedAddressArray: null,
            }
        },

        mounted() {
            //console.log('Component mounted.');
            // Getting BBR autocomplete from DAWA API
            var self = this;
            this.$dawa.dawaAutocomplete(document.getElementById('dawa-autocomplete-input'), {
                select: function (selected) {
                    console.log(selected.tekst);
                    self.selectedAddress = selected.tekst;
                    self.selectedAddressArray = selected.data;
                }
            });

        },

        created() {

        },

        methods: {},


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
