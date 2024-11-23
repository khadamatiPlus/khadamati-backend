<!DOCTYPE html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ appName() }} | @yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset("assets/img/favicon.png")}}" rel="icon">
    <link href="{{asset("assets/img/apple-touch-icon.png")}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset("assets/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/icofont/icofont.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/boxicons/css/boxicons.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/owl.carousel/assets/owl.carousel.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/venobox/venobox.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/aos/aos.css")}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset("assets/css/style.css")}}" rel="stylesheet">


</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center">

        <div class="logo  @if(app()->getLocale() == 'ar') ml-auto @else mr-auto @endif">
            <h1 class="text-light"><a href="/">Khadamati APP</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="/">{{__("Home")}}</a></li>
                <li><a href="#features">{{__("App Features")}}</a></li>
                <li><a href="#gallery">{{__("Gallery")}}</a></li>
                <li><a href="#faq">{{__("F.A.Q")}}</a></li>
                <li><a href="#contact">{{__("Contact Us")}}</a></li>
                @if(config('boilerplate.locale.status') && count(config('boilerplate.locale.languages')) > 1)
                    @if(app()->getLocale() == 'ar')
                        <li><a href="{{route('locale.change', 'en')}}">EN</a></li>
                    @else
                        <li><a href="{{route('locale.change', 'ar')}}">Ar</a></li>
                    @endif
                @endif

                <li class="get-started"><a href="#features">{{__("Get Started")}}</a></li>
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center " data-aos="fade-up">
                <div>
                    <h1>{{__("One platform, a world of opportunities.")}}</h1>
                    <h2>{{__("Easily publish your services on the Khadamati app and make them visible to thousands of users via the services review app. Get started now and start your journey to success!")}}</h2>
                    <a href="#" class="download-btn"><i class="bx bxl-play-store"></i> {{__("Google Play")}}</a>
                    <a href="#" class="download-btn"><i class="bx bxl-apple"></i> {{__("App Store")}}</a>
                </div>
            </div>
            <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
                <img src="{{asset("assets/img/hero-img.png")}}" class="img-fluid" alt="">
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
        <div class="container">

            <div class="section-title">
                <h2>{{__("App Features")}}</h2>
                <p>{{__("Discover the power of Khadamati! Whether you're offering services or searching for them, our app makes the process seamless, efficient, and accessible for everyone.")}}</p>
            </div>

            <div class="row no-gutters">
                <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
                    <div class="content d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-6 icon-box" data-aos="fade-up">
                                <i class="bx bx-upload"></i>
                                <h4>{{__("Easy Service Posting")}}</h4>
                                <p>{{__("Post your services with just a few clicks, complete with details, images, and pricing.")}}</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-search-alt"></i>
                                <h4>{{__("Powerful Search")}}</h4>
                                <p>{{__("Search for services by category, location, or keywords to find exactly what you need.")}}</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                <i class="bx bx-user"></i>
                                <h4>{{__("User Profiles")}}</h4>
                                <p>{{__("View detailed profiles of service providers to make informed decisions.")}}</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                <i class="bx bx-star"></i>
                                <h4>{{__("Ratings and Reviews")}}</h4>
                                <p>{{__("Check reviews and ratings from other users to ensure the quality of services.")}}</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                <i class="bx bx-bell"></i>
                                <h4>{{__("Instant Notifications")}}</h4>
                                <p>{{__("Receive real-time notifications about new services, requests, and updates.")}}</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                <i class="bx bx-wallet"></i>
                                <h4>{{__("Secure Transactions")}}</h4>
                                <p>{{__("Ensure safe and secure payment options for both providers and customers.")}}</p>
                            </div>
                        </div>
                    </div>
                </div>


            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                    <img src="{{asset("assets/img/features.svg")}}" class="img-fluid" alt="">
                </div>
            </div>

        </div>
    </section><!-- End App Features Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
        <div class="container">

            <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <img src="{{asset('assets/img/details-1.png')}}" class="img-fluid" alt="{{__('Easy Service Posting')}}">
                </div>
                <div class="col-md-8 pt-4" data-aos="fade-up">
                    <h3>{{__('Post Your Services with Ease')}}</h3>
                    <p class="font-italic">
                        {{__('Khadamaty simplifies the process of sharing your services, enabling you to reach potential customers efficiently.')}}
                    </p>
                    <ul>
                        <li><i class="icofont-check"></i> {{__('Add detailed descriptions and images of your services.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Easily categorize your services for better visibility.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Manage your postings with a user-friendly dashboard.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Reach a broad audience in just a few clicks.')}}</li>
                    </ul>
                    <p>
                        {{__('Whether you\'re offering professional services or personal assistance, Khadamaty helps you connect with the right audience effortlessly.')}}
                    </p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="{{asset('assets/img/details-2.png')}}" class="img-fluid" alt="{{__('Discover Services')}}">
                </div>
                <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                    <h3>{{__('Discover Services Near You')}}</h3>
                    <p class="font-italic">
                        {{__('Find the services you need quickly and efficiently, tailored to your preferences and location.')}}
                    </p>
                    <p>
                        {{__('With advanced filtering options, you can search for services based on category, location, or keywords. Access a wide range of reliable service providers.')}}
                    </p>
                    <p>
                        {{__('Get detailed profiles, reviews, and ratings to ensure the best experience. Khadamaty brings services closer to you.')}}
                    </p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <img src="{{asset('assets/img/details-3.png')}}" class="img-fluid" alt="{{__('Seamless Communication')}}">
                </div>
                <div class="col-md-8 pt-5" data-aos="fade-up">
                    <h3>{{__('Connect and Communicate')}}</h3>
                    <p>{{__('Khadamaty makes communication simple and efficient, enabling seamless interaction between service providers and customers.')}}</p>
                    <ul>
                        <li><i class="icofont-check"></i> {{__('Built-in chat system for direct communication.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Notifications for updates and responses.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Easy-to-use messaging interface for a smooth experience.')}}</li>
                    </ul>
                    <p>
                        {{__('Whether you’re inquiring about a service or finalizing details, our communication tools are designed to save time and reduce effort.')}}
                    </p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="{{asset('assets/img/details-4.png')}}" class="img-fluid" alt="{{__('Reliable Experience')}}">
                </div>
                <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                    <h3>{{__('Built for Reliability')}}</h3>
                    <p class="font-italic">
                        {{__('Our app is designed to provide a secure, trustworthy platform for both service providers and seekers.')}}
                    </p>
                    <p>
                        {{__('With robust features and user-friendly navigation, Khadamaty ensures a smooth and reliable experience for everyone.')}}
                    </p>
                    <ul>
                        <li><i class="icofont-check"></i> {{__('Verified service provider profiles.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Regular updates for optimal performance.')}}</li>
                        <li><i class="icofont-check"></i> {{__('Responsive support for resolving issues.')}}</li>
                    </ul>
                </div>
            </div>

        </div>
    </section><!-- End Details Section -->



    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery" style="direction: ltr">
        <div class="container">

            <div class="section-title">
                <h2>{{__("Gallery")}}</h2>
                <p>{{__("Explore our curated collection showcasing the incredible services and experiences offered by our trusted providers. From inspiring work samples to customer highlights, our gallery reflects the dedication and quality you can expect from Khadamati.")}}</p>
            </div>


            <div class="owl-carousel gallery-carousel" data-aos="fade-up">
                <a href="{{asset("assets/img/gallery/gallery-1.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-1.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-2.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-2.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-3.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-3.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-4.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-4.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-5.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-5.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-6.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-6.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-7.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-7.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-8.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-8.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-9.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-9.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-10.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-10.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-11.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-11.png" alt=""></a>
                <a href="{{asset("assets/img/gallery/gallery-12.png")}}" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-12.png" alt=""></a>
            </div>

        </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg" style="direction: ltr">
        <div class="container">

            <div class="section-title">
                <h2>{{__('Testimonials')}}</h2>
                <p>{{__('Listen to what our clients and partners have to say about their experience with us. These testimonials reflect our commitment to quality and excellence in service delivery.')}}</p>
            </div>

            <div class="owl-carousel testimonials-carousel" data-aos="fade-up">

                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                        <h3>{{__('Ahmed Al-Hussein')}}</h3>
                        <h4>{{__('Entrepreneur')}}</h4>
                        <p>
                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{__('My experience with their services was incredible! The team is professional and pays attention to every detail. I highly recommend them.')}}
                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                    </div>
                </div>

                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                        <h3>{{__('Fatima Al-Sayed')}}</h3>
                        <h4>{{__('Designer')}}</h4>
                        <p>
                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{__('Working with them was a fantastic experience. Their attention to detail and customer care are unmatched in the industry. Truly exceptional service!')}}
                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                    </div>
                </div>

                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                        <h3>{{__('Omar Al-Farsi')}}</h3>
                        <h4>{{__('Business Owner')}}</h4>
                        <p>
                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{__('I have worked with many service providers, but none compare to the professionalism and quality of work these guys provide. Highly recommend them!')}}
                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                    </div>
                </div>

                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                        <h3>{{__('Layla Al-Mansoori')}}</h3>
                        <h4>{{__('Freelancer')}}</h4>
                        <p>
                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{__('Their service was beyond what I expected. From communication to delivery, everything was smooth and efficient. I couldn\'t ask for better results.')}}
                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                    </div>
                </div>

                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                        <h3>{{__('Hassan Al-Jabri')}}</h3>
                        <h4>{{__('Entrepreneur')}}</h4>
                        <p>
                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{__('I am extremely satisfied with the work they delivered. Their professionalism and attention to detail helped me achieve my goals faster than expected.')}}
                            <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Testimonials Section -->



    <!-- ======= Pricing Section ======= -->
{{--    <section id="pricing" class="pricing">--}}
{{--        <div class="container">--}}

{{--            <div class="section-title">--}}
{{--                <h2>Pricing</h2>--}}
{{--                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>--}}
{{--            </div>--}}

{{--            <div class="row no-gutters">--}}

{{--                <div class="col-lg-4 box" data-aos="fade-right">--}}
{{--                    <h3>Free</h3>--}}
{{--                    <h4>$0<span>per month</span></h4>--}}
{{--                    <ul>--}}
{{--                        <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>--}}
{{--                        <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>--}}
{{--                        <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>--}}
{{--                        <li class="na"><i class="bx bx-x"></i> <span>Pharetra massa massa ultricies</span></li>--}}
{{--                        <li class="na"><i class="bx bx-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>--}}
{{--                    </ul>--}}
{{--                    <a href="#" class="get-started-btn">Get Started</a>--}}
{{--                </div>--}}

{{--                <div class="col-lg-4 box featured" data-aos="fade-up">--}}
{{--                    <h3>Business</h3>--}}
{{--                    <h4>$29<span>per month</span></h4>--}}
{{--                    <ul>--}}
{{--                        <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>--}}
{{--                        <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>--}}
{{--                        <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>--}}
{{--                        <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>--}}
{{--                        <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>--}}
{{--                    </ul>--}}
{{--                    <a href="#" class="get-started-btn">Get Started</a>--}}
{{--                </div>--}}

{{--                <div class="col-lg-4 box" data-aos="fade-left">--}}
{{--                    <h3>Developer</h3>--}}
{{--                    <h4>$49<span>per month</span></h4>--}}
{{--                    <ul>--}}
{{--                        <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>--}}
{{--                        <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>--}}
{{--                        <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>--}}
{{--                        <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>--}}
{{--                        <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>--}}
{{--                    </ul>--}}
{{--                    <a href="#" class="get-started-btn">Get Started</a>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}
{{--    </section><!-- End Pricing Section -->--}}

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg" >
        <div class="container">

            <div class="section-title">
                <h2>{{ __("Frequently Asked Questions") }}</h2>
                <p>{{ __("Here are some of the most common questions we get. If you don’t find what you’re looking for, feel free to reach out to us directly.") }}</p>
            </div>

            <div class="accordion-list">
                <ul>
                    <li data-aos="fade-up">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-toggle="collapse" class="collapse" href="#accordion-list-1">
                            {{ __("What is the typical timeline for project completion?") }}
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="accordion-list-1" class="collapse show" data-parent=".accordion-list">
                            <p>
                                {{ __("The timeline for project completion varies depending on the scope and complexity of the project. Generally, small projects can be completed in 2-4 weeks, while larger projects may take 6-8 weeks or more.") }}
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-toggle="collapse" href="#accordion-list-2" class="collapsed">
                            {{ __("How can I get a quote for my project?") }}
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="accordion-list-2" class="collapse" data-parent=".accordion-list">
                            <p>
                                {{ __("To get a quote, simply fill out our online contact form or give us a call. We’ll review your requirements and provide you with a custom proposal tailored to your needs.") }}
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="200">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-toggle="collapse" href="#accordion-list-3" class="collapsed">
                            {{ __("What types of services do you offer?") }}
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="accordion-list-3" class="collapse" data-parent=".accordion-list">
                            <p>
                                {{ __("We offer a wide range of services including web development, digital marketing, branding, graphic design, and more. We work with businesses of all sizes to help them grow and succeed online.") }}
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="300">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-toggle="collapse" href="#accordion-list-4" class="collapsed">
                            {{ __("Do you provide ongoing support after the project is completed?") }}
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="accordion-list-4" class="collapse" data-parent=".accordion-list">
                            <p>
                                {{ __("Yes, we offer ongoing support and maintenance services after the project is completed. We’re here to ensure everything runs smoothly and to address any issues that may arise.") }}
                            </p>
                        </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                        <i class="bx bx-help-circle icon-help"></i>
                        <a data-toggle="collapse" href="#accordion-list-5" class="collapsed">
                            {{ __("Can I request a custom design or feature for my project?") }}
                            <i class="bx bx-chevron-down icon-show"></i>
                            <i class="bx bx-chevron-up icon-close"></i>
                        </a>
                        <div id="accordion-list-5" class="collapse" data-parent=".accordion-list">
                            <p>
                                {{ __("Absolutely! We specialize in creating custom designs and features tailored to your specific needs. Let us know what you have in mind, and we’ll work with you to bring your vision to life.") }}
                            </p>
                        </div>
                    </li>

                </ul>
            </div>

        </div>
    </section><!-- End Frequently Asked Questions Section -->




    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>{{__("Contact Us")}}</h2>
                <p>{{__("We are based in Amman, Jordan, and would love to hear from you. Whether you have a question, need assistance, or want to discuss a project, don't hesitate to get in touch with us.")}}</p>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="contact-info">
                        <h3>{{__("Our Office")}}</h3>
                        <p><strong>{{__("Location:")}}</strong> {{__("Amman, Jordan")}}</p>
                        <p><strong>{{__("Phone:")}}</strong> +962 6 123 4567</p>
                        <p><strong>{{__("Email:")}}</strong> contact@yourcompany.com</p>
                        <p><strong>{{__("Working Hours:")}}</strong> {{__("Sunday - Thursday, 9:00 AM - 5:00 PM")}}</p>
                        <p>{{__("Feel free to visit us during business hours or reach out by phone or email. We’ll be happy to assist you!")}}</p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form action="" method="post" role="form" class="php-email-form">
                        <div class="form-group">
                            <input placeholder="{{__('Your Email')}}" type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="{{__('Please enter a valid email')}}" />
                            <div class="validate"></div>
                        </div>
                        <div class="form-group">
                            <input placeholder="{{__('Subject')}}" type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="{{__('Please enter at least 4 chars of subject')}}" />
                            <div class="validate"></div>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="{{__('Message')}}" class="form-control" name="message" rows="5" data-rule="required" data-msg="{{__('Please write something for us')}}"></textarea>
                            <div class="validate"></div>
                        </div>
                        <div class="mb-3">
                            <div class="loading">{{__('Loading')}}</div>
                            <div class="error-message"></div>
                            <div class="sent-message">{{__('Your message has been sent. Thank you!')}}</div>
                        </div>
                        <div class="text-center"><button type="submit">{{__('Send Message')}}</button></div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->



</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-newsletter" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h4>{{__("Join Our Newsletter")}}</h4>
                    <p>{{__("Stay updated with the latest news, offers, and updates from our team here in Amman, Jordan.")}}</p>
                    <form action="" method="post">
                        <input type="email" name="email" placeholder="{{__('Enter your email')}}">
                        <input type="submit" value="{{__('Subscribe')}}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 footer-contact" data-aos="fade-up">
                    <h3>{{__("Kadamati App")}}</h3>
                    <p>
                        {{__("123 Main Street, Tabarbur")}} <br>
                        {{__("Amman, Jordan 11118")}}<br>
                        {{__("Jordan")}} <br><br>
                        <strong>{{__("Phone:")}}</strong> +962 6 123 4567<br>
                        <strong>{{__("Email:")}}</strong> contact@yourcompany.com<br>
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 footer-links" data-aos="fade-up" data-aos-delay="100">
                    <h4>{{__("Useful Links")}}</h4>
                    <ul>
                        <li><i class="bx  @if(app()->getLocale() == 'ar')bx-chevron-left @else bx-chevron-right @endif"></i> <a href="/">{{__("Home")}}</a></li>
                        <li><i class="bx @if(app()->getLocale() == 'ar')bx-chevron-left @else bx-chevron-right @endif"></i> <a href="#features">{{__("App Features")}}</a></li>
                        <li><i class="bx @if(app()->getLocale() == 'ar')bx-chevron-left @else bx-chevron-right @endif"></i> <a href="#gallery">{{__("Gallery")}}</a></li>
                        <li><i class="bx @if(app()->getLocale() == 'ar')bx-chevron-left @else bx-chevron-right @endif"></i> <a href="#faq">{{__("F.A.Q")}}</a></li>
                        <li><i class="bx @if(app()->getLocale() == 'ar')bx-chevron-left @else bx-chevron-right @endif"></i> <a href="#contact">{{__("Contact Us")}}</a></li>
                    </ul>
                </div>



                <div class="col-lg-4 col-md-6 footer-links" data-aos="fade-up" data-aos-delay="300">
                    <h4>{{__("Our Social Networks")}}</h4>
                    <p>{{__("Follow us on social media for the latest updates and news!")}}</p>
                    <div class="social-links mt-3">
                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="copyright">
            &copy; {{__("Copyright")}} <strong><span>{{__("Khadamati App")}}</span></strong>. {{__("All Rights Reserved.")}}
        </div>
    </div>
</footer><!-- End Footer -->


<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->
<script src="{{asset("assets/vendor/jquery/jquery.min.js")}}"></script>
<script src="{{asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("assets/vendor/jquery.easing/jquery.easing.min.js")}}"></script>
<script src="{{asset("assets/vendor/php-email-form/validate.js")}}"></script>
<script src="{{asset("assets/vendor/owl.carousel/owl.carousel.min.js")}}"></script>
<script src="{{asset("assets/vendor/venobox/venobox.min.js")}}"></script>
<script src="{{asset("assets/vendor/aos/aos.js")}}"></script>

<!-- Template Main JS File -->
<script src="{{asset("assets/js/main.js")}}"></script>

</body>

</html>
