<?php

namespace App\Console\Commands;

use App\Models\Funcionario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
    protected $description = 'Importa lista de funcionários a partir de um arquivo CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file) || !is_readable($file)) {
            $this->error("Arquivo não encontrado ou sem permissão de leitura.");
            return;
        }

        // Desativa verificação de FK
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpa a tabela
        Funcionario::truncate();
        
        // Reativa verificação de FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = array_map('str_getcsv', file($file));
        $header = array_map('trim', $data[0]);
        unset($data[0]); // Remove cabeçalho

        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        $importedCount = 0;

        foreach ($data as $row) {
            $row = array_map('trim', $row);
            
            if (count($row) !== count($header)) {
                continue;
            }
        
            $rowData = array_combine($header, $row);
        
            try {
                Funcionario::create([
                    'matricula' => $rowData['matricula'],
                    'nome' => $rowData['nome'],
                    'cargo' => $rowData['cargo'],
                    'diretoria' => $rowData['diretoria'],
                    'secao' => $rowData['secao'],
                ]);
                $importedCount++;
            } catch (\Exception $e) {
                $this->error("Erro ao importar matrícula {$rowData['matricula']}: " . $e->getMessage());
            }
        
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Importação concluída! {$importedCount} registros foram importados.");
    }

    protected function configure()
    {
        $this->setName('app:import-funcionarios')
            ->setDescription('Importa funcionários de um arquivo CSV')
            ->addArgument('file', InputArgument::REQUIRED, 'Caminho para o arquivo CSV');
    }
}