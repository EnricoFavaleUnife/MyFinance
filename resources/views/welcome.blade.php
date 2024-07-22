<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/custom.css'])

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <header class="title">
        My Finance
    </header>

    <main>

        <div class="charts">
            <p class="card-title">Actual total: {{ end($amounts) }} $</p>

            <div class="separation-line"></div>

            <p class="card-title">Totals after each transaction</p>
            <canvas id="lineChart"></canvas>

            <p class="card-title">Totals day by day</p>
            <canvas id="barChart"></canvas>
        </div>

        <div class="right-column">
            <div class="add-transaction-form">
                <p class="card-title">Add transaction</p>
                <form action="{{ route('transactions.store') }}" method="POST">

                    @csrf

                    <input type="text" class="transaction-description" name="transaction-description" placeholder="Descrizione" request>

                    <input type="text" class="transaction-amount" name="transaction-amount" placeholder="Import" request>
                    <select class="transaction-type" name="transaction-type" id="transaction-type" request>
                        <option disabled selected value> Transaction type </option>
                        <option value="income">Income</option>
                        <option value="outcome">Outcome</option>
                    </select>

                    <button class="submit-transaction-button">Add transaction</button>
                </form>
            </div>

            <div class="transactions-history">
                <p class="card-title">Transactions history</p>

                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions->reverse()->take(6) as $transaction)
                        <tr>
                            <td class="description">{{ $transaction->description }}</td>
                            <td class="{{ $transaction->type == 'income' ? 'income' : 'outcome' }}">{{ $transaction->type == 'income' ? '+ ' . number_format($transaction->amount, 2) . ' $' : '- ' . number_format($transaction->amount, 2) . ' $' }}</td>
                            <td>{{ $transaction->date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        const dataLine = {
            labels: @json($labelsLineChart),
            datasets: [{
                label: 'Total Amount',
                data: @json($amounts),
                fill: false,
                borderColor: '#007bff',
                tension: 0.1
            }]
        };

        const configLine = {
            type: 'line',
            data: dataLine,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.dataset.label}: $${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Transaction id'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Amount'
                        }
                    }
                }
            }
        };

        // Inizializza il grafico Line
        const lineChart = new Chart(
            document.getElementById('lineChart'),
            configLine
        );

        const barData = {
            labels: @json($labelsBarChart),
            datasets: [{
                label: 'Daily Total',
                data: @json($totals),
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        };

        const barConfig = {
            type: 'bar',
            data: barData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false, // Rimuove completamente la legenda
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `Total: $${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Daily Total'
                        },
                        beginAtZero: true
                    }
                }
            }
        };

        // Inizializza il BarChart
        const barChart = new Chart(
            document.getElementById('barChart'),
            barConfig
        );
    </script>

</body>

</html>