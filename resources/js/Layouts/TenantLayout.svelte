<script lang="ts">
	import * as Sidebar from "@/components/ui/sidebar";
	import AppSidebar from "@/components/shared/app-sidebar.svelte";
	import * as DropdownMenu from "@/components/ui/dropdown-menu/index.js";
	import BreezeDropdown from "@/Components/Dropdown.svelte";
	import BreezeDropdownLink from "@/Components/DropdownLink.svelte";
	import { Link, page } from "@inertiajs/svelte";
	import type { Tenant } from "@/types/tenant";
	import { ChevronDown, LogOut } from "lucide-svelte";
	import { buttonVariants } from "@/components/ui/button";

	let user = $page.props.auth.user;
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
							<DropdownMenu.Root>
								<DropdownMenu.Trigger
									class={buttonVariants({ variant: "ghost" })}
								>
									<div>
										{user.name}
									</div>
									<ChevronDown size={16} />
								</DropdownMenu.Trigger>
								<DropdownMenu.Content align="end">
									<DropdownMenu.Item>
										<Link
											href="/logout"
											method="post"
											class="flex items-center space-x-2"
											as="button"
											type="button"
										>
											<LogOut />
											<div>Log Out</div>
										</Link>
									</DropdownMenu.Item>
								</DropdownMenu.Content>
							</DropdownMenu.Root>
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
