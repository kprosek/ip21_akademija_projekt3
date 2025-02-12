<template>
  <form @submit.prevent="fetchPrice" class="form-select-tokens">

    <label id="dropdown_token_from">From</label>
    <section class="section-select-token">

      <button v-if="isAuthenticated" @click.prevent="markFavourite('btn_from')" :disabled="tokenFrom === ''"
        class="btn btn-favourite" name="btn_favourite">
        <i :class="['fa-star', 'icon-favourite', 'fa-lg', isFromFavourite ? 'fa-solid' : 'fa-regular']"></i>
      </button>

      <select v-model="tokenFrom" @change="resetPrice" name="dropdown_token_from" required>
        <option disabled selected value="">Select:</option>
        <option v-for="item in dropdownList" :key="item" :value="item">
          {{ item }}
          <span v-if="userFavouriteTokens.includes(item)"> *</span>
        </option>
      </select>
    </section>

    <label id="dropdown_token_to">To</label>
    <section class="section-select-token">

      <button v-if="isAuthenticated" @click.prevent="markFavourite('btn_to')" :disabled="tokenTo === ''"
        class="btn btn-favourite" name="btn_favourite">
        <i :class="['fa-star', 'icon-favourite', 'fa-lg', isToFavourite ? 'fa-solid' : 'fa-regular']"></i>
      </button>

      <select v-model="tokenTo" @change="resetPrice" name="dropdown_token_to" required>
        <option disabled selected value="">Select:</option>
        <option v-for="item in dropdownList" :key="item" :value="item">
          {{ item }}
          <span v-if="userFavouriteTokens.includes(item)"> *</span>
        </option>
      </select>
    </section>

    <button class="btn btn-price"><i class="fa-solid fa-magnifying-glass"></i>Show
      Price</button>
  </form>

  <section v-if="price" class="section-border-price">
    <p class="text-token-price">Current Token value: 1 {{ tokenFrom }} = {{ price }}
      {{ tokenTo }}
    </p>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      userDropdownList: [],
      userFavouriteTokens: [],
      tokenFrom: '',
      tokenTo: '',
      price: '',
    };
  },
  props: {
    dropdownList: {
      type: Array
    },
    favouriteTokens: {
      type: Array
    },
    isAuthenticated: {
      type: Boolean
    }
  },
  computed: {
    isFromFavourite() {
      return this.userFavouriteTokens.includes(this.tokenFrom);
    },
    isToFavourite() {
      return this.userFavouriteTokens.includes(this.tokenTo);
    },
  },
  methods: {
    fetchPrice() {
      axios.get('/api/show-price', {
        params: {
          dropdown_token_from: this.tokenFrom,
          dropdown_token_to: this.tokenTo
        }
      }).then(response => {
        this.price = response.data.price
      })
    },
    markFavourite(button) {
      axios.post('/api/show-price', {
        dropdown_token_from: this.tokenFrom,
        dropdown_token_to: this.tokenTo,
        btn_favourite: button
      }, {
        withCredentials: true
      }).then(response => {
        this.userFavouriteTokens = response.data.userFavouriteTokens;
        console.log(this.userFavouriteTokens);
      })
    },
    resetPrice() {
      this.price = null
    }
  }, created() {
    this.userDropdownList = this.dropdownList;
    this.userFavouriteTokens = this.favouriteTokens;
  }
}
</script>