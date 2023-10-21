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