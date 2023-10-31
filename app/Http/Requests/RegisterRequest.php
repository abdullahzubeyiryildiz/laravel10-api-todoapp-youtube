<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad Boş Geçilemez',
            'name.string' => 'Yazı Olamalıdır',
            'name.max' => 'Max 255 Karakter Olamalıdır',
            'email.required' => 'Email Boş Geçilemez',
            'email.unique' => 'Zaten Eposta Kayıtlı',
            'email.email' => 'Geçersiz Email',
            'password.required' => 'Şifre Zorunlu Boş Geçilemez',
            'password.min' => 'Şifre En az 6 karakter olamalıdır',
        ];
    }
}
