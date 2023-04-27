<template>
    <footer class="container-fluid col-12 col-md-12 row m-0 d-flex justify-content-between">
        <div class="footer-left  col-sm-6 nowrap col-md-6 text-center pt-2">
            <ul>
                <li>© 2022 Boolbnb</li>
                <li>·</li>
                <li>Privacy</li>
                <li>·</li>
                <li>Termini</li>
                <li>·</li>
                <li>Destinazioni</li>
            </ul>
        </div>
        <div class="footer-right col-sm-6 nowrap col-md-6 text-center pt-2">
            <ul>
                <li><i class="fa-solid fa-globe"></i> Italiano (IT)</li>
                <li>·</li>
                <li>Supporto e risorse</li>
            </ul>
        </div>
    </footer>
</template>

<script>
export default { name: "FooterComponent" };
</script>

<style scoped lang="scss">
// @import "@/assets/footer.scss";
// @import "/sass/_variables.scss";
footer {
    background-color: white;
    border-top: 1px solid rgba(128, 128, 128, 0.5);
    position: fixed;
    left: 0;
    bottom: 0;
    margin-top: 50px;

    .footer-left {
        ul {
            list-style: none;

            li {
                display: inline-block;
            }
        }
    }

    .footer-right {
        ul {
            list-style: none;

            li {
                display: inline-block;

            }
        }
    }

    @media only screen and (max-width: 575px) {
        max-height: 5%;

        // .footer-left {
        //     display: none;
        // }
        // .footer-right {
        //     display: none;
        // }
    }

    @media only screen and (max-width: 780px) {

        height: 8%;
        font-size: 12px;
    }
}
</style>
