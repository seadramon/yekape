@extends('layout')
@section('page-toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">About Us</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Corporate</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
    <!--begin::Actions-->
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <!--begin::Secondary button-->
        <!--end::Secondary button-->
        <!--begin::Primary button-->
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
        <!--end::Primary button-->
    </div>
    <!--end::Actions-->
@endsection
@section('content')
<!--begin::About card-->
<div class="card">
    <!--begin::Body-->
    <div class="card-body p-lg-17">
        <!--begin::About-->
        <div class="mb-18">
            <!--begin::Wrapper-->
            <div class="mb-10">
                <!--begin::Top-->
                <div class="text-center mb-15">
                    <!--begin::Title-->
                    <h3 class="fs-2hx text-dark mb-5">About Us</h3>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="fs-5 text-muted fw-semibold">Within the last 10 years, we have sold over 100,000 admin theme copies that have been
                    <br />successfully deployed by small businesses to global enterprises</div>
                    <!--end::Text-->
                </div>
                <!--end::Top-->
                <!--begin::Overlay-->
                <div class="overlay">
                    <!--begin::Image-->
                    <img class="w-100 card-rounded" src="assets/media/stock/1600x800/img-1.jpg" alt="" />
                    <!--end::Image-->
                    <!--begin::Links-->
                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                        <a href="../../demo1/dist/pages/pricing.html" class="btn btn-primary">Pricing</a>
                        <a href="../../demo1/dist/pages/careers/apply.html" class="btn btn-light-primary ms-3">Join Us</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Description-->
            <div class="fs-5 fw-semibold text-gray-600">
                <!--begin::Text-->
                <p class="mb-8">First, a disclaimer – the entire process of writing a blog post often takes more than a couple of hours, even if you can type eighty words per minute and your writing skills are sharp. From the seed of the idea to finally hitting “Publish,” you might spend several days or maybe even a week “writing” a blog post, but it’s important to spend those vital hours planning your post and even thinking about
                <a href="../../demo1/dist/pages/blog/post.html" class="link-primary pe-1">Your Post</a>(yes, thinking counts as working if you’re a blogger) before you actually write it.</p>
                <!--end::Text-->
                <!--begin::Text-->
                <p class="mb-8">There’s an old maxim that states,
                <span class="text-gray-800 pe-1">“No fun for the writer, no fun for the reader.”</span>No matter what industry you’re working in, as a blogger, you should live and die by this statement.</p>
                <!--end::Text-->
                <!--begin::Text-->
                <p class="mb-8">Before you do any of the following steps, be sure to pick a topic that actually interests you. Nothing – and
                <a href="../../demo1/dist/pages/blog/home.html" class="link-primary pe-1">I mean NOTHING</a>– will kill a blog post more effectively than a lack of enthusiasm from the writer. You can tell when a writer is bored by their subject, and it’s so cringe-worthy it’s a little embarrassing.</p>
                <!--end::Text-->
                <!--begin::Text-->
                <p class="mb-17">I can hear your objections already. “But Dan, I have to blog for a cardboard box manufacturing company.” I feel your pain, I really do. During the course of my career, I’ve written content for dozens of clients in some less-than-thrilling industries (such as financial regulatory compliance and corporate housing), but the hallmark of a professional blogger is the ability to write well about any topic, no matter how dry it may be. Blogging is a lot easier, however, if you can muster at least a little enthusiasm for the topic at hand.</p>
                <!--end::Text-->
            </div>
            <!--end::Description-->
        </div>
        <!--end::About-->
        <!--begin::Statistics-->
        <div class="card bg-light mb-18">
            <!--begin::Body-->
            <div class="card-body py-15">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center">
                    <!--begin::Items-->
                    <div class="d-flex flex-center flex-wrap mb-10 mx-auto gap-5 w-xl-900px">
                        <!--begin::Item-->
                        <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-lg-10">
                            <!--begin::Content-->
                            <div class="text-center">
                                <!--begin::Symbol-->
                                <i class="ki-duotone ki-element-11 fs-2tx text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="mt-1">
                                    <!--begin::Animation-->
                                    <div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                    <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="700">0</div>+</div>
                                    <!--end::Animation-->
                                    <!--begin::Label-->
                                    <span class="text-gray-600 fw-semibold fs-5 lh-0">Businesses</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-lg-10">
                            <!--begin::Content-->
                            <div class="text-center">
                                <!--begin::Symbol-->
                                <i class="ki-duotone ki-chart-pie-4 fs-2tx text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="mt-1">
                                    <!--begin::Animation-->
                                    <div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                    <div class="min-w-50px" data-kt-countup="true" data-kt-countup-value="80">0</div>K+</div>
                                    <!--end::Animation-->
                                    <!--begin::Label-->
                                    <span class="text-gray-600 fw-semibold fs-5 lh-0">Quick Reports</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-lg-10">
                            <!--begin::Content-->
                            <div class="text-center">
                                <!--begin::Symbol-->
                                <i class="ki-duotone ki-basket fs-2tx text-info">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="mt-1">
                                    <!--begin::Animation-->
                                    <div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex align-items-center">
                                    <div class="min-w-50px" data-kt-countup="true" data-kt-countup-value="35">0</div>M+</div>
                                    <!--end::Animation-->
                                    <!--begin::Label-->
                                    <span class="text-gray-600 fw-semibold fs-5 lh-0">Payments</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Testimonial-->
                <div class="fs-2 fw-semibold text-muted text-center mb-3">
                <span class="fs-1 lh-1 text-gray-700">“</span>When you care about your topic, you’ll write about it in a
                <br />
                <span class="text-gray-700 me-1">more powerful</span>, emotionally expressive way
                <span class="fs-1 lh-1 text-gray-700">“</span></div>
                <!--end::Testimonial-->
                <!--begin::Author-->
                <div class="fs-2 fw-semibold text-muted text-center">
                    <a href="../../demo1/dist/account/security.html" class="link-primary fs-4 fw-bold">Marcus Levy</a>
                    <span class="fs-4 fw-bold text-gray-600">,KeenThemes CEO</span>
                </div>
                <!--end::Author-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Statistics-->
        <!--begin::Section-->
        <div class="mb-16">
            <!--begin::Top-->
            <div class="text-center mb-12">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5">Publications</h3>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="fs-5 text-muted fw-semibold">Our goal is to provide a complete and robust theme solution
                <br />to boost all of our customer’s project deployments</div>
                <!--end::Text-->
            </div>
            <!--end::Top-->
            <!--begin::Row-->
            <div class="row g-10">
                <!--begin::Col-->
                <div class="col-md-4">
                    <!--begin::Publications post-->
                    <div class="card-xl-stretch me-md-6">
                        <!--begin::Overlay-->
                        <a class="d-block overlay mb-4" data-fslightbox="lightbox-hot-sales" href="assets/media/stock/600x400/img-73.jpg">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('assets/media/stock/600x400/img-73.jpg')"></div>
                            <!--end::Image-->
                            <!--begin::Action-->
                            <div class="overlay-layer bg-dark card-rounded bg-opacity-25">
                                <i class="ki-duotone ki-eye fs-2x text-white"></i>
                            </div>
                            <!--end::Action-->
                        </a>
                        <!--end::Overlay-->
                        <!--begin::Body-->
                        <div class="m-0">
                            <!--begin::Title-->
                            <a href="../../demo1/dist/pages/user-profile/overview.html" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel - How To Started the Dashboard Tutorial</a>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="fw-semibold fs-5 text-gray-600 text-dark mt-3 mb-5">We’ve been focused on making a the from also not been afraid to and step away been focused create eye</div>
                            <!--end::Text-->
                            <!--begin::Content-->
                            <div class="fs-6 fw-bold">
                                <!--begin::Author-->
                                <a href="../../demo1/dist/apps/projects/users.html" class="text-gray-700 text-hover-primary">Jane Miller</a>
                                <!--end::Author-->
                                <!--begin::Date-->
                                <span class="text-muted">on Mar 21 2021</span>
                                <!--end::Date-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Publications post-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-4">
                    <!--begin::Publications post-->
                    <div class="card-xl-stretch mx-md-3">
                        <!--begin::Overlay-->
                        <a class="d-block overlay mb-4" data-fslightbox="lightbox-hot-sales" href="assets/media/stock/600x400/img-74.jpg">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('assets/media/stock/600x400/img-74.jpg')"></div>
                            <!--end::Image-->
                            <!--begin::Action-->
                            <div class="overlay-layer bg-dark card-rounded bg-opacity-25">
                                <i class="ki-duotone ki-eye fs-2x text-white"></i>
                            </div>
                            <!--end::Action-->
                        </a>
                        <!--end::Overlay-->
                        <!--begin::Body-->
                        <div class="m-0">
                            <!--begin::Title-->
                            <a href="../../demo1/dist/pages/user-profile/overview.html" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel - How To Started the Dashboard Tutorial</a>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="fw-semibold fs-5 text-gray-600 text-dark mt-3 mb-5">We’ve been focused on making the from v4 to v5 but we have also not been afraid to step away been focused</div>
                            <!--end::Text-->
                            <!--begin::Content-->
                            <div class="fs-6 fw-bold">
                                <!--begin::Author-->
                                <a href="../../demo1/dist/apps/projects/users.html" class="text-gray-700 text-hover-primary">Cris Morgan</a>
                                <!--end::Author-->
                                <!--begin::Date-->
                                <span class="text-muted">on Apr 14 2021</span>
                                <!--end::Date-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Publications post-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-4">
                    <!--begin::Publications post-->
                    <div class="card-xl-stretch ms-md-6">
                        <!--begin::Overlay-->
                        <a class="d-block overlay mb-4" data-fslightbox="lightbox-hot-sales" href="assets/media/stock/600x400/img-47.jpg">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('assets/media/stock/600x400/img-47.jpg')"></div>
                            <!--end::Image-->
                            <!--begin::Action-->
                            <div class="overlay-layer bg-dark card-rounded bg-opacity-25">
                                <i class="ki-duotone ki-eye fs-2x text-white"></i>
                            </div>
                            <!--end::Action-->
                        </a>
                        <!--end::Overlay-->
                        <!--begin::Body-->
                        <div class="m-0">
                            <!--begin::Title-->
                            <a href="../../demo1/dist/pages/user-profile/overview.html" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">Admin Panel - How To Started the Dashboard Tutorial</a>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="fw-semibold fs-5 text-gray-600 text-dark mt-3 mb-5">We’ve been focused on making the from v4 to v5 but we’ve also not been afraid to step away been focused</div>
                            <!--end::Text-->
                            <!--begin::Content-->
                            <div class="fs-6 fw-bold">
                                <!--begin::Author-->
                                <a href="../../demo1/dist/apps/projects/users.html" class="text-gray-700 text-hover-primary">Carles Nilson</a>
                                <!--end::Author-->
                                <!--begin::Date-->
                                <span class="text-muted">on May 14 2021</span>
                                <!--end::Date-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Publications post-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Section-->
        <!--begin::Team-->
        <div class="mb-18">
            <!--begin::Heading-->
            <div class="text-center mb-12">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5">Our Great Team</h3>
                <!--end::Title-->
                <!--begin::Sub-title-->
                <div class="fs-5 text-muted fw-semibold">It’s no doubt that when a development takes longer to complete, additional costs to
                <br />integrate and test each extra feature creeps up and haunts most of us.</div>
                <!--end::Sub-title=-->
            </div>
            <!--end::Heading-->
            <!--begin::Slider-->
            <div class="tns tns-default mb-10">
                <!--begin::Wrapper-->
                <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000" data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true" data-tns-nav="false" data-tns-items="1" data-tns-center="false" data-tns-dots="false" data-tns-prev-button="#kt_team_slider_prev" data-tns-next-button="#kt_team_slider_next" data-tns-responsive="{1200: {items: 3}, 992: {items: 2}}">
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-1.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">Paul Miles</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">Development Lead</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-2.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">Melisa Marcus</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">Creative Director</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-5.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">David Nilson</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">Python Expert</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-20.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">Anne Clarc</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">Project Manager</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-23.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">Ricky Hunt</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">Art Director</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-12.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">Alice Wayde</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">Marketing Manager</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-contain bgi-position-center" style="background-image:url('assets/media/avatars/300-9.jpg')"></div>
                        <!--end::Photo-->
                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-dark fw-bold text-hover-primary fs-3">Carles Puyol</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">QA Managers</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev">
                    <i class="ki-duotone ki-left fs-3x"></i>
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next">
                    <i class="ki-duotone ki-right fs-3x"></i>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Slider-->
        </div>
        <!--end::Team-->
        <!--begin::Card-->
        <div class="card mb-4 bg-light text-center">
            <!--begin::Body-->
            <div class="card-body py-12">
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
                <!--begin::Icon-->
                <a href="#" class="mx-4">
                    <img src="assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2" alt="" />
                </a>
                <!--end::Icon-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Body-->
</div>
<!--end::About card-->
@endsection
@section('css')
    
@endsection
@section('js')
    
@endsection