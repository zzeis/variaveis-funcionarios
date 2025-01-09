<?php

namespace App\Exports;


use App\Models\Funcionario;
use App\Models\FuncionariosVariaveis;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FuncionarioVariaveisExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $mes;

    public function __construct($mes)
    {
        $this->mes = $mes;
    }

    public function collection()
    {
        return FuncionariosVariaveis::with(['funcionario', 'variavel'])
            ->whereMonth('reference_date', $this->mes)
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
                    Carbon::parse($item->reference_date)->format('d/m/Y'), // Conversão para Carbon   
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
