<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload JSON</title>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>
    <body>
        <h1>Upload do Arquivo JSON</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div id="loadingIndicator" class="hidden">
            <div class="alert alert-processing">Processando...</div>
        </div>

        <form action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
            <input type="file" name="json_file" accept=".json" required>
        </div>
            <button class="button button-primary" type="submit">Enviar</button>
        </form>

        <form id="processForm" action="{{ route('document.process') }}" method="GET">
            @csrf
            <button class="button button-primary" type="submit">Processar Fila</button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('processForm');
                const loadingIndicator = document.getElementById('loadingIndicator');

                form.addEventListener('submit', () => {
                    loadingIndicator.classList.remove('hidden');
                });
            });
        </script>
    </body>
</html>