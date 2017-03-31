<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	@yield('meta_social')
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/font-awesome/css/font-awesome.min.css') }}">
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
</head>
<body>