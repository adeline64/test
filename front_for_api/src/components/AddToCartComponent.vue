<script>
export default {
  methods: {
    addToCart() {
      this.$emit('add-to-cart', this.product, this.quantity);
      this.$el.textContent = "MODIFIER";
    },
  },
  props: ['product', 'quantity'],
};
</script>