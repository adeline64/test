<script>
  import noUiSlider from 'nouislider';
  import 'nouislider/dist/nouislider.css';
  
  export default {
    props: {
      minChoice: Number,
      maxChoice: Number,
      minRange: Number,
      maxRange: Number,
    },
    data() {
      return {
        minHidden: 0,
        maxHidden: 0,
      };
    },
    mounted() {
    const minChoice = parseInt(this.minChoice) / 100;
    const maxChoice = parseInt(this.maxChoice) / 100;
    const minRange = parseInt(this.minRange) / 100;
    const maxRange = parseInt(this.maxRange) / 100;

    const slider = this.$refs.slider;

    noUiSlider.create(slider, {
      start: [minChoice, maxChoice],
      connect: true,
      range: {
        'min': minRange,
        'max': maxRange,
      },
      behaviour: 'tap-drag',
      tooltips: true,
    });

    const refresh = (values) => {
      console.log("values" , values);
      this.minHidden = values[0];
      console.log("minHiden", this.minHidden = values[0]);
      this.maxHidden = values[1];
      console.log("maxHidden", this.maxHidden = values[1]);
      this.$emit('apply-filters', [this.minHidden, this.maxHidden]); // Émet l'événement apply-filters
      console.log("values" , values);
      console.log("this.$emit('apply-filters', [this.minHidden, this.maxHidden]", this.$emit('apply-filters', [this.minHidden, this.maxHidden]));
    };

    slider.noUiSlider.on("update", refresh);
  },
};
  </script>

<template>
  <div>
    <div ref="slider"></div>
  </div>
</template>