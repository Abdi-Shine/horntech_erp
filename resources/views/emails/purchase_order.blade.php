<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order {{ $po->po_number }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #004161; color: white; padding: 20px 24px; border-radius: 8px 8px 0 0;">
        <h2 style="margin: 0;">Purchase Order</h2>
        <p style="margin: 4px 0 0;">{{ $po->po_number }}</p>
    </div>

    <div style="border: 1px solid #e0e0e0; border-top: none; padding: 24px; border-radius: 0 0 8px 8px;">
        <p>Dear {{ $po->supplier->name }},</p>
        <p>Please find below the details of our purchase order.</p>

        <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
            <tr style="background: #f5f5f5;">
                <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">PO Number</th>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $po->po_number }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Order Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($po->order_date)->format('d M, Y') }}</td>
            </tr>
            <tr style="background: #f5f5f5;">
                <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Expected Delivery</th>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $po->expected_delivery ? \Carbon\Carbon::parse($po->expected_delivery)->format('d M, Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 10px; border: 1px solid #ddd;">Payment Terms</th>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $po->payment_terms ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3 style="color: #004161; border-bottom: 2px solid #004161; padding-bottom: 8px;">Order Items</h3>
        <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
            <thead>
                <tr style="background: #004161; color: white;">
                    <th style="padding: 10px; text-align: left;">Product</th>
                    <th style="padding: 10px; text-align: center;">Qty</th>
                    <th style="padding: 10px; text-align: right;">Unit Price</th>
                    <th style="padding: 10px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($po->items as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;">{{ $item->product_name }}</td>
                    <td style="padding: 10px; text-align: center;">{{ $item->quantity }} {{ $item->unit }}</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($item->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #f5f5f5; font-weight: bold;">
                    <td colspan="3" style="padding: 10px; text-align: right;">Subtotal:</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($po->subtotal, 2) }}</td>
                </tr>
                @if($po->vat > 0)
                <tr style="background: #f5f5f5;">
                    <td colspan="3" style="padding: 10px; text-align: right;">VAT:</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($po->vat, 2) }}</td>
                </tr>
                @endif
                <tr style="background: #004161; color: white; font-weight: bold;">
                    <td colspan="3" style="padding: 10px; text-align: right;">Total Amount:</td>
                    <td style="padding: 10px; text-align: right;">{{ number_format($po->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        @if($po->notes)
        <p><strong>Notes:</strong> {{ $po->notes }}</p>
        @endif

        <p style="margin-top: 24px;">Regards,<br><strong>{{ auth()->user()->name ?? 'Procurement Team' }}</strong></p>
    </div>
</body>
</html>
