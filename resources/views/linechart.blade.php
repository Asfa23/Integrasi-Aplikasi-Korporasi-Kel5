<!-- linechart.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center ml-4 my-4">    
            <div class="w-[6vw]">
                <img src="{{ asset('photo/line_chart.svg') }}" alt="">
            </div>
            <h2 class="anek-latin-semibold text-[4vw] leading-tight text-[#522b5b]">
                Bar Chart View
            </h2>
        </div>
    </x-slot>

    <h2 id="dynamic-title" class="flex justify-center items-center text-center anek-latin-bold text-[1.5vw] leading-tight text-white bg-[#522b5b] mx-[3vw] p-2 rounded-[1vw] py-5 px-[2vw]">
        Jumlah Penumpang Kapal dan Pesawat Domestik serta Internasional di Semua Provinsi pada Tahun 2019-2023
    </h2>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 text-gray-900">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ url('/linechart') }}" class="mb-4">
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label for="kendaraan" class="block text-md anek-latin-light text-[#1b1b1b]">Kendaraan</label>
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
                                <label for="wilayah" class="block text-md anek-latin-light text-[#1b1b1b]">Wilayah</label>
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
                                <label for="provinsi" class="block text-md anek-latin-light text-[#1b1b1b]">Provinsi</label>
                                <select id="provinsi" name="provinsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['provinsi'] as $item)
                                        <option value="{{ $item }}" {{ request('provinsi') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="mt-6 px-4 py-2 bg-[#e7b827] text-white rounded-md bg-[#e7b827]">Filter</button>
                        </div>

                    </form>

                    <!-- Chart Container -->
                    <div class="relative">
                        <canvas id="chart"></canvas>
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

            // Function to update the chart title dynamically
            // Function to update the chart title dynamically
        function updateTitle() {
            const kendaraan = $('#kendaraan').val();
            const wilayah = $('#wilayah').val();
            const provinsi = $('#provinsi').val();

            let title = 'Jumlah Penumpang ';

            // Set kendaraan name
            if (kendaraan) {
                title += kendaraan;
            } else {
                title += 'Kapal dan Pesawat';
            }

            // Set wilayah name
            if (wilayah) {
                title += ' ' + wilayah;
            } else {
                title += ' Domestik serta Internasional';
            }

            // Kondisi khusus: Pesawat Internasional hanya ada pada 2022-2023
            if (kendaraan === 'Pesawat' && wilayah === 'Internasional') {
                title += ' di Semua Provinsi pada Tahun 2022-2023';
            } else {
                // Untuk semua kasus lainnya
                title += ' di Semua Provinsi pada Tahun 2019-2023';
            }

            $('#dynamic-title').text(title);
        }

        // Function to fetch chart data
        function fetchChartData() {
            const kendaraan = $('#kendaraan').val();
            const wilayah = $('#wilayah').val();
            const provinsi = $('#provinsi').val();

            $.ajax({
                url: '{{ route("linechart.data") }}',
                method: 'GET',
                data: {
                    kendaraan: kendaraan,
                    wilayah: wilayah,
                    provinsi: provinsi
                },
                success: function(response) {
                    updateChart(response);
                    updateTitle();  // Update the title whenever data is fetched
                }
            });
        }


            // Function to update the chart with fetched data
            function updateChart(data) {
                const ctx = document.getElementById('chart').getContext('2d');

                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.years,
                        datasets: [
                            {
                                label: 'Datang',
                                data: data.datang,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Berangkat',
                                data: data.berangkat,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tahun'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Nilai'
                                }
                            }
                        }
                    }
                });
            }

            // Handle filter changes
            function handleFilterChange() {
                $('#kendaraan, #wilayah, #provinsi').on('change', function() {
                    fetchChartData();
                    updateTitle();  // Call title update when filters change
                });
            }

            // Initial load
            handleFilterChange();
            fetchChartData(); // Initial fetch
            updateTitle(); // Set initial title
        });
        </script>
    </div>
</x-app-layout>
