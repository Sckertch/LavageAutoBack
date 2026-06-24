<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_nom'       => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-\'\.]+$/u'],
            'client_email'     => ['required', 'email:rfc,dns', 'max:255'],
            'client_telephone' => ['nullable', 'string', 'regex:/^(\+33|0)[1-9](\d{2}){4}$/'],
            'lignes'           => ['required', 'array', 'min:1', 'max:50'], // ← max 50 lignes
            'lignes.*.type'    => ['required', 'in:prestation,produit'],
            'lignes.*.id'      => ['required', 'integer', 'min:1'],
            'lignes.*.quantite'=> ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'lignes.required'          => 'Le devis doit contenir au moins une ligne.',
            'lignes.*.type.in'         => 'Le type doit être "prestation" ou "produit".',
            'lignes.*.quantite.min'    => 'La quantité doit être d\'au moins 1.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            foreach ($this->lignes ?? [] as $index => $ligne) {
                if (!isset($ligne['type'], $ligne['id'])) continue;

                $model = $ligne['type'] === 'prestation'
                    ? \App\Models\Prestation::find($ligne['id'])
                    : \App\Models\Produit::find($ligne['id']);

                if (!$model) {
                    $validator->errors()->add(
                        "lignes.$index.id",
                        "L'élément de type {$ligne['type']} avec l'id {$ligne['id']} est introuvable."
                    );
                }
            }
        });
    }
}
