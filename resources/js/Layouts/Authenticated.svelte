<script>
    import * as Sidebar from "@/components/ui/sidebar";
    import AppSidebar from "@/components/shared/app-sidebar.svelte";
    import BreezeApplicationLogo from "@/Components/ApplicationLogo.svelte";
    import BreezeDropdown from "@/Components/Dropdown.svelte";
    import BreezeDropdownLink from "@/Components/DropdownLink.svelte";
    import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.svelte";
    import { page, Link } from "@inertiajs/svelte";
    import { Separator } from "@/components/ui/separator";
    import * as Breadcrumb from "@/components/ui/breadcrumb";
    let showingNavigationDropdown = false;
    export let user = $page.props.auth.user;
</script>

<Sidebar.Provider>
    <AppSidebar />
    <Sidebar.Inset>
        <div class="min-h-screen">
            <nav class="border-b">
                <!-- Primary Navigation Menu -->
                <div class="px-4">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center gap-4">
                            <Sidebar.Trigger />
                            <!-- <Separator orientation="vertical" class=" " />
                            <Breadcrumb.Root>
                                <Breadcrumb.List>
                                    <Breadcrumb.Item class="hidden md:block">
                                        <Breadcrumb.Link href="#"
                                            >Building Your Application</Breadcrumb.Link
                                        >
                                    </Breadcrumb.Item>
                                    <Breadcrumb.Separator
                                        class="hidden md:block"
                                    />
                                    <Breadcrumb.Item>
                                        <Breadcrumb.Page
                                            >Data Fetching</Breadcrumb.Page
                                        >
                                    </Breadcrumb.Item>
                                </Breadcrumb.List>
                            </Breadcrumb.Root> -->
                        </div>

                        <div class="flex items-center">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown
                                    class="w-48 origin-top-right right-0"
                                >
                                    <span
                                        class="inline-flex rounded-md"
                                        slot="trigger"
                                    >
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {user.name}

                                            <svg
                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                    <div slot="content">
                                        <BreezeDropdownLink
                                            href="/logout"
                                            method="post"
                                            as="button"
                                            type="button"
                                        >
                                            Log Out
                                        </BreezeDropdownLink>
                                    </div>
                                </BreezeDropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </Sidebar.Inset>
</Sidebar.Provider>
