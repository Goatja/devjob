<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Vacantes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .chart-container {
            margin: 30px auto;
            max-width: 800px;
            text-align: center;
        }
        .interpretation {
            margin-top: 10px;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Estadísticas de Vacantes Publicadas y Tomadas</h1>

    <!-- Gráfica de línea -->
    <div class="chart-container">
        <canvas id="lineChart" width="400" height="200"></canvas>
        <p class="interpretation">
            Esta gráfica de línea muestra la tendencia diaria de vacantes publicadas y tomadas a lo largo del mes actual. 
            Puedes observar picos o caídas en ciertos días específicos.
        </p>
    </div>

    <!-- Gráfica de barras -->
    <div class="chart-container">
        <canvas id="barChart" width="400" height="200"></canvas>
        <p class="interpretation">
            La gráfica de barras compara el número total de vacantes publicadas frente a las tomadas de forma más directa.
            Es útil para identificar rápidamente la proporción entre ambas.
        </p>
    </div>

    <!-- Gráfica de pastel -->
    <div class="chart-container">
        <canvas id="pieChart" width="400" height="200"></canvas>
        <p class="interpretation">
            La gráfica de pastel ilustra la distribución porcentual entre las vacantes publicadas y las tomadas, proporcionando una visión general rápida.
        </p>
    </div>

    <script>
        // Obtener datos desde el backend
        fetch('/estadisticas-vacantes')
            .then(response => response.json())
            .then(data => {
                // Variables de datos
                const labels = data.dias;
                const publicadas = data.publicadas;
                const tomadas = data.tomadas;

                // Sumar totales para gráficas globales
                const totalPublicadas = publicadas.reduce((a, b) => a + b, 0);
                const totalTomadas = tomadas.reduce((a, b) => a + b, 0);

                // Gráfica de Línea
                const ctxLine = document.getElementById('lineChart').getContext('2d');
                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Vacantes Publicadas',
                                data: publicadas,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderWidth: 2,
                                fill: true,
                            },
                            {
                                label: 'Vacantes Tomadas',
                                data: tomadas,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2,
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Días del Mes'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Cantidad de Vacantes'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Gráfica de Barras
                const ctxBar = document.getElementById('barChart').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Vacantes Publicadas',
                                data: publicadas,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Vacantes Tomadas',
                                data: tomadas,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Días del Mes'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Cantidad de Vacantes'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Gráfica de Pastel
                const ctxPie = document.getElementById('pieChart').getContext('2d');
                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: ['Vacantes Publicadas', 'Vacantes Tomadas'],
                        datasets: [
                            {
                                data: [totalPublicadas, totalTomadas],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.5)',
                                    'rgba(255, 99, 132, 0.5)',
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)',
                                ],
                                borderWidth: 1,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    }
                });
            });
    </script>
</body>
</html>
