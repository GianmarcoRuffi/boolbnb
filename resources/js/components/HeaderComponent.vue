<template>
    <header>
        <nav class="container-fluid shadow-sm">
            <div
                class="row py-2 align-items-center justify-content-between text-center"
            >
                <div class="col-12 py-1 col-md-3">
                    <a href="/"
                        ><img
                            class="logo"
                            src="/images/LogoBoolbnb.png"
                            alt="boolbnblogo"
                    /></a>
                </div>
                <div
                    class="col-12 col-md-5 col-lg-4 py-1 input-box d-flex align-items-center justify-content-between py-2 shadow-sm"
                >
                    <input
                        type="text"
                        class="search-input text-center"
                        placeholder="Ricerca appartamenti"
                        name="search"
                        v-model="inputText"
                        autocomplete="off"
                        @keydown.enter="$router.push({ name: 'research', params: { userInput: inputText } })"
                    />
                    <!-- <router-link
                        :to="{ name: 'research', params: { userInput: inputText } }"
                    > -->
                    <div @click="$router.push({ name: 'research', params: { userInput: inputText } })">
                        <div
                            class="magnifying-box d-flex align-items-center justify-content-center"
                        >
                            <i class="text-white fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>
                    <!-- </router-link> -->
                </div>
                <div
                    class="col-12 col-md-3  d-flex align-items-center justify-content-center px-3"
                >
                    <a class="text-muted font-weight-bold" href="/register"
                        >Diventa un Host</a
                    >
                    <a
                        href="/admin"
                        class="user-box text-muted d-flex align-items-center border justify-content-center mx-3 p-3 shadow-sm"
                    >
                        <i class="fa-solid fa-user"></i>
                    </a>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: "HeaderComponent",
    data() {
        return {
            inputText: null,
        };
    },
    mounted() {},
};
</script>

<style scoped lang="scss">
nav{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    background-color: white;
    height: 70px;
    .logo {
        max-width: 180px;
    }
    .input-box {
        border: 1px solid grey;
        border-radius: 30px;
        height: 30px;
        .search-input {
            border-color: transparent;
            background-color: transparent;
            outline: none;
            width: 80%;
            border-right: 1px solid grey;
            font-weight: bold;
        }
        .magnifying-box {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #e61c54;
            &:hover {
                cursor: pointer;
                transform: scale(1.1);
            }
        }
    }
    .user-box {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: lightgrey;
        font-size: 1em;
        &:hover {
            cursor: pointer;
            transform: scale(1.1);
            background-color: rgb(179, 179, 179);
        }
    }
}
@media (max-width: 768px) {
  nav{
    height: 130px;
  }
}

</style>
