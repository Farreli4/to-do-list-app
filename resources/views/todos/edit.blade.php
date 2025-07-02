<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Tugas</h2>

                <form action="{{ route('todos.updateData', $todo) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT') <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
                        <input type="text" id="title" name="title" value="{{ $todo->title }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition duration-300" required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="description" name="description" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition duration-300" rows="4">{{ $todo->description }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('todos.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
