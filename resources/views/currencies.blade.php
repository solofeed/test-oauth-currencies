<!doctype html>
<html>
<head>
    <meta charset="utf-8">

    <title>OAuth</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        .flex-center {
            font-size: 20px;
            align-items: center;
            display: flex;
            justify-content: center;
        }

        /* Style the buttons that are used to open and close the accordion panel */
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: 0.4s;
        }

        /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
        .active, .accordion:hover {
            background-color: #ccc;
        }

        /* Style the accordion panel. Note: hidden by default */
        .panel {
            padding: 0 18px;
            background-color: white;
            display: none;
            overflow: hidden;
        }
    </style>
</head>
<body>
@foreach ($currencyRates as $currency)
    <button class="accordion">{{ $currency['curr_name'] }}</button>
    <div class="panel">
        <p>ID: {{ $currency['curr_id'] }}</p>
        <p>Denominator: {{ $currency['denominator'] }}</p>
        <p>Numerator: {{ $currency['numerator'] }}</p>
        <p>Status: {{ $currency['status'] }}</p>
        <div>
            @isset($currency['rates'])
                <h2>Exchange rates</h2>
                @foreach ($currency['rates'] as $rate)
                    <p>{{ $rate['curr_code'] }}: {{ $rate['rate'] }}</p>
                @endforeach
            @endisset
        </div>
    </div>
@endforeach
</body>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
</html>