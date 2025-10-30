<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Izveidot jaunu sludinājumu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Nosaukums')" class="!text-black" />
                            <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm
                                       bg-white text-gray-900 placeholder-gray-400
                                       focus:border-[#2ecc71] focus:ring focus:ring-[#2ecc71]/50" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Apraksts')" class="!text-black" />
                            <textarea id="description" name="description" rows="4" required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm
                                       bg-white text-gray-900 placeholder-gray-400
                                       focus:border-[#2ecc71] focus:ring focus:ring-[#2ecc71]/50">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Photos -->
                        <div class="mb-4">
                            <x-input-label for="photos" :value="__('Attēli (var būt vairāki)')" class="!text-black" />

                            <input id="photosInput" type="file" accept="image/*" multiple name="photos[]" class="hidden"
                                onchange="previewFiles()" />

                            <button type="button" onclick="document.getElementById('photosInput').click()"
                                class="px-4 py-2 bg-[#2ecc71] hover:bg-[#27ae60] text-white rounded-md mb-2 transition">
                                Pievienot attēlus
                            </button>

                            <div id="photoPreview" class="mt-2 flex flex-wrap gap-2"></div>
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Cena (€)')" class="!text-black" />
                            <input id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm
                                       bg-white text-gray-900 placeholder-gray-400
                                       focus:border-[#2ecc71] focus:ring focus:ring-[#2ecc71]/50" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- School -->
                        <div class="mb-6">
                            <x-input-label for="school_id" :value="__('Skola')" class="!text-black" />
                            <select id="school_id" name="school_id" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm
                                       bg-white text-gray-900 placeholder-gray-400
                                       focus:border-[#2ecc71] focus:ring focus:ring-[#2ecc71]/50">
                                <option value="">Izvēlieties skolu</option>
                                @foreach($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->region }})
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-6">
                            <x-input-label for="category_id" :value="__('Kategorija')" class="!text-black" />
                            <select id="category_id" name="category_id" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm
                                         bg-white text-gray-900 placeholder-gray-400
                                        focus:border-[#2ecc71] focus:ring focus:ring-[#2ecc71]/50">
                                <option value="">Izvēlieties kategoriju</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-[#2ecc71] hover:bg-[#27ae60] text-white rounded-md transition">
                                Saglabāt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    let selectedFiles = [];

    function previewFiles() {
        const input = document.getElementById('photosInput');
        selectedFiles = [...selectedFiles, ...Array.from(input.files)];
        input.value = ''; // allow new selection
        renderPreviews();
    }

    function renderPreviews() {
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('relative', 'inline-block');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;
                img.classList.add('h-20', 'rounded', 'border');

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.innerHTML = '✖';
                btn.classList.add(
                    'absolute', 'top-0', 'right-0',
                    'bg-red-500', 'text-white', 'rounded-full',
                    'px-1', 'leading-none'
                );
                btn.onclick = () => removeFile(index);

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                preview.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        syncInputFiles();
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        renderPreviews();
    }

    function syncInputFiles() {
        const input = document.getElementById('photosInput');
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;
    }

    // Ensure files are synced before form submit
    document.querySelector('form').addEventListener('submit', (e) => {
        syncInputFiles();
    });
    </script>
</x-app-layout>