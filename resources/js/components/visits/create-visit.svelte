<script lang="ts">
	import * as Dialog from "@/components/ui/dialog";
	import { Button } from "@/components/ui/button";
	import { Plus } from "lucide-svelte";
	import type { Tenant } from "@/types/tenant";
	import FormInput from "../ui/input/form-input.svelte";
	import { page, router, useForm } from "@inertiajs/svelte";

	let {
		tenant,
	}: {
		tenant: Tenant;
	} = $props();
	let open = $state(false);

	const form = useForm({});

	const onSubmit = (e: SubmitEvent) => {
		e.preventDefault();
		const formData = $form.data();

		router.post(
			route("tenants.visits.store", tenant),
			{},
			{
				onSuccess: () => {
					$form.reset();
					open = false;
				},
			},
		);
	};
</script>

<Dialog.Root bind:open>
	<Dialog.Trigger>
		<Button class="" variant="outline">
			<Plus />
			Create Visit
		</Button>
	</Dialog.Trigger>
	<Dialog.Content>
		<Dialog.Header>
			<Dialog.Title>Create visit</Dialog.Title>
			<Dialog.Description>
				Create a visit for a new patient or existing patient
			</Dialog.Description>
		</Dialog.Header>
		<form class="grid gap-4 py-4" onsubmit={onSubmit}>
			<FormInput label="Patient Name" />
			<div>
				<Button type="submit">Create</Button>
			</div>
		</form>
	</Dialog.Content>
</Dialog.Root>
