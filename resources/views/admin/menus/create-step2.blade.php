@extends('layouts.admin')

@section('title', 'Créer un menu - Étape 2')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un nouveau menu</h1>
        <p class="mt-2 text-gray-600">Étape 2 sur 3 : Nom et template</p>
    </div>

    <form method="POST" action="{{ route('admin.menus.create.step2.store') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom du menu</label>
            <input type="text" name="name" id="name" required
                   value="{{ old('name') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name')
                <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="template" class="block text-sm font-medium text-gray-700">Template</label>
            <select name="template" id="template" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @foreach($templates as $key => $label)
                    <option value="{{ $key }}" {{ old('template') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('template')
                <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.menus.create') }}" 
               class="rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400">
                Précédent
            </a>
            <button type="submit" 
                    class="rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                Suivant
            </button>
        </div>
    </form>
</div>
@endsection