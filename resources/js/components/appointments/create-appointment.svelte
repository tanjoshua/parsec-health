<script lang="ts">
	import * as Dialog from "@/components/ui/dialog";
	import { Button } from "@/components/ui/button";
	import { Plus } from "lucide-svelte";
	import type { Tenant } from "@/types/tenant";
	import FormInput from "../ui/input/form-input.svelte";
	import { page, router, useForm } from "@inertiajs/svelte";
	import FormDatepicker from "../ui/input/form-datepicker.svelte";
	import {
		getLocalTimeZone,
		parseDate,
		type DateValue,
	} from "@internationalized/date";

	let {
		tenant,
		page: pageType,
	}: {
		tenant: Tenant;
		page: "upcoming" | "calendar";
	} = $props();
	let open = $state(false);

	const initialDate =
		pageType === "calendar" && $page.props.selectedDay
			? parseDate($page.props.selectedDay as string)
			: undefined;

	const form = useForm({
		name: "",
		date: initialDate,
		start_time: "",
		end_time: "",
	});

	const onSubmit = (e: SubmitEvent) => {
		e.preventDefault();
		const formData = $form.data();
		const date = formData.date as unknown as DateValue;

		router.post(
			route("tenants.appointments.store", tenant),
			{
				name: formData.name,
				date: date.toString(),
				start_time: formData.start_time,
				end_time: formData.end_time,
				timezone: getLocalTimeZone(), // Include client's timezone
			},
			{
				onSuccess: () => {
					$form.reset();
					open = false;
					if (pageType === "calendar") {
						router.visit(
							route("tenants.appointments.calendar", tenant),
						);
					} else {
						router.reload({
							only: ["appointments"],
						});
					}
				},
			},
		);
	};
</script>

<Dialog.Root bind:open>
	<Dialog.Trigger>
		<Button class="" variant="outline">
			<Plus />
			Create Appointment
		</Button>
	</Dialog.Trigger>
	<Dialog.Content>
		<Dialog.Header>
			<Dialog.Title>Create appointment</Dialog.Title>
			<Dialog.Description>
				Either use a placeholder name, create a new patient or link an
				existing patient.
			</Dialog.Description>
			<form class="grid gap-4 py-4" onsubmit={onSubmit}>
				<FormInput label="Patient Name" bind:value={$form.name} />
				<FormDatepicker label="Date" bind:value={$form.date} />
				<div class="grid grid-cols-2 gap-2">
					<FormInput
						label="Start"
						type="time"
						bind:value={$form.start_time}
					/>
					<FormInput
						label="End"
						type="time"
						bind:value={$form.end_time}
					/>
				</div>

				<div>
					<Button type="submit">Create</Button>
				</div>
			</form>
		</Dialog.Header>
		<div class="grid gap-4"></div>
	</Dialog.Content>
</Dialog.Root>
