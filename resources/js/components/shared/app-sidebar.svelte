<script lang="ts">
	import Calendar from "lucide-svelte/icons/calendar";
	import House from "lucide-svelte/icons/house";
	import Inbox from "lucide-svelte/icons/inbox";
	import * as Sidebar from "@/components/ui/sidebar";
	import type { Tenant } from "@/types/tenant";
	import { Users } from "lucide-svelte";
	import { Link, page } from "@inertiajs/svelte";

	let tenant = $page.props.tenant as Tenant;

	// Menu items.
	const items = [
		{
			title: "Dashboard",
			url: route("tenants.dashboard", tenant),
			icon: House,
			isActive: $page.url === `/tenants/${tenant.id}`,
		},
		{
			title: "Visits",
			url: route("tenants.visits.index", tenant),
			icon: Inbox,
			isActive: $page.url.startsWith(`/tenants/${tenant.id}/visits`),
		},
		{
			title: "Appointments",
			url: route("tenants.appointments.index", tenant),
			icon: Calendar,
			isActive: $page.url.startsWith(
				`/tenants/${tenant.id}/appointments`,
			),
		},
		{
			title: "Patients",
			url: route("tenants.patients.index", tenant),
			icon: Users,
			isActive: $page.url.startsWith(`/tenants/${tenant.id}/patients`),
		},
	];
</script>

<Sidebar.Root>
	<Sidebar.Content>
		<Sidebar.Group>
			<Sidebar.GroupLabel>{tenant.name}</Sidebar.GroupLabel>
			<Sidebar.GroupContent>
				<Sidebar.Menu>
					{#each items as item (item.title)}
						<Sidebar.MenuItem>
							<Sidebar.MenuButton isActive={item.isActive}>
								{#snippet child({ props })}
									<Link href={item.url} {...props}>
										<item.icon />
										<span>{item.title}</span>
									</Link>
								{/snippet}
							</Sidebar.MenuButton>
						</Sidebar.MenuItem>
					{/each}
				</Sidebar.Menu>
			</Sidebar.GroupContent>
		</Sidebar.Group>
	</Sidebar.Content>
</Sidebar.Root>
