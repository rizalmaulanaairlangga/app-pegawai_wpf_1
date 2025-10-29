<div x-data="attendanceTable()" class="overflow-x-auto bg-white p-6 rounded-lg shadow-md">
  <table class="min-w-full border text-sm">
    <thead class="bg-blue-600 text-white">
      <tr>
        <th class="px-3 py-2 text-left">Departemen</th>
        <th class="px-3 py-2 text-left">Nama Pegawai</th>
        @for ($i = 0; $i < 7; $i++)
          <th class="px-3 py-2 text-center">
            {{ now()->subDays(6 - $i)->format('d M') }}
          </th>
        @endfor
      </tr>
    </thead>

    <tbody>
      @foreach ($employees as $emp)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-3 py-2">{{ $emp->department->nama_departemen ?? '-' }}</td>
          <td class="px-3 py-2">{{ $emp->nama_lengkap }}</td>
          
          @for ($i = 0; $i < 7; $i++)
            @php
              $date = now()->subDays(6 - $i)->toDateString();
              $absen = $emp->attendances->firstWhere('tanggal', $date);
              $status = $absen->status_absensi ?? null;
            @endphp

            <td class="px-3 py-2 text-center cursor-pointer"
                @click="toggle('{{ $emp->id }}', '{{ $date }}')"
                x-bind:class="getClass('{{ $emp->id }}', '{{ $date }}')">
              <span x-text="getIcon('{{ $emp->id }}', '{{ $date }}')"></span>
            </td>
          @endfor
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script>
function attendanceTable() {
  return {
    statuses: ['alpha', 'hadir', 'izin', 'sakit'],
    data: {},

    toggle(empId, date) {
      const key = `${empId}-${date}`;
      const current = this.data[key] ?? 'alpha';
      const next = this.statuses[(this.statuses.indexOf(current) + 1) % this.statuses.length];
      this.data[key] = next;
      // Kirim AJAX update ke Laravel
      fetch(`/attendances/toggle`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ employee_id: empId, tanggal: date, status: next })
      });
    },

    getClass(empId, date) {
      const key = `${empId}-${date}`;
      const status = this.data[key];
      return {
        'bg-green-100 text-green-700': status === 'hadir',
        'bg-yellow-100 text-yellow-700': status === 'izin',
        'bg-orange-100 text-orange-700': status === 'sakit',
        'bg-red-100 text-red-700': status === 'alpha',
      };
    },

    getIcon(empId, date) {
      const key = `${empId}-${date}`;
      const status = this.data[key] ?? 'alpha';
      return { hadir: '✅', izin: '🟡', sakit: '🟢', alpha: '❌' }[status];
    }
  }
}
</script>
