<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <img class="c-sidebar-brand-full" src="{{ asset('img/brand/khadamati-logo.png') }}" width="" height="50" alt="Logo" loading="lazy" />
        <img class="c-sidebar-brand-minimized" src="{{ asset('img/brand/khadamati-logo.png') }}" width="" height="50" alt="Logo" loading="lazy" />
    </div><!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <x-utils.link
                class="c-sidebar-nav-link"
                :href="route('admin.dashboard')"
                :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer"
                :text="__('Dashboard')" />
        </li>

        @if (
            $logged_in_user->hasAllAccess() ||
            (
                $logged_in_user->can('admin.access.user.list') ||
                $logged_in_user->can('admin.access.user.deactivate') ||
                $logged_in_user->can('admin.access.user.reactivate') ||
                $logged_in_user->can('admin.access.user.clear-session') ||
                $logged_in_user->can('admin.access.user.impersonate') ||
                $logged_in_user->can('admin.access.user.change-password')
            )
        )
            <li class="c-sidebar-nav-title">@lang('System')</li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-user"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Access')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.access.user.list') ||
                            $logged_in_user->can('admin.access.user.deactivate') ||
                            $logged_in_user->can('admin.access.user.reactivate') ||
                            $logged_in_user->can('admin.access.user.clear-session') ||
                            $logged_in_user->can('admin.access.user.impersonate') ||
                            $logged_in_user->can('admin.access.user.change-password')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.auth.user.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Admin Management')"
                                :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                        </li>
                    @endif

                    @if ($logged_in_user->hasAllAccess())
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.auth.role.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Role Management')"
                                :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (
                  $logged_in_user->hasAllAccess() ||
                  (
                      $logged_in_user->can('admin.merchant.list') ||
                      $logged_in_user->can('admin.merchant.store') ||
                      $logged_in_user->can('admin.merchant.update') ||
                      $logged_in_user->can('admin.merchant.delete')
                  )
              )
        <li class="c-sidebar-nav-title">@lang('Merchants')</li>
        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.merchant.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                icon="c-sidebar-nav-icon fas fa-store-alt"
                class="c-sidebar-nav-dropdown-toggle"
                :text="__('Merchants')"/>
            <ul class="c-sidebar-nav-dropdown-items">
                @if (
                    $logged_in_user->hasAllAccess() ||
                    (
                        $logged_in_user->can('admin.merchant.list') ||
                        $logged_in_user->can('admin.merchant.store') ||
                        $logged_in_user->can('admin.merchant.update') ||
                        $logged_in_user->can('admin.merchant.delete')
                    )
                )
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('admin.merchant.index')"
                            class="c-sidebar-nav-link"
                            :text="__('Merchant Management')"
                            :active="activeClass(Route::is('admin.merchant.*'), 'c-active')"/>
                    </li>
                @endif
                    @if (
                      $logged_in_user->hasAllAccess() ||
                      (
                          $logged_in_user->can('admin.service.list') ||
                          $logged_in_user->can('admin.service.store') ||
                          $logged_in_user->can('admin.service.update') ||
                          $logged_in_user->can('admin.service.delete')
                      )
                  )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.service.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Services Management')"
                                :active="activeClass(Route::is('admin.service.*'), 'c-active')"/>
                        </li>
                    @endif
            </ul>
        @endif
        @if (
                   $logged_in_user->hasAllAccess() ||
                   (
                       $logged_in_user->can('admin.customer.list') ||
                       $logged_in_user->can('admin.customer.store') ||
                       $logged_in_user->can('admin.customer.update') ||
                       $logged_in_user->can('admin.customer.delete')
                   )
               )
        <li class="c-sidebar-nav-title">@lang('Customers')</li>
        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.customer.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                icon="c-sidebar-nav-icon far fa-id-card"
                class="c-sidebar-nav-dropdown-toggle"
                :text="__('Customers')"/>

            <ul class="c-sidebar-nav-dropdown-items">
                @if (
                    $logged_in_user->hasAllAccess() ||
                    (
                        $logged_in_user->can('admin.customer.list') ||
                        $logged_in_user->can('admin.customer.store') ||
                        $logged_in_user->can('admin.customer.update') ||
                        $logged_in_user->can('admin.customer.delete')
                    )
                )
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('admin.customer.index')"
                            class="c-sidebar-nav-link"
                            :text="__('Customers Management')"
                            :active="activeClass(Route::is('admin.customer.*'), 'c-active')"/>
                    </li>
                @endif
            </ul>
        </li>
        @endif

{{--        @if (--}}
{{--      $logged_in_user->hasAllAccess() ||--}}
{{--      (--}}
{{--          $logged_in_user->can('admin.order.list')--}}

{{--      )--}}
{{--  )--}}
{{--            <li class="c-sidebar-nav-title">@lang('Orders')</li>--}}
{{--            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.order.*'), 'c-open c-show') }}">--}}
{{--                <x-utils.link--}}
{{--                    href="#"--}}
{{--                    icon="c-sidebar-nav-icon cil-find-in-page"--}}
{{--                    class="c-sidebar-nav-dropdown-toggle"--}}
{{--                    :text="__('Orders')"/>--}}

{{--                <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                    @if (--}}
{{--                        $logged_in_user->hasAllAccess() ||--}}
{{--                        (--}}
{{--                            $logged_in_user->can('admin.order.list')--}}

{{--                        )--}}
{{--                    )--}}
{{--                        <li class="c-sidebar-nav-item">--}}
{{--                            <x-utils.link--}}
{{--                                :href="route('admin.order.index')"--}}
{{--                                class="c-sidebar-nav-link"--}}
{{--                                :text="__('Orders Management')"--}}
{{--                                :active="activeClass(Route::is('admin.order.*'), 'c-active')"/>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                </ul>--}}

{{--        @endif--}}

{{--        @if (--}}
{{-- $logged_in_user->hasAllAccess() ||--}}
{{-- (--}}
{{--     $logged_in_user->can('admin.rating.list')--}}

{{-- )--}}
{{--)--}}
{{--            <li class="c-sidebar-nav-title">@lang('Rating')</li>--}}
{{--            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.rating.*'), 'c-open c-show') }}">--}}
{{--                <x-utils.link--}}
{{--                    href="#"--}}
{{--                    icon="c-sidebar-nav-icon cil-star"--}}
{{--                    class="c-sidebar-nav-dropdown-toggle"--}}
{{--                    :text="__('Ratings')"/>--}}

{{--                <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                    @if (--}}
{{--                        $logged_in_user->hasAllAccess() ||--}}
{{--                        (--}}
{{--                            $logged_in_user->can('admin.rating.list')--}}

{{--                        )--}}
{{--                    )--}}
{{--                        <li class="c-sidebar-nav-item">--}}
{{--                            <x-utils.link--}}
{{--                                :href="route('admin.rating.index')"--}}
{{--                                class="c-sidebar-nav-link"--}}
{{--                                :text="__('Ratings Management')"--}}
{{--                                :active="activeClass(Route::is('admin.rating.*'), 'c-active')"/>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                </ul>--}}

{{--        @endif--}}
        @if (
          $logged_in_user->hasAllAccess() ||
          (
              $logged_in_user->can('admin.banner.list') ||
              $logged_in_user->can('admin.banner.store')
          )
      )

            <li class="c-sidebar-nav-title">@lang('Banners')</li>
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.banner.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon fas fa-images"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Banners')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.banner.list') ||
                            $logged_in_user->can('admin.banner.store')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.banner.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Banners Management')"
                                :active="activeClass(Route::is('admin.banner.*'), 'c-active')"/>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (
        $logged_in_user->hasAllAccess() ||
        (
            $logged_in_user->can('admin.introduction.list') ||
            $logged_in_user->can('admin.introduction.store')
        )
    )

            <li class="c-sidebar-nav-title">@lang('Introductions')</li>
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.introduction.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon far fa-images"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Introductions')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.introduction.list') ||
                            $logged_in_user->can('admin.introduction.store')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.introduction.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Introductions Management')"
                                :active="activeClass(Route::is('admin.introduction.*'), 'c-active')"/>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (
       $logged_in_user->hasAllAccess() ||
       (
           $logged_in_user->can('admin.notification.list') ||
           $logged_in_user->can('admin.notification.store')
       )
   )

            <li class="c-sidebar-nav-title">@lang('Notifications')</li>
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.notification.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-bell"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Notifications')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.notification.list') ||
                            $logged_in_user->can('admin.notification.store')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.notification.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Notifications Management')"
                                :active="activeClass(Route::is('admin.notification.*'), 'c-active')"/>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (
                          $logged_in_user->hasAllAccess() ||
                          (
                              $logged_in_user->can('admin.information')

                          )
                      )
        <li class="c-sidebar-nav-title">@lang('Information')</li>
        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.information.edit'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                icon="c-sidebar-nav-icon cil-info"
                class="c-sidebar-nav-dropdown-toggle"
                :text="__('Main Information')"/>

            <ul class="c-sidebar-nav-dropdown-items">
                @if (
                    $logged_in_user->hasAllAccess() ||
                    (
                        $logged_in_user->can('admin.information')

                    )
                )
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('admin.information.edit',1)"
                            class="c-sidebar-nav-link"
                            :text="__('Edit Main Information')"
                            :active="activeClass(Route::is('admin.information.*'), 'c-active')"/>
                    </li>
                @endif

            </ul>
        </li>
        @endif
        @if (
                 $logged_in_user->hasAllAccess() ||
                 (
                     $logged_in_user->can('admin.social')

                 )
             )
        <li class="c-sidebar-nav-title">@lang('Social Media')</li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.social.edit'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                icon="c-sidebar-nav-icon cil-speech"
                class="c-sidebar-nav-dropdown-toggle"
                :text="__('Social Media Platforms')"/>

            <ul class="c-sidebar-nav-dropdown-items">
                @if (
                    $logged_in_user->hasAllAccess() ||
                    (
                        $logged_in_user->can('admin.social')

                    )
                )
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('admin.social.edit',1)"
                            class="c-sidebar-nav-link"
                            :text="__('Edit Social Media Platforms')"
                            :active="activeClass(Route::is('admin.social.*'), 'c-active')"/>
                    </li>
                @endif

            </ul>
        </li>
        @endif
    @if(
            $logged_in_user->hasAllAccess()
//            ||
//                (
//                    $logged_in_user->can('admin.lookups.country.list') ||
//                    $logged_in_user->can('admin.lookups.country.store') ||
//                    $logged_in_user->can('admin.lookups.country.update') ||
//                    $logged_in_user->can('admin.lookups.country.delete')
//                )
                ||
                (
                    $logged_in_user->can('admin.lookups.city.list') ||
                    $logged_in_user->can('admin.lookups.city.store') ||
                    $logged_in_user->can('admin.lookups.city.update') ||
                    $logged_in_user->can('admin.lookups.city.delete')
                )
                ||
                (
                    $logged_in_user->can('admin.lookups.page.list') ||
                    $logged_in_user->can('admin.lookups.page.store') ||
                    $logged_in_user->can('admin.lookups.page.update') ||
                    $logged_in_user->can('admin.lookups.page.delete')
                )
                  ||
                    (
                    $logged_in_user->can('admin.lookups.tag.list') ||
                    $logged_in_user->can('admin.lookups.tag.store') ||
                    $logged_in_user->can('admin.lookups.tag.update') ||
                    $logged_in_user->can('admin.lookups.tag.delete')
                )
                ||
                    (
                    $logged_in_user->can('admin.lookups.label.list') ||
                    $logged_in_user->can('admin.lookups.label.store') ||
                    $logged_in_user->can('admin.lookups.label.update') ||
                    $logged_in_user->can('admin.lookups.label.delete')
                )
                 ||
                    (
                    $logged_in_user->can('admin.lookups.userType.list') ||
                    $logged_in_user->can('admin.lookups.userType.store') ||
                    $logged_in_user->can('admin.lookups.userType.update') ||
                    $logged_in_user->can('admin.lookups.userType.delete')
                )
                ||
                    (
                    $logged_in_user->can('admin.lookups.category.list') ||
                    $logged_in_user->can('admin.lookups.category.store') ||
                    $logged_in_user->can('admin.lookups.category.update') ||
                    $logged_in_user->can('admin.lookups.category.delete')
                )

            )


            <li class="c-sidebar-nav-title">@lang('Lookups')</li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.page.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-paper-plane"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Our Pages')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.lookups.page.list') ||
                            $logged_in_user->can('admin.lookups.page.store') ||
                            $logged_in_user->can('admin.lookups.page.update') ||
                            $logged_in_user->can('admin.lookups.page.delete')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.lookups.page.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Our Pages List')"
                                :active="activeClass(Route::is('admin.lookups.page.*'), 'c-active')"/>
                        </li>
                    @endif

                </ul>
            </li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.country.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-flag-alt"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Countries')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.lookups.country.list') ||
                            $logged_in_user->can('admin.lookups.country.store') ||
                            $logged_in_user->can('admin.lookups.country.update') ||
                            $logged_in_user->can('admin.lookups.country.delete')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.lookups.country.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Country List')"
                                :active="activeClass(Route::is('admin.lookups.country.*'), 'c-active')"/>
                        </li>
                    @endif

                </ul>
            </li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.city.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-location-pin"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Cities')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.lookups.city.list') ||
                            $logged_in_user->can('admin.lookups.city.store') ||
                            $logged_in_user->can('admin.lookups.city.update') ||
                            $logged_in_user->can('admin.lookups.city.delete')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.lookups.city.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Cities List')"
                                :active="activeClass(Route::is('admin.lookups.city.*'), 'c-active')"/>
                        </li>
                    @endif

                </ul>
            </li>
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.area.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon fas fa-city"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Areas')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.lookups.area.list') ||
                            $logged_in_user->can('admin.lookups.area.store') ||
                            $logged_in_user->can('admin.lookups.area.update') ||
                            $logged_in_user->can('admin.lookups.area.delete')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.lookups.area.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Areas Management')"
                                :active="activeClass(Route::is('admin.lookups.area.*'), 'c-active')"/>
                        </li>
                    @endif

                </ul>
            </li>
                    <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.tag.*'), 'c-open c-show') }}">
                        <x-utils.link
                            href="#"
                            icon="c-sidebar-nav-icon cil-tags"
                            class="c-sidebar-nav-dropdown-toggle"
                            :text="__('Tags')"/>

                        <ul class="c-sidebar-nav-dropdown-items">
                            @if (
                                $logged_in_user->hasAllAccess() ||
                                (
                                    $logged_in_user->can('admin.lookups.tag.list') ||
                                    $logged_in_user->can('admin.lookups.tag.store') ||
                                    $logged_in_user->can('admin.lookups.tag.update') ||
                                    $logged_in_user->can('admin.lookups.tag.delete')
                                )
                            )
                                <li class="c-sidebar-nav-item">
                                    <x-utils.link
                                        :href="route('admin.lookups.tag.index')"
                                        class="c-sidebar-nav-link"
                                        :text="__('Tags Management')"
                                        :active="activeClass(Route::is('admin.lookups.tag.*'), 'c-active')"/>
                                </li>
                            @endif

                        </ul>
                    </li>
            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.label.*'), 'c-open c-show') }}">
                        <x-utils.link
                            href="#"
                            icon="c-sidebar-nav-icon fas fa-tag"
                            class="c-sidebar-nav-dropdown-toggle"
                            :text="__('Labels')"/>

                        <ul class="c-sidebar-nav-dropdown-items">
                            @if (
                                $logged_in_user->hasAllAccess() ||
                                (
                                    $logged_in_user->can('admin.lookups.label.list') ||
                                    $logged_in_user->can('admin.lookups.label.store') ||
                                    $logged_in_user->can('admin.lookups.label.update') ||
                                    $logged_in_user->can('admin.lookups.label.delete')
                                )
                            )
                                <li class="c-sidebar-nav-item">
                                    <x-utils.link
                                        :href="route('admin.lookups.label.index')"
                                        class="c-sidebar-nav-link"
                                        :text="__('Labels Management')"
                                        :active="activeClass(Route::is('admin.lookups.label.*'), 'c-active')"/>
                                </li>
                            @endif

                        </ul>
                    </li>

            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.lookups.category.*'), 'c-open c-show') }}">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-list"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Category')"/>

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                        (
                            $logged_in_user->can('admin.lookups.category.list') ||
                            $logged_in_user->can('admin.lookups.category.store') ||
                            $logged_in_user->can('admin.lookups.category.update') ||
                            $logged_in_user->can('admin.lookups.category.delete')
                        )
                    )
                        <li class="c-sidebar-nav-item">
                            <x-utils.link
                                :href="route('admin.lookups.category.index')"
                                class="c-sidebar-nav-link"
                                :text="__('Category List')"
                                :active="activeClass(Route::is('admin.lookups.category.*'), 'c-active')"/>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

{{--        @if (--}}
{{--               $logged_in_user->hasAllAccess() ||--}}
{{--               (--}}
{{--                   $logged_in_user->can('admin.emailEngine.mailTemplate.list') ||--}}
{{--                   $logged_in_user->can('admin.emailEngine.mailTemplate.update') ||--}}
{{--                   $logged_in_user->can('admin.emailEngine.sender.toSiteAdmins')--}}
{{--               )--}}
{{--           )--}}
{{--            <li class="c-sidebar-nav-title">@lang('Email Management')</li>--}}

{{--            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.emailEngine.mailTemplate.*'), 'c-open c-show') }}">--}}
{{--                <x-utils.link--}}
{{--                    href="#"--}}
{{--                    icon="c-sidebar-nav-icon cil-envelope-letter"--}}
{{--                    class="c-sidebar-nav-dropdown-toggle"--}}
{{--                    :text="__('Email Templates')"/>--}}

{{--                <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                    @if (--}}
{{--                        $logged_in_user->hasAllAccess() ||--}}
{{--                        (--}}
{{--                            $logged_in_user->can('admin.emailEngine.mailTemplate.list') ||--}}
{{--                            $logged_in_user->can('admin.emailEngine.mailTemplate.update')--}}
{{--                        )--}}
{{--                    )--}}
{{--                        <li class="c-sidebar-nav-item">--}}
{{--                            <x-utils.link--}}
{{--                                :href="route('admin.emailEngine.mailTemplate.index')"--}}
{{--                                class="c-sidebar-nav-link"--}}
{{--                                :text="__('Email Templates List')"--}}
{{--                                :active="activeClass(Route::is('admin.emailEngine.mailTemplate.*'), 'c-active')"/>--}}
{{--                        </li>--}}
{{--                    @endif--}}

{{--                </ul>--}}
{{--            </li>--}}

{{--            <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.emailEngine.sender.*'), 'c-open c-show') }}">--}}
{{--                <x-utils.link--}}
{{--                    href="#"--}}
{{--                    icon="c-sidebar-nav-icon cil-send"--}}
{{--                    class="c-sidebar-nav-dropdown-toggle"--}}
{{--                    :text="__('Email Sender')"/>--}}

{{--                <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                    @if (--}}
{{--                        $logged_in_user->hasAllAccess() ||--}}
{{--                        (--}}
{{--                            $logged_in_user->can('admin.emailEngine.sender.toSiteAdmins')--}}
{{--                        )--}}
{{--                    )--}}
{{--                        <li class="c-sidebar-nav-item">--}}
{{--                            <x-utils.link--}}
{{--                                :href="route('admin.emailEngine.sender.sendToSiteAdmins')"--}}
{{--                                class="c-sidebar-nav-link"--}}
{{--                                :text="__('To Site Admin')"--}}
{{--                                :active="activeClass(Route::is('admin.emailEngine.sender.sendToSiteAdmins'), 'c-active')"/>--}}
{{--                        </li>--}}
{{--                    @endif--}}

{{--                </ul>--}}
{{--            </li>--}}
{{--        @endif--}}

        @if ($logged_in_user->isMasterAdmin())
            <li class="c-sidebar-nav-title">@lang('System Logs & Performance')</li>
            <li class="c-sidebar-nav-dropdown">
                <x-utils.link
                    href="#"
                    icon="c-sidebar-nav-icon cil-list"
                    class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Logs')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('log-viewer::dashboard')"
                            class="c-sidebar-nav-link"
                            :text="__('Dashboard')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('log-viewer::logs.list')"
                            class="c-sidebar-nav-link"
                            :text="__('Logs')" />
                    </li>
                </ul>
            </li>
        @endif
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div><!--sidebar-->
