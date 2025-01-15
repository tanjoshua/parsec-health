<script lang="ts">
	import PatientVisits from "@/components/dashboard/PatientVisits.svelte";
	import DayCalendar from "@/components/dashboard/DayCalendar.svelte";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import type { Visit } from "@/types/visit";
	import type { Appointment } from "@/types/appointment";
	import type { Tenant } from "@/types/tenant";
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import SelectedPatient from "@/components/dashboard/SelectedPatient.svelte";

	const {
		activeVisits,
		completedVisits,
		appointments,
		tenant,
	}: {
		activeVisits: Visit[];
		completedVisits: Visit[];
		appointments: Appointment[];
		tenant: Tenant;
	} = $props();

	// Add a reactive time value that updates every minute
	let now = $state(new Date());

	$effect(() => {
		const interval = setInterval(() => {
			now = new Date();
		}, 1000); // Update every second

		return () => clearInterval(interval); // Cleanup on component destroy
	});

	let selectedVisit = $state<Visit | null>(null);
</script>

<svelte:head>
	<title>Dashboard | Parsec Health</title>
</svelte:head>

<TenantLayout>
	{#snippet breadcrumbs()}
		<Breadcrumb.Root>
			<Breadcrumb.List>
				<Breadcrumb.Item class="hidden md:block">
					<Breadcrumb.Link href={route("tenants.dashboard", tenant)}
						>{tenant.name}</Breadcrumb.Link
					>
				</Breadcrumb.Item>
				<Breadcrumb.Separator class="hidden md:block" />
				<Breadcrumb.Item>
					<Breadcrumb.Page>Dashboard</Breadcrumb.Page>
				</Breadcrumb.Item>
			</Breadcrumb.List>
		</Breadcrumb.Root>
	{/snippet}
	<div class="container mx-auto p-4">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
			<PatientVisits
				{activeVisits}
				{completedVisits}
				{now}
				bind:selectedVisit
			/>
			<!-- <DayCalendar {now} {appointments} /> -->
			<SelectedPatient {now} bind:selectedVisit />
		</div>
	</div>
</TenantLayout>
