<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center ml-4 my-4">    
            <div class="w-[4vw]">
                <img src="{{ asset('photo/dashboard.svg') }}" alt="">
            </div>
            <h2 class="anek-latin-semibold text-[4vw] leading-tight text-[#522b5b]">
                Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1b1b1b] overflow-hidden sm:rounded-2xl flex flex-col p-6">
                <div class="text-white anek-latin-thin text-[3vw]">
                    Halo brow,<span class="anek-latin-bold ml-2">{{ Auth::user()->name }}</span>
                </div>
                <div class="text-white anek-latin-thin text-[1.05vw] mt-1 text-justify">
                Selamat datang di dashboard eksklusif kami! Kami sudah lama menanti kehadiranmu di sini, seperti programer menunggu bug yang akhirnya terpecahkan. <span class="anek-latin-bold">Dashboard ini mungkin terlihat sederhana</span>—hanya ada grouped bar chart, line chart, dan edit profile—tapi jangan salah, <span class="anek-latin-bold"> kesederhanaan inilah yang membuat segalanya berjalan lancar, tanpa ribet! 😎 </span> Oh ya, kalau sampai bingung, (harusnya engga sih)... kemungkinan dashboard ini yang terlalu jenius buat dipahami, bukan kamu yang kurang cerdas. Jadi, yuk mulai eksplorasi! Karena di sini, data dan grafik adalah sahabat setia kita. Dan kalau bosan, ya tinggal edit profile biar fresh lagi!                </div>
            </div>
        </div>
    </div>

    <div class="tabel py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-2xl bg-[#522b5b]">
                <div class="p-6 text-gray-900">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ url('/dashboard') }}" class="mb-10">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="kendaraan" class="block text-md anek-latin-light text-white">Kendaraan</label>
                                <select id="kendaraan" name="kendaraan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['kendaraan'] as $item)
                                        <option value="{{ $item }}" {{ request('kendaraan') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="wilayah" class="block text-md anek-latin-light text-white">Wilayah</label>
                                <select id="wilayah" name="wilayah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['wilayah'] as $item)
                                        <option value="{{ $item }}" {{ request('wilayah') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-md anek-latin-light text-white">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['status'] as $item)
                                        <option value="{{ $item }}" {{ request('status') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="provinsi" class="block text-md anek-latin-light text-white">Provinsi</label>
                                <select id="provinsi" name="provinsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['provinsi'] as $item)
                                        <option value="{{ $item }}" {{ request('provinsi') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="tahun" class="block text-md anek-latin-light text-white">Tahun</label>
                                <select id="tahun" name="tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['tahun'] as $item)
                                        <option value="{{ $item }}" {{ request('tahun') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="mt-6 px-4 py-2 bg-[#E7B827] text-white rounded-md">Filter</button>
                        </div>
                    </form>

                    <!-- Tabel Data -->
                    <table class="min-w-full divide-y divide-gray-200 overflow-hidden rounded-xl shadow-lg">
                        <thead class="bg-gray-400 rounded-t-lg text-white anek-latin-extrabold">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Kendaraan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Wilayah
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Provinsi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Tahun
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                    Nilai
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300 rounded-b-lg">
                            @foreach($data as $item)
                            <tr class="hover:bg-[#FFF4D2] hover:scale-[1.02] hover:transition duration-100 ease-in-out hover:shadow-lg">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->Kendaraan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->Wilayah }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->Status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->Provinsi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->Tahun }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->Nilai }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <!-- Pagination Links -->
                    <div class="mt-4 bg-white p-3 rounded-xl">
                        {{ $data->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    $(document).ready(function() {
        let chart;

        // Fungsi untuk menangani perubahan filter
        function handleFilterChange() {
            $('#kendaraan, #wilayah, #tahun').on('change', function() {
                fetchChartData();
            });
        }

        // Inisialisasi filter dan ambil data chart awal
        handleFilterChange();
        fetchChartData(); // Initial fetch
    });
    </script>



</x-app-layout>
