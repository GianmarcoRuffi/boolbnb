<template>

    <div class="preloader d-flex justify-content-center text-center align-items-center">
        <h1 class="m-3">Pagina in fase di caricamento...</h1>
        <div class="loader"></div>
    </div>
</template>

<script>
export default {

    name: 'LoaderComponent',

};


</script>

<style scoped lang="scss">
.preloader {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: white;
    z-index: 999;

    h1 {

        color: black;
    }

}




.loader {

    border: 16px solid #f3f3f3;
    border-top: 16px solid #e61954;
    border-bottom: 16px solid #e61954;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;

    @media only screen and (max-width: 600px) {
        display: none;
    }


}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>