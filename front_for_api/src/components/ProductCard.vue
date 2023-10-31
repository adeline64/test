<script setup>
import { ref } from 'vue';
import { PlusCircleOutlined, MinusCircleOutlined } from '@ant-design/icons-vue'
import { addToCart, removeFromCart, getItemIndex, getProductCount } from '../services/cartService';

const props = defineProps(['product'])
const isPresentInCart = ref(getItemIndex(props.product) !== -1)
const productCount = ref(getProductCount(props.product) ?? 0)

const addProduct = product => {
  addToCart(product)
  isPresentInCart.value = true
  productCount.value += 1
}

const removeProduct = product => {
  removeFromCart(product)
  isPresentInCart.value = getItemIndex(product) !== -1
  productCount.value -= 1
}
</script>

<template>
  <div class="card">
    <img :src="'img/' + product.image">
    <div>
      <h3>{{ product.name }}</h3>
      <p>
        {{ (product.price / 100).toFixed(2) }} €
      </p>
      <div class="cart-interaction">
        <button :disabled="!isPresentInCart" @click="removeProduct(product)">
          <MinusCircleOutlined />
        </button>
        <p>{{ productCount }}</p>
        <button @click="addProduct(product)">
          <PlusCircleOutlined />
        </button>
      </div>
    </div>
  </div>
</template>