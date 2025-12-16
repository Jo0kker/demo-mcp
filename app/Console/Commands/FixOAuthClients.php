<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixOAuthClients extends Command
{
    protected $signature = 'mcp:fix-oauth-clients';
    protected $description = 'Repare les clients OAuth avec des donnees JSON corrompues (double-encodage)';

    public function handle()
    {
        $this->info('Verification et reparation des clients OAuth...');

        $clients = DB::table('oauth_clients')->get();
        $fixed = 0;

        foreach ($clients as $client) {
            $updates = [];

            // Verifier redirect_uris
            if ($client->redirect_uris) {
                $decoded = json_decode($client->redirect_uris, true);
                // Si c'est une string apres decodage, c'est du double-encodage
                if (is_string($decoded)) {
                    $properValue = json_decode($decoded, true);
                    if (is_array($properValue)) {
                        $updates['redirect_uris'] = json_encode($properValue);
                        $this->line("  - redirect_uris corrige: " . $updates['redirect_uris']);
                    }
                }
            }

            // Verifier grant_types
            if ($client->grant_types) {
                $decoded = json_decode($client->grant_types, true);
                if (is_string($decoded)) {
                    $properValue = json_decode($decoded, true);
                    if (is_array($properValue)) {
                        $updates['grant_types'] = json_encode($properValue);
                        $this->line("  - grant_types corrige: " . $updates['grant_types']);
                    }
                }
            }

            if (!empty($updates)) {
                DB::table('oauth_clients')
                    ->where('id', $client->id)
                    ->update($updates);
                $fixed++;
                $this->info("Client {$client->id} ({$client->name}) repare.");
            }
        }

        if ($fixed === 0) {
            $this->info('Aucun client a reparer trouve.');
        } else {
            $this->info("$fixed client(s) repare(s) avec succes!");
        }

        return Command::SUCCESS;
    }
}
