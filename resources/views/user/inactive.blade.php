<x-auth-layout>
    <!--begin::Verify Email Form-->
    <div class="w-100">

        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">حسابك قيد التحقق</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">Thanks for signing up! Before getting started, our admin well
                verify your information</div>
            <!--end::Subtitle=-->

        </div>

        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">

            {{-- <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="btn btn-lg btn-primary fw-bolder me-4">{{ __('Resend Verification Email') }}</button>
            </form> --}}

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-lg btn-light-primary fw-bolder me-4">{{ __('Log out') }}</button>
            </form>
        </div>
        <!--end::Actions-->
    </div>

    <!--end::Verify Email Form-->
</x-auth-layout>
