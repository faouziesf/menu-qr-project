@extends('layouts.admin')

@section('title', 'Créer un menu - Étape 1')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un nouveau menu</h1>
        <p class="mt-2 text-gray-600">Étape 1 sur 3 : Choisissez le type de menu</p>
    </div>

    <form method="POST" action="{{ route('admin.menus.create.step1') }}" class="space-y-6">
        @csrf
        
        <div class="grid gap-4 md:grid-cols-3">
            <label class="relative cursor-pointer">
                <input type="radio" name="type" value="pdf" class="sr-only peer" required>
                <div class="rounded-lg border-2 border-gray-300 p-6 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">
                    <div class="text-4xl mb-2">📄</div>
                    <h3 class="font-medium text-gray-900">PDF</h3>
                    <p class="text-sm text-gray-600">Uploader un fichier PDF</p>
                </div>
            </label>

            <label class="relative cursor-pointer">
                <input type="radio" name="type" value="image" class="sr-only peer" required>
                <div class="rounded-lg border-2 border-gray-300 p-6 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">
                    <div class="text-4xl mb-2">🖼️</div>
                    <h3 class="font-medium text-gray-900">Image</h3>
                    <p class="text-sm text-gray-600">Uploader une image</p>
                </div>
            </label>

            <label class="relative cursor-pointer">
                <input type="radio" name="type" value="html" class="sr-only peer" required>
                <div class="rounded-lg border-2 border-gray-300 p-6 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50">
                    <div class="text-4xl mb-2">🌐</div>
                    <h3 class="font-medium text-gray-900">HTML</h3>
                    <p class="text-sm text-gray-600">Contenu HTML personnalisé</p>
                </div>
            </label>
        </div>

        @error('type')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        <div class="flex justify-between">
            <a href="{{ route('admin.dashboard') }}" 
               class="rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400">
                Annuler
            </a>
            <button type="submit" 
                    class="rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                Suivant
            </button>
        </div>
    </form>
</div>
@endsection