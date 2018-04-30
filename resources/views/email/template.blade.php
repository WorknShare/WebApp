<!DOCTYPE html>
<html class="html">
<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Work\'n Share')</title>

</head>
<body style='font-family: "Open Sans","Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; font-size: 1rem; line-height: 1.4; background-color: #222222'>

	<table align="center" style="background-color: #ffffff; border: 1px solid #555" cellpadding="25px" cellspacing="0px">
		<thead style="background-color: #39acd8;">
			<tr>
				<th>
					<a href="{{ route('welcome') }}">
		          		<img src="{{ asset('img/banner64_2.png') }}" class="logo logo-display" alt="">
		      		</a>
		  		</th>
	  		</tr>
  		</thead>
  		<tbody>
  			<tr><td><h1>@yield('mailTitle')</h1></td>
	  		<tr><td>@yield('content')</td></tr>

	  		<tr><td><hr><p>Copyright 2018 @ Work'n Share.</p></td></tr>
  		</tbody>
	</table>
</body>
</html>