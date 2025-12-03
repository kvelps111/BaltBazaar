<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Izveidot jaunu sludinājumu') }}
        </h2>
    </x-slot>

    <style>
        :root {
            --balt-green: #2ecc71;
            --balt-green-dark: #27ae60;
        }

        /* Form Container */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 2px solid rgba(46, 204, 113, 0.1);
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        /* Form Group */
        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid rgba(46, 204, 113, 0.15);
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            background: #fff;
            color: #1a1a1a;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--balt-green);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Photo Upload */
        .photo-upload {
            border: 2px dashed rgba(46, 204, 113, 0.3);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: rgba(46, 204, 113, 0.02);
            cursor: pointer;
        }

        .photo-upload:hover {
            border-color: var(--balt-green);
            background: rgba(46, 204, 113, 0.05);
        }

        .photo-upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .photo-upload p {
            color: #666;
            margin: 0.5rem 0;
        }

        .photo-upload .btn-upload {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .photo-upload .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        /* Photo Preview */
        .photo-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .photo-preview-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid rgba(46, 204, 113, 0.1);
            transition: all 0.3s ease;
        }

        .photo-preview-item:hover {
            border-color: var(--balt-green);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.2);
        }

        .photo-preview-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            display: block;
        }

        .photo-preview-remove {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .photo-preview-item:hover .photo-preview-remove {
            opacity: 1;
        }

        .photo-preview-remove-btn {
            background: rgba(255, 255, 255, 0.9);
            color: #1a1a1a;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-weight: 700;
        }

        .photo-preview-remove-btn:hover {
            background: white;
            transform: scale(1.1);
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(46, 204, 113, 0.1);
        }

        .btn {
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--balt-green) 0%, var(--balt-green-dark) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-cancel {
            background: #f0f0f0;
            color: #1a1a1a;
            border: 2px solid #e0e0e0;
        }

        .btn-cancel:hover {
            background: #e8e8e8;
            border-color: #d0d0d0;
        }

        /* Error Messages */
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 1rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-green-50/30 min-h-screen">
        <div class="form-container">
            <div class="form-card">
                <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">{{ __('Nosaukums') }}</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus
                            placeholder="Ievadiet sludinājuma nosaukumu" />
                        @if($errors->has('title'))
                            <span class="error-message">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">{{ __('Apraksts') }}</label>
                        <textarea id="description" name="description" required
                            placeholder="Aprakstiet sludinājuma detaļas...">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <span class="error-message">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <!-- Photos -->
                    <div class="form-group">
                        <label>{{ __('Attēli (var būt vairāki)') }}</label>
                        
                        <input id="photosInput" type="file" accept="image/*" multiple name="photos[]" class="hidden"
                            onchange="previewFiles()" />

                        <div class="photo-upload" id="photoUploadArea" onclick="document.getElementById('photosInput').click()">
                            <div class="photo-upload-icon">📸</div>
                            <p class="font-semibold">Noklikšķiniet, lai pievienotu attēlus</p>
                            <p style="font-size: 0.875rem; color: #999;">vai velciet attēlus šeit</p>
                            <button type="button" class="btn-upload">
                                Pievienot attēlus
                            </button>
                        </div>

                        <div id="photoPreview" class="photo-preview-container"></div>
                        
                        @if($errors->has('photos'))
                            <span class="error-message">{{ $errors->first('photos') }}</span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="price">{{ __('Cena (€)') }}</label>
                        <input id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required
                            placeholder="0.00" />
                        @if($errors->has('price'))
                            <span class="error-message">{{ $errors->first('price') }}</span>
                        @endif
                    </div>

                    <!-- School -->
                    <div class="form-group">
                        <label for="school_id">{{ __('Skola') }}</label>
                        <select id="school_id" name="school_id" required>
                            <option value="">Izvēlieties skolu</option>
                            @foreach($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }} ({{ $school->region }})
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('school_id'))
                            <span class="error-message">{{ $errors->first('school_id') }}</span>
                        @endif
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="category_id">{{ __('Kategorija') }}</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Izvēlieties kategoriju</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <span class="error-message">{{ $errors->first('category_id') }}</span>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="button-group">
                        <a href="{{ route('listings.index') }}" class="btn btn-cancel">
                            {{ __('Atcelt') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Saglabāt sludinājumu') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let selectedFiles = [];

    // Drag and Drop functionality
    const uploadArea = document.getElementById('photoUploadArea');

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.style.borderColor = '#2ecc71';
        uploadArea.style.background = 'rgba(46, 204, 113, 0.1)';
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.style.borderColor = 'rgba(46, 204, 113, 0.3)';
        uploadArea.style.background = 'rgba(46, 204, 113, 0.02)';
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.style.borderColor = 'rgba(46, 204, 113, 0.3)';
        uploadArea.style.background = 'rgba(46, 204, 113, 0.02)';
        
        const files = e.dataTransfer.files;
        selectedFiles = [...selectedFiles, ...Array.from(files)];
        renderPreviews();
    });

    function previewFiles() {
        const input = document.getElementById('photosInput');
        selectedFiles = [...selectedFiles, ...Array.from(input.files)];
        input.value = '';
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
                wrapper.classList.add('photo-preview-item');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;

                const overlay = document.createElement('div');
                overlay.classList.add('photo-preview-remove');

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'photo-preview-remove-btn';
                btn.textContent = '−';
                btn.onclick = (e) => {
                    e.preventDefault();
                    removeFile(index);
                };

                overlay.appendChild(btn);
                wrapper.appendChild(img);
                wrapper.appendChild(overlay);
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

    document.querySelector('form').addEventListener('submit', (e) => {
        syncInputFiles();
    });
    </script>
</x-app-layout>