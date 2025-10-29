@extends('layouts.app')
@section('title', 'Data Kehadiran Karyawan')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-6" x-data="attendanceManager()">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Kehadiran Karyawan</h1>
            <p class="text-gray-600">Manajemen absensi per departemen - Minggu: {{ \Carbon\Carbon::now()->startOfWeek()->format('d M') }} - {{ \Carbon\Carbon::now()->endOfWeek()->subDay()->format('d M Y') }}</p>
        </div>
        <a href="{{ route('attendances.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Manual
        </a>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                <select x-model="selectedDepartment" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->nama_departemen }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" x-model="selectedDate" value="{{ now()->format('Y-m-d') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input type="text" x-model="searchQuery" placeholder="Cari karyawan..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Tabel Kehadiran -->
    <div class="overflow-hidden rounded-lg shadow border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departemen
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Karyawan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Absen Hari Ini
                        </th>
                        @foreach($weekDays as $day)
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $day['short_day'] }}<br>
                            <span class="text-xs font-normal">{{ \Carbon\Carbon::parse($day['date'])->format('d/m') }}</span>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="employee in filteredEmployees" :key="employee.id">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Departemen -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" 
                                      x-text="employee.department.nama_departemen"></span>
                            </td>
                            
                            <!-- Nama Karyawan -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium" x-text="getInitials(employee.nama_lengkap)"></span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900" x-text="employee.nama_lengkap"></div>
                                        <div class="text-sm text-gray-500" x-text="employee.email"></div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Tombol Absen Hari Ini -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-2" x-data="{
                                    todayAttendance: getTodayAttendance(employee.id),
                                    showDelete: false
                                }">
                                    <!-- Tombol Masuk -->
                                    <button x-show="!todayAttendance"
                                            @click="markAttendance(employee.id, 'hadir')" 
                                            class="flex items-center px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Masuk
                                    </button>

                                    <!-- Tombol Izin -->
                                    <button x-show="!todayAttendance"
                                            @click="markAttendance(employee.id, 'izin')" 
                                            class="flex items-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Izin
                                    </button>

                                    <!-- Tombol Sakit -->
                                    <button x-show="!todayAttendance"
                                            @click="markAttendance(employee.id, 'sakit')" 
                                            class="flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        Sakit
                                    </button>

                                    <!-- Status Sudah Absen -->
                                    <template x-if="todayAttendance">
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-2 rounded-lg text-sm font-medium" 
                                                  :class="getStatusClass(todayAttendance.status_absensi)"
                                                  x-text="getStatusText(todayAttendance.status_absensi) + (todayAttendance.waktu_masuk ? ' (' + todayAttendance.waktu_masuk + ')' : '')">
                                            </span>
                                            
                                            <!-- Tombol Keluar -->
                                            <button x-show="todayAttendance.status_absensi === 'hadir' && !todayAttendance.waktu_keluar"
                                                    @click="markExit(employee.id)" 
                                                    class="flex items-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded transition-colors text-xs">
                                                Keluar
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button @click="deleteAttendance(employee.id)" 
                                                    class="flex items-center px-2 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded transition-colors text-xs">
                                                Hapus
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </td>
                            
                            <!-- Data Absen Mingguan -->
                            @foreach($weekDays as $day)
                            <td class="px-3 py-4 text-center">
                                <template x-for="attendance in employee.attendances" :key="attendance.id">
                                    <div x-show="attendance.tanggal === '{{ $day['date'] }}'">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium" 
                                              :class="getStatusClass(attendance.status_absensi)"
                                              x-text="getStatusText(attendance.status_absensi)">
                                        </span>
                                        <div x-show="attendance.waktu_masuk" class="text-xs text-gray-500 mt-1" x-text="attendance.waktu_masuk + (attendance.waktu_keluar ? ' - ' + attendance.waktu_keluar : '')"></div>
                                    </div>
                                </template>
                                <div x-show="!employee.attendances.some(att => att.tanggal === '{{ $day['date'] }}')" class="text-gray-300 text-xs">-</div>
                            </td>
                            @endforeach
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="filteredEmployees.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
        <p class="mt-1 text-sm text-gray-500">Tidak ada karyawan yang sesuai dengan filter yang dipilih.</p>
    </div>
</div>

<script>
function attendanceManager() {
    return {
        selectedDepartment: '',
        selectedDate: '{{ now()->format('Y-m-d') }}',
        searchQuery: '',
        loading: false,
        employees: [
            @foreach($employees as $employee)
            {
                id: {{ $employee->id }},
                nama_lengkap: '{{ $employee->nama_lengkap }}',
                email: '{{ $employee->email }}',
                department: {
                    id: {{ $employee->department->id }},
                    nama_departemen: '{{ $employee->department->nama_departemen }}'
                },
                attendances: [
                    @foreach($employee->attendances as $attendance)
                    {
                        id: {{ $attendance->id }},
                        tanggal: '{{ $attendance->tanggal }}',
                        waktu_masuk: '{{ $attendance->waktu_masuk }}',
                        waktu_keluar: '{{ $attendance->waktu_keluar }}',
                        status_absensi: '{{ $attendance->status_absensi }}'
                    },
                    @endforeach
                ]
            },
            @endforeach
        ],
        
        get filteredEmployees() {
            let filtered = this.employees;
            
            // Filter by department
            if (this.selectedDepartment) {
                filtered = filtered.filter(emp => emp.department.id == this.selectedDepartment);
            }
            
            // Filter by search query
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(emp => 
                    emp.nama_lengkap.toLowerCase().includes(query) ||
                    emp.email.toLowerCase().includes(query)
                );
            }
            
            // Sort by department name
            filtered.sort((a, b) => a.department.nama_departemen.localeCompare(b.department.nama_departemen));
            
            return filtered;
        },
        
        getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        },
        
        getTodayAttendance(employeeId) {
            const today = this.selectedDate;
            const employee = this.employees.find(emp => emp.id === employeeId);
            if (!employee) return null;
            
            return employee.attendances.find(att => att.tanggal === today) || null;
        },
        
        getStatusClass(status) {
            const classes = {
                'hadir': 'bg-green-100 text-green-800',
                'izin': 'bg-yellow-100 text-yellow-800',
                'sakit': 'bg-red-100 text-red-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },
        
        getStatusText(status) {
            const texts = {
                'hadir': 'Hadir',
                'izin': 'Izin',
                'sakit': 'Sakit'
            };
            return texts[status] || status;
        },
        
        async markAttendance(employeeId, status) {
            this.loading = true;
            
            try {
                const currentTime = new Date().toLocaleTimeString('id-ID', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                });

                const data = {
                    karyawan_id: employeeId,
                    tanggal: this.selectedDate,
                    status_absensi: status
                };

                if (status === 'hadir') {
                    data.waktu_masuk = currentTime;
                    // Set default waktu_keluar untuk hadir
                    data.waktu_keluar = '16:00';
                } else {
                    // Untuk izin/sakit, tidak ada waktu masuk/keluar
                    data.waktu_masuk = null;
                    data.waktu_keluar = null;
                }

                const response = await fetch('{{ route("attendances.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Refresh page to get updated data
                    location.reload();
                } else {
                    alert('Error: ' + (result.message || 'Gagal mencatat absensi'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error mencatat absensi');
            } finally {
                this.loading = false;
            }
        },
        
        async markExit(employeeId) {
            this.loading = true;
            
            try {
                const currentTime = new Date().toLocaleTimeString('id-ID', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: false 
                });

                const todayAttendance = this.getTodayAttendance(employeeId);
                
                if (!todayAttendance) {
                    alert('Tidak ada data absen masuk untuk hari ini');
                    return;
                }

                const response = await fetch(`/attendances/${todayAttendance.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        waktu_keluar: currentTime,
                        status_absensi: todayAttendance.status_absensi
                    })
                });
                
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error mencatat waktu keluar');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error mencatat waktu keluar');
            } finally {
                this.loading = false;
            }
        },
        
        async deleteAttendance(employeeId) {
            if (!confirm('Yakin ingin menghapus absensi hari ini?')) {
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(`/attendances/today/${employeeId}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (result.message || 'Gagal menghapus absensi'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error menghapus absensi');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection