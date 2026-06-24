<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #ffffff;
        }

        .page {
            padding: 40px 48px;
        }

        /* ── En-tête ── */
        .header {
            display: flex; /* DomPDF supporte le block, on use float */
            margin-bottom: 40px;
        }
        .header-left { float: left; width: 50%; }
        .header-right { float: right; width: 50%; text-align: right; }
        .clearfix::after { content: ''; display: table; clear: both; }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #1d4ed8;
            margin-bottom: 4px;
        }
        .company-sub {
            font-size: 11px;
            color: #6b7280;
        }

        .devis-title {
            font-size: 28px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 4px;
        }
        .devis-ref {
            font-size: 11px;
            color: #6b7280;
        }

        /* ── Séparateur ── */
        .divider {
            border: none;
            border-top: 1.5px solid #e5e7eb;
            margin: 24px 0;
        }

        /* ── Infos client ── */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            margin-bottom: 8px;
        }

        .client-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 14px 16px;
            width: 50%;
        }
        .client-name {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 4px;
        }
        .client-detail {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        /* ── Tableau des lignes ── */
        .table-section { margin-top: 32px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #1d4ed8;
            color: #ffffff;
        }
        thead th {
            padding: 10px 12px;
            font-size: 11px;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        thead th.text-right { text-align: right; }

        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:nth-child(odd)  { background: #ffffff; }

        tbody td {
            padding: 10px 12px;
            font-size: 12px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }
        tbody td.text-right { text-align: right; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-prestation { background: #dbeafe; color: #1d4ed8; }
        .badge-produit    { background: #dcfce7; color: #15803d; }

        /* ── Total ── */
        .total-section {
            margin-top: 16px;
            text-align: right;
        }
        .total-box {
            display: inline-block;
            background: #1d4ed8;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 6px;
        }
        .total-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.8;
            margin-bottom: 2px;
        }
        .total-amount {
            font-size: 20px;
            font-weight: bold;
        }

        /* ── Statut ── */
        .statut-section { margin-top: 32px; }
        .statut-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .statut-en_attente { background: #fef3c7; color: #92400e; }
        .statut-accepte    { background: #dcfce7; color: #15803d; }
        .statut-refuse     { background: #fee2e2; color: #991b1b; }

        /* ── Pied de page ── */
        .footer {
            margin-top: 48px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- En-tête --}}
    <div class="header clearfix">
        <div class="header-left">
            <div class="company-name">🚗 LavageAuto</div>
            <div class="company-sub">Service de lavage automobile</div>
        </div>
        <div class="header-right">
            <div class="devis-title">DEVIS</div>
            <div class="devis-ref">N° {{ str_pad($devis->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="devis-ref" style="margin-top:4px;">
                Émis le {{ $devis->created_at->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <hr class="divider">

    {{-- Infos client --}}
    <div class="section-title">Client</div>
    <div class="client-box">
        <div class="client-name">{{ $devis->client_nom }}</div>
        <div class="client-detail">{{ $devis->client_email }}</div>
        @if($devis->client_telephone)
            <div class="client-detail">{{ $devis->client_telephone }}</div>
        @endif
    </div>

    {{-- Tableau des lignes --}}
    <div class="table-section">
        <div class="section-title" style="margin-bottom:12px;">Détail des prestations & produits</div>
        <table>
            <thead>
            <tr>
                <th>Type</th>
                <th>Désignation</th>
                <th class="text-right">Prix unitaire</th>
                <th class="text-right">Qté</th>
                <th class="text-right">Sous-total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($devis->lignes as $ligne)
                <tr>
                    <td>
            <span class="badge badge-{{ $ligne->type }}">
              {{ $ligne->type === 'prestation' ? 'Prestation' : 'Produit' }}
            </span>
                    </td>
                    <td>{{ $ligne->nom }}</td>
                    <td class="text-right">{{ number_format($ligne->prix_unitaire, 2, ',', ' ') }} €</td>
                    <td class="text-right">{{ $ligne->quantite }}</td>
                    <td class="text-right">{{ number_format($ligne->sous_total, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Total --}}
    <div class="total-section">
        <div class="total-box">
            <div class="total-label">Total HT</div>
            <div class="total-amount">{{ number_format($devis->total_ht, 2, ',', ' ') }} €</div>
        </div>
    </div>

    {{-- Statut --}}
    <div class="statut-section">
    <span class="statut-badge statut-{{ $devis->statut }}">
      {{ match($devis->statut) {
        'en_attente' => 'En attente',
        'accepte'    => 'Accepté',
        'refuse'     => 'Refusé',
      } }}
    </span>
    </div>

    {{-- Pied de page --}}
    <div class="footer">
        LavageAuto — Ce devis est valable 30 jours à compter de sa date d'émission.
    </div>

</div>
</body>
</html>
