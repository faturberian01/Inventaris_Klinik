@php
    $total = 0;
    $quantity = 0;
@endphp
<table border="1">
    <thead>
        <tr>
            <td colspan="6" style="text-align: center;">Laporan Penjualanan Pada :
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
            <td>No</td>
            <td>Date</td>
            <td>Product Code</td>
            <td>Product Name</td>
            <td>Product Type</td>
            <td>Quantity</td>
            <td>Price</td>
            <td>Total Price</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($histories as $history)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $history->date->format('d F Y') }}</td>
                <td>{{ $history->product->code }}</td>
                <td>{{ $history->product->name }}</td>
                <td>{{ $history->product->type->getTranslated() }}</td>
                <td>{{ number_format($history->quantity) }}</td>
                <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->product->price) }}</td>
                <td>{{ \App\Helpers\BasicHelper::getRupiahFormat($history->total) }}</td>
                @php
                    $quantity += $history->quantity;
                @endphp
                @php
                    $total += $history->total;
                @endphp
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: center;">Total</td>
            <td style="text-align: center;">{{ number_format($quantity) }}</td>
            <td></td>
            <td style="text-align: center;">{{ \App\Helpers\BasicHelper::getRupiahFormat($total) }}</td>
        </tr>
    </tbody>
</table>
