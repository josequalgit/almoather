<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow {{ isset($_COOKIE['collapsed']) && $_COOKIE['collapsed'] ? '' : 'menu-expanded'}}" data-scroll-to-active="true">
    <div class="navbar-header {{ isset($_COOKIE['collapsed']) && $_COOKIE['collapsed'] ? '' : 'expanded'}}">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
              <a class="navbar-brand mx-0 my-1" href="{{ url('/') }}">
                    <div class="brand-logo">
                        <img class="logo" src="{{ asset('img/avatars/logo-almuaather.png') }}" />
                    </div>
                </a>
            </li>
        </ul>
    </div>
    @php
      $checkStatus = array_key_exists("status", request()->route()->parameters);
      $route = Route::current();
      $name = $route->getName();
      $para = $checkStatus ? request()->route()->parameters['status'] : null;
      $role = Auth::user()->roles[0]->name
    @endphp
    <div class="main-menu-content marginFromLogo">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
          @if($role == 'superAdmin')
            <li class="">
                <a href=""><i class="bx bx-home" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            
          @endif
          <li class=" navigation-header text-truncate"><span data-i18n="Apps">Sections</span>
          </li>
           
           @if($role == 'superAdmin')
         

           @canany(['Edit Ads','Create Ads','See Ads','Delete Ads'])
            <li class="menu-item  {{ ($name == 'dashboard.ads.index'|| $name == 'dashboard.ads.create'|| $name == 'dashboard.ads.edit') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Invoice" class="d-flex jsutify-content-center align-items-center">Campaigns @if($pending_ads > 0)<span class="badge badge-danger">{{ $pending_ads }}</span>@endif</div>
              </a>
              <ul class="menu-sub">

                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == null)|| ($name == 'dashboard.ads.create'&&$para == null)||($name == 'dashboard.ads.edit')&&$para == null) ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','All') }}" class="menu-link">
                    <div data-i18n="List">All</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'UnderReview')|| ($name == 'dashboard.ads.create'&&$para == 'UnderReview')||($name == 'dashboard.ads.edit')&&$para == 'UnderReview') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','UnderReview') }}" class="menu-link">
                    <div data-i18n="List" class="d-flex jsutify-content-center align-items-center">Under Review <span class="badge badge-danger">{{ $pending_ads }}</span></div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'Pending')|| ($name == 'dashboard.ads.create'&&$para == 'Pending')||($name == 'dashboard.ads.edit')&&$para == 'Pending') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','Pending') }}" class="menu-link">
                    <div data-i18n="List">Pending</div>
                  </a>
                </li>
                <li class="menu-item 
                {{ (($name == 'dashboard.ads.index'&&$para == 'Active')|| ($name == 'dashboard.ads.create'&&$para == 'Active')||($name == 'dashboard.ads.edit')&&$para == 'Active') ? 'active':''  }}">
                  <a href="{{ route('dashboard.ads.index','Active') }}" class="menu-link">
                    <div data-i18n="List">Active</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'Finished')|| ($name == 'dashboard.ads.create'&&$para == 'Finished')||($name == 'dashboard.ads.edit')&&$para == 'Finished') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.ads.index','Finished') }}" class="menu-link">
                    <div data-i18n="List">Finished</div>
                  </a>
                </li>
                <li class="menu-item
                {{ (($name == 'dashboard.ads.index'&&$para == 'Rejected')|| ($name == 'dashboard.ads.create'&&$para == 'Rejected')||($name == 'dashboard.ads.edit')&&$para == 'Rejected') ? 'active':''  }}

                ">
                  <a href="{{ route('dashboard.ads.index','Rejected') }}" class="menu-link">
                    <div data-i18n="List">Rejected</div>
                  </a>
                </li>
              </ul>
            </li>
           @endcanany


			    @canany(['Edit Influncer','Create Influncer','See Influncer','Delete Influncer'])
            <li class="menu-item  {{ strpos($name,'dashboard.influncers') !== false ? 'open active' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Invoice" class="d-flex jsutify-content-center align-items-center">Influencers @if($pending_influencer > 0)<span class="badge badge-danger">{{ $pending_influencer }}</span>@endif</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ strpos($name,'dashboard.influncers') !== false && last(request()->segments()) == 'accepted' ? 'active':''  }}">
                  <a href="{{ route('dashboard.influncers.index','accepted') }}" class="menu-link"><div data-i18n="List">Accepted Influncers</div></a>
                </li>
                <li class="menu-item {{ strpos($name,'dashboard.influncers') !== false && last(request()->segments()) == 'rejected' ? 'active':''  }}">
                  <a href="{{ route('dashboard.influncers.index','rejected') }}" class="menu-link"><div data-i18n="List">Rejected Influncers</div></a>
                </li>
                <li class="menu-item {{ strpos($name,'dashboard.influncers') !== false && last(request()->segments()) == 'pending' ? 'active':''  }}">
                  <a href="{{ route('dashboard.influncers.index','pending') }}" class="menu-link"><div data-i18n="List" class="d-flex jsutify-content-center align-items-center">Pending Influncers  @if($pending_influencer > 0)<span class="badge badge-danger">{{ $pending_influencer }}</span>@endif</div></a>
                </li>
                <li class="menu-item {{ strpos($name,'dashboard.influncers') !== false && last(request()->segments()) == 'band' ? 'active':''  }}">
                  <a href="{{ route('dashboard.influncers.index','band') }}" class="menu-link"><div data-i18n="List">Band Influncers</div></a>
                </li>
              </ul>
            </li>
            @endcanany

            @canany(['Edit Category','Create Category','See Category','Delete Category','Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])
            <li class="menu-item  {{ ($name == 'dashboard.categories.index'|| $name == 'dashboard.categories.create'|| $name == 'dashboard.categories.edit'||$name == 'dashboard.influencerCategories.index'||$name == 'dashboard.influencerCategories.edit'||$name == 'dashboard.influencerCategories.create') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div data-i18n="Invoice">Categories</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
              
                @canany(['Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.influencerCategories.index'|| $name == 'dashboard.influencerCategories.create'|| $name == 'dashboard.influencerCategories.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.influencerCategories.index') }}" class="menu-link">
                    <div data-i18n="List">Infulncer</div>
                  </a>
                </li>
                @endcanany
                @canany(['Edit Category','Create Category','See Category','Delete Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.categories.index'|| $name == 'dashboard.categories.create'|| $name == 'dashboard.categories.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.categories.index') }}" class="menu-link">
                    <div data-i18n="List">Product</div>
                  </a>
                </li>
                @endcanany
            
              </ul>
            </li>
          @endcanany

          @canany(['Edit Campaign Goal','Create Campaign Goal','See Campaign Goal','Delete Campaign Goal'])
          <li class="{{ ($name == 'dashboard.campaignGoals.index'|| $name == 'dashboard.campaignGoals.create'|| $name == 'dashboard.campaignGoals.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.campaignGoals.index') }}"><i class="bx bx-bullseye"></i><span class="menu-title text-truncate" data-i18n="campaignGoals">Campaign Goal</span></a>
          </li>
          @endcanany

           {{-- @canany(['Edit Ads']) --}}
           <li class="menue-item {{ ($name == 'dashboard.banks.index'|| $name == 'dashboard.banks.create'|| $name == 'dashboard.banks.edit') ? 'open active':''  }}">
            <a href="{{ route('dashboard.banks.index') }}"><i class="bx bx-building"></i><span class="menu-title text-truncate" data-i18n="notifications">Banks</span></a>
          </li>
          {{-- @endcan --}}
         
              {{-- @canany(['Create City|Edit City|Delete City|Create Country|Edit Country|Delete Country|Create Area|Delete Area|Update Area']) --}}
              <li class="menu-item  {{ ($name == 'dashboard.cities.index'|| $name == 'dashboard.cities.create'|| $name == 'dashboard.cities.edit'||$name == 'dashboard.countries.index'||$name == 'dashboard.countries.edit'||$name == 'dashboard.countries.create'||$name == 'dashboard.editContactUs.create'||$name == 'dashboard.editContactUs.create'||$name == 'dashboard.editContactUs.create') ? 'open active':''  }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-location-plus"></i>
                  <div data-i18n="Invoice">Locations</div>
                  {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
                </a>
                <ul class="menu-sub">
                  <li class="menu-item
                  {{ ($name == 'dashboard.cities.all'|| $name == 'dashboard.cities.create'|| $name == 'dashboard.cities.edit') ? 'active':''  }}
                  ">
                    <a href="{{ route('dashboard.cities.all') }}" class="menu-link">
                      <div data-i18n="List">City</div>
                    </a>
                  </li>
                  <li class="menu-item
                  {{ ($name == 'dashboard.areas.all'|| $name == 'dashboard.areas.create'|| $name == 'dashboard.areas.edit') ? 'active':''  }}
                  ">
                    <a href="{{ route('dashboard.areas.all') }}" class="menu-link">
                      <div data-i18n="List">Region</div>
                    </a>
                  </li>
                  <li class="menu-item
                  {{ ($name == 'dashboard.countries.all'|| $name == 'dashboard.countries.store'|| $name == 'dashboard.countries.update') ? 'active':''  }}
                  ">
                    <a href="{{ route('dashboard.countries.all') }}" class="menu-link">
                      <div data-i18n="List">Country</div>
                    </a>
                  </li>
                </ul>
               </li>
                {{-- @endcan --}}
            {{-- @canany(['Edit Ads']) --}}
            <li class="menue-item {{ ($name == 'dashboard.tickets.index'|| $name == 'dashboard.tickets.create'|| $name == 'dashboard.tickets.edit') ? 'open active':''  }}">
              <a href="{{ route('dashboard.tickets.index') }}"><i class="bx bx-confused"></i><span class="menu-title text-truncate" data-i18n="notifications">Tickets</span></a>
            </li>
            {{-- @endcan --}}
            @canany(['Edit Notification','Create Notification','See Notification','Delete Notification'])
            <li class="{{ ($name == 'dashboard.notifications.index'|| $name == 'dashboard.notifications.create'|| $name == 'dashboard.notifications.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.notifications.index') }}"><i class="bx bx-bell"></i><span class="menu-title text-truncate" data-i18n="notifications">Notifications</span></a>
            </li>
            @endcanany
            @canany(['Edit SocialMedia','Create SocialMedia','See SocialMedia','Delete SocialMedia'])

            <li class="menu-item  {{ ($name == 'dashboard.socialMedia.index'|| $name == 'dashboard.socialMedia.create'|| $name == 'dashboard.socialMedia.edit'||$name == 'dashboard.faqs.index'||$name == 'dashboard.faqs.edit'||$name == 'dashboard.faqs.create'||$name == 'dashboard.editContactUs.index'||$name == 'dashboard.editContactUs.edit'||$name == 'dashboard.editContactUs.create') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-slider"></i>
                <div data-i18n="Invoice">Settings</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
               
                @canany(['Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.generals.index'|| $name == 'dashboard.generals.create'|| $name == 'dashboard.generals.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.generals.index') }}" class="menu-link">
                    <div data-i18n="List">General</div>
                  </a>
                </li>
                @endcanany
                @canany(['Edit Influencer Category','Create Influencer Category','See Influencer Category','Delete Influencer Category'])
                <li class="menu-item
                {{ ($name == 'dashboard.faqs.index'|| $name == 'dashboard.faqs.create'|| $name == 'dashboard.faqs.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.faqs.index') }}" class="menu-link">
                    <div data-i18n="List">Faqs</div>
                  </a>
                </li>
                @endcanany
                @canany(['Contact Us'])
                <li class="menu-item
                {{ ($name == 'dashboard.contactUs.index'|| $name == 'dashboard.contactUs.create'|| $name == 'dashboard.contactUs.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.contactUs.index') }}" class="menu-link">
                    <div data-i18n="List">Settings</div>
                  </a>
                </li>
                @endcanany
                
             

                @canany(['Edit SocialMedias','Create SocialMedia','See SocialMedia'])
                <li class="menu-item
                {{ ($name == 'dashboard.socialMedia.index'|| $name == 'dashboard.socialMedia.create'|| $name == 'dashboard.socialMedia.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.socialMedia.index') }}" class="menu-link">
                    <div data-i18n="List">Social Media</div>
                  </a>
                </li>
                @endcanany

                {{-- @canany(['Edit SocialMedias','Create SocialMedia','See SocialMedia']) --}}
                {{-- <li class="menu-item
                {{ ($name == 'dashboard.adRelation.index'|| $name == 'dashboard.adRelation.create'|| $name == 'dashboard.adRelation.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.adRelation.index') }}" class="menu-link">
                    <div data-i18n="List">Ad Relation</div>
                  </a>
                </li> --}}
                {{-- @endcanany --}}

             

                @canany(['Edit Contact Us'])
                <li class="menu-item
                {{ ($name == 'dashboard.contactUs.index'|| $name == 'dashboard.contactUs.create'|| $name == 'dashboard.contactUs.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.contactUs.edit') }}" class="menu-link">
                    <div data-i18n="List">Settings</div>
                  </a>
                </li>
                @endcanany

                <li class="menu-item
                {{ ($name == 'dashboard.terms.index'|| $name == 'dashboard.terms.create'|| $name == 'dashboard.terms.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.terms.index') }}" class="menu-link">
                    <div data-i18n="List">Privacy</div>
                  </a>
                </li>
                <li class="menu-item
                {{ ($name == 'dashboard.terms.indexPolicy'|| $name == 'dashboard.terms.updatePolicy'|| $name == 'dashboard.indexPolicy.updatePolicy') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.terms.indexPolicy') }}" class="menu-link">
                    <div data-i18n="List">Return Policy</div>
                  </a>
                </li>
                <li class="menu-item
                {{ ($name == 'dashboard.terms.indexTerms'|| $name == 'dashboard.indexTerms.updateTerms'|| $name == 'dashboard.indexTerms.updateTerms') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.terms.indexTerms') }}" class="menu-link">
                    <div data-i18n="List">Termis</div>
                  </a>
                </li>
                

                @canany(['Edit Slide','Create Slide','See Slide'])
                <li class="menu-item
                {{ ($name == 'dashboard.slides.index'|| $name == 'dashboard.slides.create'|| $name == 'dashboard.slides.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.slides.index') }}" class="menu-link">
                    <div data-i18n="List">Slides</div>
                  </a>
                </li>
                @endcanany

                @canany(['Edit Contract','Create Contract','See Contract'])
                <li class="menu-item
                {{ ($name == 'dashboard.contracts.index'|| $name == 'dashboard.contracts.create'|| $name == 'dashboard.contracts.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.contracts.edit') }}" class="menu-link">
                    <div data-i18n="List">Contract</div>
                  </a>
                </li>
                @endcanany

                @canany(['Edit Reasons','Create Reasons','See Reasons'])
                <li class="menu-item
                {{ ($name == 'dashboard.reasons.index'|| $name == 'dashboard.reasons.create'|| $name == 'dashboard.reasons.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.reasons.index') }}" class="menu-link">
                    <div data-i18n="List">Reasons</div>
                  </a>
                </li>
                @endcanany

                {{-- @canany(['Edit AdRelation','Create AdRelation','See AdRelation']) --}}
                <li class="menu-item
                {{ ($name == 'dashboard.adRelations.index'|| $name == 'dashboard.adRelations.create'|| $name == 'dashboard.adRelations.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.adRelations.index') }}" class="menu-link">
                    <div data-i18n="List">Ad Relations</div>
                  </a>
                </li>
                {{-- @endcanany --}}

             
              </ul>
            </li>

            @endcanany
            @canany(['Edit Customer','Create Customer','See Customer','Delete Customer'])
            <li class="menu-item  {{ ($name == 'dashboard.customers.index' || $name == 'dashboard.customers.edit' || $name == 'dashboard.customers.create') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Invoice">App Users</div>
              </a>
              <ul class="menu-sub">
                @canany(['Edit Customer','Create Customer','See Customer','Delete Customer'])
                <li class="menu-item
                {{ ($name == 'dashboard.customers.index'|| $name == 'dashboard.customers.create'|| $name == 'dashboard.customers.edit'|| $name == 'dashboard.customers.showAds')  ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.customers.index') }}" class="menu-link">
                    <div data-i18n="List">Customers</div>
                  </a>
                </li>
                @endcanany
            
              </ul>
            </li>
            @endcanany

            @canany(['Edit Admin','Create Admin','See Admin','Delete Admin','Edit Role','Create Role','See Role','Delete Role'])
            <li class="menu-item  {{ ($name == 'dashboard.admins.index'|| $name == 'dashboard.admins.create'|| $name == 'dashboard.admins.edit') ? 'open active':''  }} ">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Invoice">System Users</div>
                {{-- <i style="font-size: 12px;" class="menu-icon tf-icons bx bx-down-arrow ml-4 float-right"></i> --}}
              </a>
              <ul class="menu-sub">
                @canany(['Edit Admin','Create Admin','See Admin','Delete Admin'])

                <li class="menu-item
                {{ ($name == 'dashboard.admins.index'|| $name == 'dashboard.admins.create'|| $name == 'dashboard.admins.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.admins.index') }}" class="menu-link">
                    <div data-i18n="List">Admins</div>
                  </a>
                </li>
                @endcanany
               
                @canany(['Edit Role','Create Role','See Role','Delete Role'])
                <li class="menu-item
                {{ ($name == 'dashboard.roles.index'|| $name == 'dashboard.roles.create'|| $name == 'dashboard.roles.edit') ? 'active':''  }}
                ">
                  <a href="{{ route('dashboard.roles.index') }}" class="menu-link">
                    <div data-i18n="List">Roles</div>
                  </a>
                </li>
                @endcanany
              </ul>
            </li>
            @endcanany
        
          
         
          
            {{-- @canany(['Edit Ads']) --}}
            <li class="menue-item {{ ($name == 'dashboard.payments.index'|| $name == 'dashboard.payments.create'|| $name == 'dashboard.payments.edit') ? 'open active':''  }}">
              <a href="{{ route('dashboard.payments.index') }}"><i class="bx bx-credit-card"></i><span class="menu-title text-truncate" data-i18n="notifications">Payment</span></a>
            </li>
            {{-- @endcan --}}

         

             

            {{-- @canany(['Edit Ads',]) --}}
            <li class="menue-item {{ ($name == 'dashboard.frontEndSettings.index'|| $name == 'dashboard.frontEndSettings.create'|| $name == 'dashboard.frontEndSettings.edit') ? 'open active':''  }}">
             
              <a href="{{ route('dashboard.frontEndSettings.index') }}"><i class="bx bx-home-heart"></i><span class="menu-title text-truncate" data-i18n="notifications">Front End</span></a>

            </li>
            {{-- @endcan --}}
            {{-- @canany(['Edit Ads',]) --}}
            <li class="menue-item {{ ($name == 'dashboard.teams.index'|| $name == 'dashboard.teams.create'|| $name == 'dashboard.teams.edit') ? 'open active':''  }}">
             
              <a href="{{ route('dashboard.teams.index') }}"><i class="bx bx-group"></i><span class="menu-title text-truncate" data-i18n="notifications">Team</span></a>

            </li>
            {{-- @endcan --}}


        
    
           

      

            @elseif($role == 'Contracts Manager')
            <li class="{{ ($name == 'dashboard.contracts.activeContract') ? 'active':''  }}">
              <a href="{{route('dashboard.contracts.activeContract')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Influncers Contracts</span></a>
           </li>
            <li class="{{ ($name == 'dashboard.contracts.customerContracts') ? 'active':''  }}">
              <a href="{{route('dashboard.contracts.customerContracts')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Customers Contracts</span></a>
           </li>
           
            <li class="{{ ($name == 'dashboard.influncers.allInfluncerWithViews') ? 'active':''  }}">
              <a href="{{route('dashboard.influncers.allInfluncerWithViews')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Influncers</span></a>
           </li>
             @elseif($role == 'Business Manager')
             <li class="{{ ($name == 'dashboard.businessManager.canceledContract') ? 'active':''  }}">
                <a href="{{route('dashboard.businessManager.canceledContract')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Canceled</span></a>
              </li>
             <li class="{{ ($name == 'dashboard.businessManager.rejectedAds') ? 'active':''  }}">
                <a href="{{route('dashboard.businessManager.rejectedAds')}}"><i class="bx bx-book-content" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Dashboard">Rejected Ads</span></a>
              </li>
            @endif
          
            @can('See Logs')
            <li class="{{ ($name == 'dashboard.logs.index'|| $name == 'dashboard.logs.create'|| $name == 'dashboard.logs.edit') ? 'active':''  }} nav-item"><a href="{{ route('dashboard.logs.index') }}"><i class="bx bx-code-block"></i><span class="menu-title text-truncate" data-i18n="logs">Logs</span></a>
            </li>
            @endcan
           
        </ul>
    </div>
</div>