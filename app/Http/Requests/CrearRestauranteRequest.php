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
            'etiqueta_insignia' => ['nullable', 'array'],
            'etiqueta' => ['nullable', 'array'],
            'precio' => ['required', 'numeric', 'min:0'],
            'menu' => ['required'],
            'img' => ['required', 'image', 'mimes:jpeg,png,jpg,webp']
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
            'img.required' => 'Debes subir una imagen.',
            'img.image' => 'El archivo debe ser una imagen válida.',
            'img.mimes' => 'Solo se permiten imágenes jpeg, png, jpg o webp.',
        ];
    }


}
