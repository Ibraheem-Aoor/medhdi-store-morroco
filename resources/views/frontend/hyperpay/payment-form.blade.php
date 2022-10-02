<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    ​
    ​
    <style>
        ​ article.card {
            border: 0
        }

        ​ .card .card-body .nav {
            border: 1px solid #EEE;
            margin-bottom: 30px !important;
        }

        ​ .nav-fill .nav-item {
            width: 33%;
            ​
        }

        ​ .nav-pills .nav-link {
            font-size: 15px;
            border-radius: 0;
            color: #247773;
        }

        ​ .nav-pills .nav-link .fa {
            padding: 0 5px
        }

        ​ ​ .nav-pills .nav-link.active {
            background: #247773;
        }

        ​ button.subscribe {
            background: #247773;
            border-color: #247773
        }

        ​ button.subscribe:hover,
        button.subscribe:focus {
            background-color: #194442;
            border-color: #194442;
            box-shadow: none !important
        }

        ​ .btn-primary:not(:disabled):not(.disabled):active {
            background-color: #194442;
            border-color: #194442;
        }

        ​ ​ ​ .form-control:focus {
            border-color: rgba(36, 119, 115, 0.3);
            box-shadow: 0 0 0 0.1rem rgba(36, 119, 115, 0.4);
        }

        ​ @media(max-width: 351px) {
            .nav-pills .nav-link {
                font-size: 14px;
            }
        }

        ​ .bank-img {
            border-bottom: 1px solid #EEE;
            margin-bottom: 10px
        }

        ​ .bank-img ul {
            list-style: none;
            display: flex;
            width: 65%;
            margin: 15px auto 20px;
            padding: 0;
            justify-content: space-between;
            ​
        }

        .apple-pay {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        ​ .apple-pay-button {
            -webkit-appearance: -apple-pay-button;
            -apple-pay-button-type: buy;
            visibility: hidden;
            display: inline-block;
            width: 200px;
            min-height: 30px;
            border: 1px solid black;
            background-image: -webkit-named-image(apple-pay-logo-black);
            background-size: 100% calc(60% + 2px);
            background-repeat: no-repeat;
            background-color: white;
            background-position: 50% 50%;
            border-radius: 5px;
            padding: 0px;
            margin: 5px auto;
            transition: background-color .15s;
        }

        ​ .apple-pay-button.visible {
            visibility: visible;
        }

        ​ .apple-pay-button:active {
            background-color: rgb(152, 152, 152);
        }

        ​ .bank-img li img {
            width: 40px;
        }

        ​ .bank-img li.mada img {
            height: 15px;
        }

        ​ @if (app()->getLocale() == 'sa')​

        /****  RTL style for arbic page *****/
        ​ ​ body {
            text-align: right;
        }

        ​ input {
            text-align: right;
        }

        ​ .cardnumber {
            display: flex;
        }

        ​ .cardnumber input[type="text"] {
            order: 2
        }

        ​ .cardnumber .input-group-text {
            border-top-left-radius: .25rem;
            border-bottom-left-radius: .25rem;
            ​ border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        ​ .cardnumber .input-group>.form-control:not(:last-child) {
            border-top-right-radius: .25rem;
            ;
            border-bottom-right-radius: .25rem;
            ;
            ​ border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        ​ @endif​ ​ ​ .btn-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        ​ .btn-wrapper-btn {
            background: #34A987;
            min-width: 175px;
            min-height: 55px;
            font-size: 20px;
            color: #FFF;
            border-radius: 10px;
            text-align: center;
            line-height: 55px;
            margin-bottom: 30px;
            cursor: pointer;
        }

        ​ ​
    </style>
</head>
​

<body>
    @if (app()->getLocale() == 'ar')
        <style>
            .paymentWidgets {
                direction: rtl;
            }

            ​ .wpwl-label {
                text-align: right;
            }

            ​
        </style>
        ​
    @endif
    <script>
        ​
        var wpwlOptions = {
            style: "card",
            locale: "{{ app()->getLocale() }}",
            // showPlaceholders: false,
            validation: true,
            maskCvv: true,
            onReady: function(e) {
                if (wpwlOptions.locale == "ar") {
                    // $(".wpwl-group").css('direction', 'ltr');
                    $(".wpwl-control-cardNumber").css({
                        'direction': 'ltr',
                        "text-align": "right"
                    });
                    $(".wpwl-control-expiry").css({
                        'direction': 'ltr',
                        "text-align": "right"
                    });
                    $(".wpwl-control-cardNumber").attr('placeholder', 'XXXX XXXX XXXX XXXX');
                    $(".wpwl-control-cvv").attr('placeholder', 'CVV');​
                    // $(".wpwl-brand-card").css('right', '200px');
                }
            },
            onBeforeSubmitCard: function(e) {
                return validateHolder(e);
            }
        }​
        function validateHolder(e) {
            var holder = $('.wpwl-control-cardHolder').val();
            if (holder.trim().length < 2) {
                $('.wpwl-control-cardHolder').addClass('wpwl-has-error').after(
                    '<div class="wpwl-hint wpwl-hint-cardHolderError">Invalid card holder</div>');
                return false;
            }
            return true;
        }​
    </script>
    {{-- <script src="https://oppwa.com/v1/paymentWidgets.js?checkoutId={{@$response['id']}}"></script> --}}
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ @$response['id'] }}"></script>
    {{-- <script src="https://oppwa.com/v1/paymentWidgets.js?checkoutId={{@$responseData['id']}}"></script> --}}
    {{-- {{ $response['arrr'] }} --}}
    <form action="{{route('hyperPay.second_step')}}" class="paymentWidgets" data-brands="VISA MASTER MADA"></form>
    ​
    ​
    </div>
</body>

</html>
