@extends('layouts.landing')

@section('content')
    {{-- <div id="loader">
        <div id="status"></div>
    </div> --}}
    <div id="site-header">
        <header id="header" class="header-block-top">
            <div class="container">
                <div class="row">
                    <div class="main-menu">
                        <!-- navbar -->
                        @include('landing.header')
                        <!-- end navbar -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </header>
        <!-- end header -->
    </div>
    <!-- end site-header -->

    @include('landing.banner')
    <!-- end banner -->

    @include('landing.about')

    @include('landing.special_menu')
    <!-- end special-menu -->

    @include('landing.menu')
    <!-- end menu -->

    @include('landing.team')
    <!-- end team-main -->

    @include('landing.gallery')
    <!-- end gallery-main -->

    @include('landing.blog')
    <!-- end blog-main -->

    @include('landing.pricing')
    <!-- end pricing-main -->

    {{-- @include('landing.reservation') --}}
    <!-- end reservations-main -->

    @include('landing.footer')
    <!-- end footer-main -->

    <a href="#" class="scrollup" style="display: none;">Scroll</a>

    <section id="color-panel" class="close-color-panel">
        <a class="panel-button gray2"><i class="fa fa-cog fa-spin fa-2x"></i></a>
        <!-- Colors -->
        <div class="segment">
            <h4 class="gray2 normal no-padding">Color Scheme</h4>
            <a title="orange" class="switcher orange-bg"></a>
            <a title="strong-blue" class="switcher strong-blue-bg"></a>
            <a title="moderate-green" class="switcher moderate-green-bg"></a>
            <a title="vivid-yellow" class="switcher vivid-yellow-bg"></a>
        </div>
    </section>
	@push('scripts')
		
	@endpush('scripts')
@endsection
