<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue'

interface Token {
  id: string
  name: string
  last_used_at: string | null
  created_at: string
}

interface Props {
  tokens: Token[]
}

const props = defineProps<Props>()
const page = usePage()

const plainTextToken = ref<string | null>(null)
const copied = ref(false)

// Watch for flash data
watch(
  () => (page.props as any).plainTextToken,
  (newToken) => {
    if (newToken) {
      plainTextToken.value = newToken
    }
  },
  { immediate: true }
)

const form = useForm({
  name: '',
})

const createToken = () => {
  form.post('/settings/api-tokens', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}

const deleteToken = (tokenId: string) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce token ?')) {
    form.delete(`/settings/api-tokens/${tokenId}`, {
      preserveScroll: true,
    })
  }
}

const copyToken = () => {
  if (plainTextToken.value) {
    navigator.clipboard.writeText(plainTextToken.value)
    copied.value = true
    setTimeout(() => {
      copied.value = false
    }, 2000)
  }
}
</script>

<template>
  <AppLayout>
    <SettingsLayout>
      <Head title="API Tokens" />

      <div>
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
          API Tokens
        </h1>
        <p class="mt-2 text-gray-600">
          Créez et gérez vos tokens API pour accéder au serveur MCP FAQ
        </p>
      </div>

      <!-- Token Created Success -->
      <div
        v-if="plainTextToken"
        class="mb-8 bg-green-50 border border-green-200 rounded-lg p-6"
      >
        <h3 class="text-lg font-semibold text-green-900 mb-2">
          Token créé avec succès !
        </h3>
        <p class="text-sm text-green-700 mb-4">
          Copiez votre nouveau token API. Pour des raisons de sécurité, il ne sera plus affiché.
        </p>
        <div class="relative">
          <div class="bg-white p-4 rounded border border-green-300 font-mono text-xs break-all pr-20">
            {{ plainTextToken }}
          </div>
          <button
            @click="copyToken"
            :class="[
              'absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 text-white text-xs rounded transition-all duration-300 w-16 flex items-center justify-center',
              copied ? 'bg-green-700' : 'bg-green-600 hover:bg-green-700'
            ]"
          >
            <span v-if="!copied" class="transition-opacity duration-300">Copier</span>
            <svg v-else class="w-4 h-4 animate-scale-in" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
          </button>
        </div>
        <button
          @click="plainTextToken = null"
          class="mt-4 text-sm text-green-700 hover:text-green-900"
        >
          Fermer
        </button>
      </div>

      <!-- Create Token Form -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">
          Créer un nouveau token
        </h2>
        <form @submit.prevent="createToken" class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Nom du token
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              placeholder="ex: Intégration GPT, Workflow n8n"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              :class="{ 'border-red-500': form.errors.name }"
            >
            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
              {{ form.errors.name }}
            </p>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="!form.processing">Créer le token</span>
            <span v-else>Création...</span>
          </button>
        </form>
      </div>

      <!-- Existing Tokens -->
      <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">
          Tokens actifs
        </h2>

        <div v-if="tokens.length === 0" class="text-center py-8 text-gray-500">
          Vous n'avez pas encore créé de token API.
        </div>

        <div v-else class="space-y-3">
          <div
            v-for="token in tokens"
            :key="token.id"
            class="flex items-center justify-between p-4 border border-gray-200 rounded-md hover:border-gray-300 transition"
          >
            <div>
              <h3 class="font-medium text-gray-900">
                {{ token.name }}
              </h3>
              <p class="text-sm text-gray-500">
                Créé {{ token.created_at }}
                <span v-if="token.last_used_at"> • Dernière utilisation {{ token.last_used_at }}</span>
              </p>
            </div>
            <button
              @click="deleteToken(token.id)"
              class="px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md transition"
            >
              Supprimer
            </button>
          </div>
        </div>
      </div>

      <!-- Usage Instructions -->
      <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">
          Comment utiliser votre token API
        </h3>
        <p class="text-sm text-blue-700 mb-3">
          Incluez votre token dans le header Authorization de vos requêtes HTTP :
        </p>
        <pre class="bg-blue-100 p-3 rounded text-sm overflow-x-auto"><code>Authorization: Bearer VOTRE_TOKEN_ICI</code></pre>
        <p class="text-sm text-blue-700 mt-3">
          Endpoint MCP : <code class="bg-blue-100 px-2 py-1 rounded">https://demo-mcp.codible.net/mcp/faq</code>
        </p>
      </div>
    </div>
    </SettingsLayout>
  </AppLayout>
</template>

<style scoped>
@keyframes scale-in {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.animate-scale-in {
  animation: scale-in 0.3s ease-out;
}
</style>
