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
        // Primeiro, garantimos que temos as matrículas armazenadas para todos os registros
        // que vamos exportar (isso ajuda na transição)
        $this->atualizarMatriculasNasVariaveis();

        // Agora podemos buscar os dados para exportação
        // Usando a relação com o funcionário baseado na matrícula, não no ID
        return FuncionariosVariaveis::with(['funcionario', 'variavel'])
            ->whereMonth('reference_date', $this->mes)
            ->get()
            ->map(function ($item) {
                // Verificamos se o funcionário existe pela relação normal
                if ($item->funcionario) {
                    $funcionario = $item->funcionario;
                } else {
                    // Se não existir, tentamos buscar usando a matrícula salva
                    $funcionario = Funcionario::where('matricula', $item->matricula)->first();
                }

                // Se encontramos o funcionário, exibimos seus dados
                if ($funcionario) {
                    return [
                        $funcionario->nome,
                        $funcionario->matricula,
                        $funcionario->cargo,
                        $funcionario->secao,
                        $funcionario->diretoria,
                        $item->variavel->codigo,
                        $item->variavel->descricao,
                        $item->quantidade,
                        Carbon::parse($item->reference_date)->format('d/m/Y'),
                    ];
                } else {
                    // Se não encontramos o funcionário, ainda mostramos os dados da variável
                    // com informações limitadas do funcionário
                    return [
                        'Funcionário não encontrado',
                        $item->matricula ?? 'Matrícula não disponível',
                        'N/A',
                        'N/A',
                        'N/A',
                        $item->variavel->codigo,
                        $item->variavel->descricao,
                        $item->quantidade,
                        Carbon::parse($item->reference_date)->format('d/m/Y'),
                    ];
                }
            });
    }

    /**
     * Atualiza as matrículas em registros de funcionários variáveis
     * para garantir que temos esse dado salvo para uso futuro
     */
    private function atualizarMatriculasNasVariaveis()
    {
        $registros = FuncionariosVariaveis::whereNull('matricula')
            ->whereMonth('reference_date', $this->mes)
            ->get();

        foreach ($registros as $registro) {
            $funcionario = Funcionario::find($registro->funcionario_id);
            if ($funcionario) {
                $registro->matricula = $funcionario->matricula;
                $registro->save();
            }
        }
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