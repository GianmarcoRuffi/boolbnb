<template>
    <div class="h-100">
        <HeaderComponent />
        <MainComponent />
        <FooterComponent />
    </div>
</template>

<script>


import MainComponent from "../components/MainComponent.vue";
import HeaderComponent from "../components/HeaderComponent.vue";
import FooterComponent from "../components/FooterComponent.vue";
export default {
    name: "App",
    components: {
        MainComponent,
        FooterComponent,
        HeaderComponent,

    },

}



</script>

<style lang="scss">
/* width */
::-webkit-scrollbar {
    width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px white;
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #e61954;
    border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #b30000;
}

#app {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Roboto", sans-serif;



}

// @import "@/_variables.scss";
</style>
