<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    {{property.address.fulladdress}}
                </div>
                <div class="card-body">

                    <div class="row"></div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                property: {
                  address: {

                  },
                },
                bbr: {
                    /*propertyType: null, // BOLIGTYPE_KODE
                    energyConsumptionClass: null, // ENERGI_KODE
                    propertyTotalAreal: null, // ENH_ARL_SAML
                    YearOfConstruction: null, //OPRET_TS
                    rooms: null // VAERELSE_ANT*/

                },
                loading: false,
                hasError: false,
                ready: false,
            }

        },

        created() {
            this.indexData();

        },

        mounted() {

        },

        methods: {
            indexData() {

                this.loading = true;
                axios.get('showProperty')
                    .then(res => {
                        console.log(res.data);
                        this.property = res.data.data;
                        this.bbr = res.data.bbr;
                        this.loading = false;


                    }).catch(error => {
                    console.log(error.res.data);
                    this.error = error.res.data;
                    this.loading = false;
                    this.ready = false;
                    this.hasError = true;
                });
            }
        }
    }
</script>
