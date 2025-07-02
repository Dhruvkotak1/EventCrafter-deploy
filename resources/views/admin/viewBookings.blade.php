@extends('components.adminLayout')

@section('content')
<div class="p-4 space-y-10">

    {{-- UPCOMING EVENTS SECTION --}}
    <section x-data="{ showCharts: true, showTable: true }">
        <div class="flex flex-wrap items-center justify-between mb-2">
            <h2 class="text-2xl font-bold">🚀 Upcoming Events - Booking Analytics</h2>
            
        </div>
        <div class="text-sm text-base-content/70 mb-4">Charts show percentage of booked and unbooked tickets. Sorted by booking %.</div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 place-items-center" x-show="showCharts">
            @foreach ($upcomingChartData as $index => $data)
                <div class="flex flex-col justify-center items-center bg-base-200 p-3 rounded-xl shadow text-center max-w-[240px] w-full">
                    <h2 class="text-sm font-semibold mb-2 truncate">{{ $data['event'] }}</h2>
                    <canvas id="upcomingChart{{ $index }}" width="160" height="160"></canvas>
                </div>
            @endforeach
        </div>

        {{-- TABLE --}}
        <div class="mt-6 overflow-x-auto" x-show="showTable">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Booked</th>
                        <th>Total</th>
                        <th>Remaining</th>
                        <th>Booking %</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($upcomingChartData as $data)
                        <tr>
                            <td>{{ $data['event'] }}</td>
                            <td>{{ $data['date'] }}</td>
                            <td>{{ $data['booked'] }}</td>
                            <td>{{ $data['total'] }}</td>
                            <td>{{ $data['not_booked'] }}</td>
                            <td>{{ $data['percent'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- PAST EVENTS SECTION --}}
    <section x-data="{ showCharts: true, showTable: true }">
        <div class="flex flex-wrap items-center justify-between mb-2">
            <h2 class="text-2xl font-bold">📅 Past Events - Booking Analytics</h2>
            
        </div>
        <div class="text-sm text-base-content/70 mb-4">Recently completed events sorted by booking percentage.</div>

        {{-- CHARTS --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 place-items-center" x-show="showCharts">
            @foreach ($pastChartData as $index => $data)
                <div class="flex flex-col justify-center items-center bg-base-200 p-3 rounded-xl shadow text-center max-w-[240px] w-full">
                    <h2 class="text-sm font-semibold mb-2 truncate">{{ $data['event'] }}</h2>
                    <canvas id="pastChart{{ $index }}" width="160" height="160" ></canvas>
                </div>
            @endforeach
        </div>

        {{-- TABLE --}}
        <div class="mt-6 overflow-x-auto" x-show="showTable">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Booked</th>
                        <th>Total</th>
                        <th>Unbooked</th>
                        <th>Booking %</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pastChartData as $data)
                        <tr>
                            <td>{{ $data['event'] }}</td>
                            <td>{{ $data['date'] }}</td>
                            <td>{{ $data['booked'] }}</td>
                            <td>{{ $data['total'] }}</td>
                            <td>{{ $data['not_booked'] }}</td>
                            <td>{{ $data['percent'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const upcomingData = {!! json_encode($upcomingChartData) !!};
    const pastData = {!! json_encode($pastChartData) !!};

    const renderChart = (id, data) => {
        const ctx = document.getElementById(id);
        const total = data.booked + data.not_booked;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Booked', 'Unbooked'],
                datasets: [{
                    data: [data.booked, data.not_booked],
                    backgroundColor: [
                        getComputedStyle(document.documentElement).getPropertyValue('--su').trim() || '#22c55e',
                        getComputedStyle(document.documentElement).getPropertyValue('--er').trim() || '#ef4444'
                    ],
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const percent = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    upcomingData.forEach((data, i) => renderChart(`upcomingChart${i}`, data));
    pastData.forEach((data, i) => renderChart(`pastChart${i}`, data));
</script>
@endsection
