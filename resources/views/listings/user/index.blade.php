<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mani sludinājumi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($listings->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <p class="text-gray-600">{{ __('Jums vēl nav izveidotu sludinājumu.') }}</p>
                        <a href="{{ route('listings.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-900">
                            {{ __('Izveidot pirmo sludinājumu') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="space-y-6">
                            @foreach($listings as $listing)
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 last:border-0 last:pb-0">
                                    <div class="mb-4 md:mb-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $listing->title }}</h3>
                                        <p class="text-gray-600">{{ $listing->school->name }}</p>
                                        <p class="text-lg font-bold text-indigo-600">{{ number_format($listing->price, 2) }} €</p>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        
                                        <form action="{{ route('listings.destroy', $listing) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                                {{ __('Dzēst') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>