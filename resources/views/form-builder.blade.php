@extends('layouts.dashboard')

@section('hide-chrome', 'true')

@section('page-title')
    Form <strong class="font-semibold">Builder</strong>
@endsection

@section('dashboard-content')
    <livewire:form-builder :formId="$formId ?? null" />
@endsection
