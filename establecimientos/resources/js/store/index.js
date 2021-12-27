import Vue from 'vue';
import Vuex from 'vueX';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cafes:[],
        restaurantes:[],
        hoteles:[],
        establecimiento:{}

        
    },
    mutations: {
        AGREGAR_CAFES(state, cafes){
            state.cafes = cafes;
        },
        AGREGAR_RESTAURANTES(state, restaurantes){
            state.restaurantes = restaurantes;
        },
        AGREGAR_HOTELES(state, hoteles){
            state.hoteles = hoteles;
        },
        AGREGAR_ESTABLECIMIENTO(state, establecimiento){
            state.establecimiento = establecimiento
        }
        
    },
    getters:{ // Segunda forma
        obtenerEstablecimiento: state => {
            return state.establecimiento
        }
    }
    
});