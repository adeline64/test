<template>
    <main class="products">
      <ProductCard
        v-for="product in products"
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
        products: Array
    }
};
</script>
