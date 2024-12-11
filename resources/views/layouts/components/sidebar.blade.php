<aside id="application-sidebar-brand"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full  transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-5 xl:left-auto top-0 left-0 with-vertical z-[1] shrink-0  w-[270px] shadow-md mb-6 rounded-[30px] bg-white left-sidebar   transition-all duration-300">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="p-4">

        <a href="../" class="text-nowrap ">
            <img clas src="{{ asset('assets/logo/logo-black.png') }}" alt="Logo-Dark" style="width: 200px; height: auto;  margin-left: 15px;"/>
        </a>


    </div>
    <div class="scroll-sidebar" data-simplebar="">
        <nav class=" w-full flex flex-col sidebar-nav px-4 mt-5">
            <ul id="sidebarnav" class="text-gray-600 text-sm [&>li]:mb-2">
                <li class="text-xs font-bold pb-[5px]">
                    <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                    <span class="text-xs text-gray-400 font-semibold">MASTER</span>
                </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('dashboard') }}">
                            <i class="ti ti-layout-dashboard ps-2  text-2xl"></i> <span>Dashboard</span>
                        </a>
                    </li>

                @role('owner')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.categories.index') }}">
                            <i class="ti ti-stack-front ps-2 text-2xl"></i> <span>Manage Category</span>
                        </a>
                    </li>
                @endrole

                @role('teacher')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.artikel.index') }}">
                            <i class="ti ti-news ps-2 text-2xl"></i> <span>Manage Artikel</span>
                        </a>
                    </li>
                @endrole

                @role('teacher')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.courses.index') }}">
                            <i class="ti ti-folder-open ps-2 text-2xl"></i> <span>Manage Course</span>
                        </a>
                    </li>
                @endrole

                @role('owner')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.teachers.index') }}">
                            <i class="ti ti-school ps-2 text-2xl"></i> <span>Manage Teacher</span>
                        </a>
                    </li>
                @endrole

                @role('owner')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.subscribe_transactions.index') }}">
                            <i class="ti ti-coin ps-2 text-2xl"></i> <span>Manage Transaction</span>
                        </a>
                    </li>
                @endrole

                @role('owner')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.packages.index') }}">
                            <i class="ti ti-package ps-2 text-2xl"></i> <span>Manage Packages</span>
                        </a>
                    </li>
                @endrole

                @role('owner')
                    <li class="sidebar-item">
                        <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                            href="{{ route('admin.payments.index') }}">
                            <i class="ti ti-wallet ps-2 text-2xl"></i> <span>Manage Payment </span>
                        </a>
                    </li>
                @endrole
                @role('student')
                <li class="sidebar-item">
                    <a class="sidebar-link gap-3 py-2.5 my-1 text-base  flex items-center relative  rounded-md text-gray-500  w-full"
                        href="{{ route('profile.edit') }}">
                        <i class="ti ti-settings ps-2 text-2xl"></i> <span>Account Setting </span>
                    </a>
                </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>
