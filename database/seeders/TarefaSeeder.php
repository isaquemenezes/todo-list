<?php
namespace Database\Seeders;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TarefaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $usuarios = User::pluck('id');

        if ($usuarios->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Execute o UserSeeder primeiro.');
            return;
        }


        foreach (range(1, 666) as $i) {
            Tarefa::create([
                'titulo' => $faker->sentence(2),
                'descricao' => $faker->paragraph(2),
                'status' => $i % 2 === 0 ? 'concluida' : 'pendente',
                'column_extra' => 'Informações adicionais...',
                'responsavel_id' => $usuarios->random(),
            ]);
        }
    }
}
