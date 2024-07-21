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
</head>

<body>
    <header class="title">
        My Finance
    </header>

    <main>

        <div class="chart">
        </div>

        <div class="right-column">
            <div class="add-transaction-form">
                <p class="card-title">Add transaction</p>
                <form action="">
                    <input type="text" class="transaction-description" name="transaction-description" placeholder="Descrizione">

                    <input type="number" class="transaction-amount" name="transaction-amount" placeholder="Import">
                    <select class="transaction-type" name="transaction-type" id="transaction-type">
                        <option disabled selected value> Transaction type </option>
                        <option value="income">Income</option>
                        <option value="outcome">Outcome</option>
                    </select>

                    <button>Add transaction</button>
                </form>
            </div>

            <div class="transactions-history">
            </div>
        </div>

    </main>

</body>

</html>