<script>
export default {
  data() {
    return {
      cartSize: 0, // Initialisez la taille du panier à 0
    };
  },
  methods: {
    updateCartSize() {
      fetch(`${window.location.origin}/cartsize`)
        .then(response => response.text())
        .then(html => {
          this.cartSize = html;
        });
    },
  },
  mounted() {
    // Appelez la méthode pour mettre à jour la taille du panier lors du montage du composant
    this.updateCartSize();
  },
};
</script>

<template>
  <div>
    <p>Cart Size: {{ cartSize }}</p>
  </div>
</template>