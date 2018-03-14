 <?php
	$admin = Auth::guard('admin')->check();
 ?>

 <ul class="dropdown-menu">
 	<li class="user-header">
 		<p>
 			{{ $username }}
 			<small>{{ $smalltext }}</small>
 		</p>
 	</li>
 	<!-- Menu Footer-->
 	<li class="user-footer">
 		<div class="pull-left">
 			<a href="{{ $admin ? route('employee.show',Auth::user()->id_employee) : route('myaccount.index') }}" class="btn btn-default btn-flat">Profil</a>
 		</div>
 		<div class="pull-right">
 			<a href="{{ route($admin ? 'admin.logout' : 'logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Se déconnecter</a>
            <form id="logout-form" action="{{ route($admin ? 'admin.logout' : 'logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
			</form>
 		</div>
 	</li>
 </ul>
