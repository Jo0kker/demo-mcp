<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

interface Faq {
    id: number;
    question: string;
    answer: string;
    category: string | null;
    view_count: number;
    created_at: string;
}

interface Props {
    faqs: {
        data: Faq[];
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
    categories: string[];
    filters: {
        category?: string;
        search?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');

const performSearch = () => {
    router.get(
        '/faqs',
        {
            search: search.value,
            category: selectedCategory.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

const clearFilters = () => {
    search.value = '';
    selectedCategory.value = '';
    router.get('/faqs');
};
</script>

<template>
    <div>
        <Head title="FAQ - Centre d'aide" />

        <div class="min-h-screen bg-gray-50">
            <!-- Top Bar with Auth -->
            <div class="border-b border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-end gap-3">
                        <template v-if="page.props.auth?.user">
                            <Link
                                href="/dashboard"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/login"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Se connecter
                            </Link>
                            <Link
                                href="/register"
                                class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700"
                            >
                                S'inscrire
                            </Link>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-12 text-center">
                    <h1 class="mb-4 text-4xl font-bold text-gray-900">
                        Centre d'aide
                    </h1>
                    <p class="mb-6 text-xl text-gray-600">
                        Trouvez rapidement des réponses à vos questions
                    </p>
                    <Link
                        v-if="page.props.auth?.user"
                        href="/faqs/create"
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
                </div>

                <!-- Filtres -->
                <div class="mb-8 rounded-lg bg-white p-6 shadow-sm">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="col-span-2">
                            <label
                                for="search"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Rechercher
                            </label>
                            <input
                                id="search"
                                v-model="search"
                                type="text"
                                placeholder="Rechercher dans les questions..."
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                @keyup.enter="performSearch"
                            />
                        </div>
                        <div>
                            <label
                                for="category"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Catégorie
                            </label>
                            <select
                                id="category"
                                v-model="selectedCategory"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                @change="performSearch"
                            >
                                <option value="">Toutes les catégories</option>
                                <option
                                    v-for="category in categories"
                                    :key="category"
                                    :value="category"
                                >
                                    {{ category }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button
                            @click="performSearch"
                            class="rounded-md bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700"
                        >
                            Rechercher
                        </button>
                        <button
                            v-if="search || selectedCategory"
                            @click="clearFilters"
                            class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 transition hover:bg-gray-300"
                        >
                            Réinitialiser
                        </button>
                    </div>
                </div>

                <!-- Liste des FAQs -->
                <div class="space-y-4">
                    <div
                        v-for="faq in faqs.data"
                        :key="faq.id"
                        class="rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md"
                    >
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <Link :href="`/faqs/${faq.id}`" class="flex-1">
                                    <div class="mb-2 flex items-center gap-3">
                                        <h2
                                            class="text-xl font-semibold text-gray-900"
                                        >
                                            {{ faq.question }}
                                        </h2>
                                        <span
                                            v-if="faq.category"
                                            class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800"
                                        >
                                            {{ faq.category }}
                                        </span>
                                    </div>
                                    <p class="line-clamp-2 text-gray-600">
                                        {{ faq.answer }}
                                    </p>
                                </Link>
                                <div class="ml-4 flex flex-col items-end gap-2">
                                    <span class="text-sm text-gray-500"
                                        >{{ faq.view_count }} vues</span
                                    >
                                    <Link
                                        v-if="page.props.auth?.user"
                                        :href="`/faqs/${faq.id}/edit`"
                                        class="flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            />
                                        </svg>
                                        Éditer
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="faqs.data.length === 0"
                        class="py-12 text-center"
                    >
                        <p class="text-gray-600">
                            Aucune FAQ trouvée pour cette recherche.
                        </p>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    v-if="faqs.links.length > 3"
                    class="mt-8 flex justify-center gap-2"
                >
                    <Link
                        v-for="(link, index) in faqs.links"
                        :key="index"
                        :href="link.url || ''"
                        :class="[
                            'rounded-md px-4 py-2 transition',
                            link.active
                                ? 'bg-blue-600 text-white'
                                : 'bg-white text-gray-700 hover:bg-gray-100',
                            !link.url ? 'cursor-not-allowed opacity-50' : '',
                        ]"
                        :disabled="!link.url"
                    >
                        <span v-html="link.label" />
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
