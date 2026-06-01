<div class="space-y-6">
    <div>
        <label class="font-semibold text-sm text-gray-700">Judul Eksperimen</label>
        <input type="text" name="title" value="{{ old('title', $experiment->title ?? '') }}" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
        @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="font-semibold text-sm text-gray-700">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $experiment->category ?? '') }}" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" placeholder="Contoh: Kimia" />
        @error('category')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="font-semibold text-sm text-gray-700">Tingkat Kesulitan</label>
            <select name="difficulty" class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">
                @foreach(['Mudah', 'Sedang', 'Sulit'] as $level)
                    <option value="{{ $level }}" {{ old('difficulty', $experiment->difficulty ?? '') === $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
            @error('difficulty')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="font-semibold text-sm text-gray-700">Durasi (menit)</label>
            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $experiment->duration_minutes ?? '') }}" min="1" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
            @error('duration_minutes')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="font-semibold text-sm text-gray-700">Poin Reward</label>
        <input type="number" name="points_reward" value="{{ old('points_reward', $experiment->points_reward ?? 10) }}" min="0" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
        @error('points_reward')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="font-semibold text-sm text-gray-700">Deskripsi</label>
        <textarea name="description" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">{{ old('description', $experiment->description ?? '') }}</textarea>
        @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="font-semibold text-sm text-gray-700">Data Simulasi (JSON)</label>
        <textarea name="simulation_data" rows="8" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">{{ old('simulation_data', isset($experiment) ? json_encode($experiment->simulation_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '{"steps": [{"title": "Langkah 1", "description": "Deskripsi langkah pertama"}]}' ) }}</textarea>
        <p class="mt-2 text-sm text-gray-500">Masukkan JSON yang valid, misalnya: <code>{"steps":[{"title":"Langkah 1","description":"Deskripsi"}]}</code></p>
        @error('simulation_data')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>
