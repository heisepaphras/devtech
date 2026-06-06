@extends('layouts.app')

@section('content')
<section class="page-shell py-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <span class="kicker">Dashboard</span>
            <h1 class="display-6 fw-bold text-white mt-2 mb-0">Website Analytics</h1>
        </div>
        <div class="d-flex gap-2 bg-dark-subtle p-1.5 rounded-3 border border-warning-subtle">
            <a href="{{ route('admin.analytics.index', ['range' => 'today']) }}" class="btn btn-sm {{ $currentRange === 'today' ? 'btn-brand' : 'btn-outline-light border-0 text-white' }}">Today</a>
            <a href="{{ route('admin.analytics.index', ['range' => '7days']) }}" class="btn btn-sm {{ $currentRange === '7days' ? 'btn-brand' : 'btn-outline-light border-0 text-white' }}">Last 7 Days</a>
            <a href="{{ route('admin.analytics.index', ['range' => '30days']) }}" class="btn btn-sm {{ $currentRange === '30days' ? 'btn-brand' : 'btn-outline-light border-0 text-white' }}">Last 30 Days</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Stats Cards Row -->
        <div class="row g-4 mb-5" data-stagger>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm module-item h-100 reveal">
                    <div class="card-body p-4">
                        <span class="small text-uppercase fw-bold text-secondary">Page Views</span>
                        <h2 class="display-6 fw-extrabold text-brand mt-2 mb-1">{{ number_format($overview['total_views']) }}</h2>
                        <span class="small text-secondary"><i class="fa-solid fa-eye me-1 text-warning"></i>Total hits logged</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm module-item h-100 reveal">
                    <div class="card-body p-4">
                        <span class="small text-uppercase fw-bold text-secondary">Unique Visitors</span>
                        <h2 class="display-6 fw-extrabold text-brand mt-2 mb-1">{{ number_format($overview['unique_visitors']) }}</h2>
                        <span class="small text-secondary"><i class="fa-solid fa-users me-1 text-warning"></i>Unique sessions</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm module-item h-100 reveal">
                    <div class="card-body p-4">
                        <span class="small text-uppercase fw-bold text-secondary">Pages / Session</span>
                        <h2 class="display-6 fw-extrabold text-brand mt-2 mb-1">{{ $overview['avg_views_per_session'] }}</h2>
                        <span class="small text-secondary"><i class="fa-solid fa-arrow-trend-up me-1 text-warning"></i>Average depth</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm module-item h-100 reveal">
                    <div class="card-body p-4">
                        <span class="small text-uppercase fw-bold text-secondary">Bounce Rate</span>
                        <h2 class="display-6 fw-extrabold text-brand mt-2 mb-1">{{ $overview['bounce_rate'] }}%</h2>
                        <span class="small text-secondary"><i class="fa-solid fa-arrow-right-to-bracket me-1 text-warning"></i>Single-page visits</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trend Chart Section -->
        <div class="card border-0 shadow-sm mb-5 module-item">
            <div class="card-body p-4">
                <h3 class="h5 text-brand fw-bold mb-4"><i class="fa-solid fa-chart-line me-2 text-warning"></i>Traffic Trend</h3>
                <div id="trendChart" style="min-height: 350px;"></div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Top Pages -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100 module-item">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand fw-bold mb-4"><i class="fa-solid fa-file-lines me-2 text-warning"></i>Popular Pages</h3>
                        @if (empty($topPages))
                            <p class="text-secondary text-center my-5">No page activity recorded in this period.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle table-hover">
                                    <thead>
                                        <tr class="text-secondary small">
                                            <th>Page URL</th>
                                            <th class="text-end">Views</th>
                                            <th class="text-end">Unique Visitors</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topPages as $page)
                                            <tr>
                                                <td class="font-monospace text-break">{{ $page['url'] }}</td>
                                                <td class="text-end fw-bold text-brand">{{ number_format($page['views']) }}</td>
                                                <td class="text-end text-secondary">{{ number_format($page['visitors']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Referrers -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100 module-item">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand fw-bold mb-4"><i class="fa-solid fa-share-nodes me-2 text-warning"></i>Top Traffic Sources</h3>
                        @if (empty($topReferrers))
                            <p class="text-secondary text-center my-5">No referrer metrics logged.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle table-hover">
                                    <thead>
                                        <tr class="text-secondary small">
                                            <th>Referrer Source</th>
                                            <th class="text-end">Sessions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topReferrers as $ref)
                                            <tr>
                                                <td class="fw-semibold text-brand">
                                                    @if ($ref['referrer_domain'] === 'Direct / None')
                                                        <span class="text-muted"><i class="fa-solid fa-globe me-2"></i>Direct / None</span>
                                                    @else
                                                        <span><i class="fa-solid fa-arrow-up-right-from-square me-2 text-warning"></i>{{ $ref['referrer_domain'] }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-end fw-bold text-brand">{{ number_format($ref['count']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Countries -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 module-item">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand fw-bold mb-4"><i class="fa-solid fa-earth-africa me-2 text-warning"></i>Top Locations</h3>
                        @if (empty($topCountries))
                            <p class="text-secondary text-center my-5">No location data captured.</p>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @php
                                    $maxViews = collect($topCountries)->max('views') ?: 1;
                                @endphp
                                @foreach ($topCountries as $c)
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-semibold text-brand"><i class="fa-solid fa-map-pin me-2 text-warning"></i>{{ $c['country'] }}</span>
                                            <span class="small text-secondary">{{ number_format($c['views']) }} views</span>
                                        </div>
                                        <div class="progress" style="height: 6px; background-color: rgba(23, 57, 122, 0.08);">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($c['views'] / $maxViews) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Devices breakdown -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 module-item">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand fw-bold mb-4"><i class="fa-solid fa-laptop-code me-2 text-warning"></i>Device Split</h3>
                        @if (empty($deviceBreakdown))
                            <p class="text-secondary text-center my-5">No device logs available.</p>
                        @else
                            <div class="d-flex flex-column gap-3 pt-2">
                                @php
                                    $totalDevices = array_sum($deviceBreakdown) ?: 1;
                                @endphp
                                @foreach ($deviceBreakdown as $device => $count)
                                    @php
                                        $percentage = round(($count / $totalDevices) * 100);
                                        $icon = match($device) {
                                            'Mobile' => 'fa-mobile-button',
                                            'Tablet' => 'fa-tablet-screen-button',
                                            default => 'fa-desktop'
                                        };
                                    @endphp
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-semibold text-brand"><i class="fa-solid {{ $icon }} me-2 text-warning"></i>{{ $device }}</span>
                                            <span class="small text-secondary">{{ $percentage }}% ({{ number_format($count) }})</span>
                                        </div>
                                        <div class="progress" style="height: 6px; background-color: rgba(23, 57, 122, 0.08);">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Browsers breakdown -->
            <div class="col-md-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100 module-item">
                    <div class="card-body p-4">
                        <h3 class="h5 text-brand fw-bold mb-4"><i class="fa-solid fa-compass me-2 text-warning"></i>Web Browsers</h3>
                        @if (empty($browserBreakdown))
                            <p class="text-secondary text-center my-5">No browser statistics recorded.</p>
                        @else
                            <div class="d-flex flex-column gap-3 pt-2">
                                @php
                                    $totalBrowsers = array_sum($browserBreakdown) ?: 1;
                                @endphp
                                @foreach ($browserBreakdown as $browser => $count)
                                    @php
                                        $percentage = round(($count / $totalBrowsers) * 100);
                                        $icon = match($browser) {
                                            'Chrome' => 'fa-chrome',
                                            'Safari' => 'fa-safari',
                                            'Firefox' => 'fa-firefox',
                                            'Edge' => 'fa-edge',
                                            default => 'fa-window-maximize'
                                        };
                                        $brand = $icon === 'fa-window-maximize' ? 'fa-regular' : 'fa-brands';
                                    @endphp
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-semibold text-brand"><i class="{{ $brand }} {{ $icon }} me-2 text-warning"></i>{{ $browser }}</span>
                                            <span class="small text-secondary">{{ $percentage }}% ({{ number_format($count) }})</span>
                                        </div>
                                        <div class="progress" style="height: 6px; background-color: rgba(23, 57, 122, 0.08);">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ApexCharts scripts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trendData = @json($dailyTrend);
        
        const dates = trendData.map(item => item.date);
        const views = trendData.map(item => item.views);
        const visitors = trendData.map(item => item.visitors);

        const options = {
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
                fontFamily: 'Manrope, system-ui, sans-serif'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#d8a43a', '#17397a'],
            series: [{
                name: 'Page Views',
                data: views
            }, {
                name: 'Unique Visitors',
                data: visitors
            }],
            xaxis: {
                categories: dates,
                labels: {
                    style: {
                        colors: '#706f6c'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#706f6c'
                    }
                }
            },
            tooltip: {
                theme: 'light',
                x: {
                    format: 'dd MMM'
                }
            },
            grid: {
                borderColor: '#e8d5ab',
                strokeDashArray: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            }
        };

        const chart = new ApexCharts(document.querySelector("#trendChart"), options);
        chart.render();
    });
</script>
@endsection
