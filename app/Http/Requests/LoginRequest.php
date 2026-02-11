<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string', Password::default()],
        ];
    }

    public function authenticate(): User
    {
        $credentials = $this->validated();

        if (! Auth::validate($credentials)) {
            throw ValidationException::withMessages([
                'message' => __('auth.failed'),
            ]);
        }

        return User::where('email', $this->email)->first();
    }
}
