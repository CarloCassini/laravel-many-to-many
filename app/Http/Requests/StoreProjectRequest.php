<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', 'unique:projects'],
            'git_url' => [],
            'description' => ['string'],
            'type_id' => ['nullable', 'exists:types,id'],
            'tecnologies' => ['nullable', 'exists:tecnologies,id'],
            'cover_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:512'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'il nome è obbligatiorio',
            'name.string' => 'il nome deve essere un testo',
            'name.max' => 'il nome deve essere max di 50 caratteri',
            'name.unique' => 'il nome esiste già',

            // 'git_url.string' => ' url deve essere di tipo testo',


            'description.string' => 'la descrizione deve essere di tipo testo',

            'type_id.exists' => 'il type inserito non è valido',
            'type_id.required' => 'itestdo',

            'tecnologies.exists' => 'la tecnologià scelta non è tra quelle valide',

            'cover_image.mimes' => 'l\' immagine deve essere jpg, jpeg o png',
            'cover_image.max' => 'l\'immagine deve essere di max 512 kb',
        ];
    }
}