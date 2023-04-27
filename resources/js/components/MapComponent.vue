<template>
    <div class="map-container w-100">
        <div id="map"></div>
    </div>
</template>

<script>
export default {
    name: "Map",

    mounted() {
        const apartmentcoordinates = [
            this.apartment.longitude,
            this.apartment.latitude,
        ];
        const map = tt.map({
            container: "map",
            key: "YeAUs1VSBC9gVGieDMDGZZVGtnxy9myl",
            center: apartmentcoordinates,
            zoom: 15,
        });
        const apartmentmarker = new tt.Marker()
            .setLngLat(apartmentcoordinates)
            .addTo(map);
    },

    props: {
        apartment: Object,
    },
};
</script>

<style>
#map {
    height: 50vh;
    width: 50vw;
}


@media only screen and (max-width: 570px) {
    #map {
        height: 50vh;
        width: 80vw;
    }

    .map-container {

        display: flex;
        justify-content: center;
        align-items: center;
    }

}
</style>
