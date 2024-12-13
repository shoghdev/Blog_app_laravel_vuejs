<template>
    <Head :title="isEditMode ? 'Edit Post' : 'Create Post'"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{
                    isEditMode ? 'Edit Post' : 'Create Post'
                }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-center">
                        <div class="w-full">
                            <form @submit.prevent="submit" class="mt-6 p-4 space-y-6">
                                <div class="relative">
                                    <InputLabel for="title" value="Title"/>
                                    <TextInput
                                        id="title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :class="{ 'border-red-500': form.errors.title }"
                                        v-model="form.title"
                                        autocomplete="title"
                                    />
                                    <InputError class="mt-2" :message="form.errors.title"/>
                                </div>

                                <div class="relative">
                                    <InputLabel for="content" value="Content"/>
                                    <TextAreaInput
                                        id="content"
                                        class="mt-1 block w-full"
                                        :class="{ 'border-red-500': form.errors.content }"
                                        v-model="form.content"
                                    />
                                    <InputError class="mt-2" :message="form.errors.content"/>
                                </div>
                                <div class="mb-4">
                                    <InputLabel class="block text-sm font-medium text-gray-700 mb-2">Add image to the
                                        post
                                    </InputLabel>
                                    <input
                                        type="file"
                                        @change="handleFileChange"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border file:border-gray-300 file:bg-pink-600 file:text-white hover:file:bg-pink-700 transition duration-200"
                                    />
                                    <InputError class="mt-2" :message="form.errors.image"/>
                                </div>
                                <div class="flex items-center gap-4">
                                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import * as Yup from 'yup';
import {computed} from 'vue';

const props = defineProps({
    post: {
        type: Object,
        default: null
    }
});

const isEditMode = computed(() => !!props.post);

const form = useForm({
    title: props.post?.title || '',
    content: props.post?.content || '',
    image: null
});

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};

const schema = Yup.object({
    title: Yup.string().max(120, 'Title must be at most 120 characters').required('Title is required'),
    content: Yup.string().min(56, 'Content must be at least 56 characters').required('Content is required'),
    image: Yup.mixed()
        .test('fileType', 'Only JPEG, WEBP or PNG files are allowed', (value) =>
            value ? ['image/jpeg', 'image/png', 'image/webp'].includes(value.type) : false
        ),
});

const submit = async () => {
    try {
        await schema.validate({
            title: form.title,
            content: form.content,
            image: form.image,
        }, {abortEarly: false});

        const formData = new FormData();
        formData.append('title', form.title);
        formData.append('content', form.content);
        formData.append('image', form.image);

        if (isEditMode.value) {
            console.log("edit")
            console.log("Route:", route('posts.update', props.post.id));
            form.patch(route('posts.update',  props.post.id), {
                data:formData,
                preserveScroll: true,
                onSuccess: () => {
                    console.log("Post updated successfully");
                    form.reset();
                },
            });
        } else {
            console.log("Create mode detected, sending POST request");
            form.post(route('posts.store'), {
                data: formData,
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                },
            });
        }
    } catch (error) {
        if (error.inner) {
            form.errors = {};
            error.inner.forEach((e) => {
                form.errors[e.path] = e.message;
            });
        }
    }
};

</script>
