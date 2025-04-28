<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $testimony->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-gray-600">Par {{ $testimony->user->name }}</p>
                            <p class="text-gray-500 text-sm">{{ $testimony->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        
                        @if(Auth::id() === $testimony->user_id)
                            <div class="flex space-x-2">
                                <a href="{{ route('testimonies.edit', $testimony) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('testimonies.destroy', $testimony) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if($testimony->status !== 'published')
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                            <p>Ce témoignage est en attente de modération et n'est pas encore visible publiquement.</p>
                        </div>
                    @endif

                    <div class="prose max-w-none mt-6">
                        {{ $testimony->content }}
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-between">
                <a href="{{ route('testimonies.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Retour aux témoignages
                </a>
            </div>
        </div>
    </div>
</x-app-layout>