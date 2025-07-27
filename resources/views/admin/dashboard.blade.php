@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <a href="{{ route('admin.menus.create') }}" 
           class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Créer un nouveau menu
        </a>
    </div>
</div>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($menus as $menu)
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">{{ $menu->name }}</h3>
                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold 
                          {{ $menu->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $menu->is_published ? 'Publié' : 'Brouillon' }}
                    </span>
                </div>
                
                <div class="mt-2">
                    <p class="text-sm text-gray-600">
                        Type: <span class="font-medium">{{ ucfirst($menu->type) }}</span><br>
                        Template: <span class="font-medium">{{ ucfirst($menu->template) }}</span><br>
                        Créé le: {{ $menu->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>

                @if($menu->qr_code_path)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $menu->qr_code_path) }}" 
                             alt="QR Code" class="h-20 w-20 mx-auto">
                    </div>
                @endif

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('admin.menus.edit', $menu) }}" 
                       class="flex-1 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm text-white hover:bg-indigo-700">
                        Modifier
                    </a>
                    <a href="{{ route('public.menu', $menu->slug) }}" 
                       target="_blank"
                       class="flex-1 rounded-md bg-gray-600 px-3 py-2 text-center text-sm text-white hover:bg-gray-700">
                        Voir
                    </a>
                </div>

                <div class="mt-2">
                    <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce menu ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full rounded-md bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Aucun menu créé pour le moment.</p>
            <a href="{{ route('admin.menus.create') }}" 
               class="mt-4 inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                Créer votre premier menu
            </a>
        </div>
    @endforelse
</div>
@endsection