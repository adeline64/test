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

<style>
.card {
  border: 1px solid black;
  border-radius: 10px;
  padding: 10px;
  margin: 0 8px 8px 0;
  text-align: center;
}

.card img {
  width: 200px;
}

.card>div {
  padding-top: 1px;
  position: relative;
  box-sizing: border-box;
}

.card>div:before {
  content: "";
  position: absolute;
  border-bottom: 1px solid black;
  left: 0;
  top: 0;
  width: 100%;
}

.cart-interaction {
  display: flex;
  justify-content: space-around;
}

.cart-interaction button {
  background-color: transparent;
  border: none;
  font-size: 30px;
}

.cart-interaction button:hover {
  cursor: pointer;
}

.cart-interaction button:disabled:hover {
  cursor: auto;
}

.cart-interaction button:first-child {
  color: red;
}

.cart-interaction button:first-child:disabled {
  color: grey;
}

.cart-interaction button:last-child {
  color: green;
}
</style>