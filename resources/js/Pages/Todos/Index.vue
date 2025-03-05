<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import { Button } from '@/Components/ui/button';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Wrapper from '@/Layouts/Wrapper.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import confetti from 'canvas-confetti';
import { defineProps, ref, watch } from 'vue';

const props = defineProps({
    todos: {
        type: Array,
        default: () => [],
    },
});
const todos = ref(props.todos);

watch(
    () => props.todos,
    (newTodos) => {
        todos.value = newTodos;
    },
);

const form = useForm({
    title: '',
    description: '',
});

const submit = () => {
    form.post('/todos', {
        onSuccess: () => form.reset(),
    });
};

const deleteTodo = (id) => {
    router.delete(`/todos/${id}`);
};

const updateTodo = (id, completed) => {
    router.put(
        `/todos/${id}`,
        {
            completed: completed,
        },
        {
            onSuccess: () => {
                // After the server updates the data, check if all todos are completed
                if (completed && todos.value.every((todo) => todo.completed)) {
                    triggerConfetti();
                }
            },
        },
    );
};

const triggerConfetti = () => {
    confetti({
        particleCount: 150,
        spread: 90,
        origin: { y: 0.6 },
    });
};
</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                To-Do List
            </h2>
        </template>
        <Wrapper>
            <form @submit.prevent="submit" class="flex flex-row flex-wrap items-center justify-start gap-2 lg:w-1/2">
                <input class="flex-grow dark:bg-gray-700"
                       v-model="form.title" type="text" placeholder="New To-Do" />
                <Button class = "dark:border dark:border-gray-700" type="submit">Add</Button>
                <fieldset class="flex w-full justify-between hidden">
                    <legend>Manage</legend>
                    <Button>Archive Completed</Button>
                </fieldset>
            </form>
            <ul aria-live="polite" class="flex flex-col justify-start lg:w-1/2">
                <li v-for="todo in todos" :key="todo.id" :class="{
                    'light:bg-gray-400 text-gray-500 dark:bg-gray-900 line-through':
                        todo.completed,
                    'text-black dark:text-white': !todo.completed,
                }" class="my-2 flex items-center justify-between gap-2 pl-2 even:bg-gray-100 dark:even:bg-gray-800">
                    <Checkbox :aria-checked="todo.completed.toString()" :checked="todo.completed"
                        @change="updateTodo(todo.id, $event.target.checked)" />
                    {{ todo.title }}
                    <Button class="ml-auto dark:border  dark:border-gray-700" @click="deleteTodo(todo.id)">Delete
                    </Button>
                </li>
            </ul>
        </Wrapper>
    </AuthenticatedLayout>
</template>
