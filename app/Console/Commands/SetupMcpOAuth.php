<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;

class SetupMcpOAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcp:setup-oauth {--force : Force la création même si un client existe déjà}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure OAuth 2.1 pour le serveur MCP et met à jour le .env';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Configuration OAuth pour MCP');
        $this->newLine();

        // Vérifier si des credentials existent déjà dans le .env
        if (config('services.mcp.client_id') && !$this->option('force')) {
            $this->warn('⚠️  Des credentials OAuth MCP existent déjà dans le .env !');
            $this->info('Client ID: ' . config('services.mcp.client_id'));
            $this->newLine();

            if (!$this->confirm('Voulez-vous en créer de nouveaux ?', false)) {
                $this->info('✅ Configuration annulée');
                return Command::SUCCESS;
            }
        }

        // Créer un nouveau client password grant directement
        $this->info('📝 Création du client OAuth Password Grant...');
        $this->newLine();

        // Générer le secret plaintext
        $plaintextSecret = \Illuminate\Support\Str::random(40);

        // Créer le client directement avec le secret plaintext
        $client = new Client();
        $client->name = 'MCP OAuth Client';
        $client->secret = $plaintextSecret; // Passport hash automatiquement via l'accessor
        $client->provider = 'users';
        $client->redirect_uris = [config('app.url')]; // Ne pas json_encode, le cast array le fait
        $client->grant_types = ['password', 'refresh_token', 'authorization_code']; // Ne pas json_encode
        $client->revoked = false;
        $client->save();

        $this->newLine();
        $this->info('✅ Client OAuth créé avec succès !');
        $this->newLine();

        // Afficher les credentials
        $this->components->twoColumnDetail('Client ID', $client->id);
        $this->components->twoColumnDetail('Client Secret (plaintext)', $plaintextSecret);
        $this->newLine();

        // Mettre à jour le .env avec le plaintext ET le hash
        $this->info('📄 Mise à jour du fichier .env...');
        $this->updateEnvFile($client->id, $plaintextSecret);

        $this->newLine();
        $this->info('✨ Configuration terminée !');
        $this->newLine();

        // Afficher la configuration Claude Desktop
        $this->displayClaudeConfig($client, $plaintextSecret);

        return Command::SUCCESS;
    }

    /**
     * Met à jour le fichier .env avec les credentials OAuth (plaintext)
     */
    protected function updateEnvFile(string $clientId, string $plaintextSecret): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $this->error('❌ Fichier .env non trouvé !');
            return;
        }

        $envContent = file_get_contents($envPath);

        // Ajouter ou mettre à jour MCP_OAUTH_CLIENT_ID
        if (str_contains($envContent, 'MCP_OAUTH_CLIENT_ID=')) {
            $envContent = preg_replace(
                '/MCP_OAUTH_CLIENT_ID=.*/',
                'MCP_OAUTH_CLIENT_ID=' . $clientId,
                $envContent
            );
        } else {
            $envContent .= "\n# MCP OAuth Configuration\nMCP_OAUTH_CLIENT_ID=" . $clientId . "\n";
        }

        // Ajouter ou mettre à jour MCP_OAUTH_CLIENT_SECRET (PLAINTEXT pour Claude Desktop)
        if (str_contains($envContent, 'MCP_OAUTH_CLIENT_SECRET=')) {
            $envContent = preg_replace(
                '/MCP_OAUTH_CLIENT_SECRET=.*/',
                'MCP_OAUTH_CLIENT_SECRET=' . $plaintextSecret,
                $envContent
            );
        } else {
            $envContent .= "MCP_OAUTH_CLIENT_SECRET=" . $plaintextSecret . "\n";
        }

        file_put_contents($envPath, $envContent);

        $this->info('✅ Fichier .env mis à jour avec le secret PLAINTEXT');
        $this->warn('⚠️  Le secret est stocké en clair dans le .env - ajoutez .env au .gitignore !');
    }

    /**
     * Affiche la configuration pour Claude Desktop
     */
    protected function displayClaudeConfig(Client $client, string $plaintextSecret = null): void
    {
        $appUrl = config('app.url');

        $this->info('📋 Configuration pour Claude Desktop :');
        $this->newLine();

        // Utiliser le plaintext fourni ou lire depuis le .env
        $secret = $plaintextSecret ?? env('MCP_OAUTH_CLIENT_SECRET');

        $config = [
            'mcpServers' => [
                'demo-faq-admin' => [
                    'command' => 'npx',
                    'args' => [
                        '@modelcontextprotocol/server-http',
                        $appUrl . '/mcp/faq/admin'
                    ],
                    'oauth' => [
                        'authorizationUrl' => $appUrl . '/oauth/authorize',
                        'tokenUrl' => $appUrl . '/oauth/token',
                        'clientId' => $client->id,
                        'clientSecret' => $secret,
                        'scopes' => ['*']
                    ]
                ]
            ]
        ];

        $this->line(json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->newLine();

        $this->info('💡 Copiez cette configuration dans :');
        if (PHP_OS_FAMILY === 'Darwin') {
            $this->line('   ~/Library/Application Support/Claude/claude_desktop_config.json');
        } elseif (PHP_OS_FAMILY === 'Windows') {
            $this->line('   %APPDATA%\Claude\claude_desktop_config.json');
        } else {
            $this->line('   ~/.config/Claude/claude_desktop_config.json');
        }
    }
}
