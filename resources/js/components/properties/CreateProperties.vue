<template>
    <div class="container">
        <div class="row justify-content-center">

            <form>
                <div class="form-group">
                    <vue-dawa @select="selectItem($event, 'yourAddressObject')"
                              :val="yourAddressObject.oneLineAddress"
                              :showMax="5"
                              placeholder="Your Placeholder"
                              containerId="your-container"
                              :options="{
                               baseUrl: apiBase,
                              }"
                              fieldId="your-field-id"
                              fieldName="your-field-name">
                        <label slot="label-top" for="field-2">Your label</label>
                    </vue-dawa>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';


    export default {

        data: function () {
            return {
                yourAddressObject: {
                    oneLineAddress: '',

                },
                apiBase: 'http://dawa.aws.dk',

            }
        },

        mounted() {
            console.log('Component mounted.');
        },

        created() {

        },

        methods: {


            translateData (address) {

                if (!address || !address.data) {
                    return 'Not found';
                }
                return {
                    id: address.data.id,
                    street: address.data.vejnavn,
                    streetNumber: address.data.husnr,
                    floor: address.data.etage,
                    door: address.data.dør,
                    zipCode: address.data.postnr,
                    city: address.data.postnrnavn,
                    oneLineAddress: address.tekst
                }
            }

        },


    }
</script>
