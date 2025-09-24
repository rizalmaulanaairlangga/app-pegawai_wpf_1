@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="poppins-regular bg-gray-100 text-gray-800">
  <div class="max-w-7xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-900 border-b-2 border-blue-600 pb-2 mb-6">
      Daftar Pegawai
    </h1>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold">Nama Lengkap</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Nomor Telepon</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Lahir</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Alamat</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Masuk</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
          @foreach($employees as $employee)
          <tr class="hover:bg-blue-50">
            <td class="px-4 py-3">{{ $employee->nama_lengkap }}</td>
            <td class="px-4 py-3">{{ $employee->email }}</td>
            <td class="px-4 py-3">{{ $employee->nomor_telepon }}</td>
            <td class="px-4 py-3">{{ $employee->tanggal_lahir }}</td>
            <td class="px-4 py-3">{{ $employee->alamat }}</td>
            <td class="px-4 py-3">{{ $employee->tanggal_masuk }}</td>
            <td class="px-4 py-3">
                <span class="{{ strtolower($employee->status) == 'aktif' 
                    ? 'px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800' 
                    : 'px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-800' }}">
                    {{ $employee->status }}
                </span>
            </td>
            <td class="px-4 py-3">
                <div class="flex flex-col items-center space-y-2">
                    <!-- Tombol Detail -->
                    <a href="{{ route('employees.show', $employee->id) }}" 
                    class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" 
                            class="w-4 h-4 mr-1 fill-current">
                            <path d="M320 96C239.2 96 174.5 132.8 127.4 176.6C80.6 220.1 49.3 272 34.4 307.7C31.1 315.6 31.1 324.4 34.4 332.3C49.3 368 80.6 420 127.4 463.4C174.5 507.1 239.2 544 320 544C400.8 544 465.5 507.2 512.6 463.4C559.4 419.9 590.7 368 605.6 332.3C608.9 324.4 608.9 315.6 605.6 307.7C590.7 272 559.4 220 512.6 176.6C465.5 132.9 400.8 96 320 96zM176 320C176 240.5 240.5 176 320 176C399.5 176 464 240.5 464 320C464 399.5 399.5 464 320 464C240.5 464 176 399.5 176 320zM320 256C320 291.3 291.3 320 256 320C244.5 320 233.7 317 224.3 311.6C223.3 322.5 224.2 333.7 227.2 344.8C240.9 396 293.6 426.4 344.8 412.7C396 399 426.4 346.3 412.7 295.1C400.5 249.4 357.2 220.3 311.6 224.3C316.9 233.6 320 244.4 320 256z"/>
                        </svg>
                        Detail
                    </a>

                    <!-- Tombol Edit -->
                    <a href="{{ route('employees.edit', $employee->id) }}" 
                    class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" 
                            class="w-4 h-4 mr-1 fill-current">
                            <path d="M535.6 85.7C513.7 63.8 478.3 63.8 456.4 85.7L432 110.1L529.9 208L554.3 183.6C576.2 161.7 576.2 126.3 554.3 104.4L535.6 85.7zM236.4 305.7C230.3 311.8 225.6 319.3 222.9 327.6L193.3 416.4C190.4 425 192.7 434.5 199.1 441C205.5 447.5 215 449.7 223.7 446.8L312.5 417.2C320.7 414.5 328.2 409.8 334.4 403.7L496 241.9L398.1 144L236.4 305.7zM160 128C107 128 64 171 64 224L64 480C64 533 107 576 160 576L416 576C469 576 512 533 512 480L512 384C512 366.3 497.7 352 480 352C462.3 352 448 366.3 448 384L448 480C448 497.7 433.7 512 416 512L160 512C142.3 512 128 497.7 128 480L128 224C128 206.3 142.3 192 160 192L256 192C273.7 192 288 177.7 288 160C288 142.3 273.7 128 256 128L160 128z"/>
                        </svg>
                        Edit
                    </a>

                    <!-- Tombol Delete -->
                    <form action="{{ route('employees.destroy', $employee->id) }}" 
                        method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" 
                                class="w-4 h-4 mr-1 fill-current">
                                <path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
