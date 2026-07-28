<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Faq {
    id: number;
    question: string;
    answer: string;
    category: string | null;
    is_published: boolean;
}

interface Props {
    faq: Faq;
    categories: string[];
}

const props = defineProps<Props>();

const form = useForm({
    question: props.faq.question,
    answer: props.faq.answer,
    category: props.faq.category || '',
    is_published: props.faq.is_published,
});

const submit = () => {
    form.put(`/admin/faqs/${props.faq.id}`);
};

const deleteFaq = () => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?')) {
        form.delete(`/admin/faqs/${props.faq.id}`);
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Éditer une FAQ" />

        <div class="max-w-3xl">
            <!-- Header -->
            <div class="mb-8">
                <Link
                    href="/admin/faqs"
                    class="mb-4 inline-flex items-center text-sm text-gray-600 hover:text-gray-900"
                >
                    <svg
                        class="mr-2 h-4 w-4"
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
                <h1 class="mt-4 text-3xl font-bold text-gray-900">
                    Éditer la FAQ
                </h1>
            </div>

            <!-- Form -->
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Question -->
                    <div>
                        <label
                            for="question"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Question *
                        </label>
                        <input
                            id="question"
                            v-model="form.question"
                            type="text"
                            required
                            placeholder="Ex: Comment réinitialiser mon mot de passe ?"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.question }"
                        />
                        <p
                            v-if="form.errors.question"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.question }}
                        </p>
                    </div>

                    <!-- Answer -->
                    <div>
                        <label
                            for="answer"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Réponse *
                        </label>
                        <textarea
                            id="answer"
                            v-model="form.answer"
                            required
                            rows="8"
                            placeholder="Rédigez une réponse détaillée et utile..."
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.answer }"
                        />
                        <p
                            v-if="form.errors.answer"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.answer }}
                        </p>
                    </div>

                    <!-- Category -->
                    <div>
                        <label
                            for="category"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Catégorie
                        </label>
                        <select
                            id="category"
                            v-model="form.category"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.category }"
                        >
                            <option value="">Aucune catégorie</option>
                            <option
                                v-for="cat in categories"
                                :key="cat"
                                :value="cat"
                            >
                                {{ cat }}
                            </option>
                        </select>
                        <p
                            v-if="form.errors.category"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.category }}
                        </p>
                    </div>

                    <!-- Published -->
                    <div class="flex items-center">
                        <input
                            id="is_published"
                            v-model="form.is_published"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label
                            for="is_published"
                            class="ml-2 block text-sm text-gray-700"
                        >
                            Publier immédiatement
                        </label>
                    </div>

                    <!-- Actions -->
                    <div
                        class="flex items-center justify-between border-t border-gray-200 pt-4"
                    >
                        <button
                            type="button"
                            @click="deleteFaq"
                            class="rounded-md bg-red-600 px-6 py-2 text-white transition hover:bg-red-700"
                        >
                            Supprimer
                        </button>

                        <div class="flex items-center gap-3">
                            <Link
                                href="/admin/faqs"
                                class="rounded-md bg-gray-200 px-6 py-2 text-gray-700 transition hover:bg-gray-300"
                            >
                                Annuler
                            </Link>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-md bg-blue-600 px-6 py-2 text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span v-if="!form.processing"
                                    >Mettre à jour</span
                                >
                                <span v-else>Mise à jour...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
