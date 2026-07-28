<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Props {
    categories: string[];
}

defineProps<Props>();

const form = useForm({
    question: '',
    answer: '',
    category: '',
    is_published: true,
});

const submit = () => {
    form.post('/faqs', {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <div>
        <Head title="Créer une FAQ" />

        <div class="min-h-screen bg-gray-50">
            <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <Link
                        href="/faqs"
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
                        Créer une nouvelle FAQ
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
                                :class="{
                                    'border-red-500': form.errors.question,
                                }"
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
                                :class="{
                                    'border-red-500': form.errors.answer,
                                }"
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
                            <input
                                v-if="categories.length === 0"
                                id="category"
                                v-model="form.category"
                                type="text"
                                placeholder="Ex: Technique, Facturation, Compte..."
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                :class="{
                                    'border-red-500': form.errors.category,
                                }"
                            />
                            <select
                                v-else
                                id="category"
                                v-model="form.category"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                :class="{
                                    'border-red-500': form.errors.category,
                                }"
                            >
                                <option value="">
                                    Sélectionner ou laisser vide pour une
                                    nouvelle catégorie
                                </option>
                                <option
                                    v-for="cat in categories"
                                    :key="cat"
                                    :value="cat"
                                >
                                    {{ cat }}
                                </option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                Sélectionnez une catégorie existante ou laissez
                                vide pour en créer une nouvelle
                            </p>
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
                        <div class="flex items-center gap-3 pt-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-md bg-blue-600 px-6 py-2 text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span v-if="!form.processing"
                                    >Créer la FAQ</span
                                >
                                <span v-else>Création en cours...</span>
                            </button>
                            <Link
                                href="/faqs"
                                class="rounded-md bg-gray-200 px-6 py-2 text-gray-700 transition hover:bg-gray-300"
                            >
                                Annuler
                            </Link>
                        </div>

                        <!-- Success message -->
                        <div
                            v-if="form.recentlySuccessful"
                            class="rounded-md bg-green-50 p-4"
                        >
                            <p class="text-sm text-green-800">
                                ✓ FAQ créée avec succès !
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
