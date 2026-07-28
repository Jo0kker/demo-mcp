<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface Token {
    id: string;
    name: string;
    last_used_at: string | null;
    created_at: string;
}

interface Props {
    tokens: Token[];
}

defineProps<Props>();
const page = usePage();

const plainTextToken = ref<string | null>(null);
const copied = ref(false);

// Watch for flash data
watch(
    () => (page.props as any).plainTextToken,
    (newToken) => {
        if (newToken) {
            plainTextToken.value = newToken;
        }
    },
    { immediate: true },
);

const form = useForm({
    name: '',
});

const createToken = () => {
    form.post('/settings/api-tokens', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const deleteToken = (tokenId: string) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce token ?')) {
        form.delete(`/settings/api-tokens/${tokenId}`, {
            preserveScroll: true,
        });
    }
};

const copyToken = () => {
    if (plainTextToken.value) {
        navigator.clipboard.writeText(plainTextToken.value);
        copied.value = true;
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    }
};
</script>

<template>
    <AppLayout>
        <SettingsLayout>
            <Head title="API Tokens" />

            <div>
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">API Tokens</h1>
                    <p class="mt-2 text-gray-600">
                        Créez et gérez vos tokens API pour accéder au serveur
                        MCP FAQ
                    </p>
                </div>

                <!-- Token Created Success -->
                <div
                    v-if="plainTextToken"
                    class="mb-8 rounded-lg border border-green-200 bg-green-50 p-6"
                >
                    <h3 class="mb-2 text-lg font-semibold text-green-900">
                        Token créé avec succès !
                    </h3>
                    <p class="mb-4 text-sm text-green-700">
                        Copiez votre nouveau token API. Pour des raisons de
                        sécurité, il ne sera plus affiché.
                    </p>
                    <div class="relative">
                        <div
                            class="rounded border border-green-300 bg-white p-4 pr-20 font-mono text-xs break-all"
                        >
                            {{ plainTextToken }}
                        </div>
                        <button
                            @click="copyToken"
                            :class="[
                                'absolute top-1/2 right-2 flex w-16 -translate-y-1/2 items-center justify-center rounded px-3 py-1.5 text-xs text-white transition-all duration-300',
                                copied
                                    ? 'bg-green-700'
                                    : 'bg-green-600 hover:bg-green-700',
                            ]"
                        >
                            <span
                                v-if="!copied"
                                class="transition-opacity duration-300"
                                >Copier</span
                            >
                            <svg
                                v-else
                                class="animate-scale-in h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="3"
                                    d="M5 13l4 4L19 7"
                                />
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
                <div class="mb-8 rounded-lg bg-white p-6 shadow-sm">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900">
                        Créer un nouveau token
                    </h2>
                    <form @submit.prevent="createToken" class="space-y-4">
                        <div>
                            <label
                                for="name"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Nom du token
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="ex: Intégration GPT, Workflow n8n"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-md bg-blue-600 px-6 py-2 text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <span v-if="!form.processing">Créer le token</span>
                            <span v-else>Création...</span>
                        </button>
                    </form>
                </div>

                <!-- Existing Tokens -->
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900">
                        Tokens actifs
                    </h2>

                    <div
                        v-if="tokens.length === 0"
                        class="py-8 text-center text-gray-500"
                    >
                        Vous n'avez pas encore créé de token API.
                    </div>

                    <div v-else class="space-y-3">
                        <div
                            v-for="token in tokens"
                            :key="token.id"
                            class="flex items-center justify-between rounded-md border border-gray-200 p-4 transition hover:border-gray-300"
                        >
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    {{ token.name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Créé {{ token.created_at }}
                                    <span v-if="token.last_used_at">
                                        • Dernière utilisation
                                        {{ token.last_used_at }}</span
                                    >
                                </p>
                            </div>
                            <button
                                @click="deleteToken(token.id)"
                                class="rounded-md px-4 py-2 text-sm text-red-600 transition hover:bg-red-50 hover:text-red-700"
                            >
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Usage Instructions -->
                <div
                    class="mt-8 rounded-lg border border-blue-200 bg-blue-50 p-6"
                >
                    <h3 class="mb-2 text-lg font-semibold text-blue-900">
                        Comment utiliser votre token API
                    </h3>
                    <p class="mb-3 text-sm text-blue-700">
                        Incluez votre token dans le header Authorization de vos
                        requêtes HTTP :
                    </p>
                    <pre
                        class="overflow-x-auto rounded bg-blue-100 p-3 text-sm"
                    ><code>Authorization: Bearer VOTRE_TOKEN_ICI</code></pre>
                    <p class="mt-3 text-sm text-blue-700">
                        Endpoint MCP :
                        <code class="rounded bg-blue-100 px-2 py-1"
                            >https://demo-mcp.codible.net/mcp/faq</code
                        >
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
