<template>
    <Head title="Artevo" />
    <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-white flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <!-- <img src="../../../public/dookas 1.jpg" alt="Logo" srcset="" width="100"> -->
                            <h1 class="text-2xl font-bold text-red-600 dark:text-red-400">Artevo</h1>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <a href="#hero" class="inline-flex items-center px-1 pt-1 border-b-2 border-red-600 text-sm font-medium text-red-600 dark:text-red-400">Home</a>
                            <a href="#features" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium hover:border-red-600 hover:text-red-600 dark:hover:text-red-400">Products</a>
                            <a href="#about" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium hover:border-red-600 hover:text-red-600 dark:hover:text-red-400">About</a>
                            <a href="#contact" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium hover:border-red-600 hover:text-red-600 dark:hover:text-red-400">Contact</a>
                        </div>
                    </div>
                    <!-- Removed register and login links block -->
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="hero" class="flex-grow bg-gradient-to-r from-red-500 via-pink-500 to-purple-600 flex flex-col justify-center items-center text-center px-6 py-20">
            <h2 class="text-5xl font-extrabold text-white mb-6 drop-shadow-lg fade-in">Welcome to Artevo</h2>
            <h2 class="text-2xl font-bold text-white mb-6 drop-shadow-lg fade-in delay-200">Powered By Dooski Karya Sinergi</h2>
            <p class="text-lg text-white max-w-2xl mb-10 drop-shadow-md fade-in delay-400">
                Discover the power of innovation and creativity with Artevo. Your gateway to modern solutions.
            </p>
            <div class="space-x-4">
                <a href="#features" class="inline-block bg-white bg-opacity-30 hover:bg-opacity-60 text-white font-semibold px-8 py-3 rounded-lg shadow-md transition-colors duration-300 transform hover:scale-105 hover:shadow-xl fade-in delay-600">Explore Products</a>
                <a href="#contact" class="inline-block border border-white border-opacity-40 hover:border-opacity-80 hover:bg-white hover:bg-opacity-30 text-white font-semibold px-8 py-3 rounded-lg shadow-md transition-colors duration-300 transform hover:scale-105 hover:shadow-xl fade-in delay-800">Contact Us</a>
            </div>
        </section>

        <!-- Products Section -->
        <section id="features" class="max-w-7xl mx-auto px-6 py-20">
            <h3 class="text-3xl font-bold text-center mb-12">Products</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 justify-center">
                <div v-for="product in pagedProducts" :key="product.id" class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow-md hover:shadow-2xl transition-colors duration-300 transform hover:scale-105 fade-in-up min-w-[280px] min-h-[400px] flex flex-col border border-gray-200 dark:border-gray-700" v-intersect>
                    <img v-if="product.image" :src="product.image" alt="product image" class="mb-4 rounded-md object-cover h-48 w-full transition-transform duration-300 transform hover:scale-110 flex-shrink-0" />
                    <h4 class="text-xl font-semibold mb-3 text-red-700 dark:text-red-500">{{ product.name }}</h4>
                    <p class="text-gray-800 dark:text-gray-300 mb-2 flex-grow">
                        {{ truncatedDescription(product.description) }}
                        <template v-if="isTruncated(product.description)">
                            ... <a @click.prevent="goToProduct(product.product_code)" href="#" class="text-red-700 dark:text-red-500 underline hover:text-red-900 dark:hover:text-red-400">view more</a>
                        </template>
                    </p>
                    <p class="text-gray-900 dark:text-white font-extrabold mt-auto">Price: Rp. {{ formatPrice(product.price) }}</p>
                </div>
            </div>
            <div class="flex justify-center mt-6 space-x-4 items-center">
                <div class="flex space-x-2 mx-4">
                    <button
                        v-for="index in totalPages"
                        :key="index"
                        @click="currentPage = index - 1"
                        :class="['w-3 h-3 rounded-full transition-colors duration-300', currentPage === index - 1 ? 'bg-red-600' : 'bg-gray-300']"
                    ></button>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="bg-gray-50 dark:bg-gray-900 py-20 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="text-3xl font-bold mb-6">About Artevo</h3>
                <p class="text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                    Artevo is dedicated to delivering innovative solutions that empower businesses and individuals to achieve their goals with cutting-edge technology and creative design.
                </p>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="max-w-4xl mx-auto px-6 py-20 text-center">
            <h3 class="text-3xl font-bold mb-6">Get in Touch</h3>
            <p class="mb-8 text-gray-700 dark:text-gray-300">Have questions or want to learn more? Reach out to us!</p>
            <a href="mailto:contact@artevo.com" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105 hover:shadow-xl">Email Us</a>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-100 dark:bg-gray-800 py-6 text-center text-gray-600 dark:text-gray-400">
            Dooski &copy; {{ new Date().getFullYear() }}
        </footer>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { formatPrice } from '../Helpers/formatPrice.js';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    products: {
        type: Array,
        required: true,
    },
});

const productsPerPage = 3;
const currentPage = ref(0);

const totalPages = computed(() => Math.ceil(props.products.length / productsPerPage));

const pagedProducts = computed(() => {
    const start = currentPage.value * productsPerPage;
    return props.products.slice(start, start + productsPerPage);
});

function prevPage() {
    if (currentPage.value > 0) {
        currentPage.value--;
    }
}

function nextPage() {
    if (currentPage.value < totalPages.value - 1) {
        currentPage.value++;
    }
}

function truncatedDescription(description) {
    const maxWords = 20;
    if (!description) return '';
    const words = description.split(' ');
    if (words.length <= maxWords) return description;
    return words.slice(0, maxWords).join(' ');
}

function isTruncated(description) {
    if (!description) return false;
    return description.split(' ').length > 20;
}

function goToProduct(productCode) {
    // Navigate to product detail page
    window.location.href = `/products/${productCode}`;
}

// Intersection Observer directive for fade-in-up animation
const intersect = {
    mounted(el) {
        el.classList.add('opacity-0', 'translate-y-6', 'transition-all', 'duration-700');
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    el.classList.remove('opacity-0', 'translate-y-6');
                    el.classList.add('opacity-100', 'translate-y-0');
                    observer.unobserve(el);
                }
            },
            { threshold: 0.1 }
        );
        observer.observe(el);
    },
};

defineExpose({ intersect });
</script>

<style scoped>
.fade-in {
    animation: fadeIn 1s ease forwards;
}
.fade-in.delay-200 {
    animation-delay: 0.2s;
}
.fade-in.delay-400 {
    animation-delay: 0.4s;
}
.fade-in.delay-600 {
    animation-delay: 0.6s;
}
.fade-in.delay-800 {
    animation-delay: 0.8s;
}
.fade-in-up {
    opacity: 0;
    transform: translateY(1.5rem);
    animation: fadeInUp 0.7s ease forwards;
}
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(1.5rem);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
