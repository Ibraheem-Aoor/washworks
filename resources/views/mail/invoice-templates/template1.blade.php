
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    h1, h2, h3, h4, h5, h6 {
      color: #000000;
    }

    p {
      margin: 0 0 8px;
    }

    .invoice {
      width: 190mm;
      height: auto;
      box-sizing: border-box;
    }

    .invoice-header {
      text-align: right;
    }

    .invoice-header h1 {
      margin: 0 0 10px;
    }

    .invoice-details {
      text-align: right;
    }
    .invoice-footer {
      text-align: center;
    }

    .invoice-logo img {
      height: 40px;
    }

    .invoice-logo-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 0 0 20px;
      padding: 0 0 20px;
      border-bottom: 1px solid #f1f1f1;
    }
    .invoice-detail-part {
        display: flex;
        justify-content: space-between;
        margin: 16px 0;
    }

    .invoice-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .invoice-table th, .invoice-table td {
      border: 1px solid #f1f1f1;
      padding: 16px 16px;
      text-align: left;
      font-size: 14px;
    }

    .invoice-table th {
      background-color: #f2f2f2;
    }

    .total {
      margin-top: 20px;
      text-align: right;
    }

    .thank-you {
      margin-top: 20px;
      background: #f1f1f1;
      padding: 16px;
      text-align: center;
    }
    .thank-you p {
      margin: 0;
    }
    .invoice-customer p {
      margin: 0 0 10px;
    }
    .invoice-customer h3,
    .invoice-billing h3 {
      margin-top: 0;
      margin-bottom: 8px;
    }

    strong {
      color: #000000;
    }

    table th {
      color: #000000;
    }

    table.invoice-table tr th:last-child,
    table.invoice-table tr td:last-child {
        text-align: right;
    }

    .invoice-payment {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 20px;
    }

    .invoice-pay-info h3 {
      margin: 0 0 8px;
    }

    .invoice-payment ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .invoice-payment ul li {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 3rem;
      margin-top: 10px;
    }

    .invoice-payment ul li label {
      font-weight: 600;
    }

    .invoice-info {
        background: #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
    }

    .invoice-info .payment-method {
      text-align: right;
    }

    .invoice-date p + p,
    .invoice-info .payment-method p + p {
      margin: 0;
    }


  </style>
</head>
<body>
  <div class="invoice">


    <div class="invoice-logo-section">
      <div class="invoice-logo">
      </div>
      <div class="invoice-header">
        <h1>Invoice</h1>
        <div class="invoice-details">
          <p><strong>Invoice No:</strong>ORDER{{$data['id']}}</p>
        </div>
      </div>

    </div>

    <div class="invoice-detail-part">
      <div class="invoice-customer">
        <h3>Customer Info</h3>
        <p>{{$data['user_name']}}</p>
        <p>{{$data['email']}}</p>
        <p>{{$data['mobile']}}</p>
      </div>
      <div class="invoice-billing">
        <h3>Billing Address</h3>
        <p>{{$data['venue_address']}}</p>
      </div>
    </div>

    <div class="invoice-info">
        <div class="invoice-date">
          <p><strong>Order Date:</strong></p>
          <p>{{$data['booking_date']}}</p>
        </div>
        <div class="payment-method">
          <p><strong>Payment Method:</strong></p>
          <p>{{$data['transaction_type']}}</p>
        </div>
    </div>

    <table class="invoice-table">
      <thead>
        <tr>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data['extra']['services'] as $key => $value)

        <tr>
          <td>{{$value['service_name']}}</td>
          <td>1</td>
          <td>{{$value['service_price']}}</td>
          <td>{{$value['service_price']}}</td>
        </tr>

        @endforeach

        <!-- @if (!empty($data['product_name'])) -->

        @php
            $productPrice = 0;
          @endphp

      @foreach($data['extra']['products'] as $key => $value)
        <tr>
        <td>{{$value['product_name']}}</td>
        <td>{{$value['product_qty']}}</td>

          @php
                $price = $value['product_price'];
                $delPrice = false;
                $discountType = $value['discount_type'];
                $discountValue = $value['discount_value'] . ($discountType == 'percent' ? '%' : '');
                if($price != $value['discounted_price']) {
                    $delPrice = $price;
                    $price = $value['discounted_price'];
                }
                $productPrice = $price * $value['product_qty'] +$productPrice
          @endphp

        <td>{{$price}}</td>
        <td>{{ $price * $value['product_qty'] }}</td>
        </tr>

      @endforeach
        <!-- @endif -->
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" style="color: #000000; text-align: right;"><strong>Sub Total:</strong></td>
          <td>{{ \Currency::format($data['serviceAmount'] + $data['product_price']) }}</td>
        </tr>
        <tr>
          <td colspan="3" style="color: #000000; text-align: right;"><strong>Tips:</strong></td>
          <td>{{ \Currency::format($data['tip_amount']) }}</td>
        </tr>
        <tr>
          <td colspan="3" style="color: #000000; text-align: right;"><strong>TAX:</strong></td>
          <td>{{ \Currency::format($data['tax_amount']) }}</td>
        </tr>
        <tr>
          <td colspan="3" style="color: #000000; text-align: right;"><strong>Grand Total:</strong></td>
          <td>{{ \Currency::format($data['grand_total']) }}</td>
        </tr>
      </tfoot>
    </table>

    <div class="thank-you">
      <p>{{ setting('spacial_note') }}</p>
    </div>
  </div>

</body>
</html>
