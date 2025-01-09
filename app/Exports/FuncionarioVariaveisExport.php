<?php

namespace App\Exports;


use App\Models\Funcionario;
use App\Models\FuncionariosVariaveis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FuncionarioVariaveisExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return FuncionariosVariaveis::with(['funcionario', 'variavel'])
            ->get()
            ->map(function ($item) {

                return [
                    $item->funcionario->nome,
                    $item->funcionario->matricula,
                    $item->funcionario->cargo,
                    $item->funcionario->secao,
                    $item->funcionario->diretoria,
                    $item->variavel->codigo,
                    $item->variavel->descricao,
                    $item->quantidade,
                    $item->reference_date,

                ];
            });
    }

    public function headings(): array
    {
        return [
            'Funcionário',
            'Matrícula',
            'Cargo',
            'Seção',
            'Diretoria',
            'Código Variável',
            'Descrição Variável',
            'Quantidade',
            'Data Referência',

        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Aplica estilo ao cabeçalho (primeira linha)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], // Texto branco
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4CAF50'], // Fundo verde
                ],
            ],
        ];
    }
}
