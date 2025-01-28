<script lang="ts">
	import * as Dialog from "@/components/ui/dialog";
	import { Button } from "@/components/ui/button";
	import { Plus } from "lucide-svelte";
	import type { Tenant } from "@/types/tenant";
	import FormInput from "../ui/input/form-input.svelte";
	import { router, useForm } from "@inertiajs/svelte";
	import FormDatepicker from "../ui/input/form-datepicker.svelte";
	import { getLocalTimeZone, type DateValue } from "@internationalized/date";

	let { tenant }: { tenant: Tenant } = $props();
	let open = $state(false);

	const form = useForm({
		name: "",
		date: undefined,
		start_time: "",
		end_time: "",
	});

	const onSubmit = (e: SubmitEvent) => {
		console.log($form.data());
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
					router.reload({
						only: ["appointments"],
					});
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
