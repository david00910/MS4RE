<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">List of properties</div>

                    <div class="card-body">
                        <ul v-for="property in properties">
                            <li>
                                <h5>ID:</h5>  {{ property.id }}
                            </li>
                            <li>
                                <h5>Description:</h5>  {{ property.description}}
                            </li>
                            <li>
                                <h5>Brutto:</h5> {{property.brutto}}
                            </li>
                            <li>
                                <h5>Netto:</h5> {{property.netto}}
                            </li>
                            <li>
                                <h5>Owner expense:</h5> {{property.own_exp}}
                            </li>
                            <li>
                                <h5>Price:</h5> {{property.price}}
                            </li>
                            <li>
                                <h5>m² price:</h5> {{property.sqm_price}}
                            </li>
                            <small>
                                Updated at: {{property.updated_at}}

                                Created at: {{property.created_at}}
                            </small>
                            <hr/>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        data: function () {
            return {
                properties: '',
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

                axios.get('/properties')
                    .then(res => {
                        console.log(res.data);
                        this.properties = res.data;
                    })
            }
        }
    }
</script>
