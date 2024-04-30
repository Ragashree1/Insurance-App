@extends('layout')
@section('content')

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Mortgage Calculator</title>
</head>

<body>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCalculator">
        Calculate Mortgage
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalCalculator" tabindex="-1" role="dialog" aria-labelledby="modalCalculator"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCalculatorTitle">Calculate Mortgage</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='mortgageForm'>
                        <div class=" form-group">
                            <label for="price">Price :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="price" name="price" required min="1">
                            </div>
                            <br><br>

                            <label for="years">Number of Years :</label>
                            <input type="number" class="form-control" id="years" name="years" required min="1">
                            <br><br>

                            <label for="percentage">Percentage :</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="percentage" name="percentage" required min="1">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <br><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="calculateInstallment()">Calculate Installment</button>
                            </div>
                        </div>
        <!-- Form fields -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Monthly Payment</h5>
                <h3 class="card-text" id="monthlyPayment">Amount: $0.00</h3>
            </div>
                    </div>
                    <div id="result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous">
    </script>

<script>
function calculateInstallment() {
    // Gather input values
    var price = document.getElementById('price').value;
    var years = document.getElementById('years').value;
    var percentage = document.getElementById('percentage').value;

    // Send AJAX request to backend
    fetch('/calculate-mortgage', {
        method: 'POST', // Make sure it's a POST request
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ price: price, years: years, percentage: percentage })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Update result in HTML
        document.getElementById('monthlyPayment').innerText = '$' + data.monthlyPayment.toFixed(2);
    })
    .catch(error => {
        // Handle error
        console.error('Error:', error);
    });
}




</script>



</body>

</html>

@endsection