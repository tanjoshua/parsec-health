<script lang="ts">
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import * as Tabs from "@/components/ui/tabs/index";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import { Button } from "@/components/ui/button";
	import Calendar from "@/components/ui/calendar/calendar.svelte";
	import type { Tenant } from "@/types/tenant";
	import { CalendarIcon, Plus } from "lucide-svelte";
	import {
		type DateValue,
		getLocalTimeZone,
		parseDate,
		today,
	} from "@internationalized/date";
	import dayjs from "dayjs";
	import { router } from "@inertiajs/svelte";
	import type { Appointment } from "@/types/appointment";
	import ScrollArea from "@/components/ui/scroll-area/scroll-area.svelte";
	import AppointmentCard from "@/components/appointments/appointment-card.svelte";
	import AppointmentHeader from "@/components/appointments/appointment-header.svelte";

	let {
		tenant,
		selectedDay: selectedDayProp,
		appointments,
	}: {
		tenant: Tenant;
		selectedDay?: string;
		appointments: Appointment[];
	} = $props();

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
		<AppointmentHeader {tenant} page="calendar" />
		<div class="mt-4 flex space-x-4">
			<div class="">
				<Calendar
					type="single"
					value={selectedDay}
					onValueChange={onDayChange}
				/>
			</div>
			<ScrollArea
				class="flex-1 border rounded-md p-4 h-[calc(100vh-10rem)] "
			>
				<div class="grid gap-4">
					<div class="text-xl font-bold">
						{selectedDayDate.format("D MMMM YYYY, dddd")}
					</div>

					{#if appointments.length > 0}
						{#each appointments as appointment (appointment.id)}
							<AppointmentCard {appointment} />
						{/each}
					{:else}
						<div class="mt-64 flex flex-col items-center gap-4">
							<div
								class="h-20 w-20 rounded-full bg-muted text-muted-foreground flex justify-center items-center"
							>
								<CalendarIcon size={40} />
							</div>
							<div
								class="text-lg font-semibold text-muted-foreground"
							>
								No appointments on this day
							</div>
						</div>
					{/if}
				</div>
			</ScrollArea>
		</div>
	</div>
</TenantLayout>
