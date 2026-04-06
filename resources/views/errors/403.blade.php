@extends('errors.layout')

@section('title', '403')
@section('code', '403')
@section('message', __('messages.error_forbidden'))
@section('description', $exception->getMessage() ?: __('messages.error_forbidden_desc'))
