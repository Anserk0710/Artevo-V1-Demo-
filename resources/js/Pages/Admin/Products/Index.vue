<script setup>
import AdminLayout from '../../../Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link, router } from '@inertiajs/vue3';
import QRCodeVue from 'qrcode.vue';
import { ref } from 'vue';

defineProps({
    products: Object
});

const popupImage = ref(null);

function openPopup(imageUrl) {
    popupImage.value = imageUrl;
}

function closePopup() {
    popupImage.value = null;
}

function printQRCode(productId) {
    const printSection = document.getElementById(`print-section-${productId}`);
    if (!printSection) {
        alert('Bagian QR code tidak ditemukan.');
        return;
    }
    // Select canvas and svg elements inside the print section
    const canvasElement = printSection.querySelector('canvas');
    const svgElement = printSection.querySelector('svg');

    if (canvasElement) {
        // Print canvas as image
        const imgURI = canvasElement.toDataURL('image/png');
        const printWindow = window.open('', '', 'width=300,height=300');
        printWindow.document.write('<html><head><title>Cetak QR Code</title><style>body{margin:0;display:flex;justify-content:center;align-items:center;height:100vh;}</style></head><body><img src="' + imgURI + '" style="width:200px; height:200px;" /></body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    } else if (svgElement) {
        // Convert SVG to PNG with higher resolution for printing
        const svgData = new XMLSerializer().serializeToString(svgElement);
        const canvas = document.createElement('canvas');
        const size = 200; // desired size for print
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');
        const img = new Image();
        const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        const url = URL.createObjectURL(svgBlob);

        img.onload = () => {
            ctx.drawImage(img, 0, 0, size, size);
            URL.revokeObjectURL(url);
            const imgURI = canvas.toDataURL('image/png');

            const printWindow = window.open('', '', 'width=300,height=300');
            printWindow.document.write('<html><head><title>Cetak QR Code</title><style>body{margin:0;display:flex;justify-content:center;align-items:center;height:100vh;}</style></head><body><img src="' + imgURI + '" style="width:200px; height:200px;" /></body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        };
        img.onerror = () => {
            alert('Gagal memuat QR code untuk dicetak.');
        };
        img.src = url;
    } else {
        alert('QR code tidak ditemukan.');
    }
}

function destroy(routeName, id) {
    if (confirm('Apakah Anda Ingin Menghapus Data Ini?')) {
        router.delete(route(routeName, id));
    }
}

function formatPrice(value) {
    if (!value) return '0';
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function goToPage(url) {
    router.get(url);
}
</script>

<template>
    <Head title="Products" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 mb-2">
                    Daftar Produk
                </h2>
                <button
                    @click="router.get('/admin/products/create')"
                    class="px-3 py-1 sm:px-4 sm:py-2 text-sm sm:text-base bg-gradient-to-r from-teal-400 via-cyan-500 to-blue-500 text-white rounded shadow-lg transition-all duration-500 ease-in-out transform hover:scale-110 hover:shadow-4xl hover:brightness-110 hover:-translate-y-1"
                >
                    + Tambah Produk
                </button>
            </div>
        </template>

        <div>
            <div class="flex flex-col sm:flex-row flex-wrap gap-4 py-4 px-2">
                <div
                    v-for="product in products.data"
                    :key="product.id"
                    :id="`print-section-${product.id}`"
                    class="w-full sm:w-72 border p-4 rounded-lg print-area bg-white shadow-md"
                >
                    <h2 class="font-semibold text-lg mb-2">{{ product.name }}</h2>
                    <p class="mb-1 text-sm sm:text-base">Harga: Rp {{ formatPrice(product.price) }}</p>
                    <p class="mb-1 text-sm sm:text-base">Ukuran: {{ product.size }}</p>
                    <p class="mb-1 text-sm sm:text-base">Bahan: {{ product.material }}</p>
                    <p class="mb-1 text-sm sm:text-base">Kode Produk: {{ product.product_code }}</p>
                    <QRCodeVue :value="`http://127.0.0.1:8000/products/${product.product_code}`" :size="50" />
                    <div class="flex gap-3 mt-3">
                        <Link
                            :href="route('admin.products.edit', product.id)"
                            class="text-green-600 underline transition-transform duration-300 ease-in-out hover:scale-110 hover:animate-pulse text-sm sm:text-base"
                        >
                            Edit
                        </Link>
                        <button
                            @click="destroy('admin.products.destroy', product.id)"
                            class="text-red-600 underline transition-transform duration-300 ease-in-out hover:scale-110 hover:animate-pulse text-sm sm:text-base"
                        >
                            Hapus
                        </button>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button
                            v-if="product.image"
                            @click="openPopup(product.image)"
                            class="px-3 py-1 sm:px-4 sm:py-2 text-sm sm:text-base bg-gradient-to-r from-teal-400 via-cyan-500 to-blue-500 text-white rounded shadow-lg transition-all duration-500 ease-in-out transform hover:scale-110 hover:shadow-4xl hover:brightness-110 hover:-translate-y-1 hover:animate-pulse"
                        >
                            Lihat Gambar
                        </button>
                        <button
                            @click="printQRCode(product.id)"
                            class="px-3 py-1 sm:px-4 sm:py-2 text-sm sm:text-base bg-gradient-to-r from-teal-400 via-cyan-500 to-blue-500 text-white rounded shadow-lg transition-all duration-500 ease-in-out transform hover:scale-110 hover:shadow-4xl hover:brightness-110 hover:-translate-y-1 hover:animate-pulse"
                        >
                            Cetak QR
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button
                    :disabled="!products.prev_page_url"
                    @click.prevent="goToPage(products.prev_page_url)"
                    class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 transition duration-300 ease-in-out hover:brightness-110 disabled:hover:brightness-100"
                >
                    Sebelumnya
                </button>
                <button
                    :disabled="!products.next_page_url"
                    @click.prevent="goToPage(products.next_page_url)"
                    class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 transition duration-300 ease-in-out hover:brightness-110 disabled:hover:brightness-100"
                >
                    Berikutnya
                </button>
            </div>
        </div>

        <div
            v-if="popupImage"
            class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 animate__animated animate__fadeIn"
            @click.self="closePopup"
        >
            <div
                class="relative bg-white rounded p-4 max-w-full sm:max-w-lg max-h-full overflow-auto animate__animated animate__zoomIn"
            >
                <button
                    @click="closePopup"
                    class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 font-bold text-xl"
                >
                    &times;
                </button>
                <img
                    :src="popupImage"
                    alt="Gambar Produk"
                    class="max-w-full max-h-[80vh] rounded"
                />
            </div>
        </div>
    </AdminLayout>
</template>
