<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planification;
use App\Models\DemandeConfirmee;
use App\Models\Produit;
use App\Models\DemandeEssai;
use App\Models\Essai;
use App\Models\Laboratoire;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     */
    public function index()
    {
        // Chiffres globaux sur les produits/demandes
        $totalDemandes = Produit::count();
        $DemandesFaites = Produit::where('statut', 'done')->count();
        $DemandesEnCours = Produit::where('statut', 'in_progress')->count();
        $DemandesAFaire = Produit::where('statut', 'todo')->count();

        // Répartition par type de demande
        $DemandesReglementaires = Produit::where('type', 'reglementaire')->count();
        $DemandesDeveloppement = Produit::where('type', 'développement')->count();

        // Essais
        $totalEssais = DemandeEssai::count();
        $clotures = DemandeEssai::where('cloture', true)->count();

        // Laboratoires actifs
        $laboratoiresActifs = Laboratoire::where('is_active', true)->count();

        // Répartition par statut des essais
        $statuts = DemandeEssai::select('statut', DB::raw('count(*) as total'))
                               ->groupBy('statut')
                               ->pluck('total','statut');

        // Évolution mensuelle des demandes (12 derniers mois)
        $evolutionMensuelle = DemandeEssai::select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('annee','mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        // Transformer en format utilisable pour Chart.js
        $labels = [];
        $values = [];
        foreach ($evolutionMensuelle as $row) {
            $labels[] = $row->mois . '/' . $row->annee;
            $values[] = $row->total;
        }

        return view('dashboard.index', compact(
            'totalDemandes',
            'DemandesFaites',
            'DemandesEnCours',
            'DemandesAFaire',
            'DemandesReglementaires',
            'DemandesDeveloppement',
            'totalEssais',
            'clotures',
            'laboratoiresActifs',
            'statuts',
            'labels',
            'values'
        ));
    }
}
