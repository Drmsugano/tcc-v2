<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'NOME' => 'required|string|max:255',
            'USUARIO' => 'required|string|max:255|unique:USUARIOS,USUARIO',
            'EMAIL' => 'required|email|max:255|unique:USUARIOS,EMAIL',
            'SENHA' => 'required|string|min:1',
            'permissoes' => 'required|array',
            'permissoes.*' => 'uuid|exists:PERMISSOES,PUBLIC_ID'
        ];
    }
    public function messages()
    {
        return [
            'NOME.required' => 'O nome completo do usuário não foi digitado',
            'EMAIL.required' => 'O email não foi informado',
            'EMAIL.unique' => 'O email informado já foi encontrado na base de dados',
            'USUARIO.required' => 'O usuário não foi informado',
            'USUARIO.unique' => 'O usuário informado já foi encontrado na base de dados',
            'SENHA.required' => 'A senha não foi informada',
            'permissoes.required' => 'As permissões não foram informadas',
            'permissoes.*.uuid' => 'ID de permissão inválido',
            'permissoes.*.exists' => 'Permissão não encontrada na base de dados',
        ];
    }

}
