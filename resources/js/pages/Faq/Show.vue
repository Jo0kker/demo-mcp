<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

interface Faq {
    id: number;
    question: string;
    answer: string;
    category: string | null;
    view_count: number;
    created_at: string;
}

interface Props {
    faq: Faq;
}

defineProps<Props>();
</script>

<template>
    <div>
        <Head :title="`FAQ - ${faq.question}`" />

        <div class="min-h-screen bg-gray-50">
            <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <div class="mb-8">
                    <Link
                        href="/faqs"
                        class="inline-flex items-center text-blue-600 transition hover:text-blue-800"
                    >
                        <svg
                            class="mr-2 h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                        Retour à la liste
                    </Link>
                </div>

                <!-- FAQ Content -->
                <article class="rounded-lg bg-white p-8 shadow-sm">
                    <header class="mb-8">
                        <div class="mb-4 flex items-center gap-3">
                            <h1 class="text-3xl font-bold text-gray-900">
                                {{ faq.question }}
                            </h1>
                            <span
                                v-if="faq.category"
                                class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800"
                            >
                                {{ faq.category }}
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-4 text-sm text-gray-500"
                        >
                            <span>{{ faq.view_count }} vues</span>
                            <span>•</span>
                            <span>{{
                                new Date(faq.created_at).toLocaleDateString(
                                    'fr-FR',
                                )
                            }}</span>
                        </div>
                    </header>

                    <div class="prose max-w-none">
                        <p class="text-lg whitespace-pre-wrap text-gray-700">
                            {{ faq.answer }}
                        </p>
                    </div>
                </article>

                <!-- Help Section -->
                <div class="mt-8 rounded-lg bg-blue-50 p-6">
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">
                        Cette réponse vous a-t-elle aidé ?
                    </h3>
                    <p class="mb-4 text-gray-600">
                        Si vous avez besoin d'une assistance supplémentaire,
                        n'hésitez pas à contacter notre support.
                    </p>
                    <Link
                        href="/faqs"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700"
                    >
                        Voir d'autres questions
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
