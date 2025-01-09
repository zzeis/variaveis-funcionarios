<?php

namespace App\Console\Commands;

use App\Models\Funcionario;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ImportFuncionarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-funcionarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file) || !is_readable($file)) {
            $this->error("File not found or not readable.");
            return;
        }

        $data = array_map('str_getcsv', file($file));
        $header = array_map('trim', $data[0]);
        unset($data[0]); // Remove the header row

        foreach ($data as $row) {
            $row = array_combine($header, $row);

            // Criar o usuário com os dados do CSV
            Funcionario::create([
                'matricula' => $row['matricula'],
                'nome' => $row['nome'],
                'cargo' => $row['cargo'],
                'diretoria' => $row['diretoria'],
                'secao' => $row['secao'],
            ]);

            $this->info("Imported user: {$row['nome']}");
        }

        $this->info("All users have been imported successfully.");
    }

    protected function configure()
    {
        $this->setName('app:import-funcionarios')
            ->setDescription('Import users from a CSV file')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the CSV file');
    }
}
