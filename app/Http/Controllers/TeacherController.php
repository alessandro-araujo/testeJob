<?php

namespace App\Http\Controllers;

use App\Models\Spreadsheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function view()
    {
        return view('teachers.index');
    }

    public function reports_view()
    {

        $user = Auth::user();
        $students = User::where('role', 'student')->get();
        $spreadsheet = Spreadsheet::where('rm_teacher', $user->rm)->get();

        $studentsMap = [];
        foreach ($students as $student) {
            $studentsMap[$student->rm] = $student->name;
        }

        // $responseArray = [];
        // foreach ($spreadsheet as $valor) {
        //     $nome = isset($studentsMap[$valor->rm_student]) ? $studentsMap[$valor->rm_student] : "$valor->rm_student";
        //     $responseArray [] = ['name' => $nome, 'note1' => $valor->note1, 'note2' => $valor->note2,'note3' => $valor->note3,'note4' => $valor->note4,'note5' => $valor->note5,'note6' => $valor->note6,'finalnote' => $valor->finalnote];
        // }
        $responseArray = [];

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
            $responseArray[] = [
                'name' => $nome,
                'note1' => $valor->note1,
                'note2' => $valor->note2,
                'note3' => $valor->note3,
                'note4' => $valor->note4,
                'note5' => $valor->note5,
                'note6' => $valor->note6,
                'finalnote' => $valor->finalnote,
                'media' => number_format($media, 1),
                'status' => $status
            ];
        }


        return view('teachers.students', compact('user', 'responseArray'));
    }

}
