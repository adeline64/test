<template>
  <div>
    <cart-size-component></cart-size-component>
    <filter-component
      :minChoice="minChoice"
      :maxChoice="maxChoice"
      :minRange="minRange"
      :maxRange="maxRange"
      @apply-filters="updateFilters"
    ></filter-component>
    <product-list-component :products="filteredProducts"></product-list-component>
  </div>
</template>

<script>
import CartSizeComponent from '../components/CartSizeComponent.vue';
import FilterComponent from '../components/FilterComponent.vue';
import ProductListComponent from '../components/ProductListComponent.vue';

export default {
  components: {
    CartSizeComponent,
    FilterComponent,
    ProductListComponent, // Utilisez le composant ProductListComponent ici
  },
  data() {
    return {
      minChoice: 0, // Initialisez avec les valeurs souhaitées
      maxChoice: 100, // Initialisez avec les valeurs souhaitées
      minRange: 0, // Initialisez avec les valeurs souhaitées
      maxRange: 800, // Initialisez avec les valeurs souhaitées
      products: [], // Tous les produits
      filteredProducts: [],
    };
  },
  methods: {
    async getProducts() {
      const res = await fetch('http://127.0.0.1:8000/api/products');
      const data = await res.json();
      this.products = data['hydra:member'];
      this.applyFilters(); // Appliquez les filtres au chargement initial
    },
    updateSlider(values) {
      this.minChoice = parseFloat(values[0]); // Convertir en nombre
      console.log("this.minChoice = parseFloat(values[0])", this.minChoice = parseFloat(values[0]));
      console.log("this.minChoice", this.minChoice);
      this.maxChoice = parseFloat(values[1]); // Convertir en nombre
      console.log("this.maxChoice = parseFloat(values[1])", this.maxChoice = parseFloat(values[1]));
      console.log("this.maxChoice", this.maxChoice);
      this.updateFilters(); // Mettez à jour les filtres lorsque le slider est mis à jour
      console.log("this.updateFilters();", this.updateFilters());
    },
    updateFilters(values) {
      console.log("updateFilters values", values);
      this.minChoice = parseFloat(values[0]);
      console.log("this.minChoice", this.minChoice);
      this.maxChoice = parseFloat(values[1]);
      console.log("this.maxChoice", this.maxChoice);
      this.applyFilters();
    },
    applyFilters() {
      console.log('minChoice:', this.minChoice);
      console.log('maxChoice:', this.maxChoice);
      this.filteredProducts = this.products.filter(product => {
        const productPrice = product.price;
        return productPrice >= this.minChoice * 100 && productPrice <= this.maxChoice * 100;
      });
    },
  },
  mounted() {
    this.getProducts();
    console.log("this.getProducts();", this.getProducts());
  },
};
</script>
