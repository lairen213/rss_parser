@extends('errors::vendor.laravel.framework.src.Illuminate.Foundation.Exceptions.views.minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
