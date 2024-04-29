@extends('layout')
@section('content')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Mortgage Calculator</title>

    <style>
        .form-container {
            float: right;
            width: 25%;
            border: 2px solid #ced4da; /* Add border to the container */
            border-radius: 8px; /* Optional: Add border radius for rounded corners */
            padding: 30px; /* Optional: Add padding for content inside the container */
            margin: 50px;
        }
    </style>
</head>
<body>

    <div class="col-md-6 form-container" id='mortgageForm'>
        <h2>Mortgage Calculator</h2>

        <form action="{{ route('calculate') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="price">Price :</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ isset($price) ? $price : old('price') }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br><br>

                <label for="years">Number of Years :</label>
                <input type="number" class="form-control @error('years') is-invalid @enderror" id="years" name="years" value="{{ isset($years) ? $years : old('years') }}">
                @error('years')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <br><br>

                <label for="percentage">Percentage :</label>
                <div class="input-group">
                    <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ isset($percentage) ? $percentage : old('percentage') }}">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                @error('percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <br><br>

                <button type="submit" class="btn btn-primary">Calculate Installment</button>   
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
    </div>

    <div id="result" class="mt-3"></div>

</body>
</html>

@endsection
