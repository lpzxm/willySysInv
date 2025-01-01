<style>
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: #0d6efd;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
    }

    .chart-container {
        height: 300px;
    }
</style>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container py-5">
    <h1 class="text-center mb-4">Estadísticas del Sistema</h1>

    <!-- Cards de Estadísticas -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-header">Total de Productos</div>
                <div class="card-body">
                    <i class="fas fa-boxes stat-icon"></i>
                    <p class="stat-number">1,234</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-header">Inversión Total</div>
                <div class="card-body">
                    <i class="fas fa-dollar-sign stat-icon"></i>
                    <p class="stat-number">$45,678.90</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-header">Entradas del Mes</div>
                <div class="card-body">
                    <i class="fas fa-arrow-down stat-icon"></i>
                    <p class="stat-number">567</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="card-header">Salidas del Mes</div>
                <div class="card-body">
                    <i class="fas fa-arrow-up stat-icon"></i>
                    <p class="stat-number">321</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica -->
    <div class="mt-5">
        <h2 class="text-center">Resumen Mensual</h2>
        <div class="card">
            <div class="card-body">
                <canvas id="monthlyChart" class="chart-container"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Configuración de la gráfica
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                    label: 'Entradas',
                    data: [500, 700, 800, 600, 900, 750],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Salidas',
                    data: [300, 400, 500, 350, 450, 400],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Entradas vs. Salidas'
                }
            }
        }
    });
</script>