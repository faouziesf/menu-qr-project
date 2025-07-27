@extends('layouts.admin')

@section('title', 'Créer un menu - Étape 3')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un nouveau menu</h1>
        <p class="mt-2 text-gray-600">Étape 3 sur 3 : Contenu du menu</p>
        <p class="text-sm text-gray-500">Type: {{ ucfirst($menuData['type']) }} | Template: {{ ucfirst($menuData['template']) }}</p>
    </div>

    <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        @if($menuData['type'] === 'html')
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu HTML</label>
                <textarea name="content" id="content" rows="15" required
                          placeholder="Collez votre code HTML ici..."
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
        @else
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700">
                    @if($menuData['type'] === 'pdf')
                        Fichier PDF (max 10MB)
                    @else
                        Image (JPG, PNG, GIF - max 5MB)
                    @endif
                </label>
                <input type="file" name="file" id="file" required
                       accept="{{ $menuData['type'] === 'pdf' ? '.pdf' : 'image/*' }}"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('file')
                    <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <div class="flex justify-between">
            <a href="{{ route('admin.menus.create.step2') }}" 
               class="rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400">
                Précédent
            </a>
            <button type="submit" 
                    class="rounded-md bg-green-600 px-6 py-2 text-white hover:bg-green-700">
                Créer le menu
            </button>
        </div>
    </form>
</div>
@endsection