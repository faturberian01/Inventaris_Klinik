@php
    $profits = $histories->filter(function($history) {
        return $history->total >= 0;
    });

    $losses = $histories->filter(function($history) {
        return $history->total < 0;
    });

    $totalProfit = 0;
    $totalLoss = 0;
    $quantityProfit = 0;
    $quantityLoss = 0;
@endphp

<table border="1">
    <thead>
        <tr>
            <td colspan="6" style="text-align: center;">Laporan Penjualan Pada :
                @if ($startDate && $endDate)
                    {{ $startDate->format('d/m/Y') }}/{{ $endDate->format('d/m/Y') }}
                @else
                    Seluruhnya
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;">CV. MA Medika</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;">Profit</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
        <tr>
            <td>No</td>
            <td>Date</td>
            <td>Product Code</td>
            <td>Product Name</td>
            <td>Product Type</td>
            <td>Reason</td>
            <td>Quantity</td>
            <td>Price</td>
            <td>Total Price</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($profits as $history)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $history->date->format('d F Y') }}</td>
                <td>{{ $history->product->code }}</td>
                <td>{{ $history->product->name }}</td>
                <td>{{ $history->product->type->getTranslated() }}</td>
                <td>{{ $history->reason}}</td>
                <td>{{ number_format($history->quantity) }}</td>
                <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->product->price) }}</td>
                <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->total) }}</td>
                @php
                    $quantityProfit += $history->quantity;
                    $totalProfit += $history->total;
                @endphp
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: center;">Total</td>
            <td style="text-align: center;">{{ number_format($quantityProfit) }}</td>
            <td></td>
            <td style="text-align: center;">{{ \App\Helpers\BasicHelper::getRupiahFormat($totalProfit) }}</td>
        </tr>
    </tbody>
</table>


<table border="1">
    <thead>
        <tr>
            <td colspan="6" style="text-align: center;">Loss</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;"></td>
        </tr>
        <tr>
            <td>No</td>
            <td>Date</td>
            <td>Product Code</td>
            <td>Product Name</td>
            <td>Product Type</td>
            <td>Reason</td>
            <td>Quantity</td>
            <td>Price</td>
            <td>Total Price</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($losses as $history)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $history->date->format('d F Y') }}</td>
                <td>{{ $history->product->code }}</td>
                <td>{{ $history->product->name }}</td>
                <td>{{ $history->product->type->getTranslated() }}</td>
                <td>{{ $history->reason}}</td>
                <td>{{ number_format($history->quantity) }}</td>
                <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->product->price) }}</td>
                <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->total) }}</td>
                @php
                    $quantityLoss += $history->quantity;
                    $totalLoss += $history->total;
                @endphp
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: center;">Total</td>
            <td style="text-align: center;">{{ number_format($quantityLoss) }}</td>
            <td></td>
            <td style="text-align: center;">{{ \App\Helpers\BasicHelper::getRupiahFormat($totalLoss) }}</td>
        </tr>
    </tbody>
</table>

