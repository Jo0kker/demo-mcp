<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'

interface Faq {
  id: number
  question: string
  answer: string
  category: string | null
  is_published: boolean
}

interface Props {
  faq: Faq
}

const props = defineProps<Props>()

const form = useForm({
  question: props.faq.question,
  answer: props.faq.answer,
  category: props.faq.category || '',
  is_published: props.faq.is_published,
})

const submit = () => {
  form.put(`/faqs/${props.faq.id}`)
}

const deleteFaq = () => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?')) {
    form.delete(`/faqs/${props.faq.id}`)
  }
}
</script>

<template>
  <div>
    <Head title="Éditer une FAQ" />

    <div class="min-h-screen bg-gray-50">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
          <Link
            href="/faqs"
            class="text-sm text-gray-600 hover:text-gray-900 mb-4 inline-flex items-center"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour à la liste
          </Link>
          <h1 class="text-3xl font-bold text-gray-900 mt-4">
            Éditer la FAQ
          </h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm p-6">
          <form @submit.prevent="submit" class="space-y-6">
            <!-- Question -->
            <div>
              <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                Question *
              </label>
              <input
                id="question"
                v-model="form.question"
                type="text"
                required
                placeholder="Ex: Comment réinitialiser mon mot de passe ?"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': form.errors.question }"
              >
              <p v-if="form.errors.question" class="mt-1 text-sm text-red-600">
                {{ form.errors.question }}
              </p>
            </div>

            <!-- Answer -->
            <div>
              <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">
                Réponse *
              </label>
              <textarea
                id="answer"
                v-model="form.answer"
                required
                rows="8"
                placeholder="Rédigez une réponse détaillée et utile..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': form.errors.answer }"
              />
              <p v-if="form.errors.answer" class="mt-1 text-sm text-red-600">
                {{ form.errors.answer }}
              </p>
            </div>

            <!-- Category -->
            <div>
              <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                Catégorie
              </label>
              <input
                id="category"
                v-model="form.category"
                type="text"
                placeholder="Ex: Technique, Facturation, Compte..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': form.errors.category }"
              >
              <p v-if="form.errors.category" class="mt-1 text-sm text-red-600">
                {{ form.errors.category }}
              </p>
            </div>

            <!-- Published -->
            <div class="flex items-center">
              <input
                id="is_published"
                v-model="form.is_published"
                type="checkbox"
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
              >
              <label for="is_published" class="ml-2 block text-sm text-gray-700">
                Publier immédiatement
              </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
              <button
                type="button"
                @click="deleteFaq"
                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
              >
                Supprimer
              </button>

              <div class="flex items-center gap-3">
                <Link
                  href="/faqs"
                  class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
                >
                  Annuler
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="!form.processing">Mettre à jour</span>
                  <span v-else>Mise à jour...</span>
                </button>
              </div>
            </div>

            <!-- Success message -->
            <div
              v-if="form.recentlySuccessful"
              class="rounded-md bg-green-50 p-4"
            >
              <p class="text-sm text-green-800">
                ✓ FAQ mise à jour avec succès !
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
