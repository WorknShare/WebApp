<!DOCTYPE html>
<html class="html">
<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Work\'n Share')</title>

</head>
<body style='font-family: "Open Sans","Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; font-size: 1rem; line-height: 1.4;'>

    <header>
      <a href="{{ route('welcome') }}">
          <img src="{{ asset('img/banner64.png') }}" class="logo logo-display" alt="">
      </a>
	</header>

	<section>
	   <h1>@yield('mailTitle')</h1>
	   @yield('content')
	</section>

	<hr>
	<section>
		<p>
			<p>Copyright 2018 @ Work'n Share.</p>
		</p>
	</section>
</body>
</html>