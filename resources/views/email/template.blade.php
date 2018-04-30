<!DOCTYPE html>
<html class="html">
<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Work\'n Share')</title>

</head>
<body style='font-family: "Open Sans","Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Helvetica Neue",sans-serif; font-size: 1rem; line-height: 1.4; margin:0' background="#fff">

	<table align="center" cellpadding="25px" cellspacing="0px" width="100%">
		<thead style="background-color: #39acd8;">
			<tr>
				<th>
					<font color="#fff">
						<a href="{{ route('welcome') }}" style="color:#fff">
			          		<img src="{{ asset('img/banner64_2.png') }}" class="logo logo-display" alt="Work'n Share">
			      		</a>
		      		</font>
		  		</th>
	  		</tr>
  		</thead>

	</table>

	<table align="center" cellpadding="25px" cellspacing="0px" background="#fff">
  		<tbody>
  			<tr><td><h1>@yield('mailTitle')</h1></td>
	  		<tr><td>@yield('content')</td></tr>

	  		<tr><td><hr><p>Copyright 2018 @ Work'n Share.</p></td></tr>
  		</tbody>
	</table>
</body>
</html>