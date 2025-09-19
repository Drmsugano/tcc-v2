<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    public function rules(): array
    {
        return [
            'NOME' => 'required|string|max:255',
            'USUARIO' => 'required|string|max:255|unique:USUARIOS,USUARIO',
            'EMAIL' => 'required|email|max:255|unique:USUARIOS,EMAIL',
            'SENHA' => 'required|string|min:1',
            'permissoes' => 'required|array',
            'permissoes.*' => 'string'
        ];
    }
    public function messages()
    {
        return [
            'NOME.required' => 'O nome completo do usuário não foi digitado',
            'EMAIL.required' => 'O email informado já foi encontrado na base de dados',
            'USUARIO' => 'O usuário informado já foi encontrado na base de dados',
            'SENHA.required' => 'A senha não foi informada',
            'permissoes' => 'As permissoes não foram informadas'
        ];
    }
}
