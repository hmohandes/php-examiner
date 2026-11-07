<x-card title="Score Distribution">

    <div
        wire:ignore
        style="height:400px;"
    >
        <canvas id="scoreDistributionChart"></canvas>
    </div>

</x-card>

@script
<script>

document.addEventListener('livewire:navigated', initializeChart);
document.addEventListener('livewire:initialized', initializeChart);

let chart = null;

function initializeChart() {

    const canvas = document.getElementById('scoreDistributionChart');

    if (!canvas) {
        return;
    }

    if (chart) {
        chart.destroy();
    }

    chart = new Chart(canvas, {

        type: 'bar',

        data: {

            labels: @json($labels),

            datasets: [{

                label: 'Students',

                data: @json($scores),

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    callbacks: {

                        label(context) {
                            return context.raw + ' students';
                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    title: {

                        display: true,

                        text: 'Students'

                    }

                },

                x: {

                    title: {

                        display: true,

                        text: 'Score (%)'

                    }

                }

            }

        }

    });

}

</script>
@endscript