<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Témoignages') }}
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
                            <h3 class="text-lg font-semibold">{{ $testimony->title }}</h3>
                            <p class="text-gray-600 text-sm">Par {{ $testimony->user->name }} - {{ $testimony->created_at->format('d/m/Y') }}</p>
                            <p class="mt-4">{{ Str::limit($testimony->content, 200) }}</p>
                            <div class="mt-4">
                                <a href="{{ route('testimonies.show', $testimony) }}" class="text-blue-600 hover:underline">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p class="text-center text-gray-500">Aucun témoignage n'a été publié pour le moment.</p>
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