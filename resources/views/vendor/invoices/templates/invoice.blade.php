
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Invoice - Mark Ezekiel Oyos</title>
  <style>
    * {
  box-sizing: border-box;
}
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      margin: 0;
      padding: 0;
      font-size: 15px;
      color: #333;
    }

    /* .invoice-container {
      width: 800px;
      margin: 0 auto;
      padding: 40px;
    } */

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #999;
      padding: 8px;
      text-align: left;
    overflow-wrap: break-word;
    word-break: break-word;

    }

    .no-border th,
    .no-border td {
      border: none;
      padding: 0 0 10px;
    }

    ul {
      margin: 0;
      padding-left: 20px;
    }

    img.logo {
      max-width: 240px;
      height: auto;
      margin-bottom: 20px;
    }

    .text-right {
      text-align: right;
    }

    .bold {
      font-weight: 600;
    }

    @media print {
      .page-break {
        page-break-before: always;
      }
    }
.invoice-container {
  max-width: 750px;
  width: 100%;
  margin: 0 auto;
  padding: 20px;
  box-sizing: border-box;
}
  </style>
</head>
<body>
  <div class="invoice-container">
    <!-- Header -->
    <table class="no-border">
      <tr style="border-bottom: 6px solid #31859c;">
        <td colspan="2" style="text-align: center;">
          <img src="{{public_path('vendor/invoices/logo.png')}}" alt="Falcon International Consultants Logo" class="logo" />
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;">
          <h3 style="font-size: 24px; color: #7f7f7f; text-decoration: underline; margin: 24px 0 12px;">Invoice</h3>
        </td>
      </tr>
      <tr>
        <td style="width: 50%; vertical-align: top;">
          <p>Falcon International Consultants</p>
          <p>
            Office 607, 6th Floor, Al Rosais Center, Olaya St., Al Olaya Riyadh, 12213, Saudi Arabia<br />
            Phone: +966 565449820<br />
            Email: <a href="mailto:info@falconinternationalconsultants.com">info@falconinternationalconsultants.com</a>
          </p>
        </td>
        <td style="width: 50%; text-align: right; vertical-align: top;">
          <p>To: {{$invoice->buyer->name}}</p>
          <p>
            Phone: {{$invoice->buyer->contact}}<br />
            Email: <a href="mailto:{{$invoice->buyer->email}}">{{$invoice->buyer->email}}</a>
          </p>
        </td>
      </tr>
    </table>

    <!-- Invoice Info -->
    <div style="display: inline-block;">
      <table class="no-border">
        <tr>
          <td style="padding: 6px 12px;"><span class="bold">Invoice No:</span><br />INV/{{$invoice->buyer->inv_no}}</td>
          <td style="padding: 6px 12px;"><span class="bold">Invoice Date:</span><br />21/01/2024</td>
          <td style="padding: 6px 12px;"><span class="bold">Due Date:</span><br />Work Permit</td>
          <td style="padding: 6px 12px;"><span class="bold">Contract:</span><br />FC06</td>
        </tr>
      </table>
    </div>

    <!-- Description -->
    <table class="no-border">
      <tr>
        <td style="width: 50%;">
          <span class="bold">Description</span><br />
          Submission Letter: Second Payment
        </td>
        <td style="width: 50%; text-align: right;">
          <table class="no-border" style="width: 100%;">
            <tr>
              <td class="bold">Unit Price Taxes</td>
              <td class="bold text-right">Total Price</td>
            </tr>
            <tr>
              <td>1,500.00</td>
              <td class="text-right">8,500.00 SR</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Totals -->
    <table class="no-border">
      <tr>
        <td style="width: 50%;"></td>
        <td style="width: 50%; text-align: right;">
          <table class="no-border" style="width: 100%;">
            <tr>
              <td colspan="2" class="bold">Subtotal:</td>
              <td colspan="2" class="text-right">8,500.00 SR</td>
            </tr>
            <tr>
              <td colspan="2" class="bold" style="padding-top: 24px; padding-bottom: 12px;">Total:</td>
              <td colspan="2" class="text-right" style="padding-top: 24px; padding-bottom: 12px;">1,500.00 SR</td>
            </tr>
            <tr><td colspan="2"><em>Paid on 17/09/2024</em></td><td colspan="2" class="text-right">1,000.00 SR</td></tr>
            <tr><td colspan="2"><em>Paid on 06/10/2024</em></td><td colspan="2" class="text-right">2,500.00 SR</td></tr>
            <tr><td colspan="2"><em>Paid on 05/11/2024</em></td><td colspan="2" class="text-right">2,000.00 SR</td></tr>
            <tr><td colspan="2"><em>Paid on 21/01/2024</em></td><td colspan="2" class="text-right">1,500.00 SR</td></tr>
            <tr>
              <td colspan="2" style="padding-top: 24px;">Balance on Work Permit</td>
              <td colspan="2" class="text-right" style="padding-top: 24px;">1,500.00 SR</td>
            </tr>
            <tr style="border-top: 1px solid #000;">
              <td colspan="2" class="bold" style="padding: 10px 0;">Amount Due</td>
              <td colspan="2" class="text-right bold" style="padding: 10px 0;">1,500.00 SR</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Footer -->
    <table class="no-border">
      <tr>
        <td style="padding-top: 20px;">
          <p style="font-size: 14px;">
            Please note that this invoice is non-refundable. In accordance with embassy guidelines, any refunds for an invalid work permit will be processed as directed by the embassy.
          </p>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
