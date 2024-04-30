@extends('layout')
@section('content')

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
                    <h5 class="modal-title" id="modalCalculator">Calculate Mortgage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='mortgageForm'>
                    <!--<form action="{{ route('calculate') }}" method="POST" id="mortgageForm"> -->
                    <form action="{{ route('calculate') }}" method="POST" id="mortgageForm">

                        @csrf
                        <div class=" form-group">
                            <label for="price">Price :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ isset($price) ? $price : old('price') }}" required min="1">
                            </div>
                            <br><br>

                            <label for="years">Number of Years :</label>
                            <input type="number" class="form-control" id="years" name="years"
                                value="{{ isset($years) ? $years : old('years') }}" required min="1">
                            <br><br>

                            <label for="percentage">Percentage :</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="percentage" name="percentage"
                                    value="{{ isset($percentage) ? $percentage : old('percentage') }}" required min="1">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <br><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Calculate Installment</button>
                            </div>
                        </div>
                    </form>
                    <div class="card mt-3">
                        <div class="card-body">
                            @isset($error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                            @else
                            @isset($monthly_payment)
                            <h5 class="card-title">Monthly Payment</h5>
                            <h3 class="card-text">Amount: ${{ number_format($monthly_payment, 2) }}</h3>
                            @endisset
                            @endisset
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

</body>

</html>

@endsection