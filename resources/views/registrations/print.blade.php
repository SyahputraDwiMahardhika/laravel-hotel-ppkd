<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservation Confirmation</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
        }

        .container {
            width: 800px;
            margin: auto;
        }

        .center {
            text-align: center;
        }

        .logo {
            width: 70px;
        }

        .line {
            border-bottom: 1px solid black;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 0;
        }

        .label {
            width: 200px;
        }

        .colon {
            width: 20px;
        }

        .right {
            text-align: right;
        }

        .small {
            font-size: 13px;
        }

        .policy {
            margin-top: 20px;
            font-size: 13px;
        }

        .print-btn {
            margin: 20px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="print-btn">
        <button onclick="window.print()">Print</button>
    </div>

    <div class="container">

        <div class="center">
            <img src="{{ asset('logo-hotel.png') }}" class="logo">
            <h3>PPKD HOTEL</h3>
        </div>

        <p><b>Reservation Confirmation</b></p>

        <div class="line"></div>

        <table>
            <tr>
                <td class="label">To</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->full_name }}</td>
            </tr>
        </table>

        <br>

        <table>
            <tr>
                <td class="label">Company / Agent</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->company ?? '-' }}</td>

                <td class="label right">Telp</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->phone_number ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Booking No</td>
                <td class="colon">:</td>
                <td>{{ $registration->registration_number }}</td>

                <td class="label right">Fax</td>
                <td class="colon">:</td>
                <td>-</td>
            </tr>

            <tr>
                <td class="label">Book By</td>
                <td class="colon">:</td>
                <td>{{ $registration->receptionist->name }}</td>

                <td class="label right">Email</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->email ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Phone</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->phone_number }}</td>

                <td class="label right">Date</td>
                <td class="colon">:</td>
                <td>{{ now()->format('d-m-Y') }}</td>
            </tr>

            <tr>
                <td class="label">Email</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->email ?? '-' }}</td>
            </tr>

        </table>

        <div class="line"></div>

        <table>

            <tr>
                <td class="label">First Name</td>
                <td class="colon">:</td>
                <td>{{ $registration->guest->full_name }}</td>
            </tr>

            <tr>
                <td class="label">Arrival Date</td>
                <td class="colon">:</td>
                <td>{{ $registration->check_in_date }}</td>
            </tr>

            <tr>
                <td class="label">Departure Date</td>
                <td class="colon">:</td>
                <td>{{ $registration->check_out_date }}</td>
            </tr>

            <tr>
                <td class="label">Total Night</td>
                <td class="colon">:</td>
                <td>{{ $registration->nights }}</td>
            </tr>

            <tr>
                <td class="label">Room / Unit Type</td>
                <td class="colon">:</td>
                <td>{{ $registration->room->roomType->name }}</td>
            </tr>

            <tr>
                <td class="label">Person Pax</td>
                <td class="colon">:</td>
                <td>{{ $registration->num_guests }}</td>
            </tr>

            <tr>
                <td class="label">Room Rate Net</td>
                <td class="colon">:</td>
                <td>Rp {{ number_format($registration->room->roomType->price_per_night) }}</td>
            </tr>

        </table>

        <div class="line"></div>

        <p class="small">
            Please guarantee this booking with credit card number with clear copy of the card both sides and card holder
            signature.
        </p>
        @if ($registration->payment_method == 'credit_card')
            <p><b>Bank Transfer</b></p>

            <table>
                <tr>
                    <td class="label">Card Number</td>
                    <td class="colon">:</td>
                    <td>{{ $registration->card_number }}</td>
                </tr>

                <tr>
                    <td class="label">Card Holder Name</td>
                    <td class="colon">:</td>
                    <td>{{ $registration->card_holder_name }}</td>
                </tr>

                <tr>
                    <td class="label">Card Type</td>
                    <td class="colon">:</td>
                    <td>Credit Card</td>
                </tr>

                <tr>
                    <td class="label">Expired Date</td>
                    <td class="colon">:</td>
                    <td>{{ $registration->card_expired }}</td>
                </tr>

                <tr>
                    <td class="label">Card Holder Signature</td>
                    <td class="colon">:</td>
                    <td>____________________</td>
                </tr>
            </table>
        @endif

        <div class="line"></div>

        <p><b>Reservation guaranteed by the following credit card</b></p>

        <table>

            <tr>
                <td class="label">Card Number</td>
                <td class="colon">:</td>
                <td></td>
            </tr>

            <tr>
                <td class="label">Card Holder Name</td>
                <td class="colon">:</td>
                <td></td>
            </tr>

            <tr>
                <td class="label">Card Type</td>
                <td class="colon">:</td>
                <td></td>
            </tr>

            <tr>
                <td class="label">Expired Date</td>
                <td class="colon">:</td>
                <td></td>
            </tr>

            <tr>
                <td class="label">Card Holder Signature</td>
                <td class="colon">:</td>
                <td></td>
            </tr>

        </table>

        <div class="policy">

            <b>Cancellation policy</b>

            <ol>
                <li>Check in time 02.00 pm and check out time 12.00 pm</li>
                <li>All non guaranteed reservations will automatically be released on 6 pm</li>
                <li>The hotel will charge 1 night for guaranteed reservations not cancelled before arrival</li>
            </ol>

        </div>

    </div>

</body>

</html>
