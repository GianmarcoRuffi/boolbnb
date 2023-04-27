<template>
    <div class="container">
        <LoaderComponent v-if="loading" />

        <section class="row d-flex justify-content-center mb-5">

            <!-- leftbar -->

            <div
                class="bg-white ml-2 col-12 col-md-10 col-lg-3 leftbar row d-flex justify-content-center align-items-center rounded shadow my-3">
                <!-- / Search Container -->

                <h3 class="py-3">Filtra la tua ricerca</h3>

                <!-- search boxes -->

                <div class="search-box col-sm-12  col-md-10 col-lg-12 py-3 m-3">
                    <label for="min_rooms">Numero minimo di stanze:</label>
                    <input type="number" id="min_rooms" name="min_rooms" v-model="userRooms" />
                </div>

                <div class="search-box col-sm-12 col-lg-12 col-md-10 py-3 m-3">
                    <label for="min_beds">Numero minimo di posti letto:</label>
                    <input type="number" id="min_beds" name="min_beds" v-model="userBeds" />
                </div>

                <!-- Km range -->
                <div class="search-box m-3 col-sm-12 col-lg-12 col-md-10 py-3 text-center align-text-center">
                    <label for="radius">Raggio di ricerca:</label>
                    <input class="user-range" type="range" min="1" max="100" value="20" id="radius" name="radius"
                        v-model="userRange" />
                    <span>{{ userRange }} km</span>
                </div>

                <!-- Servizi -->

                <div class="services-box col-sm-12 col-lg-12 col-md-10 py-3 m-3">
                    <h5 class="mb-4 mt-2">Servizi:</h5>
                    <div v-for="(service, index) in services" :key="index" class="form-check-inline d-flex">
                        <input type="checkbox" class="mr-3" :id="service.id" :value="service.id"
                            v-model="userServices" />
                        <label class="service-label" :for="service.id">{{
                                service.name
                        }}</label>
                    </div>

                    <!-- Filter button -->

                    <button class="filter-button rounded w-100" type="button" @click="search()">
                        Filtra
                    </button>
                </div>
            </div>

            <!-- Appartamenti ricercati -->


            <div v-if="apartments !== null && apartments.length > 0" class="found-apartments col-12 col-lg-8 offset-1">
                <div class="apartments-box row justify-content-center">
                    <!-- <h1>Appartamenti ricercati:</h1> -->
                    <div class="row my-3 mx-3" v-for="(apartment, index) in apartments" :key="index"
                        v-show="apartments">
                        <!-- inizio Card -->
                        <div class="card shadow" style="width: 500px, height: 500px" v-if="apartment.visible">
                            <div class="row no-gutters">
                                <div class="col-sm-5 d-flex justify-content-center align-items-center">
                                    <img :src="`../storage/${apartment.images[0].image}`" class="img-fluid rounded"
                                        :alt="apartment.title" />
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{ apartment.title }}
                                        </h5>

                                        <p v-html="apartment.description" class="card-text abstract"></p>

                                        <router-link :to="{
                                            name: 'apartment',
                                            params: {
                                                slug: apartment.slug,
                                            },
                                        }" target="_blank">Visualizza
                                            appartamento</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /fine Card -->
                    </div>
                </div>
            </div>

            <div v-else-if="apartments !== null" class="failed-research py-5 col-12 col-lg-8 offset-1">
                <div class="row justify-content-center"></div>
                <h1>
                    Siamo spiacenti, la tua ricerca non ha prodotto alcun risultato.
                </h1>
            </div>

        </section>
    </div>
</template>

<script>

import LoaderComponent from '../components/LoaderComponent.vue';


export default {
    name: "ResearchComponent",

    components: {
        LoaderComponent


    },
    // props: {
    //     msg: String
    // },

    data() {
        return {
            apartments: null,
            aptServices: null,
            services: null,
            userRooms: null,
            userBeds: null,
            userRange: 20,
            userServices: [],
            loading: false,

        };
    },
    methods: {
        // definisco la funzione di ricerca
        search() {
            this.apartments = null;
            this.loading = true;
            // trasformo in stringa l'array di servizi scelti dall'utente
            const inputServices = JSON.stringify(this.userServices);
            // chiamo l'api impostata nel controller passandole gli input dell'utente e salvo la lista di appartamenti restituita
            const inputText = this.$route.params.userInput;

            axios
                .get(`/api/apartments/${inputText}/${this.userRange}/${this.userRooms}/${this.userBeds}/${inputServices}`)
                .then((response) => {
                    this.apartments = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
        },
    },
    mounted() {

        // al caricamento del componente chiamo la funzione per ricercare gli appartamenti (verrà eseguita una prima ricerca senza filtri, solo per distanza)
        this.search();

        // salvo tutti i servizi nel db tramite api
        axios
            .get("/api/services")
            .then((response) => {
                this.services = response.data;

            })
            .catch((error) => {
                console.log(error);

            });


    },



    // quando l'url del componente cambia, viene eseguita di nuovo la funzione search
    watch: {
        $route(to, from) {
            this.search();
        },
    },



};
</script>

<style scoped lang="scss">
html {
    scroll-behavior: smooth;
}

::-webkit-scrollbar {
    width: 4px;
}

p.abstract {
    max-height: 200px;
    overflow-y: auto;
}

section {
    width: 100%;
    height: 100%;
}

.leftbar {

    height: 100%;



}

.search-box {
    border: 1px solid #e61954;
    border-radius: 5px;
    width: 100%;
}

.services-box {
    border: 1px solid #e61954;
    border-radius: 5px;
    width: 100%;
    padding: 10%;

    h5 {
        font-weight: bold;
    }

    input[type="checkbox"] {
        transform: scale(1.5);
    }

    .filter-button {
        margin-top: 7%;
        background-color: #e61954;
        color: white;
        border: none;

        width: 150px;
        height: 50px;

        &:hover {
            background-color: #e6195363;
        }
    }
}

.card-title {
    color: #003580;
    font-weight: bold;
    text-transform: uppercase;
}

.img-fluid {
    object-fit: cover;
    height: 100%;
    max-width: 90%;
    max-height: 90%;
}


/*.apartments-box {
    background-color: white;
    max-width: 70%;
    max-height: 90%;
    overflow-y: auto;
}*/

// .apartment-card {
//   width: 500px;
//   border: solid 1px rgb(0, 0, 0);

//
// }
</style>
