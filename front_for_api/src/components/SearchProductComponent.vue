<script>
export default {
  data() {
    return {
      searchValue: '',
    };
  },
  methods: {
    search() {
      if (this.searchValue.length > 1) {
        fetch(`${window.location.origin}/api-search/${this.searchValue}`)
          .then(response => response.json())
          .then(data => {
            this.$emit('search-results', data);
          });
      }
    },
  },
};
</script>