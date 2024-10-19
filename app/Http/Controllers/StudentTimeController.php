<?php

namespace App\Http\Controllers;


use App\Models\StudentTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentTimeController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string',
        ]);
    
        // Tente encontrar um registro existente para o aluno
        $studentTime = StudentTime::where('student_name', $request->student_name)->first();
    
        if ($studentTime) {
            // Se já existe, atualiza apenas o horário de início
            $studentTime->start_time = Carbon::now();
            $studentTime->end_time = null; // Limpar o horário de término
            $studentTime->save();
        } else {
            // Se não existe, cria um novo registro
            $studentTime = StudentTime::create([
                'student_name' => $request->student_name,
                'start_time' => Carbon::now(),
                'total_time' => '00:00:00', // Inicializa com zero
            ]);
        }
    
        return response()->json($studentTime);
    }

    public function stop(Request $request, $id)
    {
        $studentTime = StudentTime::findOrFail($id);
        $studentTime->end_time = Carbon::now();
    
        // Calcula o tempo total
        $start = Carbon::parse($studentTime->start_time);
        $end = Carbon::parse($studentTime->end_time);
        $studentTime->total_time = $start->diff($end)->format('%H:%I:%S');
        $studentTime->save();
    
        return response()->json($studentTime);
    }

    public function index()
    {
        $times = StudentTime::all();
        return view('index', compact('times'));
    }
}

