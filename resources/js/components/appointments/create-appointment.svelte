<script lang="ts">
	import * as Dialog from "@/components/ui/dialog";
	import { Button } from "@/components/ui/button";
	import { Plus } from "lucide-svelte";
	import type { Tenant } from "@/types/tenant";
	import FormInput from "../ui/input/form-input.svelte";
	import { useForm } from "@inertiajs/svelte";
	import FormDatepicker from "../ui/input/form-datepicker.svelte";

	let { tenant }: { tenant: Tenant } = $props();

	const form = useForm({
		name: "",
		date: "",
	});
</script>

<Dialog.Root>
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
			<form class="grid gap-4 py-4">
				<FormInput label="Patient Name" bind:value={$form.name} />
				<FormDatepicker label="Date" bind:value={$form.date} />
				<div class="grid grid-cols-2 gap-2">
					<FormInput label="Start" type="time" />
					<FormInput label="End" type="time" />
				</div>

				<div>
					<Button type="submit">Create</Button>
				</div>
			</form>
		</Dialog.Header>
		<div class="grid gap-4"></div>
	</Dialog.Content>
</Dialog.Root>
