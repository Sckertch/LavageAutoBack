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
            'client_nom'       => ['required', 'string', 'max:255'],
            'client_email'     => ['required', 'email', 'max:255'],
            'client_telephone' => ['nullable', 'string', 'max:20'],
            'lignes'           => ['required', 'array', 'min:1'],
            'lignes.*.type'    => ['required', 'in:prestation,produit'],
            'lignes.*.id'      => ['required', 'integer'],
            'lignes.*.quantite'=> ['required', 'integer', 'min:1'],
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
}
