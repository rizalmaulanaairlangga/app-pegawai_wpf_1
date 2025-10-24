@props([
  'type' => '',             // Jenis tombol: back, create, edit, delete     
  'routePrefix' => '',      // Prefix route: employees, departments, dll    
  'id' => null,             // ID data (untuk edit/delete)  
  'label' => null           // Label custom opsional    
])


@if ($type === 'back')
  <a
    href="javascript:history.back()"
    class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
      viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 19l-7-7 7-7" />
    </svg>
    Kembali
  </a>

@elseif ($type === 'create')
  <div class="mt-6 flex justify-end">
    <a href="{{ route($routePrefix . '.create') }}"
      class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      {{ $label ?? 'Tambah ' . ucfirst(Str::singular($routePrefix)) }}
    </a>
  </div>

@elseif ($type === 'edit' && $id)
  <a href="{{ route($routePrefix . '.edit', $id) }}"
    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
    {{ $label ?? 'Edit' }}
  </a>

@elseif ($type === 'delete' && $id)
  <form action="{{ route($routePrefix . '.destroy', $id) }}" method="POST"
    onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
      class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">
      {{ $label ?? 'Hapus' }}
    </button>
  </form>
@endif