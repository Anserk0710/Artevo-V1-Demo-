<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-md border border-gray-300 shadow-sm px-3 py-2 transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        v-model="model"
        ref="input"
    />
</template>
