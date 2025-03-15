<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsRequest;
use App\Models\Spreadsheet;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class StudentsController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $teachers = User::where('role', 'teacher')->get();
        $associated = Student::where('rm_student', $user->rm)->get();

        return view('students.index', compact('user', 'teachers', 'associated'));
    }

    public function check_view()
    {
        $user = Auth::user();
        $teachers = User::where('role', 'teacher')->get();
        $associated = Student::pluck('rm_student')->toArray(); // RMs dos estudantes associados
        $spreadsheet = Spreadsheet::get();

        // Filtrando os alunos que não estão associados
        $responseArray = $spreadsheet->filter(function($row) use ($associated) {
            return !in_array($row->rm_student, $associated);  // Alunos não associados
        });

        // Pegando os estudantes cadastrados no sistema
        $students = User::where('role', 'student')->pluck('name', 'rm')->toArray(); // Pegando nome e RM como chave-valor

        // Verificar a quantidade de alunos não cadastrados
        $notRegistered = $responseArray->filter(function($row) use ($students) {
            return !array_key_exists($row->rm_student, $students);  // Alunos não cadastrados
        });

        $notRegisteredCount = $notRegistered->count();  // Quantidade de alunos não cadastrados

        // Filtrar apenas os alunos que estão cadastrados
        $responseArray = $responseArray->filter(function($row) use ($students) {
            return array_key_exists($row->rm_student, $students);  // Mantém apenas os alunos cadastrados
        })->map(function($row) use ($students) {
            return [
                'name' => $students[$row->rm_student], // Pegando o nome correto
                'rm_student' => $row->rm_student
            ];
        });

        return view('students.check', compact('user', 'teachers', 'notRegisteredCount','responseArray'));
    }

    public function reports_view()
    {
        $user = Auth::user();
        $teachers = User::where('role', 'teacher')->get();
        $associated = Student::where('rm_student', $user->rm)->get();
        $spreadsheet = Spreadsheet::where('rm_student', $user->rm)->get();

        return view('students.reports', compact('user', 'teachers', 'associated', 'spreadsheet'));
    }

    public function store(StudentsRequest $request)
    {
        $request->validated();
        try {
            Student::create([
                'rm_student' => $request->rm_student,
                'rm_teacher' => $request->rm_teacher,
            ]);
            return redirect()->back()->with('success', 'Students associado com sucesso');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function destroy($rm_student, $rm_teacher)
    {
        $student = Student::where('rm_student', $rm_student)->where('rm_teacher', $rm_teacher)->first();
        $student->delete();
        return redirect()->route('student.view')->with('success', 'Associação removida com sucesso!');
    }
}
