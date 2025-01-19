<script lang="ts">
	import * as Tabs from "@/components/ui/tabs/index";
	import type { Tenant } from "@/types/tenant";
	import { router } from "@inertiajs/svelte";
	import CreateAppointment from "./create-appointment.svelte";

	let { tenant, page }: { tenant: Tenant; page: "upcoming" | "calendar" } =
		$props();
</script>

<div class="flex justify-between items-center">
	<Tabs.Root value={page} class="flex">
		<Tabs.List class="grid grid-cols-2">
			<Tabs.Trigger
				value="upcoming"
				onclick={() => {
					router.visit(route("tenants.appointments.index", tenant));
				}}>Upcoming</Tabs.Trigger
			>
			<Tabs.Trigger
				value="calendar"
				onclick={() => {
					router.visit(
						route("tenants.appointments.calendar", tenant),
					);
				}}>Calendar View</Tabs.Trigger
			>
		</Tabs.List>
	</Tabs.Root>
	<CreateAppointment {tenant} />
</div>
