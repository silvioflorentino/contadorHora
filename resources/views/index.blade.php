@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contador de Tempo</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Tempo Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($times as $time)
            <tr id="row-{{ $time->id }}">
                <td>{{ $time->student_name }}</td>
                <td id="total-time-{{ $time->id }}">{{ $time->total_time ?? '00:00:00' }}</td>
                <td>
                    <button class="btn btn-primary start-btn" data-id="{{ $time->id }}">Iniciar</button>
                    <button class="btn btn-danger stop-btn" data-id="{{ $time->id }}" disabled>Parar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let startButtons = document.querySelectorAll('.start-btn');
        let stopButtons = document.querySelectorAll('.stop-btn');
        
        startButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                let studentId = this.getAttribute('data-id');
                fetch(`/times/start`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ student_name: studentId })
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector(`#row-${studentId} .stop-btn`).removeAttribute('disabled');
                    button.setAttribute('disabled', 'true');
                });
            });
        });
        
        stopButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                let studentId = this.getAttribute('data-id');
                fetch(`/times/stop/${studentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector(`#total-time-${studentId}`).innerHTML = data.total_time;
                    button.setAttribute('disabled', 'true');
                    document.querySelector(`#row-${studentId} .start-btn`).removeAttribute('disabled');
                });
            });
        });
    });
</script>
@endsection
