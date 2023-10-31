<template>
  <main class="products">
    <ProductCard
      v-for="product in filteredProducts"
      :key="product.id"
      :product="product"
    />
  </main>
</template>

<script>
import ProductCard from './ProductCard.vue'

export default {
  components: {
    ProductCard
  },
  props: {
    products: Array,
    minChoice: Number,
    maxChoice: Number,
  },
  computed: {
    filteredProducts() {
      return this.products.filter(product => {
        const productPrice = product.price; // Prix du produit en centimes
        return productPrice >= this.minChoice * 100 && productPrice <= this.maxChoice * 100;
      });
    },
  },
};
</script>
