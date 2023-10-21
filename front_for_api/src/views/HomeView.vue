<script>
export default {
  data() {
    return {
      products: [],
    }
  },
  methods: {
    async getProducts() {
      const res = await fetch('http://127.0.0.1:8000/api/products')
      const data = await res.json()
      this.products = data['hydra:member']
    },
  },
  mounted() {
    this.getProducts()
  }
}
</script>

<script setup>
import ProductCard from '../components/ProductCard.vue'
</script>

<template>
  <main class="products">
    <ProductCard v-for="product in this.products" :key="product.id" :product="product" />
  </main>
</template>

<style>
.products {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin: 50px;
}
</style>