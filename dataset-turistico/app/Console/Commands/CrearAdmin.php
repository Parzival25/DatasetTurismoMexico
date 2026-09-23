<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CrearAdmin extends Command
{
    protected $signature = 'dataset:crear-admin
        {email : Correo con el que iniciará sesión}
        {--nombre=Administrador : Nombre visible}
        {--password= : Contraseña (si se omite, se pide de forma interactiva)}';

    protected $description = 'Crea o actualiza un usuario del panel de administración';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->option('password') ?: $this->secret('Contraseña (mínimo 8 caracteres)');

        $validador = Validator::make(compact('email', 'password'), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validador->fails()) {
            foreach ($validador->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $this->option('nombre'), 'password' => Hash::make($password)]
        );

        $this->info("Usuario {$email} listo para entrar en /admin.");

        return self::SUCCESS;
    }
}
