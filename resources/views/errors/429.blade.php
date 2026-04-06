@extends('errors.layout')

@section('title', '429')
@section('code', '429')
@section('message', __('messages.error_too_many_requests'))
@section('description', __('messages.error_too_many_requests_desc'))
