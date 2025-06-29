<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Invoice</title>

    <style>
        body {
            font-family: 'almarai', sans-serif;
        }

        .text-center {
            text-align: center;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'almarai', sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box-top table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }



        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box-top table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: 'almarai', sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body dir="ltr">

    <div class="invoice-box invoice-box-top">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('store/img/logo.png') }}" style="width: 70; max-width: 300px;" />
                            </td>
                            <td>
                                Order: #{{ $ref_id }}<br />
                                Created at {{ \Carbon\Carbon::parse($created_at)->format('M, d, Y') }}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                {{ config('app.name') }}<br />
                                company address<br />
                            </td>
                            <td>
                                {{ ucfirst($first_name) . ' ' . ucfirst($last_name) }}<br />
                                #{{ $ref_id }}<br />
                                {{ $email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="invoice-box">
        <table class="table">
            <thead>
                <tr style="background-color: #f2f2f2" class="text-center">
                    <th scope="col">Product</td>
                    <th scope="col">Quantity</td>
                    <th scope="col">Price</td>
                    <th scope="col">Total</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr class="text-center">
                        <td class="text-center">{{$item['name_' . app()->getLocale()]}}</td>
                        <td class="text-center">{{$item['pivot']['quantity']}}</td>
                        <td class="text-center">{{number_format($item['price'], 2)}}</td>
                        <td class="text-center">{{number_format($item['price'] * $item['pivot']['quantity'], 2)}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr style="background-color: #f2f2f2" class="total text-center">
                    <td class="text-center">Shipping:</td>
                    <td colspan="2"></td>
                    <td class="text-center">{{number_format($shipping, 2)}}</td>
                </tr>
               @if ($discount != 0)
               <tr style="background-color: #f2f2f2" class="total text-center">
                <td class="text-center">Discount:</td>
                <td colspan="2"></td>
                <td class="text-center">{{number_format($discount, 2)}}</td>
            </tr>
               @endif
                <tr style="background-color: #f2f2f2" class="total text-center">
                    <td class="text-center">Total:</td>
                    <td colspan="2"></td>
                    <td class="text-center">{{number_format($total, 2)}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
