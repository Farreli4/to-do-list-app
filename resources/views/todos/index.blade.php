<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- KARTU STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-md flex justify-between items-start"><div><p class="text-sm font-medium text-gray-500">Total Tugas</p><p class="text-3xl font-bold text-gray-800">{{ $total_todos }}</p></div><div class="bg-blue-100 text-blue-600 p-3 rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg></div></div>
                <div class="bg-white p-6 rounded-2xl shadow-md flex justify-between items-start"><div><p class="text-sm font-medium text-gray-500">Tugas Selesai</p><p class="text-3xl font-bold text-gray-800">{{ $completed_todos }}</p></div><div class="bg-green-100 text-green-600 p-3 rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div></div>
                <div class="bg-white p-6 rounded-2xl shadow-md flex justify-between items-start"><div><p class="text-sm font-medium text-gray-500">Tugas Tersisa</p><p class="text-3xl font-bold text-gray-800">{{ $remaining_todos }}</p></div><div class="bg-orange-100 text-orange-600 p-3 rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div></div>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow-md mb-8">
                <form action="{{ route('todos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="title" placeholder="Judul Tugas..." class="w-full px-4 py-3 border-0 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500 transition duration-300" required>
                    <textarea name="description" placeholder="Deskripsi singkat (opsional)..." class="w-full px-4 py-3 border-0 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500 transition duration-300" rows="2"></textarea>
                    <div class="text-right">
                        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                            Tambah Tugas
                        </button>
                    </div>
                </form>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div>
                    <h2 class="text-xl font-bold text-black mb-4">Tugas Tersisa</h2>
                    <div class="space-y-4">
                        @forelse ($todos->where('is_completed', false) as $todo)
                            <div class="group bg-white p-4 rounded-2xl shadow-sm flex items-start transition-all duration-300 hover:shadow-lg">
                                <form action="{{ route('todos.update', $todo) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full cursor-pointer flex-shrink-0 mt-1" onclick="this.closest('form').submit()"></div>
                                </form>
                                <div class="flex-1 ml-4">
                                    <span class="text-black font-medium">{{ $todo->title }}</span>
                                    @if($todo->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $todo->description }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center ml-auto pl-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('todos.edit', $todo) }}" class="text-gray-400 hover:text-blue-500 mr-2" title="Edit Tugas">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('todos.update', $todo) }}" method="POST" class="mr-2">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-gray-400 hover:text-green-500" title="Selesaikan Tugas">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus tugas ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Hapus Tugas">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white text-center p-8 rounded-2xl shadow-md border-2 border-dashed border-gray-200">
                                <svg class="mx-auto h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" /></svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Hebat!</h3><p class="mt-1 text-sm text-gray-500">Tidak ada tugas yang tersisa.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-black mb-4">Tugas Selesai</h2>
                    <div class="space-y-4">
                        @forelse ($todos->where('is_completed', true) as $todo)
                            <div class="group bg-white p-4 rounded-2xl shadow-sm flex items-start opacity-70">
                                <form action="{{ route('todos.update', $todo) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="w-6 h-6 border-2 border-green-500 bg-green-500 rounded-full cursor-pointer flex-shrink-0 mt-1 text-white flex items-center justify-center" onclick="this.closest('form').submit()">✓</div>
                                </form>
                                <div class="flex-1 ml-4">
                                    <span class="text-gray-500 font-medium line-through">{{ $todo->title }}</span>
                                    @if($todo->description)
                                        <p class="text-sm text-gray-400 mt-1 line-through">{{ $todo->description }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center ml-auto pl-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus tugas ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Hapus Tugas">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white text-center p-8 rounded-2xl shadow-md border-2 border-dashed border-gray-200">
                                <svg class="mx-auto h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0l-.07.002z" /></svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada tugas selesai</h3><p class="mt-1 text-sm text-gray-500">Ayo selesaikan beberapa tugas!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
