<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

#[Signature('app:create-stcecilias-editor {email : Login email for the new editor} {--name= : Display name for the editor}')]
#[Description('Create an editor restricted to St Cecilia’s Hall, without changing existing accounts')]
class CreateStceciliasEditor extends Command
{
    public function handle(): int
    {
        $email = Str::lower(trim((string) $this->argument('email')));
        $name = trim((string) ($this->option('name') ?: 'St Cecilia’s editor'));
        $validator = Validator::make(['email' => $email, 'name' => $name], [
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        if (User::query()->whereRaw('LOWER(email) = ?', [$email])->exists()) {
            $this->error('An account with this email already exists. No account was changed.');

            return self::FAILURE;
        }

        $password = Str::password(24);
        $user = new User(['name' => $name, 'email' => $email, 'password' => $password]);
        $user->cms_role = User::ROLE_STCECILIAS_EDITOR;
        $user->save();

        $this->info('Created a St Cecilia’s-only editor. Other CMS sections are unavailable.');
        $this->line('Email: '.$email);
        $this->line('Password: '.$password);
        $this->comment('Save this generated password now; it cannot be retrieved later.');

        return self::SUCCESS;
    }
}
