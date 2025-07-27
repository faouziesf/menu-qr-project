@extends('layouts.admin')

@section('title', 'Modifier le menu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Modifier le menu</h1>
        <p class="mt-2 text-gray-600">{{ $menu->name }}</p>
    </div>

    <form method="POST" action="{{ route('admin.menus.update', $menu) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom du menu</label>
            <input type="text" name="name" id="name" required
                   value="{{ old('name', $menu->name) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name')
                <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="template" class="block text-sm font-medium text-gray-700">Template</label>
            <select name="template" id="template" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="blank" {{ $menu->template === 'blank' ? 'selected' : '' }}>Page vierge</option>
                <option value="modern" {{ $menu->template === 'modern' ? 'selected' : '' }}>Moderne</option>
                <option value="classic" {{ $menu->template === 'classic' ? 'selected' : '' }}>Classique</option>
            </select>
        </div>

        @if($menu->type === 'html')
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu HTML</label>
                <textarea name="content" id="content" rows="15"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm">{{ old('content', $menu->content) }}</textarea>
            </div>
        @else
            <div>
                <label class="block text-sm font-medium text-gray-700">Fichier actuel</label>
                @if($menu->file_path)
                    <div class="mt-2 p-4 bg-gray-50 rounded-md">
                        <a href="{{ asset('storage/' . $menu->file_path) }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-800">
                            Voir le fichier actuel
                        </a>
                    </div>
                @endif
                
                <label for="file" class="block text-sm font-medium text-gray-700 mt-4">
                    Remplacer par un nouveau fichier (optionnel)
                </label>
                <input type="file" name="file" id="file"
                       accept="{{ $menu->type === 'pdf' ? '.pdf' : 'image/*' }}"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        @endif

        <div class="flex items-center">
            <input type="checkbox" name="is_published" id="is_published" 
                   {{ $menu->is_published ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                Publier le menu
            </label>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.dashboard') }}" 
               class="rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400">
                Retour
            </a>
            <button type="submit" 
                    class="rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection