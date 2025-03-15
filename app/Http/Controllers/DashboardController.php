<?php

namespace App\Http\Controllers;

use App\Models\Spreadsheet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $studentsArray = [];

        $graphicsArrayPizza = [];
        $rowPizza = [];
        $graphicsArrayBar = [];
        $graphicsArrayLine = [];

        if($user->role === 'student'){
            $spreadsheet = Spreadsheet::where('rm_student', $user->rm)->get();
            foreach ($spreadsheet as $valor) {
                $nome = isset($studentsMap[$valor->rm_student]) ? $studentsMap[$valor->rm_student] : "$valor->rm_student";

                $notas = [$valor->note1, $valor->note2, $valor->note3, $valor->note4, $valor->note5, $valor->note6];
                $nota_final = $valor->finalnote;
                $soma_total = array_sum($notas) + ($nota_final * 2);
                $media = $soma_total / 8;
                $media = ceil($media * 10) / 10;

                // Define o status do aluno
                $status = ($media >= 7) ? 'Aprovado' : 'Reprovado';

                // Adiciona ao array final
                $studentsArray[] = [
                    'name' => $user->name,
                    'media' => number_format($media, 1),
                    'status' => $status
                ];
            }
        }else{
            // Gráfico de Pizza de Aprovados e Reprovados
            $spreadsheet = Spreadsheet::get();

            foreach ($spreadsheet as $valor) {
                $nome = isset($studentsMap[$valor->rm_student]) ? $studentsMap[$valor->rm_student] : "$valor->rm_student";

                $notas = [$valor->note1, $valor->note2, $valor->note3, $valor->note4, $valor->note5, $valor->note6];
                $nota_final = $valor->finalnote;
                $soma_total = array_sum($notas) + ($nota_final * 2);
                $media = $soma_total / 8;
                $media = ceil($media * 10) / 10;

                // Define o status do aluno
                $status = ($media >= 7) ? 'Aprovado' : 'Reprovado';

                if ($status === 'Aprovado'){
                    $rowPizza[] = 1;
                }else{
                    $rowPizza[] = 0;
                }
            }
             // Contando aprovados e reprovados
            $aprovados = count(array_filter($rowPizza, fn($value) => $value === 1));
            $reprovados = count(array_filter($rowPizza, fn($value) => $value === 0));

            // Criando um array associativo com os dados
            $graphicsArrayPizza = [
                'aprovados' => $aprovados,
                'reprovados' => $reprovados
            ];

            // Gráfico de Barras com Média Geral por Professor
            $teachers = User::where('role', 'teacher')->get();

            foreach ($spreadsheet as $row) {
                $teacherId = $row["rm_teacher"];

                if (!isset($graphicsArrayBar[$teacherId])) {
                    $graphicsArrayBar[$teacherId] = [
                        "cont" => 0,
                        "media_total" => 0,
                        "students" => []
                    ];
                }

                // Cálculo da média do aluno
                $notas = [$row["note1"], $row["note2"], $row["note3"], $row["note4"], $row["note5"], $row["note6"]];
                $nota_final = $row["finalnote"];
                $soma_total = array_sum($notas) + ($nota_final * 2);
                $media = $soma_total / 8;
                $media = ceil($media * 10) / 10;

                // Adiciona o aluno no array de students
                $graphicsArrayBar[$teacherId]["students"][] = [
                    "rm_student" => $row["rm_student"],
                    "media" => $media
                ];

                // Atualiza a quantidade de alunos (cont)
                $graphicsArrayBar[$teacherId]["cont"] = count($graphicsArrayBar[$teacherId]["students"]);

                // Atualiza a soma das médias para calcular a média total mais tarde
                $graphicsArrayBar[$teacherId]["media_total"] += $media;
            }

            // Calculando a média total por professor
            foreach ($graphicsArrayBar as $teacherId => &$data) {
                if ($data["cont"] > 0) {
                    $data["media_total"] = $data["media_total"] / $data["cont"]; // Média total de todos os alunos
                    $data["media_total"] = ceil($data["media_total"] * 10) / 10; // Arredonda para uma casa decimal
                }
            }
        }
        // dd($graphicsArrayBar);
        // die;

        return view('dashboard.index', compact('user', 'studentsArray', 'graphicsArrayPizza', 'graphicsArrayBar'));
    }
}
