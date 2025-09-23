@extends('layouts.admin.base')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed" id="contentContainer">
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Dashboard Analytics
                </h1>
                <p class="text-sm text-gray-600">Overview statistik sistem dan aktivitas</p>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        @permission('dashboard-access')
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-7.5">
                <div class="kt-card p-5">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                            <i class="ki-filled ki-people text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Users</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['total_users']) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="kt-card p-5">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                            <i class="ki-filled ki-document text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Articles</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['total_articles']) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="kt-card p-5">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                            <i class="ki-filled ki-eye text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Views</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['total_views']) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="kt-card p-5">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg">
                            <i class="ki-filled ki-bookmark text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Published Articles</p>
                            <h3 class="text-2xl font-bold">{{ number_format($data['stats']['published_articles']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-7.5">
                <!-- Articles by Status -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Articles by Status</h3>
                    <div id="articles-status-chart" style="height: 300px;"></div>
                </div>

                <!-- Articles by Category -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Top Categories</h3>
                    <div id="articles-category-chart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Trends Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-7.5">
                <!-- User Registration Trend -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">User Registration Trend</h3>
                    <div id="user-trend-chart" style="height: 300px;"></div>
                </div>

                <!-- Article Publishing Trend -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Article Publishing Trend</h3>
                    <div id="article-trend-chart" style="height: 300px;"></div>
                </div>
            </div>

            <!-- Data Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-7.5">
                <!-- Top Authors -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Top Authors</h3>
                    <div class="space-y-3">
                        @foreach ($data['top_authors'] as $author)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        {{ substr($author['name'], 0, 1) }}
                                    </div>
                                    <span class="font-medium">{{ $author['name'] }}</span>
                                </div>
                                <span class="kt-badge kt-badge-primary">{{ $author['count'] }} articles</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Most Viewed Articles -->
                <div class="kt-card p-5">
                    <h3 class="text-lg font-semibold mb-4">Most Viewed Articles</h3>
                    <div class="space-y-3">
                        @foreach ($data['most_viewed_articles'] as $article)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-sm line-clamp-2 mb-2">{{ $article['title'] }}</h4>
                                <div class="flex items-center justify-between text-xs text-gray-600">
                                    <span>by {{ $article['author'] }}</span>
                                    <span class="kt-badge kt-badge-info">{{ number_format($article['views']) }} views</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Views Distribution -->
            <div class="kt-card p-5 mb-7.5">
                <h3 class="text-lg font-semibold mb-4">Articles Views Distribution</h3>
                <div id="views-distribution-chart" style="height: 300px;"></div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Articles by Status Donut Chart
                    const statusChart = new ApexCharts(document.querySelector("#articles-status-chart"), {
                        series: [{{ $data['articles_by_status']['published'] }},
                            {{ $data['articles_by_status']['draft'] }}
                        ],
                        chart: {
                            type: 'donut',
                            height: 300,
                            fontFamily: 'Inter, sans-serif'
                        },
                        labels: ['Published', 'Draft'],
                        colors: ['#10B981', '#F59E0B'],
                        legend: {
                            position: 'bottom'
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%'
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return Math.round(val) + "%"
                            }
                        }
                    });
                    statusChart.render();

                    // Articles by Category Bar Chart
                    const categoryChart = new ApexCharts(document.querySelector("#articles-category-chart"), {
                        series: [{
                            name: 'Articles',
                            data: {!! $data['articles_by_category']->pluck('count')->toJson() !!}
                        }],
                        chart: {
                            type: 'bar',
                            height: 300,
                            fontFamily: 'Inter, sans-serif'
                        },
                        colors: ['#3B82F6'],
                        xaxis: {
                            categories: {!! $data['articles_by_category']->pluck('name')->toJson() !!}
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '70%',
                                borderRadius: 4
                            }
                        },
                        dataLabels: {
                            enabled: false
                        }
                    });
                    categoryChart.render();

                    // User Registration Trend Line Chart
                    const userTrendChart = new ApexCharts(document.querySelector("#user-trend-chart"), {
                        series: [{
                            name: 'New Users',
                            data: {!! $data['user_registration_trend']->pluck('count')->toJson() !!}
                        }],
                        chart: {
                            type: 'line',
                            height: 300,
                            fontFamily: 'Inter, sans-serif',
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#8B5CF6'],
                        stroke: {
                            width: 3,
                            curve: 'smooth'
                        },
                        xaxis: {
                            categories: {!! $data['user_registration_trend']->pluck('month')->toJson() !!}
                        },
                        markers: {
                            size: 6,
                            hover: {
                                size: 8
                            }
                        },
                        grid: {
                            borderColor: '#e7e7e7'
                        }
                    });
                    userTrendChart.render();

                    // Article Publishing Trend Area Chart
                    const articleTrendChart = new ApexCharts(document.querySelector("#article-trend-chart"), {
                        series: [{
                            name: 'Articles Published',
                            data: {!! $data['article_publishing_trend']->pluck('count')->toJson() !!}
                        }],
                        chart: {
                            type: 'area',
                            height: 300,
                            fontFamily: 'Inter, sans-serif',
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#06B6D4'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.7,
                                opacityTo: 0.1,
                            }
                        },
                        stroke: {
                            width: 2,
                            curve: 'smooth'
                        },
                        xaxis: {
                            categories: {!! $data['article_publishing_trend']->pluck('month')->toJson() !!}
                        },
                        grid: {
                            borderColor: '#e7e7e7'
                        }
                    });
                    articleTrendChart.render();

                    // Views Distribution Radial Bar Chart
                    const viewsDistributionChart = new ApexCharts(document.querySelector("#views-distribution-chart"), {
                        series: [
                            {{ round(($data['views_distribution']['low'] / max($data['stats']['total_articles'], 1)) * 100) }},
                            {{ round(($data['views_distribution']['medium'] / max($data['stats']['total_articles'], 1)) * 100) }},
                            {{ round(($data['views_distribution']['high'] / max($data['stats']['total_articles'], 1)) * 100) }}
                        ],
                        chart: {
                            type: 'radialBar',
                            height: 300,
                            fontFamily: 'Inter, sans-serif'
                        },
                        colors: ['#EF4444', '#F59E0B', '#10B981'],
                        labels: ['Low Views (<100)', 'Medium Views (100-1K)', 'High Views (>1K)'],
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '12px',
                                    },
                                    value: {
                                        fontSize: '14px',
                                        formatter: function(val) {
                                            return val + "%"
                                        }
                                    }
                                }
                            }
                        },
                        legend: {
                            show: true,
                            position: 'bottom'
                        }
                    });
                    viewsDistributionChart.render();
                });
            </script>
        @else
            <div>
                <!-- Personal Comment Analytics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-7.5">
                    <div class="kt-card p-5">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg">
                                <i class="ki-filled ki-message text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Comments</p>
                                <h3 class="text-2xl font-bold">{{ $data['comments']->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="kt-card p-5">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                                <i class="ki-filled ki-document text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Unique Articles</p>
                                <h3 class="text-2xl font-bold">{{ $data['comments']->pluck('article_id')->unique()->count() }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="kt-card p-5">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg">
                                <i class="ki-filled ki-calendar text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Last Comment</p>
                                <h3 class="text-2xl font-bold">
                                    {{ optional($data['comments']->first())->created_at ? $data['comments']->first()->created_at->diffForHumans() : '-' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="kt-card p-5">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg">
                                <i class="ki-filled ki-clock text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">First Comment</p>
                                <h3 class="text-2xl font-bold">
                                    {{ optional($data['comments']->last())->created_at ? $data['comments']->last()->created_at->diffForHumans() : '-' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart: Comments per Month -->
                <div class="kt-card p-5 mb-7.5">
                    <h3 class="text-lg font-semibold mb-4">Comments per Month</h3>
                    <div id="comments-per-month-chart" style="height: 300px;"></div>
                </div>

                <!-- Recent Comments Table -->
                <div class="kt-card p-5 mb-7.5">
                    <h3 class="text-lg font-semibold mb-4">Recent Comments</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Article</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($data['comments']->take(10) as $comment)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-800">
                                            {{ optional($comment->article)->title ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($comment->content, 50) }}
                                        </td>
                                        <td class="px-4 py-2 text-xs text-gray-400">
                                            {{ $comment->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Chart: Comments per Month
                        const comments = @json($data['comments']);
                        // Group comments by month
                        const monthMap = {};
                        comments.forEach(c => {
                            const d = new Date(c.created_at);
                            const key = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0');
                            monthMap[key] = (monthMap[key] || 0) + 1;
                        });
                        const months = Object.keys(monthMap).sort();
                        const counts = months.map(m => monthMap[m]);
                        const monthLabels = months.map(m => {
                            const [y, mo] = m.split('-');
                            return new Date(y, mo - 1).toLocaleString('default', {
                                month: 'short',
                                year: 'numeric'
                            });
                        });
                        const chart = new ApexCharts(document.querySelector("#comments-per-month-chart"), {
                            series: [{
                                name: 'Comments',
                                data: counts
                            }],
                            chart: {
                                type: 'bar',
                                height: 300,
                                fontFamily: 'Inter, sans-serif'
                            },
                            colors: ['#FF6B6B'],
                            xaxis: {
                                categories: monthLabels
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '70%',
                                    borderRadius: 4
                                }
                            },
                            dataLabels: {
                                enabled: false
                            }
                        });
                        chart.render();
                    });
                </script>
            </div>
        @endpermission
    </div>
    <!-- End of Container -->
@endsection
