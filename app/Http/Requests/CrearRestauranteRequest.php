<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearRestauranteRequest extends FormRequest
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
            'titulo' => ['required', 'min:3'],
            'desc' => ['required'],
            'tipo' => ['required'],
            'etiqueta_insignia' => ['required'],
            'etiqueta' => ['required'],
            'ubi' => ['required'],
            'cheff' => ['required'],
            'precio' => ['required'],
            'menu' => ['required'],
        ];
    }

    public function message(): array
    {
        return[
            'titulo.required' => 'No puedes dejar el campo título vacío.',
            'titulo.min' => 'El título debe de ser superior a 3 carácteres.',
            'desc.required' => 'No puedes dejar el campo descripción vacío.',
            'tipo.required' => 'No puedes dejar el tipo vacío.'
        ];
    }


}
