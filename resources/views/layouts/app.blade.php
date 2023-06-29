<!DOCTYPE html>
<html>
<head>
	<title>School management system</title>
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script>

        $(document).ready(function () {
            $('#parent_name').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '/parent-autocomplete',
                        dataType: 'json',
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                minLength: 2 // Minimum characters required to trigger autocomplete
            });
        });

        $(document).on('autocompleteselect', '#parent-name', function (event, ui) {
            $(this).val(ui.item.value);
        });

        </script>

</head>
<body class="dark:bg-gray-700">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: sticky ; top: 0; z-index:1;" >
		<a class="navbar-brand" href="#">School Management System</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
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
						@if (Auth::user()->role === 'admini')
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
			</ul>

			<ul class="navbar-nav ml-auto">
                <li class="nav-item" style=""><span class="badge badge-info">{{ str_replace('-', '/', session('today')) }}</span></li>
                <li class="nav-item"><img src="{{ asset('storage/' . Auth::user()->profile_pic_filepath) }}" alt="Profile Image" width="30" class="rounded-circle mr-2"></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ Auth::user()->name }}
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
		</div>
	</nav>

	<!-- Page Content -->
	<div class="container dark:text-gray-300 dark:border-gray-300" >
            @yield('content')
	</div>

	<!-- Include jQuery and Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
