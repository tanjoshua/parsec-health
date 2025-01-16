<script lang="ts">
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import { Button } from "@/components/ui/button";
	import Calendar from "@/components/ui/calendar/calendar.svelte";
	import type { Tenant } from "@/types/tenant";
	import { Plus } from "lucide-svelte";
	import {
		type DateValue,
		getLocalTimeZone,
		parseDate,
		today,
	} from "@internationalized/date";
	import dayjs from "dayjs";
	import { router } from "@inertiajs/svelte";

	let {
		tenant,
		selectedDay: selectedDayProp,
	}: { tenant: Tenant; selectedDay?: string } = $props();
	let selectedDay = selectedDayProp
		? parseDate(selectedDayProp)
		: today(getLocalTimeZone());
	let selectedDayDate = dayjs(selectedDay.toDate(getLocalTimeZone()));

	const onDayChange = (day?: DateValue) => {
		if (day) {
			router.visit("", {
				only: ["selectedDay", "appointments"],
				data: {
					day: day.toString(),
				},
			});
		}
	};
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
		<div class="flex h-full space-x-4">
			<div class="flex flex-col items-center h-full">
				<Button class="w-full" variant="outline">
					<Plus />
					Create Appointment
				</Button>
				<Calendar
					type="single"
					value={selectedDay}
					onValueChange={onDayChange}
				/>
			</div>
			<div class="flex-1 border rounded-md p-4">
				<div class="text-xl font-bold">
					{selectedDayDate.format("D MMMM YYYY, dddd")}
				</div>
			</div>
		</div>
	</div>
</TenantLayout>
