{{-- Takes html tags, head, header and footer from DEFAULT layout view --}}
@extends('layouts.default')

{{-- Puts this content in DEFAULT's "yield" --}}
@section('content')

{{-- includes de cada issue --}}
@include('partials.slogan')
@include('partials.team-section')
@include('partials.collaborators')
@include('partials.faqs')

@stop