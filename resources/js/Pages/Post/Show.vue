<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post Details</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <img :src="post.image" alt="Post Image" class="w-full h-48 object-cover"/>
                        <h3 class="font-semibold text-lg text-gray-800">{{ post.title }}</h3>
                        <p class="text-gray-600">{{ post.content.substring(0, 100) + '...' }}</p>
                        <p class="text-gray-500 text-sm mt-2">Author: {{ author.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {defineProps} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    author: {
        type: Object
    }
});
</script>
