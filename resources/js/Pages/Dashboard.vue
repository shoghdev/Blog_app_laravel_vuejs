<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-10">
                    <a
                        class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 transition duration-200 mb-5"
                        href='/posts/create'>
                        Create Post
                    </a>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <List :posts="props.posts" :author="props.author" :creator="props.creator"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {defineProps} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import List from "@/Components/List.vue";

const props = defineProps({
    posts: {
        type: Array,
        required: true,
    },
    author: {
        type: Object,
        default: () => ({}),
    },
    creator: {
        type: Array
    }
});
</script>
