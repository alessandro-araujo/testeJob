@php
    $title = "Dashboard";
@endphp

@extends('layouts.default')
@section('content')

<div>
    <h1 class="text-3xl font-bold">Bem-vindo {{ $user->name }}</h1>
    <p class="mt-4"><strong>Category: </strong>{{ $user->role }} </p>
    @if(empty($studentsArray))
        <p><strong>Todos os Graficos são separados pelos Numeros de Matriculas dos professores!</strong></p>
    @else
        <p><strong>Numero de Matricula:</strong>{{ $user->rm }}</p>
    @endif
    <br>
    <div class="flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-9/10 ">
                @if(empty($studentsArray))
                    <!-- Gráfico de Pizza de Aprovados e Reprovados -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold mb-4">Gráfico de Aprovados e Reprovados</h2>
                        <div class="w-1/5 h-60 mx-auto">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                    <!-- Gráfico de Barras com Média Geral por Professor -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold mb-4">Média Geral dos Alunos por Professor</h2>
                        <canvas id="barChartAvg" class="w-full h-96"></canvas>
                    </div>
                    <!-- Gráfico de Barras com Quantidade de Alunos por Professor e Percentual de Aprovados -->
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-center">Quantidade de Alunos por Professor e Percentual de Aprovados</h2>
                        <canvas id="barChartStudents" class="w-full h-96"></canvas>
                    </div>
                @else
                    <p><h2 class="text-3xl font-bold">Verifique seus status</h2></p>
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border-b px-4 py-2 text-left">Nome/RM</th>
                                <th class="border-b px-4 py-2 text-left">Media</th>
                                <th class="border-b px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($studentsArray as $data)
                                <tr>
                                    <td class="border-b px-4 py-2">{{ $data['name'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['media'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['status'] }}</td>
                                </tr>
                            @empty
                                <p><strong>Verificamos que você não tem notas registradas</strong></p>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            <x-alert />
        </div>
    </div>
</div>

<script>
    // Gráfico de Pizza (Aprovados vs Reprovados)
    const dados = @json($graphicsArrayPizza);
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Aprovados', 'Reprovados'],
            datasets: [{
                data: [dados.aprovados, dados.reprovados],
                backgroundColor: ['#4CAF50', '#F44336'],
            }]
        }
    });



    // Passando os dados do PHP para o JavaScript
    const graphicsData = @json($graphicsArrayBar);

    // Extrai os professores e as médias dos alunos para o gráfico
    const professores = Object.keys(graphicsData);
    const medias = professores.map(prof => {
        const notasProfessor = graphicsData[prof].students.map(student => student.media);
        const media = notasProfessor.reduce((a, b) => a + b, 0) / notasProfessor.length;
        return media;
    });

    // Configuração do gráfico de barras
    const ctxBarAvg = document.getElementById('barChartAvg').getContext('2d');
    const barChartAvg = new Chart(ctxBarAvg, {
        type: 'bar',
        data: {
            labels: professores,
            datasets: [{
                label: 'Média Geral dos Alunos',
                data: medias,
                backgroundColor: '#2196F3',
            }]
        }
    });


// Processar os dados para extrair informações necessárias
// const professores = Object.keys(graphicsData); // Pega os IDs dos professores
const quantidadeAlunos = [];
const aprovadosPorProfessor = [];

professores.forEach(professorId => {
    const professor = graphicsData[professorId];
    const alunos = professor.students;

    const totalAlunos = alunos.length;
    const aprovados = alunos.filter(aluno => aluno.media >= 7).length;
    const percentualAprovados = (aprovados / totalAlunos) * 100;

    quantidadeAlunos.push(totalAlunos);
    aprovadosPorProfessor.push(percentualAprovados);
});

// Criar o gráfico
const ctxBarStudents = document.getElementById('barChartStudents').getContext('2d');
const barChartStudents = new Chart(ctxBarStudents, {
    type: 'bar',
    data: {
        labels: professores, // IDs dos professores
        datasets: [
            {
                label: 'Quantidade de Alunos',
                data: quantidadeAlunos,
                backgroundColor: '#FFC107',
            },
            {
                label: 'Percentual de Aprovados',
                data: aprovadosPorProfessor,
                type: 'line',
                borderColor: '#4CAF50',
                borderWidth: 2,
                fill: false,
            }
        ]
    }
});


    // // Gráfico de Barras - Média por Professor
    // // Dados de exemplo
    // const alunos = [
    //     { nota: 8, professor: "Professor A" },
    //     { nota: 6, professor: "Professor A" },
    //     { nota: 9, professor: "Professor B" },
    //     { nota: 7, professor: "Professor B" },
    //     { nota: 5, professor: "Professor A" },
    //     { nota: 10, professor: "Professor C"},
    //     { nota: 4, professor: "Professor C" },
    //     { nota: 7, professor: "Professor A" },
    // ];
    // const professores = ['Professor A', 'Professor B', 'Professor C'];
    // const medias = professores.map(prof => {
    //     const notasProfessor = alunos.filter(a => a.professor === prof).map(a => a.nota);
    //     const media = notasProfessor.reduce((a, b) => a + b, 0) / notasProfessor.length;
    //     return media;
    // });


    // // Gráfico de Barras - Quantidade de Alunos e Percentual de Aprovados por Professor
    // const quantidadeAlunos = professores.map(prof => alunos.filter(a => a.professor === prof).length);
    // const aprovadosPorProfessor = professores.map(prof => {
    //     const alunosProfessor = alunos.filter(a => a.professor === prof);
    //     const aprovados = alunosProfessor.filter(a => a.nota >= 7).length;
    //     return (aprovados / alunosProfessor.length) * 100;
    // });

    // const ctxBarStudents = document.getElementById('barChartStudents').getContext('2d');
    // const barChartStudents = new Chart(ctxBarStudents, {
    //     type: 'bar',
    //     data: {
    //         labels: professores,
    //         datasets: [
    //             {
    //                 label: 'Quantidade de Alunos',
    //                 data: quantidadeAlunos,
    //                 backgroundColor: '#FFC107',
    //             },
    //             {
    //                 label: 'Percentual de Aprovados',
    //                 data: aprovadosPorProfessor,
    //                 type: 'line',
    //                 borderColor: '#4CAF50',
    //                 borderWidth: 2,
    //                 fill: false,
    //             }
    //         ]
    //     }
    // });

</script>

@endsection
