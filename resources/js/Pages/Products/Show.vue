<script setup>
import { computed, ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  product: Object
});

const formattedPrice = computed(() => {
  if (!props.product.price && props.product.price !== 0) return '';
  // Convert number to string
  const priceStr = props.product.price.toString();
  // Use regex to add dot as thousand separator
  return priceStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
});

const likes = ref(props.product.likes || 0);
const likedKey = `liked_product_${props.product.product_code}`;
const liked = ref(false);

const likeProduct = async () => {
  if (liked.value) return;
  try {
    const response = await axios.post(`/products/${props.product.product_code}/like`);
    likes.value = response.data.likes;
    liked.value = true;
    localStorage.setItem(likedKey, 'true');
  } catch (error) {
    if (error.response && error.response.status === 429) {
      alert(error.response.data.message);
      liked.value = true;
      localStorage.setItem(likedKey, 'true');
    } else {
      alert('Terjadi kesalahan saat memberikan like.');
    }
  }
};

onMounted(() => {
  if (localStorage.getItem(likedKey) === 'true') {
    liked.value = true;
  }
});
</script>

<template>
  <div class="w-full min-h-screen p-6 md:p-12 bg-gradient-to-br from-yellow-50 via-yellow-100 to-yellow-200 rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-500 flex flex-col">
    <div class="flex flex-1 flex-col md:flex-row md:space-x-16">
      <div class="md:w-1/2 flex justify-center items-center mb-8 md:mb-0 max-h-[600px]">
        <img
          :src="product.image || 'https://via.placeholder.com/600x600.png?text=Product+Image'"
          alt="Product Image"
          class="rounded-xl object-cover w-full max-w-full max-h-full shadow-lg transition-transform duration-300 hover:scale-105"
        />
      </div>
      <div class="md:w-1/2 flex flex-col justify-between px-6 md:px-8 h-full text-gray-900">
        <div>
          <h1 class="text-4xl md:text-6xl font-extrabold mb-6 md:mb-8 text-yellow-600 drop-shadow-lg">{{ product.name }}</h1>
          <p class="text-2xl md:text-3xl text-yellow-700 font-bold mb-6 md:mb-8">Harga: Rp {{ formattedPrice }}</p>
          <p class="text-lg md:text-xl mb-6 md:mb-8 leading-relaxed text-yellow-900">{{ product.description }}</p>
          <div class="flex flex-col md:flex-row md:space-x-12 space-y-6 md:space-y-0 mb-8 md:mb-10">
            <div class="flex items-center space-x-4 text-yellow-700 drop-shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 md:h-8 w-7 md:w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4" />
              </svg>
              <span class="text-lg md:text-xl font-semibold"><strong>Ukuran:</strong> {{ product.size }}</span>
            </div>
            <div class="flex items-center space-x-4 text-yellow-700 drop-shadow-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 md:h-8 w-7 md:w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.485-9h-1M4.515 12h-1m15.364 4.95l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728l-.707-.707M6.343 17.657l-.707-.707" />
              </svg>
              <span class="text-lg md:text-xl font-semibold"><strong>Bahan:</strong> {{ product.material }}</span>
            </div>
          </div>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-8 space-y-5 sm:space-y-0">
          <button
            type="button"
            class="inline-flex items-center px-8 py-4 sm:px-8 sm:py-4 bg-yellow-500 text-white text-lg font-semibold rounded-xl shadow-lg hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-400 transition duration-300 w-full sm:w-auto justify-center disabled:opacity-60 disabled:cursor-not-allowed"
            :disabled="liked"
            @click="likeProduct"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
            {{ liked ? 'Liked' : 'Like' }} ({{ likes }})
          </button>
          <button
            type="button"
            class="inline-flex items-center px-10 py-4 sm:px-10 sm:py-4 bg-yellow-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:bg-yellow-700 focus:outline-none focus:ring-4 focus:ring-yellow-500 transition duration-300 w-full sm:w-auto justify-center"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
            </svg>
            Beli Sekarang
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
