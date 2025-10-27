<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const page = usePage()

interface Faq {
  id: number
  question: string
  answer: string
  category: string | null
  view_count: number
  created_at: string
}

interface Props {
  faqs: {
    data: Faq[]
    links: Array<{ url: string | null; label: string; active: boolean }>
  }
  categories: string[]
  filters: {
    category?: string
    search?: string
  }
}

const props = defineProps<Props>()

const search = ref(props.filters.search || '')
const selectedCategory = ref(props.filters.category || '')

const performSearch = () => {
  router.get('/faqs', {
    search: search.value,
    category: selectedCategory.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  })
}

const clearFilters = () => {
  search.value = ''
  selectedCategory.value = ''
  router.get('/faqs')
}
</script>

<template>
  <div>
    <Head title="FAQ - Centre d'aide" />

    <div class="min-h-screen bg-gray-50">
      <!-- Top Bar with Auth -->
      <div class="border-b border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
          <div class="flex justify-end items-center gap-3">
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
                class="text-sm px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
              >
                S'inscrire
              </Link>
            </template>
          </div>
        </div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Centre d'aide
          </h1>
          <p class="text-xl text-gray-600 mb-6">
            Trouvez rapidement des réponses à vos questions
          </p>
          <Link
            href="/faqs/create"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Créer une FAQ
          </Link>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-2">
              <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                Rechercher
              </label>
              <input
                id="search"
                v-model="search"
                type="text"
                placeholder="Rechercher dans les questions..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                @keyup.enter="performSearch"
              >
            </div>
            <div>
              <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                Catégorie
              </label>
              <select
                id="category"
                v-model="selectedCategory"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                @change="performSearch"
              >
                <option value="">
                  Toutes les catégories
                </option>
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
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
            >
              Rechercher
            </button>
            <button
              v-if="search || selectedCategory"
              @click="clearFilters"
              class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition"
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
            class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow"
          >
            <Link
              :href="`/faqs/${faq.id}`"
              class="block p-6"
            >
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-xl font-semibold text-gray-900">
                      {{ faq.question }}
                    </h2>
                    <span
                      v-if="faq.category"
                      class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800"
                    >
                      {{ faq.category }}
                    </span>
                  </div>
                  <p class="text-gray-600 line-clamp-2">
                    {{ faq.answer }}
                  </p>
                </div>
                <div class="ml-4 flex flex-col items-end text-sm text-gray-500">
                  <span>{{ faq.view_count }} vues</span>
                </div>
              </div>
            </Link>
          </div>

          <div
            v-if="faqs.data.length === 0"
            class="text-center py-12"
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
              'px-4 py-2 rounded-md transition',
              link.active
                ? 'bg-blue-600 text-white'
                : 'bg-white text-gray-700 hover:bg-gray-100',
              !link.url ? 'opacity-50 cursor-not-allowed' : '',
            ]"
            :disabled="!link.url"
            v-html="link.label"
          />
        </div>
      </div>
    </div>
  </div>
</template>
