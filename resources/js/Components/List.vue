<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="post in $page.props.posts" :key="post.id"
                     class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img :src="post.image" alt="Post Image" class="w-full h-48 object-cover"/>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800">{{ post.title }}</h3>
                        <p class="text-gray-600">{{ post.content.substring(0, 100) + '...' }}</p>
                        <p class="text-gray-500 text-sm mt-2">Author: {{ post.author.name }}</p>
                        <div class="mt-4 flex space-x-2">
                            <NavLink
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200"
                                :href="route('posts.show', post.id)"> Show
                            </NavLink>
                            <NavLink
                                :href="route('posts.edit', { post: post.id })"
                                v-if="$page.props.creator"
                                class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition duration-200">
                                Edit
                            </NavLink>
                            <button
                                v-if="$page.props.creator"
                                @click="deletePost(post)"
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-200">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps} from 'vue';
import NavLink from "../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/NavLink.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
});
const deletePost = (post) => {
    router.delete(route('posts.destroy', post));
};

const {posts, author} = props;
</script>
