<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $menu->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100">
    @if($menu->template === 'modern')
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    @elseif($menu->template === 'classic')
        <div class="min-h-screen bg-white">
    @else
        <div class="min-h-screen bg-white">
    @endif
        
        <header class="no-print bg-white shadow-sm">
            <div class="mx-auto max-w-4xl px-4 py-4">
                <h1 class="text-2xl font-bold text-gray-900">{{ $menu->name }}</h1>
            </div>
        </header>

        <main class="mx-auto max-w-4xl px-4 py-8">
            @if($menu->type === 'html')
                <div class="prose max-w-none">
                    {!! $menu->content !!}
                </div>
            @elseif($menu->type === 'pdf')
                <div class="text-center">
                    <embed src="{{ asset('storage/' . $menu->file_path) }}" 
                           type="application/pdf" 
                           width="100%" 
                           height="800px"
                           class="border rounded-lg shadow-lg">
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $menu->file_path) }}" 
                           target="_blank"
                           class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Télécharger le PDF
                        </a>
                    </div>
                </div>
            @elseif($menu->type === 'image')
                <div class="text-center">
                    <img src="{{ asset('storage/' . $menu->file_path) }}" 
                         alt="{{ $menu->name }}"
                         class="max-w-full h-auto mx-auto rounded-lg shadow-lg">
                </div>
            @endif
        </main>

        <footer class="no-print mt-12 bg-gray-50 py-8">
            <div class="mx-auto max-w-4xl px-4 text-center text-gray-600">
                <p>Menu généré avec Menu QR</p>
            </div>
        </footer>
    </div>
</body>
</html>