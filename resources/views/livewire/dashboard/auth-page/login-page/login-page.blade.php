<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
        <!-- BEGIN: Login Info -->
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="" class="-intro-x flex items-center pt-5">
                <img alt="Tinker Tailwind HTML Admin Template" class="w-6" src="/assets/core/images/logo.svg">
                <span class="text-white text-lg ml-3"> Tink<span class="font-medium">er</span> </span>
            </a>
            <div class="my-auto">
                <img alt="Tinker Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16"
                    src="/assets/core/images/illustration.svg">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    Selamat Datang!
                    <br>
                    <span class="text-3xl">Silakan masukkan kredensial Anda untuk melanjutkan.</span>
                </div>
                <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500" style="font-size: 15px">Ayo telusuri berbagai macam undangan yang menarik untuk acara spesial kamu!!</div>
            </div>
        </div>
        <!-- END: Login Info -->
        <!-- BEGIN: Login Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
               
            <div
                class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Sign In
                </h2>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your
                    account. Manage all your e-commerce accounts in one place</div>

                <div class="intro-x mt-8">
                    <!-- In your blade view -->
                    @if (session()->has('success'))
                        <div class="alert alert-outline-success alert-dismissible show flex items-center mb-2" role="alert"> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> {{ session()->get('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> <i data-feather="x" class="w-4 h-4"></i> </button> </div>
                    @endif

                        
                    <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
                        placeholder="Email" wire:model.defer="email">
                    @error('email')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="password"
                        class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-2"
                        placeholder="Password" wire:model.defer="password">
                    @error('password')
                        <span class="text-danger mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                </div>
                <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                        <input id="remember-me" type="checkbox" class="form-check-input border mr-2" wire:model.defer="remember_me">
                        <label class="cursor-pointer select-none" for="remember-me">Ingat Saya</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                        wire:click="login" wire:loading.attr="disabled">

                        <span wire:loading.remove>Masuk</span>
                            
                        <div wire:loading.flex style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
                            <svg width="25" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(226, 232, 240)" class="w-8 h-7">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                            </svg>
                        </div>
                    
                    </button>
                    
                    <a href="{{ route('registration') }}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Daftar</a>
                        
                </div>
                <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                    By signin up, you agree to our
                    <br>
                    <a class="text-theme-25 dark:text-theme-22" href="">Terms and Conditions</a> & <a
                        class="text-theme-25 dark:text-theme-22" href="">Privacy Policy</a>
                </div>
            </div>
        </div>
        <!-- END: Login Form -->
    </div>
</div>
<!-- BEGIN: Dark Mode Switcher-->
