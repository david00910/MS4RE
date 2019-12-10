<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col bg-brand-primary" style="height: 50px !important;">

                <div class="col p-2">
                <a class="btn btn-sm btn-outline-brand-greenish mt-1" :href="'/'"> < Back to list</a>
                </div>

            </div>
        </div>

        <div class="row">

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" style="max-height: 1080px !important;">
                    <div class="carousel-item active">
                        <img class="d-block w-100" :src="'/images/exampleHD.jpg'" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" :src="'/images/exampleHD.jpg'" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" :src="'/images/exampleHD.jpg'" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                   data-slide="prev">
                    <span class="carousel-control-prev-icon text-brand-greenish" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                   data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>


        <div class="row p-5">

            <div class="col-8">
                <h5 class="h5 p-3 text-brand-primary">{{property.address.fulladdress}}</h5>
                <p class="p-3 text-brand-charleston">{{property.description}}</p>
            </div>
            <div class="col">
                <ul class="list-group text-light">
                    <li v-if="bbr.BOLIGTYPE_KODE === '1'" class="list-group-item bg-brand-primary"><h5>Type</h5><span>Living apartment</span>
                    </li>
                    <li v-else-if="bbr.BOLIGTYPE_KODE === '2'" class="list-group-item bg-brand-primary"><h5>Type</h5>
                        <span>Occupational accomodation</span>
                    </li>
                    <li v-else-if="bbr.BOLIGTYPE_KODE === '3'" class="list-group-item bg-brand-primary"><h5>Type</h5>
                        <span>Single-room apartment</span>
                    </li>
                    <li v-else-if="bbr.BOLIGTYPE_KODE === '4'" class="list-group-item bg-brand-primary"><h5>Type</h5>
                        <span>Community house</span>
                    </li>
                    <li v-else-if="bbr.BOLIGTYPE_KODE === '5'" class="list-group-item bg-brand-primary"><h5>Type</h5>
                        <span>Summer house/apartment</span>
                    </li>
                    <li v-else-if="bbr.BOLIGTYPE_KODE === 'E'" class="list-group-item bg-brand-primary"><h5>Type</h5>
                        <span>Other(e.g. institution)</span>
                    </li>
                    <li v-if="bbr.ENERGI_KODE !== null" class="list-group-item bg-brand-primary"><h5>Energy</h5><span>Class {{bbr.ENERGI_KODE}}</span>
                    </li>
                    <li v-if="bbr.BEBO_ARL !== null" class="list-group-item bg-brand-primary"><h5>Living area</h5><span>{{bbr.BEBO_ARL}} m²</span>
                    </li>
                    <li v-if="bbr.ENH_ARL_SAML !== null" class="list-group-item bg-brand-primary"><h5>Total area</h5>
                        <span>{{bbr.ENH_ARL_SAML}} m²</span>
                    </li>
                    <li v-if="bbr.bygning.OPFOERELSE_AAR !== null" class="list-group-item bg-brand-primary"><h5>
                        Year</h5><span>{{bbr.bygning.OPFOERELSE_AAR}}</span>
                    </li>
                    <li v-if="bbr.VAERELSE_ANT !== null" class="list-group-item bg-brand-primary"><h5>Rooms</h5><span>{{bbr.VAERELSE_ANT}}</span>
                    </li>

                </ul>
            </div>
        </div>

        <div class="row p-5 bg-brand-greenish">
            <div class="col">
                <ul class="list-group list-group-horizontal-sm text-light">
                    <li class="list-group-item bg-brand-greenish"><h5>Price</h5><span>{{property.price | numeral('0,0')}} DKK</span>
                    </li>
                    <li class="list-group-item bg-brand-greenish"><h5>Brutto</h5><span>{{property.brutto | numeral('0,0')}} DKK</span>
                    </li>
                    <li class="list-group-item bg-brand-greenish"><h5>Netto</h5><span>{{property.netto | numeral('0,0')}} DKK</span>
                    </li>
                    <li class="list-group-item bg-brand-greenish"><h5>Owner's expense</h5><span>{{property.own_exp | numeral('0,0')}} DKK</span>
                    </li>
                    <li class="list-group-item bg-brand-greenish"><h5>Deposit</h5><span>{{property.deposit | numeral('0,0')}} DKK</span>
                    </li>
                    <li class="list-group-item bg-brand-greenish"><h5>m²</h5><span>{{property.sqm_price | numeral('0,0')}} DKK</span>
                    </li>
                </ul>
            </div>
            <div class="col-4">
                <div class="card bg-brand-charleston">
                    <div class="card-body text-light p-3">
                        <h5 class="h5">Do you have a question?</h5>
                        <p>Call us <strong>+45 88 99 99 99</strong> or</p>
                        <a class="btn btn-outline-brand-primary text-left" href="#">write to us.</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 p-0">
                <GmapMap
                    ref="mapRef"
                    :center="{lat: this.property.address.coordinate_y, lng: this.property.address.coordinate_x}"
                    :zoom="23"
                    map-type-id="terrain"
                    style="width: 100%; height: 500px;">
                    <GmapMarker
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :clickable="true"
                        :draggable="true"
                        @click="center=m.position"
                    />
                </GmapMap>
            </div>
        </div>

    </div>

</template>
<script>
    export default {
        data: function () {
            return {
                property: {
                    address: {},
                },
                propertyImages: '',
                markers: null,
                bbr: {
                    bygning: {
                        OPFOERELSE_AAR: null,
                    },
                    BOLIGTYPE_KODE: null,
                    ENERGI_KODE: null,
                    BEBO_ARL: null,
                    ENH_ARL_SAML: null,
                    VAERELSE_ANT: null

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
                var path = window.location.pathname;
                var segments = path.split("/");
                var id = segments[3];
                axios.get('showProperty/' + id)
                    .then(res => {
                        console.log(res.data);
                        this.property = res.data.data;

                        this.markers = [{
                            position: {
                                lat: res.data.data.address.coordinate_y,
                                lng: res.data.data.address.coordinate_x
                            }
                        }];

                        this.bbr = res.data.bbr[0];
                        this.loading = false;

                    }).catch(error => {
                    console.log(error.res.data);
                    this.error = error.res.data;
                    this.loading = false;
                    this.ready = false;
                    this.hasError = true;
                });
            },

        }
    }
</script>
