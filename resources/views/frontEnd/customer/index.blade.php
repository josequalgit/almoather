@extends('frontEnd.layouts.index')
@section('content')
<section class="background-page10 position-relative py-5">
        
    <div class="py-5">
        <div class="contract text-center">
            <h1>{{ trans('messages.frontEnd.welcome_back') }}</h1>
            <p>{{ auth()->user()->customers->full_name }}</p>
        </div>
    </div>
    <div class="position-absolute flower">
        <img src="assets/img/Group 55162.png" alt="" width="260px">
    </div>
 </section>

 <section  class="section-contract">
    <div class="min-height-100">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-lg-12 col-md-12 col-sm-12   mt-5 ">
                <ul class="nav nav-pills  justify-content-between text-center" id="pills-tab" role="tablist" >
                    <li class="nav-item content-button col-md-3 col-6 " role="presentation ">
                        <button class="nav-link btn btn-none active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ trans('messages.frontEnd.active') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation">
                        <button class="nav-link btn btn-none" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{ trans('messages.frontEnd.pending') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation ">
                        <button class="nav-link btn btn-none" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ trans('messages.frontEnd.rejected') }}</button>
                      </li>
                      <li class="nav-item content-button col-md-3 col-6" role="presentation">
                        <button class="nav-link btn btn-none" id="pills-Canceled-tab" data-bs-toggle="pill" data-bs-target="#pills-Canceled" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">{{ trans('messages.frontEnd.finished') }}</button>
                    </li>
                  </ul>
                  <div class="container">
                    <div class="tab-content " id="pills-tabContent">
                        <div class="tab-pane ul-content fade show active w-40" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                           
                              <div id="ad-content" class="row text-center mt-3 ads-container">
                            
                              </div>
                              <div class="mt-3 col text-center">
                                <button class="btn btn-primary w-50 load-more-button">
                                    {{ trans('messages.frontEnd.more') }}
                                </button>
                              </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                        <div class="tab-pane fade" id="pills-Canceled" role="tabpanel" aria-labelledby="pills-Canceled-tab">...</div>
                      </div>
                  </div>
                  
             </div>
          </div>
       
        </div>
      </div>
  
  </section>
@endsection

@section('scripts')
<script>
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    getAds('Pending');
    // getFakeAds();


    function getFakeAds()
    {
        let ads = [
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
            {
                "id": 1,
                "image": [],
                "videos": [],
                "cr_certificate": [],
                "cr_image": {
                    "id": 267,
                    "url": "https://almuaathir.josequal.net//storage/267/IndependenceDay.pdf"
                },
                "campaign_goal": {
                    "id": 6,
                    "title": "حملات التبرع الخيرية"
                },
                "logo": {
                    "id": 269,
                    "url": "https://almuaathir.josequal.net//storage/269/1200px-Albaik_logo.svg.png"
                },
                "store_name": "البيك",
                "marouf_num": "123",
                "store_link": "https://www.facebook.com",
                "prefired": [
                    {
                        "id": 4,
                        "url": "https://almuaathir.josequal.net//storage/4/snapchat.png"
                    },
                    {
                        "id": 6,
                        "url": "https://almuaathir.josequal.net//storage/6/tiktok.png"
                    }
                ],
                "media_accounts": [
                    {
                        "id": 4,
                        "image": "https://almuaathir.josequal.net//storage/4/snapchat.png",
                        "link": "https://snapchat.com/https://snapchat.com/www.snapchat.com"
                    },
                    {
                        "id": 6,
                        "image": "https://almuaathir.josequal.net//storage/6/tiktok.png",
                        "link": "https://tiktok.com/https://tiktok.com/https://tiktok.com/dgh is"
                    }
                ],
                "cr_num": "123",
                "about": "انت مش عايز حد من الشباب اللي رح تكون عارف ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا",
                "relation": "",
                "category": "الخدمات الاكاديمية والتصاميم",
                "scenario": null,
                "influencer": null,
                "budget": 286000,
                "format_budget": "286,000",
                "date": "28/06/2022",
                "start_date": null,
                "end_date": null,
                "type": "عن بعد",
                "price": null,
                "website_link": null,
                "about_product": "ليش هيك ما رح تقدر تقول لي لا يزم مرحبا مليون دولار مرحبا مليون دولار مرحبا مليون دولار مرحبا اللي في الصوره",
                "country": {
                    "id": 1,
                    "name": "المملكة العربية السعودية"
                },
                "city": {
                    "id": 25,
                    "name": "مكة المكرمة"
                },
                "area": {
                    "id": 2,
                    "name": "مكة المكرمة"
                },
                "location": "المملكة العربية السعودية, مكة المكرمة, مكة المكرمة",
                "customer_id": 1,
                "isVat": 1,
                "discount_code": null,
                "hasStore": false,
                "is_onSite": "عن بعد",
                "tax_value": "128522845",
                "reject_note": null,
                "admin_approved_influencers": false,
                "executionDate": null,
                "camp_link": null,
                "status": "approve",
                "messages": {
                    "label_text": "Waiting for first payment",
                    "button_text": "Pay First Payment"
                }
            },
        ]
        for (let index = 0; index < ads.length; index++) {
            const element = ads[index];
            let div = `<div class="col-sm-4 mt-2">
                                  <div class="card background-box-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col text-end">
                                                <img src="${element.logo.url}" alt="" width="60px" height="60px">
                                            </div>
                                            <div class="col text-start above-text">
                                                <p >${element.store_name}</p>  
                                                <span>${element.product_type ?? ''}</span>  
                                            </div>
                                            <hr class="mt-2 hr-content" width="80px">
                                            <div class="col text-start left-text">
                                                <p>${element.is_onSite}</p>  
                                                <span>${element.country.name}</span>   
                                            </div>
                                            <div class="col text-end right-text">
                                                <p>${element.budget}</p>  
                                                <span>(${element.date})</span>  
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
            `

            $("#ad-content").append(div)
        }
    }
    let page_number = 0;
    /** FOR GETTING ADS **/
    function getAds(status)
    {
        let route = '{{ route("getAdsApi",":status") }}';
        let add_status = route.replace(':status',status);
        console.log(add_status)
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url:add_status,
            beforeSend: function (xhr) {
                 xhr.setRequestHeader('Authorization', `Bearer ${localStorage.getItem('token')}`);
            },
            type:'GET',
            success:(res)=>{
             console.log('response: ',res)
            },
            error:(err)=>{
                console.log('error: ',err)
            }
        })
    }

    /** Pagination function **/
    function getNextPage()
    {
        let route = '{{ route("getAdsApi",":status") }}';
        $.ajax({
            url:add_status+'?page='+page_number,
            type:'GET',
            dataType: 'json', 
            success:(res)=>{
             console.log('response: ',res)
            },
            error:(err)=>{
                console.log('error: ',err)
                alert('here')
            }
        })
    }
</script>
@endsection