<div class="space-y-4">
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Zone de drop des fichiers -->
    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
        <input
            type="file"
            wire:model="files"
            multiple
            class="hidden"
            id="file-upload"
            accept="image/*,application/pdf,.doc,.docx"
        >

        <label for="file-upload" class="cursor-pointer">
            <div class="space-y-2">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="text-sm text-gray-600">
                    <span class="font-medium text-blue-600 hover:text-blue-500">Cliquez pour uploader</span>
                    ou glissez-déposez vos fichiers ici
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, PDF jusqu'à 10MB</p>
            </div>
        </label>
    </div>

    <!-- Barre de progression -->
    @if ($isUploading)
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ $uploadProgress }}%"></div>
        </div>
        <p class="text-sm text-gray-600 text-center">Upload en cours... {{ $uploadProgress }}%</p>
    @endif

    <!-- Liste des fichiers uploadés -->
    @if (!empty($uploadedFiles))
        <div class="space-y-2">
            <h4 class="font-medium text-gray-900">Fichiers uploadés :</h4>
            @foreach ($uploadedFiles as $index => $file)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded border">
                    <div class="flex items-center space-x-3">
                        @if (str_starts_with($file['mime_type'], 'image/'))
                            <img src="{{ $file['url'] }}" alt="{{ $file['original_name'] }}" class="w-10 h-10 object-cover rounded">
                        @else
                            <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $file['original_name'] }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($file['size'] / 1024, 1) }} KB</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ $file['url'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                            Voir
                        </a>
                        <button
                            wire:click="removeFile({{ $index }})"
                            class="text-red-600 hover:text-red-800 text-sm"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?')"
                        >
                            Supprimer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Loading indicator -->
    <div wire:loading class="text-center">
        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-blue-500">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Traitement...
        </div>
    </div>
</div>
