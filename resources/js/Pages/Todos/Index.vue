<script setup>

import { defineProps } from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Button } from '@/Components/ui/button'

defineProps({
    todos: {
        type: Array,
        default: () => [],  // Ensure it's always an array
    },
})

const form = useForm({
    title: '',
    description: '',
})

const submit = () => {
    form.post('/todos', {
        onSuccess: () => form.reset(),
    })
}

const deleteTodo = (id) => {
    router.delete(`/todos/${id}`)
}
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">To-Do List</h2>
        </template>
        <div>
            <form @submit.prevent="submit">
                <input v-model="form.title" type="text" placeholder="New To-Do">
                <Button type="submit">Add</Button>
            </form>

            <ul>
                <li v-for="todo in todos" :key="todo.id">
                    {{ todo.title }}
                    <button @click="deleteTodo(todo.id)">Delete</button>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
