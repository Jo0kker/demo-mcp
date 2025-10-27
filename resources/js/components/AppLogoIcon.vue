<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        :class="className"
        v-bind="$attrs"
    >
        <!-- Headset support icon -->
        <path d="M3 11c0-3.87 3.13-7 7-7h4c3.87 0 7 3.13 7 7v6c0 1.1-.9 2-2 2h-2c-1.1 0-2-.9-2-2v-2c0-1.1.9-2 2-2h2V11c0-2.76-2.24-5-5-5h-4C7.24 6 5 8.24 5 11v2h2c1.1 0 2 .9 2 2v2c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2v-6z"/>
        <path d="M19 16v2a2 2 0 0 1-2 2h-1"/>
    </svg>
</template>
