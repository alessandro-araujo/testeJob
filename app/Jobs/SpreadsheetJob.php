<?php

namespace App\Jobs;

use App\Models\Spreadsheet;
use App\Models\SpreadsheetFlag;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SpreadsheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fullPath = storage_path('app/private/' . $this->filePath);
        $spreadsheet = IOFactory::load($fullPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $headers = array_map('strtolower', array_map('trim', $rows[0]));
        $data = array_slice($rows, 1);

        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            foreach ($chunk as $row) {
                $record = array_combine($headers, $row);
                $userData = [
                    'rm_student' => preg_replace('/[^0-9]/', '', $record['aluno']),
                    'rm_teacher' => preg_replace('/[^0-9]/', '', $record['professor']),
                    'note1' => $record['nota 1'],
                    'note2' => $record['nota 2'],
                    'note3' => $record['nota 3'],
                    'note4' => $record['nota 4'],
                    'note5' => $record['nota 5'],
                    'note6' => $record['nota 6'],
                    'finalnote' => $record['nota prova final'],
                ];

                try {
                    // Verifica se já existe um registro idêntico na tabela Spreadsheet
                    $exists = Spreadsheet::where($userData)->exists();

                    if ($exists) {
                        // Se o registro completo já existe, não faz nada
                        continue;
                    }

                    // Verifica se existe um registro na Spreadsheet apenas pelo rm_student
                    $studentExists = Spreadsheet::where('rm_student', $userData['rm_student'])->exists();

                    if ($studentExists) {
                        // Se já existir na tabela Spreadsheet, verifica se também existe na SpreadsheetFlag com os mesmos dados
                        $flagExists = SpreadsheetFlag::where($userData)->exists();

                        if ($flagExists) {
                            continue; // Se já existe na SpreadsheetFlag, não faz nada
                        }

                        // Se não existir na SpreadsheetFlag, cadastra um novo registro
                        SpreadsheetFlag::create($userData);
                    } else {
                        // Se não existir na tabela Spreadsheet, cadastra na Spreadsheet
                        Spreadsheet::create($userData);
                    }
                } catch (Exception $error) {
                    Log::error('Erro ao processar usuário a partir do XLSX', [
                        'exception' => get_class($error),
                        'message'   => $error->getMessage(),
                        'file'      => $error->getFile(),
                        'line'      => $error->getLine(),
                        'data'      => $userData,
                    ]);
                    throw $error;
                }
            }
        }
    }
}
