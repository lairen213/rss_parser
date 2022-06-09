@extends('errors::vendor.laravel.framework.src.Illuminate.Foundation.Exceptions.views.minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
