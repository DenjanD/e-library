<!DOCTYPE html>
<html lang="en">

@include('admin/template')

@yield('head')

<body class="sb-nav-fixed">
    @yield('navbar')

    <div id="layoutSidenav">
        @yield('sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>

                    <div class="row mt-5">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Kategori buku terbanyak dipinjam
                                </div>
                                <div class="card-body"><canvas id="tranChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area mr-1"></i>
                                    Jumlah peminjaman buku per bulan
                                </div>
                                <div class="card-body"><canvas id="bookChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            @yield('footer')
        </div>
    </div>
    @yield('scripts')
    <script>
        var label1 = [];
        var value1 = [];
        var value2 = [];

        $.ajax({
            type: "GET",
            url: "{{ url('admin/katbchart') }}",
            dataType: "json",
            success: function(response) {
                var i = 0;
                var j = 0;
                response.labelKat.forEach(function(item) {
                    this.label1[i] = item.label;
                    i++;
                });
                response.valueKat.forEach(function(item) {
                    this.value1[j] = item.value;
                    j++;
                });
                generateChart1();
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ url('admin/transchart') }}",
            dataType: "json",
            success: function(response) {
                var i = 0;
                response.valueTrans.forEach(function(item) {
                    this.value2[i] = item.value;
                    i++;
                });
                generateChart2();
            }
        });

        function generateChart1() {
            // Bar Chart
            var ctx2 = document.getElementById("tranChart");
            var myLineChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: this.label1,
                    datasets: [{
                        label: "Angka",
                        backgroundColor: "rgba(2,117,216,1)",
                        borderColor: "rgba(2,117,216,1)",
                        data: this.value1,
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'month'
                            },
                            gridLines: {
                                display: false
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }

        function generateChart2() {
            // Area Chart
            var ctx = document.getElementById("bookChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Marcj", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
                    datasets: [{
                        label: "Pinjaman",
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                        data: this.value2,
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)",
                            }
                        }],
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }
    </script>
</body>

</html>