<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nomFormation' => ['required', 'string', 'max:50'],
            'fichier' => ['nullable', 'file', 'max:1024'],
            'dateDebut' => ['required', 'date',], //'max:now'
            'dateFin' => ['nullable', 'date',], //'min:dateDebut', 'max:value'
        ];
    }
}
