<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Page;
use Alert;
class FrontEndSettingController extends Controller
{
   

    private $tabsName = [
        'welcome_message'=>[
            'title'=>'Welcome message',
            'type'=>'welcome_page'
        ],
        'about_us'=>[
            'title'=>'About Us',
            'type'=>'about_us'
        ],
        'faq'=>[
            'title'=>'Faq',
            'type'=>'faq',
        ],
        'contact_us'=>[
            'title'=>'Contact Us',
            'type'=>'contact_info',
        ],
        'website_description'=>[
            'title'=>'Website Description',
            'type'=>'website_description',
        ],
        'login_text'=>[
            'title'=>'Login Text',
            'type'=>'login_text',
        ],
        'register_type'=>[
            'title'=>'Register type',
            'type'=>'register_type',
        ],
        'get_touch'=>[
            'title'=>'Get in touch us',
            'type'=>'get_touch',
        ],
        'location'=>[
            'title'=>'Location',
            'type'=>'location',
        ],
        'our-services'=>[
            'title'=>'Our Services',
            'type'=>'our-services',
        ],

    ];


    public function index($type = 'welcome_page')
    {
        $setting = AppSetting::where('key','welcome_page')->first();
        $data =  json_decode($setting->value);
        $data_contact = null;
        $contact_info = null;
        $appSettingInfo = null;
        $data = Page::where('slug',$type)->first();

        if($type != 'welcome_page')
        {

            if(!$data) 
            {
                $this->create_page($type);
              
            }
                $data_contact = AppSetting::where('key',$type)->first();
                if($data_contact) $appSettingInfo = json_decode($data_contact->value);
        }
        else
        {
            $data_contact = AppSetting::where('key',$type)->first();
            if($data_contact) $appSettingInfo = json_decode($data_contact->value);

        }
        $tabNames = $this->tabsName;
        return view('dashboard.frontEndSetting.index',compact('data','tabNames','type','appSettingInfo','data_contact'));
    }

    public function updateWelcomePage(Request $request)
    {
        $data = AppSetting::where('key','welcome_page')->first();
        if(!$data)
        {
            AppSetting::create([
                'key'=>'welcome_page',
                'value'=>json_encode([
                    'title'=>[
                        'ar'=>$request->title_ar,
                        'en'=>$request->title_en,
                    ],
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en
                    ]
                ])
            ]);
        }
        else
        {
            $data->update([
                'key'=>'welcome_page',
                'value'=>json_encode([
                    'title'=>[
                        'ar'=>$request->title_ar,
                        'en'=>$request->title_en,
                    ],
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en,
                    ]
             ])
            ]);
        }

        return back();

    }

    public function updateBriefAboutUs(Request $request)
    {
        $data = Page::where('slug','about_us')->first();
        if(!$data)
        {
            Page::create([
                'title'=>[
                    'ar'=>$request->title_ar,
                    'en'=>$request->title_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ],
                'content'=>json_encode([
                    'section_one'=>[
                        'title_ar'=>$request->title_ar_section_one,
                        'title_en'=>$request->title_en_section_one,
                        'description_ar'=>$request->description_ar_section_one,
                        'description_en'=>$request->description_en_section_one,
                    ],
                    'section_two'=>[
                        'title_ar'=>$request->title_ar_section_two,
                        'title_en'=>$request->title_en_section_two,
                        'description_ar'=>$request->description_ar_section_two,
                        'description_en'=>$request->description_en_section_two,
                    ],
                    ]),
                'slug'=>'about_us'
            ]);
        }
        else
        {
            $data->update([
                'title'=>[
                    'ar'=>$request->title_ar,
                    'en'=>$request->title_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ],
                'content'=>json_encode([
                    'section_one'=>[
                        'title_ar'=>$request->title_ar_section_one,
                        'title_en'=>$request->title_en_section_one,
                        'description_ar'=>$request->description_ar_section_one,
                        'description_en'=>$request->description_en_section_one,
                    ],
                    'section_two'=>[
                        'title_ar'=>$request->title_ar_section_two,
                        'title_en'=>$request->title_en_section_two,
                        'description_ar'=>$request->description_ar_section_two,
                        'description_en'=>$request->description_en_section_two,
                    ],
                    ]),
            ]);
        }
        if($request->hasFile('image'))
        {
            $data->clearMediaCollection('image');
            $data->addMedia($request->file('image'))
            ->toMediaCollection('image');
        }
        if($request->hasFile('header_image'))
        {
            $data->clearMediaCollection('aboutUsHeader');
            $data->addMedia($request->file('header_image'))
            ->toMediaCollection('aboutUsHeader');
        }
        if($request->hasFile('section_one_image'))
        {
            $data->clearMediaCollection('aboutUsSectionOneImage');
            $data->addMedia($request->file('section_one_image'))
            ->toMediaCollection('aboutUsSectionOneImage');
        }
        if($request->hasFile('section_two_image'))
        {
            $data->clearMediaCollection('aboutUsSectionOneImage');
            $data->addMedia($request->file('section_two_image'))
            ->toMediaCollection('aboutUsSectionTwoImage');
        }
        return back();
        
    }

    public function updateFaq(Request $request)
    {
        $data = Page::where('slug','faq')->first();
        if(!$data)
        {
            Page::create([
                'title'=>[
                    'ar'=>$request->title_ar,
                    'en'=>$request->title_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ],
                'slug'=>'faq'
            ]);
        }
        else
        {
            $data->update([
                'title'=>[
                    'ar'=>$request->title_ar,
                    'en'=>$request->title_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ],
            ]);
        }
        return back();
    }
    public function updateContactUs(Request $request)
    {
        $data = Page::where('slug','contact_us')->first();
        if(!$data)
        {
            Page::create([
                'title'=>[
                    'ar'=>$request->title_ar,
                    'en'=>$request->title_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ],
                'slug'=>'contact_us'
            ]);
        }
        else
        {
            $data->update([
                'title'=>[
                    'ar'=>$request->title_ar,
                    'en'=>$request->title_en,
                ],
                'description'=>[
                    'ar'=>$request->description_ar,
                    'en'=>$request->description_en,
                ],
            ]);
        }

       
            $settingContactInfo = AppSetting::where('key','contact_info')->first();
            if(!$settingContactInfo)
            {
                AppSetting::create([
                    'key'=>'contact_info',
                    'value'=>json_encode([
                        'phone'=>$request->phone,
                        'location'=>$request->location,
                        'email'=>$request->email,
                    ])
                ]);
            }
            else
            {
                $settingContactInfo->update([
                    'value'=>json_encode([
                        'phone'=>$request->phone,
                        'location'=>$request->location,
                        'email'=>$request->email,
                    ])
                ]);
        }




        
        return back();
    }

    public function updateWebsiteDescription(Request $request)
    {
        $data = AppSetting::where('key','website_description')->first();
        if(!$data)
        {
            AppSetting::create([
                'key'=>'website_description',
                'value'=>json_encode([
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en
                    ]
                ])
            ]);
        }
        else
        {
            $data->update([
                'key'=>'website_description',
                'value'=>json_encode([
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en
                    ]
                ])
            ]);
        }

        return back();
    }
    public function registerType(Request $request)
    {
        $data = AppSetting::where('key','register_type')->first();
        if(!$data)
        {
            AppSetting::create([
                'key'=>'register_type',
                'value'=>json_encode([
                    'title'=>[
                        'ar'=>$request->title_ar,
                        'en'=>$request->title_en
                    ],
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en
                    ]
                ])
            ]);
        }
        else
        {
            $data->update([
                'key'=>'register_type',
                'value'=>json_encode([
                    'title'=>[
                        'ar'=>$request->title_ar,
                        'en'=>$request->title_en
                    ],
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en
                    ]
                ])
            ]);
        }

        return back();
    }


    public function updateLoginText(Request $request)
    {
        $data = AppSetting::where('key','login_text')->first();
        if(!$data)
        {
            AppSetting::create([
                'key'=>'login_text',
                'value'=>json_encode([
                    'title'=>[
                        'ar'=>$request->title_ar,
                        'en'=>$request->title_en,
                    ],
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en
                    ]
                ])
            ]);
        }
        else
        {
            $data->update([
                'key'=>'login_text',
                'value'=>json_encode([
                    'title'=>[
                        'ar'=>$request->title_ar,
                        'en'=>$request->title_en,
                    ],
                    'description'=>[
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en,
                    ]
             ])
            ]);
        }

        return back();
    }

    public function updateMapLink(Request $request)
    {
        $data = AppSetting::where('key','location')->first();
        if(!$data)
        {
            AppSetting::create([
                'key'=>'location',
                'value'=>json_encode(['link'=>$request->link])
            ]);
        }
        else
        {
            $data->update([
                'value'=>json_encode(['link'=>$request->link])
            ]);
        }

        return back();
    }

    private function create_page($slug)
    {
        $data = Page::create([
            'title'=>[
                'ar'=>'test',
                'en'=>'test',
            ],
            'description'=>[
                'ar'=>'test',
                'en'=>'test',
            ],
            'slug'=>$slug
        ]);

        return $data;
    }

    public function update_services(Request $request)
    {
        $page = Page::where('slug','our-services')->first();

        if($request->hasFile('header_image'))
        {
            $page->clearMediaCollection('service_header_image');
            $page->addMedia($request->file('header_image'))
            ->toMediaCollection('service_header_image');
        }
        if($request->hasFile('second_section_image_one'))
        {
            $page->clearMediaCollection('service_second_section_image_one');
            $page->addMedia($request->file('second_section_image_one'))
            ->toMediaCollection('service_second_section_image_one');
        }
        if($request->hasFile('second_section_image_two'))
        {
            $page->clearMediaCollection('service_second_section_image_two');
            $page->addMedia($request->file('second_section_image_two'))
            ->toMediaCollection('service_second_section_image_two');
        }
        if($request->hasFile('main_video_video_section'))
        {
            $page->clearMediaCollection('main_video_video_section');
            $page->addMedia($request->file('main_video_video_section'))
            ->toMediaCollection('main_video_video_section');
        }
        if($request->hasFile('back_ground_video_image'))
        {
            $page->clearMediaCollection('back_ground_video_image');
            $page->addMedia($request->file('back_ground_video_image'))
            ->toMediaCollection('back_ground_video_image');
        }

        $data = [
            'name'=>[
                'ar'=>$request->title_ar,
                'en'=>$request->title_en,
            ],
            'description'=>[
                'ar'=>$request->description_ar,
                'en'=>$request->description_en,
            ],
            'content'=>json_encode([
                'title_ar_section_one'=>$request->title_ar_section_one,
                'title_en_section_one'=>$request->title_en_section_one,
                'description_ar_section_one'=>$request->description_ar_section_one,
                'description_en_section_one'=>$request->description_en_section_one,
                'title_ar_section_two'=>$request->title_ar_section_two,
                'title_en_section_two'=>$request->title_en_section_two,
                'description_ar_section_two'=>$request->description_ar_section_two,
                'description_en_section_two'=>$request->description_en_section_two,
                'card_one_title_en'=>$request->card_one_title_en,
                'card_one_title_ar'=>$request->card_one_title_ar,
                'card_one_description_ar'=>$request->card_one_description_ar,
                'card_one_description_en'=>$request->card_one_description_en,
                'card_two_title_en'=>$request->card_two_title_en,
                'card_two_title_ar'=>$request->card_two_title_ar,
                'card_two_description_ar'=>$request->card_two_description_ar,
                'card_two_description_en'=>$request->card_two_description_en,
                'card_three_title_en'=>$request->card_three_title_en,
                'card_three_title_ar'=>$request->card_three_title_ar,
                'card_three_description_ar'=>$request->card_three_description_ar,
                'card_three_description_en'=>$request->card_three_description_en,
                'card_four_title_en'=>$request->card_four_title_en,
                'card_four_title_ar'=>$request->card_four_title_ar,
                'card_four_description_ar'=>$request->card_four_description_ar,
                'card_four_description_en'=>$request->card_four_description_en,
                'video_section_title_en'=>$request->video_section_title_en,
                'video_section_title_ar'=>$request->video_section_title_ar,
                'video_section_description_en'=>$request->video_section_description_en,
                'video_section_description_ar'=>$request->video_section_description_ar,
            ])
        ];

        $page->update($data);
        Alert::toast('Service page was update', 'success');
        return back();
    }

    
}
