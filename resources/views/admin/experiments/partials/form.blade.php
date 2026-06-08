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

    @php
        $existingSteps = old('steps', $experiment->simulation_data['steps'] ?? []);
        if (! is_array($existingSteps) || count($existingSteps) === 0) {
            $existingSteps = [['title' => 'Langkah 1', 'description' => 'Deskripsi langkah pertama']];
        }

        $existingTools = old('tools', isset($experiment) ? implode(', ', $experiment->simulation_data['tools'] ?? []) : '');
        $existingResult = old('expected_result', $experiment->simulation_data['expected_result'] ?? '');
    @endphp

    <div>
        <div class="flex items-center justify-between gap-4">
            <div>
                <label class="font-semibold text-sm text-gray-700">Langkah Simulasi</label>
                <p class="mt-2 text-sm text-gray-500">Tambah atau hapus langkah sesuai kebutuhan eksperimen.</p>
            </div>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600">Langkah dapat ditambahkan / dihapus</span>
        </div>

        <div id="stepsContainer" class="mt-4 space-y-4">
            @foreach($existingSteps as $index => $step)
                <div class="rounded-3xl border border-gray-200 bg-slate-50 p-5 step-card">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h4 class="font-semibold text-gray-800">Langkah {{ $index + 1 }}</h4>
                            <p class="text-sm text-gray-500">Judul dan deskripsi setiap langkah.</p>
                        </div>
                        <button type="button" class="remove-step-button inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-sm font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                    </div>

                    <div class="mt-4 grid gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-700">Judul Langkah</label>
                            <input type="text" name="steps[{{ $index }}][title]" value="{{ old('steps.'.$index.'.title', $step['title'] ?? '') }}" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
                            @error('steps.'.$index.'.title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="font-semibold text-sm text-gray-700">Deskripsi Langkah</label>
                            <textarea name="steps[{{ $index }}][description]" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">{{ old('steps.'.$index.'.description', $step['description'] ?? '') }}</textarea>
                            @error('steps.'.$index.'.description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button id="addStepBtn" type="button" class="inline-flex items-center rounded-full bg-brand px-5 py-3 text-sm font-semibold text-white hover:bg-brandHover">Tambah Langkah</button>
        </div>
    </div>

    <div>
        <label class="font-semibold text-sm text-gray-700">Alat & Bahan</label>
        <input type="text" name="tools" value="{{ $existingTools }}" placeholder="Contoh: Gelas, Air, Botol" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
        <p class="mt-2 text-sm text-gray-500">Pisahkan alat dengan koma. Contoh: Gelas, Air, Botol.</p>
        @error('tools')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="font-semibold text-sm text-gray-700">Hasil yang Diharapkan</label>
        <textarea name="expected_result" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">{{ $existingResult }}</textarea>
        @error('expected_result')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stepsContainer = document.getElementById('stepsContainer');
        const addStepBtn = document.getElementById('addStepBtn');

        const escapeHtml = (string) => {
            return String(string)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        };

        const updateStepIndexes = () => {
            Array.from(stepsContainer.querySelectorAll('.step-card')).forEach((card, index) => {
                const header = card.querySelector('h4');
                if (header) {
                    header.textContent = `Langkah ${index + 1}`;
                }

                const titleInput = card.querySelector('input[name^="steps["]');
                const descriptionTextarea = card.querySelector('textarea[name^="steps["]');

                if (titleInput) {
                    titleInput.name = `steps[${index}][title]`;
                }
                if (descriptionTextarea) {
                    descriptionTextarea.name = `steps[${index}][description]`;
                }
            });
        };

        const createStepCard = (title = '', description = '') => {
            const card = document.createElement('div');
            card.className = 'rounded-3xl border border-gray-200 bg-slate-50 p-5 step-card';
            card.innerHTML = `
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h4 class="font-semibold text-gray-800">Langkah</h4>
                        <p class="text-sm text-gray-500">Judul dan deskripsi setiap langkah.</p>
                    </div>
                    <button type="button" class="remove-step-button inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-sm font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                </div>
                <div class="mt-4 grid gap-4">
                    <div>
                        <label class="font-semibold text-sm text-gray-700">Judul Langkah</label>
                        <input type="text" name="steps[0][title]" value="${escapeHtml(title)}" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand" />
                    </div>
                    <div>
                        <label class="font-semibold text-sm text-gray-700">Deskripsi Langkah</label>
                        <textarea name="steps[0][description]" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-brand focus:outline-none focus:ring-brand">${escapeHtml(description)}</textarea>
                    </div>
                </div>
            `;

            card.querySelector('.remove-step-button').addEventListener('click', function () {
                if (stepsContainer.children.length <= 1) {
                    return;
                }
                card.remove();
                updateStepIndexes();
            });

            return card;
        };

        addStepBtn.addEventListener('click', function () {
            const newCard = createStepCard('', '');
            stepsContainer.appendChild(newCard);
            updateStepIndexes();
        });

        stepsContainer.querySelectorAll('.remove-step-button').forEach((button) => {
            button.addEventListener('click', function () {
                const card = button.closest('.step-card');
                if (! card || stepsContainer.children.length <= 1) {
                    return;
                }
                card.remove();
                updateStepIndexes();
            });
        });

        updateStepIndexes();
    });
</script>
