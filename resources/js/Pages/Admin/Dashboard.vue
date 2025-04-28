<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Example card 1 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
                    <p class="text-gray-700">Number of registered users, active users, etc.</p>
                </div>

                <!-- Example card 2 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Status</h3>
                    <p class="text-gray-700">Server uptime, recent errors, and performance metrics.</p>
                </div>

                <!-- Example card 3 -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                    <p class="text-gray-700">Latest admin actions and user activities.</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
