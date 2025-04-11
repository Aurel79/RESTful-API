<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Mata Uang</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Konversi Mata Uang</h1>

    <form id="currencyForm">
        <label for="amount">Masukkan Nominal (USD):</label>
        <input type="number" id="amount" name="amount" required>

        <label for="currency">Pilih Mata Uang:</label>
        <select id="currency" name="currency">
            @if(isset($rates['conversion_rates']) && is_array($rates['conversion_rates']))
                @foreach ($rates['conversion_rates'] as $currency => $rate)
                    <option value="{{ $currency }}">{{ $currency }}</option>
                @endforeach
            @else
                <option disabled>Error fetching currency data</option>
            @endif
        </select>

        <button type="submit">Konversi</button>
    </form>

    <h2>Hasil Konversi: <span id="result">-</span></h2>

    <script>
        $(document).ready(function () {
            $('#currencyForm').submit(function (event) {
                event.preventDefault();

                let amount = $('#amount').val();
                let currency = $('#currency').val();

                // Pastikan jumlah yang dimasukkan valid
                if (!amount || amount <= 0) {
                    alert("Masukkan jumlah yang valid!");
                    return;
                }

                $.ajax({
                    url: '/convert',
                    type: 'POST',
                    data: {
                        amount: amount,
                        currency: currency,
                        _token: '{{ csrf_token() }}' // Tambahkan CSRF token untuk keamanan
                    },
                    success: function (data) {
                        if (data.converted_amount) {
                            $('#result').text(data.converted_amount);
                        } else {
                            $('#result').text("Terjadi kesalahan dalam konversi.");
                        }
                    },
                    error: function () {
                        $('#result').text("Gagal mengambil data konversi.");
                    }
                });
            });
        });
    </script>
</body>
</html>
