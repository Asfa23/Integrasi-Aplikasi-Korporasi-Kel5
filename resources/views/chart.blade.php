<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center ml-4 my-4">    
            <div class="w-[4vw]">
                <img src="{{ asset('photo/bar_chart.svg') }}" alt="">
            </div>
            <h2 class="anek-latin-semibold text-[4vw] leading-tight text-[#522b5b]">
                Bar Chart View
            </h2>
        </div>
    </x-slot>

    <h2 id="chart-title" class="flex justify-center items-center text-center anek-latin-bold text-[1.5vw] leading-tight text-white bg-[#522b5b] mx-[3vw] p-2 rounded-[1vw] py-5 px-[2vw]">
        Jumlah Penumpang Kapal dan Pesawat Domestik serta Internasional pada Tahun 2019-2023
    </h2>


    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border-[#88369B]">
                <div class="p-6 text-gray-900">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ url('/chart') }}" class="mb-4">
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
                                <label for="tahun" class="block text-md anek-latin-light text-[#1b1b1b]">Tahun</label>
                                <select id="tahun" name="tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All</option>
                                    @foreach($filters['tahun'] as $item)
                                        <option value="{{ $item }}" {{ request('tahun') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="mt-6 px-4 py-2 bg-[#e7b827] text-white rounded-md">Filter</button>
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

            function updateTitle() {
                const kendaraan = $('#kendaraan').val();
                const wilayah = $('#wilayah').val();
                const tahun = $('#tahun').val();

                let title = 'Jumlah Penumpang ';
                
                if (kendaraan) {
                    title += kendaraan;
                } else {
                    title += 'Kapal dan Pesawat';
                }

                if (wilayah) {
                    title += ' ' + wilayah;
                } else {
                    title += ' Domestik serta Internasional';
                }

                if (tahun) {
                    title += ' pada Tahun ' + tahun;
                } else {
                    title += ' pada Tahun 2019-2023';
                }

                $('#chart-title').text(title);
            }

            function fetchChartData() {
                const kendaraan = $('#kendaraan').val();
                const wilayah = $('#wilayah').val();
                const tahun = $('#tahun').val();

                $.ajax({
                    url: '{{ route("chart.data") }}',
                    method: 'GET',
                    data: {
                        kendaraan: kendaraan,
                        wilayah: wilayah,
                        tahun: tahun
                    },
                    success: function(response) {
                        updateChart(response);
                        updateTitle(); // Update title after fetching data
                    }
                });
            }

            function updateChart(data) {
                const ctx = document.getElementById('chart').getContext('2d');

                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: 'bar', // Keep it as 'bar' for vertical grouped bars
                    data: {
                        labels: data.provinces,
                        datasets: [
                            {
                                label: 'Datang',
                                data: data.datang,
                                backgroundColor: '#4e73df', // Warna solid untuk Datang
                                borderColor: '#4e73df', // Warna border yang sama
                                borderWidth: 1
                            },
                            {
                                label: 'Berangkat',
                                data: data.berangkat,
                                backgroundColor: '#1cc88a', // Warna solid untuk Berangkat
                                borderColor: '#1cc88a', // Warna border yang sama
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: '#1b1b1b' // Mengubah warna teks legenda menjadi putih
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                    }
                                },
                                bodyColor: '#FFFFFF',
                                titleColor: '#FFFFFF'
                            }
                        },
                        scales: {
                            x: {
                                stacked: false, // Set to false for grouped bars
                                ticks: {
                                    color: '#1b1b1b'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)',
                                    drawBorder: false
                                }
                            },
                            y: {
                                stacked: false,
                                beginAtZero: true,
                                ticks: {
                                    color: '#1b1b1b'
                                },
                                grid: {
                                    color: '#D0D0D0',
                                    drawBorder: false
                                }
                            }
                        },
                        elements: {
                            bar: {
                                borderSkipped: 'bottom'
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 10,
                                bottom: 0
                            }
                        }
                    }
                });
            }

            function handleFilterChange() {
                $('#kendaraan, #wilayah, #tahun').on('change', function() {
                    fetchChartData();
                    updateTitle();
                });
            }

            handleFilterChange();
            fetchChartData(); // Initial fetch
        });
        </script>
    </div>
</x-app-layout>
