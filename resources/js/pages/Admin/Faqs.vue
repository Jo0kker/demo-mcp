<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

interface Faq {
  id: number
  question: string
  answer: string
  category: string | null
  is_published: boolean
  view_count: number
  created_at: string
}

interface Props {
  faqs: {
    data: Faq[]
    links: Array<{ url: string | null; label: string; active: boolean }>
  }
}

const props = defineProps<Props>()

const deleteFaq = (faqId: number) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?')) {
    router.delete(`/admin/faqs/${faqId}`, {
      preserveScroll: true,
    })
  }
}
</script>

<template>
  <AppLayout>
    <Head title="Gestion des FAQs" />

    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">
            Gestion des FAQs
          </h1>
          <p class="mt-2 text-gray-600">
            Créez et gérez toutes vos questions fréquentes
          </p>
        </div>
        <Link
          href="/admin/faqs/create"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Créer une FAQ
        </Link>
      </div>

      <!-- Liste des FAQs -->
      <div class="bg-white rounded-lg shadow-sm">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Question
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Catégorie
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Statut
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Vues
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="faq in faqs.data" :key="faq.id" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">
                    {{ faq.question }}
                  </div>
                  <div class="text-sm text-gray-500 line-clamp-1">
                    {{ faq.answer }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    v-if="faq.category"
                    class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800"
                  >
                    {{ faq.category }}
                  </span>
                  <span v-else class="text-sm text-gray-400">
                    Aucune
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="[
                      'px-2 py-1 text-xs font-medium rounded-full',
                      faq.is_published
                        ? 'bg-green-100 text-green-800'
                        : 'bg-gray-100 text-gray-800'
                    ]"
                  >
                    {{ faq.is_published ? 'Publié' : 'Brouillon' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ faq.view_count }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end gap-2">
                    <Link
                      :href="`/admin/faqs/${faq.id}/edit`"
                      class="text-blue-600 hover:text-blue-900"
                    >
                      Éditer
                    </Link>
                    <button
                      @click="deleteFaq(faq.id)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Supprimer
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Empty State -->
        <div
          v-if="faqs.data.length === 0"
          class="text-center py-12"
        >
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune FAQ</h3>
          <p class="mt-1 text-sm text-gray-500">
            Commencez par créer votre première FAQ
          </p>
          <div class="mt-6">
            <Link
              href="/admin/faqs/create"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Créer une FAQ
            </Link>
          </div>
        </div>

        <!-- Pagination -->
        <div
          v-if="faqs.links.length > 3"
          class="px-6 py-4 border-t border-gray-200 flex justify-center gap-2"
        >
          <Link
            v-for="(link, index) in faqs.links"
            :key="index"
            :href="link.url || ''"
            :class="[
              'px-4 py-2 rounded-md transition',
              link.active
                ? 'bg-blue-600 text-white'
                : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300',
              !link.url ? 'opacity-50 cursor-not-allowed' : '',
            ]"
            :disabled="!link.url"
            v-html="link.label"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
