/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component("AppMain", require("./components/AppMain.vue").default);
// Vue.component("Header", require("./components/Header.vue").default);
// Vue.component("Footer", require("./components/Footer.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});

window.boolbnb = {
    currentForm: null,
    apartment_id: null,
    openModal(e, id){
        e.preventDefault();
        this.apartment_id = id;
        this.currentForm = e.currentTarget.parentNode;
        $('#deleteModal-body').html('Sicuro di voler cancellare l\'appartamento');
        $('#deleteModal').modal('show');
    },
    submitForm(){
        this.currentForm.submit();
    }
}

// associo al click del bottone la funzione di validazione
document.getElementById('register_btn').addEventListener('click', validate);
// salvo il form
const form = document.getElementById('registration_form');
// imposto il messaggio d'errore
const errorMessage = 'Le password non coincidono';

function validate(event){
    // fermo l'invio del form
    event.preventDefault();
    // salvo i due campi password
    const password = document.getElementById('password');
    const password_confirm = document.getElementById('password-confirm');
    // confronto i loro valori
    if(password.value != password_confirm.value){
        // se non combaciano invio il messaggio d'errore
        password_confirm.setCustomValidity(errorMessage);
        password_confirm.reportValidity();
    } else {
        // se combaciano invio il form
        form.submit();
    }
}