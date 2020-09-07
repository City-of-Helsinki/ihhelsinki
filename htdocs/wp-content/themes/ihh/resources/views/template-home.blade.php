{{--
  Template Name: Home
--}}

@extends('layouts.app')

@section('content')
  @include('components.home.title')
  @include('components.home.testimonials')
  @include('components.home.lift-box')
  @include('components.home.services')
  @include('components.home.reservation-status')
  @include('components.home.contact')
  @include('components.home.twitter')
@endsection
