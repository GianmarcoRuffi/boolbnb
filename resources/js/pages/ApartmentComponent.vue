<template>
    <section class="container  pt-3 pb-5 bg-white my-3">

        <LoaderComponent v-if="loading" />
        <div class="row top justify-content-center py-3" v-if="apartment">


            <!-- scheda appartamento -->

            <div class="col-12 font-weigth-bold text-center">

                <h1 class="font-weight-bold">{{ apartment.title }}</h1>
            </div>
            <div class="col-12">
                <div class="slider-wrapper rounded" tabindex="0" @keydown.left="slidePrev" @keydown.right="slideNext">
                    <div class="item position-relative">
                        <div @click="slidePrev" class="prev">prev</div>
                        <div @click="slideNext" class="next">next</div>
                        <img class="img-fluid rounded" :src="`/storage/${apartment.images[indexActive].image}`"
                            :alt="apartment.title" />
                    </div>

                    <div class="thumbs d-flex rounded my-3">
                        <div @click="select(index)" class="thumb" :class="{ active: index === indexActive }"
                            v-for="(images, index) in apartment.images" :key="index">
                            <img class="rounded-bottom" :src="`/storage/${images.image}`" :alt="apartment.title" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-8 py-2">

                <h4>Intero Alloggio</h4>

                <span class="font-italic">
                    {{ apartment.rooms }} Camere -
                    {{ apartment.beds }} Posti Letto -
                    {{ apartment.bathrooms }} Bagni
                </span>
                <p v-html="apartment.description"></p>
            </div>
            <div class="price col-4 py-2">
                <h1>&#8364; {{ apartment.price }} / notte</h1>
            </div>
            <div class="col-12 py-2">
                <h3>Cosa Troverai:</h3>
                <div v-for="(service, index) in apartment.services" :key="index">
                    <ul>
                        <li>{{ service.name }}</li>
                    </ul>
                </div>
            </div>
            <p class="col-12 font-weight-bold"><i class="fa-solid fa-location-dot"></i> {{apartment.address}} </p> 
            <div class="border rounded">
                <map-component :apartment="apartment" />
            </div>
        </div>

        <div id="message-sent-container">
            <div class="message-sent">
                <span>Il messaggio è stato inviato correttamente all'host!</span>
            </div>

        </div>
        <div class="chat-image">
            <i class="first fa-solid fa-comments left" @click="display = true"></i>
            <div class="chat p-3 shadow-sm" v-if="display == true">
                <span class="chat-title">Invia un Messaggio all'host</span>
                <span class="chat-closer" @click="display = false">X</span>
                <form @submit.prevent="addMessage()">
                    <div class="form-group">
                        <label for="name">Nome*</label>
                        <input type="text" class="form-control" id="name" aria-describedby="name"
                            placeholder="Inserisci Name" v-model="formData.name" required autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label for="username">Email*</label>
                        <input type="text" class="form-control" id="email" aria-describedby="email"
                            placeholder="Inserisci email" v-model="formData.email" required autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label for="content">Messaggio*</label>
                        <textarea class="form-control" id="content" aria-describedby="content" cols="30" rows="7"
                            laceholder="Inserisci messaggio" v-model="formData.content" required
                            autocomplete="off"></textarea>
                    </div>
                    <button type="submit ">Invia Messaggio</button>

                </form>
            </div>
        </div>
    </section>
</template>


<!--/////////////////////////////////////////////// Script ///////////////////////////////////////////////////////-->

<script>
import MapComponent from "../components/MapComponent.vue";
import LoaderComponent from '../components/LoaderComponent.vue';

export default {
    name: "ApartmentComponent",
    components: {
        MapComponent,
        LoaderComponent,
    },
    data() {
        return {
            apartment: null,
            indexActive: 0,
            intervallo: null,
            display: false,
            loading: true,

            formData: {
                name: "",
                email: "",
                content: "",
                apartment_id: "",
            },
            userEmail: ''
        };
    },
    methods: {
        slidePrev() {
            if (this.indexActive === 0) {
                this.indexActive = this.apartment.images.length - 1;
            } else {
                this.indexActive -= 1;
            }
        },
        slideNext() {
            if (this.indexActive === this.apartment.images.length - 1) {
                this.indexActive = 0;
            } else {
                this.indexActive += 1;
            }
        },

        // Funzione di invio messaggio all'host

        addMessage() {

            axios
                .post("/api/messages", this.formData)
                .then((response) => {

                    console.log(this.apartment);
                    console.log(this.apartment.messages);
                    this.apartment.messages.push(response.data);


                })
                .catch((error) => {
                    console.log(error);
                });

            this.display = false;
            // alert("Il messaggio è stato inviato correttamente all'host!");
            document.getElementById("message-sent-container").style.display = 'block';
            setTimeout(function () {
                let alert = document.getElementById("message-sent-container");
                alert.style.display = 'none';
            }, 4000);
        },
    },
    mounted() {
        this.loading = true;
        // salvo lo slug passato dall'url
        const slug = this.$route.params.slug;
        // chiamo l'api passandole lo slug per ottenere il singolo appartamento
        axios.get(`/api/apartments/${slug}`).then((res) => {
            this.apartment = res.data;
            this.formData.apartment_id = this.apartment.id;
            this.loading = false;
        }).catch((error) => {
            this.loading = false;
            console.log(error)
        });
        // chiamo l'api che determina se l'utente è autenticato ed eventualmente mi restituisce la sua email
        axios.get(`/admin/users`).then((res) => {
            // inserisco nel campo dell'email ciò che torna dall'api
            this.formData.email = res.data
        }).catch((error) => {
            this.loading = false;
            console.log(error)
        })
    },
};
</script>


<!--/////////////////////////////////////////////////// Style //////////////////////////////////////////////////////////-->

<style scoped lang="scss">
.return-wrapper {

    width: 150px;
    height: 50px;

}

.return-button {

    background-color: #e61954;
    color: white;
    border: none;

    width: 150px;
    height: 50px;

    &:hover {
        background-color: #e6195363;
    }
}

.slider-wrapper {
    outline: 0;

    .item {
        position: relative;
        overflow: hidden;

        img {
            height: 100%;
        }

        .prev,
        .next {
            text-align: center;
            width: 100px;
            height: 100px;
            margin: 10px 0;
            border-radius: 50%;
            background: white;
            position: absolute;
            cursor: pointer;
            z-index: 980;
            line-height: 25px;
            text-transform: uppercase;
            padding: 10px;
            font-size: 1em;
            letter-spacing: 1.5px;
            color: #e61c54;
            top: 50%;
        }

        .next {
            transform: rotate(270deg);
            right: -60px;
        }

        .prev {
            left: -60px;
            transform: rotate(90deg);
        }
    }

    .thumbs {
        width: 100%;
        background: #000;

        .thumb {
            width: calc(100% / 5);
            opacity: 0.5;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        .thumb.active {
            border: 2px solid #ccc;
            opacity: 1;
        }
    }

    .description_container {
        border-bottom: 3px solid grey;
    }
}

#message-sent-container {


    position: fixed;
    right: 2%;
    bottom: 20%;
    // top: 50%;
    // left: 50%;
    z-index: 985;
    display: none;


    .message-sent {

        height: 150px;
        width: 300px;
        position: relative;
        border: 1px solid #e61954;
        border-radius: 10px;
        background-color: white;
        color: black;
        font-size: 26px;
        font-weight: bold;
        z-index: 985;
        text-align: left;
        padding: 10px;
    }
}

.chat-image {
    border-radius: 50%;
    background-color: #e61c54;
    width: 100px;
    height: 100px;
    position: fixed;
    right: 2%;
    bottom: 6%;
    z-index: 991;
    cursor: pointer;

    @media (max-width: 570px) {
        width: 60px;
        height: 60px;

    }

    .first {
        color: white;
        font-size: 50px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 992;


        @media (max-width: 570px) {
            font-size: 30px;

        }
    }



    .chat {
        width: 400px;
        height: 500px;
        position: fixed;
        bottom: 5%;
        right: 2%;
        z-index: 996;
        background-color: white;
        font-size: 14px;
        border-radius: 10px;

        @media (max-width: 400px) {
            width: 340px;
            height: 500px;


        }

        .chat-closer {
            font-size: 2em;
            color: #e61c54;
            font-weight: bolder;
            position: absolute;
            top: 0px;
            right: 10px;
        }

        .chat-title {
            font-size: 1.5em;
            color: #e61c54;
        }

        button {
            padding: 8px 28px;
            background-color: #e61c54;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;

            &:hover {
                background: #bc1746;
            }
        }
    }
}

@media (max-width: 570px) {
    .chat-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;

        .first {
            font-size: 20px;
        }

        .chat {
            width: 350px;
            height: 500px;
        }
    }
}

@media (max-width: 770px) {

    .top {

        margin-top: 10%;

    }

    // .return-wrapper {

    //     width: 130px;
    //     height: 30px;
    //     margin-top: 15%;


    // }

    .price h1 {
        font-size: 1.5rem;
        font-weight: bold;

    }

}
</style>
