<?php

namespace App\Http\Controllers;
use App\Http\Requests\SpreadsheetRequest;
use App\Jobs\SpreadsheetJob;
use App\Models\Spreadsheet;
use App\Models\SpreadsheetFlag;
use Illuminate\Support\Facades\Storage;

class SpreadsheetController extends Controller
{
    public function index($filename)
    {
        $filePath = storage_path("app/private/uploads/{$filename}");
        if (!file_exists($filePath)) {
            return redirect()->route('spreadsheets.index')->with('error', 'Arquivo não encontrado.');
        }

        return response()->download($filePath);
    }

    public function view()
    {
        $files = array_diff(scandir(storage_path('app/private/uploads')), ['.', '..']);
        $latestFile = !empty($files) ? end($files) : null;

        if (empty($files)) {
            return view('spreadsheet.index', ['latestFile' => null]);
        }

        return view('spreadsheet.index', compact('latestFile'));
    }

    public function store(SpreadsheetRequest $request)
    {
        $request->validated();

        $timestamp = now()->setTimezone('America/Sao_Paulo')->format('Y-m-d-H-i-s');
        $filename = "import-{$timestamp}.xlsx";
        $path = $request->file('file')->storeAs('uploads', $filename);

        if (SpreadsheetJob::dispatch($path)->onQueue('SpreadsheetJob')){
            return back()->with('success', 'Dados estão sendo importados.');
        } else {
            return back()->with('error', 'Ocorreu problemas na importação');
        }
    }

    public function flag_view()
    {
        // Buscar todos os alunos que estão na SpreadsheetFlag
        $spreadsheet_flag = SpreadsheetFlag::get();

        // Filtrar apenas os alunos que existem nas duas tabelas
        $students_with_updates = Spreadsheet::whereIn('rm_student', $spreadsheet_flag->pluck('rm_student'))
            ->get()
            ->map(function ($student) use ($spreadsheet_flag) {
                $updated_data = $spreadsheet_flag->where('rm_student', $student->rm_student)->first();
                return [
                    'original' => $student,
                    'update' => $updated_data
                ];
            });

        return view('spreadsheet.flag', compact('students_with_updates'));
    }

    public function update_flag()
    {
        // Buscar todos os registros que precisam ser atualizados
        $spreadsheet_flag = SpreadsheetFlag::get();
        $totalRegistrosAtualizados = 0;

        foreach ($spreadsheet_flag as $update) {
            // Atualizar os dados na tabela Spreadsheet
            Spreadsheet::where('rm_student', $update->rm_student)->update([
                'rm_teacher' => $update->rm_teacher,
                'note1' => $update->note1,
                'note2' => $update->note2,
                'note3' => $update->note3,
                'note4' => $update->note4,
                'note5' => $update->note5,
                'note6' => $update->note6,
                'finalnote' => $update->finalnote,
            ]);

            // Remover o registro atualizado da SpreadsheetFlag
            $update->delete();

            // Contar quantos registros foram atualizados
            $totalRegistrosAtualizados++;
        }

        return redirect()->back()->with('success', "Foram atualizados $totalRegistrosAtualizados registros.");
    }





}
