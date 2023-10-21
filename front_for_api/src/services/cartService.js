export const getCart = () => {
  return JSON.parse(localStorage.getItem('cart')) ?? [];
}

export const getItemIndex = product => {
  return getCart().findIndex(item => item.name === product.name)
}

export const getProductCount = product => {
  const [cart, item] = getItemAndCart(product)

  return cart[item]?.count ?? null
}

const getItemAndCart = product => {
  return [getCart(), getItemIndex(product)]
}

const setCart = cart => {
  localStorage.setItem('cart', JSON.stringify(cart))
}

export const addToCart = product => {
  const [cart, item] = getItemAndCart(product)

  if (item !== -1) {
    cart[item].count += 1
  } else {
    cart.push({
      name: product.name,
      count: 1,
      unitPrice: product.price
    })
  }

  setCart(cart)
}

export const removeFromCart = product => {
  const [cart, item] = getItemAndCart(product)

  cart[item].count -= 1

  if (cart[item].count === 0) {
    cart.splice(item, 1)
  }

  setCart(cart)
}