<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicaments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            // Identité du médicament
            $table->text('specialite');          // Nom commercial (ex: ABILIFY)
            $table->string('dosage')->nullable();          // Ex: 10 MG
            $table->string('forme')->nullable();           // Ex: COMPRIME

            // Statuts réglementaires
            $table->string('statut_amm')->nullable();               // Ex: AMM ENREGISTREE
            $table->string('statut_commercialisation',700)->nullable(); // Ex: Commercialisé

            // Composition / classification
            $table->text('substance_active')->nullable();       // Peut contenir plusieurs substances "//"
            $table->string('classe_therapeutique',700)->nullable();
            $table->string('presentation')->nullable();
            $table->string('pp_gn',700)->nullable();             // PP / GN / NA / RX...
            $table->string('epi',500)->nullable();                   // Fabricant / laboratoire

            // Prix (stockés en centimes pour éviter les soucis d'arrondi ; null si absent)
            $table->unsignedBigInteger('ppv_cents')->nullable();  // Prix Public de Vente
            $table->unsignedBigInteger('ph_cents')->nullable();   // Prix Hôpital
            $table->unsignedBigInteger('pfht_cents')->nullable(); // Prix Fabricant Hors Taxe
            $table->string('tva')->nullable();

            $table->string('lien_rcp_naf')->nullable();

            // Déduplication / traçabilité du scraping
            $table->string('source_hash')->unique()->nullable(); // hash(specialite+dosage+forme+presentation+epi)
            $table->unsignedInteger('source_page')->nullable();
            $table->timestamp('scraped_at')->nullable();

            $table->timestamps();

            // $table->index('specialite');
            $table->index('forme');
            $table->index('statut_commercialisation');
            $table->index('classe_therapeutique');
            $table->index('epi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicaments');
    }
};
