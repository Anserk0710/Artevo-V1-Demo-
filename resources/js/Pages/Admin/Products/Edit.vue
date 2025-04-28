    <template>
        <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>
        <form @submit.prevent="submit">
            <div v-for="field in fields" :key="field.name" class="mb-3">
            <label>{{ field.label }}</label>
            <input
                v-model="form[field.name]"
                :type="field.type || 'text'"
                class="w-full border p-2 rounded"
            />
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">
            Update
            </button>
        </form>
        </div>
    </template>
    
    <script setup>
    import { useForm } from '@inertiajs/vue3'
const { product } = defineProps({ product: Object })

const form = useForm({ ...product })
    
    const fields = [
        { name: 'name', label: 'Nama Produk' },
        { name: 'description', label: 'Deskripsi' },
        { name: 'price', label: 'Harga', type: 'number' },
        { name: 'size', label: 'Ukuran' },
        { name: 'material', label: 'Bahan' },
        { name: 'image', label: 'Gambar (URL)' },
    ]
    
    function submit() {
        form.put(route('products.update', form.id))
    }
    </script>
    