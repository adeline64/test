<script>
import CartSizeComponent from '../components/CartSizeComponent.vue';
import FilterComponent from '../components/FilterComponent.vue';
import ProductListComponent from '../components/ProductListComponent.vue';

export default {
  components: {
    CartSizeComponent,
    FilterComponent,
    ProductListComponent,
  },
  data() {
    return {
      minChoice: 0, // Initialisez avec les valeurs souhaitées
      maxChoice: 100, // Initialisez avec les valeurs souhaitées
      minRange: 0, // Initialisez avec les valeurs souhaitées
      maxRange: 200, // Initialisez avec les valeurs souhaitées
      products: [],
    };
  },
  methods: {
    async getProducts() {
      const res = await fetch('http://127.0.0.1:8000/api/products');
      const data = await res.json();
      this.products = data['hydra:member'];
    },
  },
  mounted() {
    this.getProducts();
  },
};

</script>

<template>
  <div>
    <cart-size-component></cart-size-component>
    <filter-component
      :minChoice="minChoice"
      :maxChoice="maxChoice"
      :minRange="minRange"
      :maxRange="maxRange"
    ></filter-component>
    <product-list-component :products="products"></product-list-component>
  </div>
</template>