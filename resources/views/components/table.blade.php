{{-- resources/views/components/table.blade.php --}}
@props(['columns', 'data', 'routePrefix'])

<div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg px-6 pb-6">
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
      <thead class="bg-blue-600 text-white">
        <tr>
          @foreach ($columns as $col)
            <th class="px-4 py-3 text-left text-sm font-semibold">
              @if($col === 'nama_karyawan')
                Nama Karyawan
              @else
                {{ ucfirst(str_replace('_', ' ', $col)) }}
              @endif
            </th>
          @endforeach
          <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200">
        @foreach ($data as $item)
          <tr class="hover:bg-blue-50">
            @foreach ($columns as $col)
              <td class="px-4 py-3">
                @if ($col === 'email')
                  <a href="mailto:{{ $item->$col }}" class="text-blue-600 hover:underline">{{ $item->$col }}</a>
                @elseif ($col === 'nomor_telepon')
                  <a href="tel:{{ $item->$col }}" class="text-blue-600 hover:underline">{{ $item->$col }}</a>
                @elseif ($col === 'nama_karyawan')
                  {{ $item->employee->nama_lengkap ?? 'N/A' }}
                @elseif ($col === 'department_id')
                  <a href="{{ route('departments.show', $item->$col) }}" class="text-blue-600 hover:underline">{{ $item->$col }}</a>
                @elseif ($col === 'position_id')
                  <a href="{{ route('positions.show', $item->$col) }}" class="text-blue-600 hover:underline">{{ $item->$col }}</a>
                @elseif ($col === 'status_absensi')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($item->$col == 'hadir') bg-green-100 text-green-800
                    @elseif($item->$col == 'izin') bg-yellow-100 text-yellow-800
                    @elseif($item->$col == 'sakit') bg-orange-100 text-orange-800
                    @elseif($item->$col == 'alpha') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($item->$col) }}
                  </span>
                @elseif ($col === 'tanggal')
                  {{ \Carbon\Carbon::parse($item->$col)->format('d F Y') }}
                @elseif ($col === 'bulan')
                  {{ \Carbon\Carbon::createFromFormat('Y-m', $item->$col)->format('F Y') }}
                @elseif (in_array($col, ['gaji_pokok', 'tunjangan', 'potongan', 'total_gaji']))
                  Rp{{ number_format($item->$col, 0, ',', '.') }}
                @else
                  {{ $item->$col }}
                @endif
              </td>
            @endforeach

            <td class="px-4 py-3">
              <div class="flex flex-row items-center justify-center space-x-2">
                <!-- Tombol Detail -->
                <a href="{{ route($routePrefix . '.show', $item->id) }}"
                  class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  </svg>
                </a>

                <!-- Tombol Edit -->
                <a href="{{ route($routePrefix . '.edit', $item->id) }}"
                  class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>
                </a>

                <!-- Tombol Hapus -->
                <form action="{{ route($routePrefix . '.destroy', $item->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                      stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                  </button>
                </form>
              </div>
            </td>

          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if (method_exists($data, 'links'))
    <div class="mt-4">
      {{ $data->links() }}
    </div>
  @endif
</div>