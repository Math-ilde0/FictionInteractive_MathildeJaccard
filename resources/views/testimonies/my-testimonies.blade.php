<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes témoignages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('testimonies.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Ajouter un témoignage
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="space-y-6">
                @forelse ($testimonies as $testimony)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $testimony->title }}</h3>
                                    <p class="text-gray-500 text-sm">Créé le {{ $testimony->created_at->format('d/m/Y') }}</p>
                                    
                                    <div class="mt-2">
                                        @if($testimony->status === 'published')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Publié</span>
                                        @elseif($testimony->status === 'draft')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En attente</span>
                                        @elseif($testimony->status === 'rejected')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Refusé</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('testimonies.edit', $testimony) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('testimonies.destroy', $testimony) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 text-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <p class="mt-4">{{ Str::limit($testimony->content, 200) }}</p>
                            <div class="mt-4">
                                <a href="{{ route('testimonies.show', $testimony) }}" class="text-blue-600 hover:underline">Voir le témoignage</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p class="text-center text-gray-500">Vous n'avez pas encore partagé de témoignage.</p>
                        </div>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $testimonies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>