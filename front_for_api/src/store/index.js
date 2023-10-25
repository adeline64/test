import { createStore } from 'vuex';

const store = createStore({
  state: {
    isLoggedIn: false, // Définissez l'état initial à la déconnexion
  },
  mutations: {
    setLoggedIn(state, value) {
      state.isLoggedIn = value;
    },
  },
  actions: {
    login({ commit }) {
      commit('setLoggedIn', true);
    },
    logout({ commit }) { // Ajoutez un objet de paramètre commit
      commit('setLoggedIn', false);
    },
  },
  getters: {
    isLoggedIn: (state) => state.isLoggedIn,
  },
});

export default store;
