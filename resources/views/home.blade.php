@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h2 class="mb-4">Chart Transaksi</h2>
        
        <canvas id="salesChart" width="400" height="150"></canvas>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            let ctx = document.getElementById('salesChart').getContext('2d');

            let salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Jumlah Transaksi',
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.1)',
                            data: [],
                            fill: true
                        },
                        {
                            label: 'Total Pendapatan (Rp)',
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 128, 0, 0.1)',
                            data: [],
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: { display: true, text: 'Tanggal' }
                        },
                        y: {
                            title: { display: true, text: 'Jumlah' }
                        }
                    }
                }
            });

            function updateChart() {
                $.ajax({
                    url: "{{ route('chart.data') }}",
                    method: 'GET',
                    success: function (response) {
                        let labels = [];
                        let jumlahTransaksi = [];
                        let totalPendapatan = [];

                        response.forEach(data => {
                            labels.push(data.date);
                            jumlahTransaksi.push(data.jumlah_transaksi);
                            totalPendapatan.push(data.total_pendapatan);
                        });

                        salesChart.data.labels = labels;
                        salesChart.data.datasets[0].data = jumlahTransaksi;
                        salesChart.data.datasets[1].data = totalPendapatan;
                        salesChart.update();
                    }
                });
            }

            updateChart(); // Load data pertama kali
            setInterval(updateChart, 5000); // Perbarui setiap 5 detik
        });
    </script>
@endsection
