<html lang="utf-8">
    <body>
        <div>
            <h1>Hello , {{ $notification->email }}</h1>

            <h2>The price of BTC has exceeded the limit of {{ $notification->price_limit }} USD.</h2>
        </div>
    </body>
</html>