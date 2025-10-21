<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'

interface Faq {
  id: number
  question: string
  answer: string
  category: string | null
  view_count: number
  created_at: string
}

interface Props {
  faq: Faq
}

defineProps<Props>()
</script>

<template>
  <div>
    <Head :title="`FAQ - ${faq.question}`" />

    <div class="min-h-screen bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <div class="mb-8">
          <Link
            href="/faqs"
            class="text-blue-600 hover:text-blue-800 transition inline-flex items-center"
          >
            <svg
              class="w-5 h-5 mr-2"
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
        <article class="bg-white rounded-lg shadow-sm p-8">
          <header class="mb-8">
            <div class="flex items-center gap-3 mb-4">
              <h1 class="text-3xl font-bold text-gray-900">
                {{ faq.question }}
              </h1>
              <span
                v-if="faq.category"
                class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800"
              >
                {{ faq.category }}
              </span>
            </div>
            <div class="flex items-center gap-4 text-sm text-gray-500">
              <span>{{ faq.view_count }} vues</span>
              <span>•</span>
              <span>{{ new Date(faq.created_at).toLocaleDateString('fr-FR') }}</span>
            </div>
          </header>

          <div class="prose max-w-none">
            <p class="text-lg text-gray-700 whitespace-pre-wrap">
              {{ faq.answer }}
            </p>
          </div>
        </article>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            Cette réponse vous a-t-elle aidé ?
          </h3>
          <p class="text-gray-600 mb-4">
            Si vous avez besoin d'une assistance supplémentaire, n'hésitez pas à contacter notre support.
          </p>
          <Link
            href="/faqs"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
          >
            Voir d'autres questions
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
