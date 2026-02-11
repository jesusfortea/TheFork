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
            'tipo' => ['required', 'integer'],
            'ubi' => ['required'],
            'cheff' => ['required'],
            'precio' => ['required', 'numeric', 'min:0'],
            'menu' => ['required'],
            'img' => ['required', 'max:2048']
        ];
    }

    public function messages(): array
    {
        return[
            'titulo.required' => 'No puedes dejar el campo título vacío.',
            'titulo.min' => 'El título debe de ser superior a 3 carácteres.',
            'desc.required' => 'No puedes dejar el campo descripción vacío.',
            'tipo.required' => 'No puedes dejar el campo tipo vacío.',
            'ubi.required' => 'No puedes dejar el campo ubicación vací0.',
            'cheff.required' => 'No puedes dejar el campo cheff vacío.',
            'precio.required' => 'No puedes dejar el campo precio vacío.',
            'menu.required' => 'No puedes dejar el campo menú vacío.',
            'tipo.integer' => 'El campo tipo tiene que ser numérico.',
            'precio.numeric' => 'El campo precio tiene que ser numérico.',
            'img.required' => 'No puedes dejar el campo imagen vacío.',
            'img.image' => 'El campo imagen tiene que ser una imagen.'
        ];
    }


}
