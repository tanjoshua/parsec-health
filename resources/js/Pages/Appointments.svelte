<script lang="ts">
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import type { Tenant } from "@/types/tenant";
	import type { Appointment } from "@/types/appointment";
	import ScrollArea from "@/components/ui/scroll-area/scroll-area.svelte";
	import AppointmentCard from "@/components/appointments/appointment-card.svelte";
	import AppointmentHeader from "@/components/appointments/appointment-header.svelte";
	import type { PaginatedResult } from "@/types/pagination";
	import PaginationBar from "@/components/table/pagination-bar.svelte";
	import { router } from "@inertiajs/svelte";
	import { CalendarIcon } from "lucide-svelte";

	let {
		tenant,
		appointments,
		pageSize,
	}: {
		tenant: Tenant;
		pageSize: string;
		appointments: PaginatedResult<Appointment>;
	} = $props();
</script>

<svelte:head>
	<title>Appointments | Parsec Health</title>
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
					<Breadcrumb.Page>Appointments</Breadcrumb.Page>
				</Breadcrumb.Item>
			</Breadcrumb.List>
		</Breadcrumb.Root>
	{/snippet}
	<div class="container mx-auto p-4 h-full">
		<AppointmentHeader {tenant} page="upcoming" />
		{#if appointments.data.length > 0}
			<div class="mt-4">
				<div class="grid gap-4">
					{#each appointments.data as appointment (appointment.id)}
						<AppointmentCard {appointment} />
					{/each}
				</div>
			</div>
			<div class="mt-4">
				<PaginationBar
					pagination={appointments}
					{pageSize}
					onPageSizeChange={(value) => {
						router.visit("", { data: { pageSize: value } });
					}}
				/>
			</div>
		{:else}
			<div class="flex justify-center items-center h-full">
				<div class="flex flex-col items-center gap-4">
					<div
						class="h-20 w-20 rounded-full bg-muted text-muted-foreground flex justify-center items-center"
					>
						<CalendarIcon size={40} />
					</div>
					<div class="text-lg font-semibold text-muted-foreground">
						No upcoming appointments
					</div>
				</div>
			</div>
		{/if}
	</div>
</TenantLayout>
