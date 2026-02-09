<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">
            {{ __('Izveidot jaunu sludinājumu') }}
        </h2>
    </x-slot>

    <div class="page-container">
        <div class="form-wrapper">
            <div class="form-card">

                <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label for="title" class="form-label">
                            Nosaukums
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            required
                            autofocus
                            value="{{ old('title') }}"
                            placeholder="Ievadiet sludinājuma nosaukumu"
                            class="form-input">
                        @error('title')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="form-label">
                            Apraksts
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            required
                            rows="4"
                            placeholder="Aprakstiet sludinājuma detaļas..."
                            class="form-textarea">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Photos --}}
                    <div>
                        <label class="form-label-photos">
                            Attēli (var būt vairāki)
                        </label>

                        <input
                            id="photosInput"
                            type="file"
                            name="photos[]"
                            multiple
                            accept="image/*"
                            class="hidden"
                            onchange="previewFiles()">

                        <div
                            id="photoUploadArea"
                            onclick="document.getElementById('photosInput').click()"
                            class="photo-upload-area">

                            <div class="text-5xl mb-4">📸</div>
                            <p class="font-semibold text-gray-700 mb-4">
                                Noklikšķiniet, lai pievienotu attēlus
                            </p>

                            <button type="button" class="btn-primary">
                                Pievienot attēlus
                            </button>
                        </div>

                        <div id="photoPreview" class="photo-preview-grid"></div>

                        @error('photos')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="form-label">
                            Cena (€)
                        </label>
                        <input
                            id="price"
                            name="price"
                            type="number"
                            step="0.01"
                            required
                            value="{{ old('price') }}"
                            placeholder="0.00"
                            class="form-input">
                        @error('price')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- School --}}
                    <div>
                        <label for="school_id" class="form-label">
                            Skola
                        </label>
                        <select
                            id="school_id"
                            name="school_id"
                            required
                            class="form-select">
                            <option value="">Izvēlieties skolu</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->region }})
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="form-label">
                            Kategorija
                        </label>
                        <select
                            id="category_id"
                            name="category_id"
                            required
                            class="form-select">
                            <option value="">Izvēlieties kategoriju</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="form-actions">
                        <a href="{{ route('listings.index') }}" class="btn-secondary">
                            Atcelt
                        </a>

                        <button type="submit" class="btn-primary">
                            Saglabāt sludinājumu
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
    function previewFiles() {
        const input = document.getElementById('photosInput');
        const previewContainer = document.getElementById('photoPreview');
        const uploadArea = document.getElementById('photoUploadArea');

        // Clear previous previews
        previewContainer.innerHTML = '';

        if (input.files && input.files.length > 0) {
            // Hide upload area when files are selected
            uploadArea.style.display = 'none';

            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group';

                    previewItem.innerHTML = `
                        <img src="${e.target.result}"
                             alt="Preview ${index + 1}"
                             class="w-full h-48 object-cover rounded-lg">
                        <button type="button"
                                onclick="removeImage(${index})"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                            ×
                        </button>
                    `;

                    previewContainer.appendChild(previewItem);
                };

                reader.readAsDataURL(file);
            });

            // Add button to add more photos at the end
            const addMoreButton = document.createElement('div');
            addMoreButton.className = 'flex items-center justify-center';
            addMoreButton.innerHTML = `
                <button type="button"
                        onclick="addMorePhotos()"
                        class="w-full h-48 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors flex flex-col items-center justify-center text-gray-600 hover:text-blue-600">
                    <span class="text-4xl mb-2">+</span>
                    <span class="font-semibold">Pievienot vēl</span>
                </button>
            `;
            previewContainer.appendChild(addMoreButton);

        } else {
            // Show upload area if no files
            uploadArea.style.display = 'flex';
        }
    }

    function addMorePhotos() {
        const input = document.getElementById('photosInput');
        const tempInput = document.createElement('input');
        tempInput.type = 'file';
        tempInput.multiple = true;
        tempInput.accept = 'image/*';
        
        tempInput.onchange = function(e) {
            const dt = new DataTransfer();
            
            // Add existing files
            Array.from(input.files).forEach(file => {
                dt.items.add(file);
            });
            
            // Add new files
            Array.from(tempInput.files).forEach(file => {
                dt.items.add(file);
            });
            
            input.files = dt.files;
            previewFiles();
        };
        
        tempInput.click();
    }

    function removeImage(index) {
        const input = document.getElementById('photosInput');
        const dt = new DataTransfer();

        Array.from(input.files).forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });

        input.files = dt.files;
        previewFiles();
    }
</script>
</x-app-layout>