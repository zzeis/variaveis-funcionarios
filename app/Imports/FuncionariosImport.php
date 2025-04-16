<?php

namespace App\Imports;

use App\Models\Funcionario;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FuncionariosImport implements ToCollection, WithHeadingRow
{
    private $importId;
    private $totalRows = 0;

    public function __construct($importId)
    {
        $this->importId = $importId;
    }

    public function collection(Collection $rows)
    {
        $totalRows = count($rows);

        // Atualiza o total
        Cache::put("import_{$this->importId}", [
            'total' => $totalRows,
            'processed' => 0,
            'percentage' => 0,
            'complete' => false
        ], now()->addMinutes(10));

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Funcionario::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $processed = 0;
        foreach ($rows as $row) {
            Funcionario::create([
                'matricula' => $row['matricula'],
                'nome'      => $row['nome'],
                'cargo'     => $row['cargo'] ?? null,
                'diretoria' => $row['diretoria'] ?? null,
                'secao'     => $row['secao'] ?? null,
            ]);

            $processed++;

            // Atualiza o progresso a cada 10 registros
            if ($processed % 10 === 0 || $processed === $totalRows) {
                $percentage = round(($processed / $totalRows) * 100);

                Cache::put("import_{$this->importId}", [
                    'total' => $totalRows,
                    'processed' => $processed,
                    'percentage' => $percentage,
                    'complete' => $processed === $totalRows
                ], now()->addMinutes(10));
            }
        }
    }


    public function getTotalRows(): int
    {
        return $this->totalRows;
    }



    public function rules(): array
    {
        return [
            '*.matricula' => 'required|unique:funcionarios,matricula',
            '*.nome' => 'required',
            '*.cargo' => 'required',
            '*.diretoria' => 'required',
            '*.secao' => 'required',
        ];
    }
}
