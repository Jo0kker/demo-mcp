<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
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
    stats: {
        totalFaqs: number;
        publishedFaqs: number;
        totalViews: number;
    };
    recentFaqs: Faq[];
    topFaqs: Faq[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-3">
                <div
                    class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                Total FAQs
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.totalFaqs }}
                            </p>
                        </div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                FAQs Publiées
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.publishedFaqs }}
                            </p>
                        </div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100"
                        >
                            <svg
                                class="h-6 w-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">
                                Vues Totales
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ stats.totalViews.toLocaleString() }}
                            </p>
                        </div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100"
                        >
                            <svg
                                class="h-6 w-6 text-purple-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two columns -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Recent FAQs -->
                <div
                    class="rounded-lg border border-gray-200 bg-white shadow-sm"
                >
                    <div
                        class="flex items-center justify-between border-b border-gray-200 px-6 py-4"
                    >
                        <h2 class="text-lg font-semibold text-gray-900">
                            FAQs Récentes
                        </h2>
                        <Link
                            href="/admin/faqs"
                            class="text-sm text-blue-600 hover:text-blue-800"
                        >
                            Voir tout
                        </Link>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <Link
                            v-for="faq in recentFaqs"
                            :key="faq.id"
                            :href="`/admin/faqs/${faq.id}/edit`"
                            class="block px-6 py-4 transition hover:bg-gray-50"
                        >
                            <p class="line-clamp-1 font-medium text-gray-900">
                                {{ faq.question }}
                            </p>
                            <div class="mt-1 flex items-center gap-2">
                                <span
                                    v-if="faq.category"
                                    class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800"
                                >
                                    {{ faq.category }}
                                </span>
                                <span class="text-xs text-gray-500"
                                    >{{ faq.view_count }} vues</span
                                >
                            </div>
                        </Link>
                        <div
                            v-if="recentFaqs.length === 0"
                            class="px-6 py-8 text-center text-gray-500"
                        >
                            Aucune FAQ pour le moment
                        </div>
                    </div>
                </div>

                <!-- Top FAQs -->
                <div
                    class="rounded-lg border border-gray-200 bg-white shadow-sm"
                >
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">
                            FAQs les plus consultées
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <Link
                            v-for="faq in topFaqs"
                            :key="faq.id"
                            :href="`/admin/faqs/${faq.id}/edit`"
                            class="block px-6 py-4 transition hover:bg-gray-50"
                        >
                            <div class="flex items-start justify-between">
                                <p
                                    class="line-clamp-1 flex-1 font-medium text-gray-900"
                                >
                                    {{ faq.question }}
                                </p>
                                <span
                                    class="ml-2 text-sm font-semibold text-purple-600"
                                >
                                    {{ faq.view_count }}
                                </span>
                            </div>
                            <span
                                v-if="faq.category"
                                class="mt-2 inline-block rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800"
                            >
                                {{ faq.category }}
                            </span>
                        </Link>
                        <div
                            v-if="topFaqs.length === 0"
                            class="px-6 py-8 text-center text-gray-500"
                        >
                            Aucune FAQ consultée
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
            >
                <h2 class="mb-4 text-lg font-semibold text-gray-900">
                    Actions rapides
                </h2>
                <div class="flex gap-4">
                    <Link
                        href="/admin/faqs/create"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700"
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
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        Créer une FAQ
                    </Link>
                    <Link
                        href="/admin/faqs"
                        class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-gray-700 transition hover:bg-gray-300"
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
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"
                            />
                        </svg>
                        Gérer les FAQs
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
