<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Crypto Currencies</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        @auth
            <section class="section-logout">
                <p>Logged in with {{ $email }}</p>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </section>
        @endauth

        @guest
            <section class="section-login">
                <a class="btn-login" href="{{ route('login') }}">Login</a>
            </section>
        @endguest
        <section class="section-border">
            <h1>{{ $pageTitle }}</h1>
        </section>
    </header>

    <main>
            <section id="vue-crypto-price-form">
                <crypto-price-form
                    :dropdown-list='@json($dropdownList)'
                    :favourite-tokens='@json($userFavouriteTokens)'
                    :is-authenticated='@json($isAuthenticated)'
                    ></crypto-price-form>
            </section>
        </section>
    </main>

    <footer>
        <p class="text-footer">Project created in 2025</p>
    </footer>

    @vite('resources/js/app.js')
</body>

</html>
