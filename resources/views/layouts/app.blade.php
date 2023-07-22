<!DOCTYPE html>
<html>
<head>
	<title>School management system</title>
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>

        nav {
            position: sticky
            top: 0;
            z-index: 1;
        }

        @media print {
          .dont-print {
            display: none;
          }
        }

        /* Customize the font size of the navbar links on smaller screens */
        @media (max-width: 767px) {
            nav {
                display: flex;
                flex-direction: row;
            }
            .navbar-nav .nav-link {
            font-size: 14px;
            margin: 10px;
            }
            .navbar-nav {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            .unshow-on-small-screen {
                visibility: hidde;
            }
        }
</style>

</head>
<body class="">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="position: sticky; top: 0;">
		<a class="navbar-brand unshow-on-small-screen" href="#">School Management System</a><!--
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>-->
		<!--<div class="collape navbar-collae" id="navbarNav">-->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="{{route('dashboard')}}">Home</a>
				</li>
                @if (count(Auth::user()->classes) > 0 && count(Auth::user()->subjects) > 0)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" href="#" id="marksheetDropdown">Create Marksheet</a>
                        <div class="dropdown-menu"  aria-labelledby="marksheetDropdown">
                            @foreach (Auth::user()->classes as $class)
                                <a class="dropdown-item" href=" {{ route('marksheet', ['class_id' => $class->id])}}"> {{ $class->name }} </a>
                            @endforeach
                        </div>
                    </li>
                @endif
				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" href="#" id="academiaDropdown">Academia</a>
                    <div class="dropdown-menu"  aria-labelledby="academiaDropdown">
                        @if (Auth::user()->class)
                            <a class="dropdown-item" href="{{ route('grading') }}">Aggregation</a>
                            <a class="dropdown-item" href="{{ route('comments')}}">Commenting</a>
                            <a class="dropdown-item" href="{{ route('attendance.create', ['class_id' => Auth::user()->class->id])}}">Attendance</a>
                        @endif
                        @if (in_array(Auth::user()->role, ['dos', 'secretary', 'head_teacher']))
                            <a class="dropdown-item" href="{{ route('period') }}">Set Year Calendar</a>
                        @endif
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Register
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						@if (in_array(Auth::user()->role, ['admini']))
						    <a class="dropdown-item" href="{{ route('register') }}">Staff</a>
						@endif
                            <a class="dropdown-item" href="{{ route('student.create') }}">Student</a>
                            <a class="dropdown-item" href="{{ route('class-reg') }}">Class</a>
                            <a class="dropdown-item" href="{{ route('subject-reg') }}">Subject</a>
						<div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('parent') }}">Parent</a>
                            <a class="dropdown-item" href="{{ route('requirements.create') }}">Requirements</a>
					</div>
				</li>
                <li class="nav-item"><button onclick="window.print()" class="dont-print btn btn-info">Print page</button></li>
			<!--</ul>-->

			<!--<ul class="navbar-nav ml-auto ">-->
                <!--<li class="nav-item unshow-on-small-screen" style=""><span class="badge badge-info">{{ str_replace('-', '/', session('today')) }}</span></li>-->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle unshow-on-small-screen" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{ asset('storage/' . Auth::user()->profile_pic_filepath) }}" alt="Profile Image" width="30" class="rounded-circle mr-2">
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
						<form action="{{ route('logout') }}" method="POST" class="dropdown-item">
							@csrf
							<input type="submit" value="Logout">
						</form>
					</div>
				</li>
			</ul>

	</nav>

	<!-- Page Content -->
	<div class="dark:text-gray-300 dark:border-gray-300" >
            @yield('content')
	</div>

	<!-- Include jQuery and Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
